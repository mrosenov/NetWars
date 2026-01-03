<?php

namespace App\Services;

use App\Models\NetworkLogfile;
//use App\Models\NetworkLogfileVersion;
use Illuminate\Support\Facades\DB;

class NetworkLogService {
    public function get(int $networkId): NetworkLogfile {
        return NetworkLogfile::query()->firstOrCreate(
            ['network_id' => $networkId],
            ['content' => '']
        );
    }

    public function baseHash(string $content): string {
        // not security, just concurrency guard
        return hash('sha256', $content);
    }

    public function appendLine(int $networkId, string $line): void {
        // Normalize incoming line
        $line = rtrim($line, "\r\n");
        $quotedLine = DB::getPdo()->quote($line);

        // Ensure row exists
        $this->get($networkId);

        DB::table('network_logfiles')
            ->where('network_id', $networkId)
            ->update([
                'content' => DB::raw("
                CONCAT(
                    {$quotedLine},
                    CHAR(10),
                    REPLACE(COALESCE(content,''), CHAR(13), '')
                )
            "),
                'updated_at' => now(),
            ]);
    }

    public function saveEdited(int $networkId, ?int $actorId, string $newContent, string $expectedBaseHash): void {
        DB::transaction(function () use ($networkId, $actorId, $newContent, $expectedBaseHash) {
            $log = NetworkLogfile::query()->where('network_id', $networkId)->lockForUpdate()->firstOrCreate(['network_id' => $networkId], ['content' => '']);

            $current = (string) $log->content;
            $currentHash = $this->baseHash($current);

            // Prevent silent overwrites if someone else changed it while player was editing
            if (!hash_equals($currentHash, $expectedBaseHash)) {
                abort(409, 'Log changed while you were editing. Reload and try again.');
            }

            // Save previous version (hidden history)
//            NetworkLogfileVersion::query()->create([
//                'network_id' => $networkId,
//                'saved_by_actor_id' => $actorId,
//                'saved_at' => now(),
//                'content' => $current,
//            ]);

            $log->content = $newContent;
            $log->tamper_count = $log->tamper_count + 1;
            $log->last_tampered_at = now();
            $log->save();
        });
    }
}
