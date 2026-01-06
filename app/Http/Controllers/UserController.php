<?php

namespace App\Http\Controllers;

use App\Services\NetworkLogService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logs_index() {
        $hacker = auth()->user();
        $network = $hacker->network;
        $logs = new NetworkLogService();
        $content = $logs->get($network->id)['content'] ?? '';

        return view('pages.logs.index', [
            'hacker' => $hacker,
            'network' => $network,
            'content' => $content,
        ]);
    }

    public function logs_save(Request $request) {
        $hacker = auth()->user();

        $data = $request->validate([
            'content' => ['nullable', 'string'],
            'target' => ['required', 'in:local,remote'],
        ]);

        if ($data['target'] === 'local') {
            $targetNetwork = $hacker->network;
        }
        else {
            $targetNetwork = $hacker->connectedNetwork();

            if (!$targetNetwork) {
                abort(404, 'No remote target network found.');
            }
        }

        $contentBytes = strlen($data['content']); // bytes

        app(UserProcessController::class)->start('log', [
            'content' => $data['content'],
            'target_network_id' => $targetNetwork->id,
            'log_size_bytes' => $contentBytes,
        ]);

        return redirect()->route('tasks.index');
    }
}
