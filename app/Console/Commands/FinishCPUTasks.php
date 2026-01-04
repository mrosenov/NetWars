<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserProcessController;
use App\Models\UserProcess;
use App\Services\NetworkLogService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FinishCPUTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cpu:tasks {--limit=500 : Max finished processes per run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalize overdue cpu tasks and rebalance shares';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $limit = (int) $this->option('limit');

        # Grab a batch of processes that ends_at should finish
        $finishedIds = UserProcess::query()
            ->where('resource_type', 'cpu')
            ->where('status', 'running')
            ->whereNotNull('ends_at')
            ->where('ends_at', '<=', $now)
            ->orderBy('ends_at')
            ->limit($limit)
            ->pluck('id');

        if ($finishedIds->isEmpty()) {
            return self::SUCCESS;
        }

        # Group by user so we can finalize + rebalance per user inside a transaction
        $userIds = UserProcess::query()
            ->whereIn('id', $finishedIds)
            ->select('user_id')
            ->distinct()
            ->pluck('user_id');

        $logs = new NetworkLogService();

        foreach ($userIds as $userId) {
            DB::transaction(function () use ($userId, $now, $logs) {
                $finished = UserProcess::query()
                    ->where('user_id', $userId)
                    ->where('resource_type', 'cpu')
                    ->where('status', 'running')
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '<=', $now)
                    ->lockForUpdate()
                    ->get();

                if ($finished->isEmpty()) return;

                foreach ($finished as $process) {
                    $process->status = 'completed';
                    $process->completed_at = $now;
                    $process->ends_at = $now;
                    $process->save();

                    # Apply effects
                    app()->make(UserProcessController::class)->applyCpuProcessEffects($process, $logs);
                }

                # Rebalance shares
                app()->make(UserProcessController::class)->rebalanceUserCpuProcesses($userId);
            });
        }

        $this->info("Finalized cpu tasks for users: " . $userIds->count());

        return self::SUCCESS;
    }
}
