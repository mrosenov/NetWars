<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\UserProcess;
use App\Services\NetworkLogService;

class NetworkLogfile extends Command
{
    protected $signature = 'network:logfile {--limit=50}';
    protected $description = 'Apply completed edit-log processes and save network logs';

    public function __construct(private NetworkLogService $logs)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $now = now();
        $limit = (int) $this->option('limit');

        $processed = 0;
        $failed = 0;

        DB::transaction(function () use ($now, $limit, &$processed, &$failed) {
            $processes = UserProcess::where('resource_type', 'cpu')
                ->where('action', 'log')
                ->where('status', 'running')
                ->whereNotNull('ends_at')
                ->where('ends_at', '<=', $now)
                ->orderBy('ends_at')
                ->limit($limit)
                ->lockForUpdate()
                ->get();



            foreach ($processes as $p) {
                try {
                    $this->applyLogEdit($p);

                    $p->status = 'completed';
                    $p->completed_at = $now;
                    $processed++;
                } catch (\Throwable $e) {
                    $p->status = 'failed';
                    $meta = $p->metadata ?? [];
                    $meta['error'] = $e->getMessage();
                    $p->metadata = $meta;
                    $failed++;
                }

                $p->ends_at = $now;
                $p->save();
            }
        });

        $this->info("Logfile command finished: {$processed} completed, {$failed} failed.");
        return self::SUCCESS;
    }

    public function applyLogEdit(UserProcess $p): void
    {
        $meta = $p->metadata ?? [];
        $networkId = $meta['network_id'] ?? null;

        if (!$networkId) {
            throw new \RuntimeException('Invalid process metadata');
        }

        // The content the player wants to save (store it in payload_text when process is created)
        $content = $meta['content'] ?? null;
        if ($content === null) {
            throw new \RuntimeException('Missing payload_text content');
        }

        // FORCE MODE: compute expectedBaseHash from the CURRENT log content
        $currentContent = $this->logs->get((int)$networkId) ?? '';
//        $expectedBaseHash = hash('sha256', $currentContent);
//
        $this->logs->saveEdited(
            networkId: (int) $networkId,
            actorId: (int) $p->user_id,
            newContent: $content,
//            expectedBaseHash: $expectedBaseHash
        );
    }

}

