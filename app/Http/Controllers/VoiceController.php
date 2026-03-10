<?php

namespace App\Http\Controllers;

use App\Models\VoiceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VoiceController extends Controller
{
    public function index()
    {
        if (!session('submission_id')) {
            return redirect()->route('form');
        }
        return view('voice');
    }

    public function upload(Request $request)
    {
        if (!session('submission_id')) {
            return response()->json(['error' => 'Session expired'], 403);
        }

        $request->validate(['audio' => 'required|file|max:30720']);

        $uploadedFile = $request->file('audio');
        $uuid         = Str::uuid();
        $shareToken   = Str::random(40);

        $rawPath  = storage_path('app/private/voices_raw/' . $uuid . '.webm');
        $mp3Path  = storage_path('app/public/voices/' . $uuid . '.mp3');

        if (!file_exists(storage_path('app/private/voices_raw'))) {
            mkdir(storage_path('app/private/voices_raw'), 0755, true);
        }
        if (!file_exists(storage_path('app/public/voices'))) {
            mkdir(storage_path('app/public/voices'), 0755, true);
        }

        $uploadedFile->move(storage_path('app/private/voices_raw'), $uuid . '.webm');

        $ffmpeg  = $this->findFfmpeg();
        $cmd     = "{$ffmpeg} -y -i " . escapeshellarg($rawPath) . " -vn -ar 44100 -ac 2 -b:a 128k " . escapeshellarg($mp3Path) . " 2>&1";
        $output  = shell_exec($cmd);

        @unlink($rawPath);

        if (!file_exists($mp3Path) || filesize($mp3Path) < 1000) {
            \Log::error('FFmpeg conversion failed: ' . $output);
            return response()->json(['error' => 'Audio processing failed. FFmpeg output: ' . $output], 500);
        }

        VoiceMessage::create([
            'submission_id' => session('submission_id'),
            'file_name'     => $uuid . '.mp3',
            'share_token'   => $shareToken,
        ]);

        return response()->json([
            'share_url' => route('voice.listen', $shareToken),
        ]);
    }

    public function listen(string $token)
    {
        $voice    = VoiceMessage::where('share_token', $token)->firstOrFail();
        $audioUrl = asset('storage/voices/' . $voice->file_name);
        return view('listen', compact('audioUrl'));
    }

    private function findFfmpeg(): string
    {
        $paths = [
            '/opt/homebrew/bin/ffmpeg',
            '/usr/local/bin/ffmpeg',
            '/usr/bin/ffmpeg',
        ];
        foreach ($paths as $p) {
            if (file_exists($p)) return $p;
        }
        return 'ffmpeg';
    }
}