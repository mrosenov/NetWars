<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserProcessController;
use App\Models\UserProcess;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NetworkTransfersTick extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfers:tick {--limit=500 : Max finished processes per run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalize overdue network transfers and rebalance shares';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $now = now();
        $limit = (int) $this->option('limit');

        # Grab a batch of processes that should be finished by ends_at
        $finishedIds = UserProcess::query()
            ->where('resource_type', 'network')
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

        foreach ($userIds as $userId) {
            DB::transaction(function () use ($userId, $now) {
                $finished = UserProcess::query()
                    ->where('user_id', $userId)
                    ->where('resource_type', 'network')
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

                    app()->make(UserProcessController::class)->applyNetworkProcessEffects($process);
                }

                // rebalance both directions (cheap)
                app()->make(UserProcessController::class)->rebalanceUserNetProcesses($userId, 'download');
                app()->make(UserProcessController::class)->rebalanceUserNetProcesses($userId, 'upload');
            });
        }

        $this->info("Finalized transfers for users: " . $userIds->count());

        return self::SUCCESS;
    }
}
