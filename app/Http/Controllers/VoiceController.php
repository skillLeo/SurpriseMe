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

        $file       = $request->file('audio');
        $shareToken = Str::random(40);

        // Detect extension from MIME type (webm, ogg, mp4 are all fine for browsers)
        $mime = $file->getMimeType() ?? 'audio/webm';
        if (str_contains($mime, 'ogg'))       $ext = 'ogg';
        elseif (str_contains($mime, 'mp4'))   $ext = 'mp4';
        elseif (str_contains($mime, 'mpeg'))  $ext = 'mp3';
        else                                   $ext = 'webm';

        $fileName = Str::uuid() . '.' . $ext;

        // Ensure the voices directory exists
        $dir = storage_path('app/public/voices');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Save directly — no FFmpeg needed, browsers play webm/ogg natively
        Storage::disk('public')->putFileAs('voices', $file, $fileName);

        // Verify file was saved and is not empty
        if (!Storage::disk('public')->exists('voices/' . $fileName) ||
            Storage::disk('public')->size('voices/' . $fileName) < 100) {
            \Log::error('Voice file save failed: ' . $fileName);
            return response()->json(['error' => 'File save failed'], 500);
        }

        VoiceMessage::create([
            'submission_id' => session('submission_id'),
            'file_name'     => $fileName,
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
}