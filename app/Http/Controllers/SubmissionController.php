<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('form');
    }

    /**
     * STEP 1 — Validate + generate links.
     * Save nothing to DB yet. Store pending data in session. Return links to JS.
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'user_name'    => 'required|string|max:100',
            'user_phone'   => 'required|string|max:20',
            'friend_name'  => 'required|string|max:100',
            'friend_phone' => 'required|string|max:20',
        ]);

        $userToken   = Str::random(32);
        $friendToken = Str::random(32);

        // Store in session only — no DB write, no SMS sent yet
        session([
            'pending' => [
                'user_name'    => $validated['user_name'],
                'user_phone'   => $validated['user_phone'],
                'friend_name'  => $validated['friend_name'],
                'friend_phone' => $validated['friend_phone'],
                'user_token'   => $userToken,
                'friend_token' => $friendToken,
                'expires_at'   => Carbon::now()->addDays(60)->toDateTimeString(),
            ]
        ]);

        return response()->json([
            'user_name'    => $validated['user_name'],
            'friend_name'  => $validated['friend_name'],
            'user_phone'   => $validated['user_phone'],
            'friend_phone' => $validated['friend_phone'],
            'user_link'    => route('gift', ['token' => $userToken]),
            'friend_link'  => route('gift', ['token' => $friendToken]),
        ]);
    }

    /**
     * STEP 2 — User confirmed. Now save to DB and send SMS.
     */
    public function confirm(Request $request, TwilioService $twilio)
    {
        $pending = session('pending');

        if (!$pending) {
            return response()->json(['error' => 'Session expired. Please go back and try again.'], 403);
        }

        $submission = Submission::create([
            'user_name'    => $pending['user_name'],
            'user_phone'   => $pending['user_phone'],
            'friend_name'  => $pending['friend_name'],
            'friend_phone' => $pending['friend_phone'],
            'user_token'   => $pending['user_token'],
            'friend_token' => $pending['friend_token'],
            'expires_at'   => $pending['expires_at'],
        ]);

        $userLink   = route('gift', ['token' => $pending['user_token']]);
        $friendLink = route('gift', ['token' => $pending['friend_token']]);

        $userSms   = "Hey {$pending['user_name']}! \xF0\x9F\x8E\x81 Here's your exclusive surprise gift shopping link - pick something special for {$pending['friend_name']}!\n{$userLink}\n(Valid 60 days) - SurpriseMe";
        $friendSms = "Hey {$pending['friend_name']}! \xF0\x9F\x8E\x81 {$pending['user_name']} is planning a surprise just for you! Here's your gift shopping link:\n{$friendLink}\n(Valid 60 days) - SurpriseMe";

        $twilio->sendSms($pending['user_phone'], $userSms);
        $twilio->sendSms($pending['friend_phone'], $friendSms);

        session()->forget('pending');
        session([
            'submission_id' => $submission->id,
            'user_name'     => $submission->user_name,
            'friend_name'   => $submission->friend_name,
        ]);

        return response()->json(['redirect' => route('voice')]);
    }

    /**
     * STEP 2 (cancelled) — Discard pending session. No DB write, no SMS.
     */
    public function cancel()
    {
        session()->forget('pending');
        return response()->json(['ok' => true]);
    }
}