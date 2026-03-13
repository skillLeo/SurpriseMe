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

    public function store(Request $request, TwilioService $twilio)
    {
        $validated = $request->validate([
            'user_name'    => 'required|string|max:100',
            'user_phone'   => 'required|string|max:20',
            'friend_name'  => 'required|string|max:100',
            'friend_phone' => 'required|string|max:20',
        ]);
    
        // ── International phone deduplication ─────────────────────────────────
        // Strip all non-digit characters and compare the last 10 digits.
        // This correctly treats 0311-000-0571, +92311 000 0571, and 923110000571
        // as the same number regardless of formatting or country-code prefix.
        $userDigits   = preg_replace('/\D/', '', $validated['user_phone']);
        $friendDigits = preg_replace('/\D/', '', $validated['friend_phone']);
    
        if (
            strlen($userDigits) >= 7 &&
            strlen($friendDigits) >= 7 &&
            substr($userDigits, -10) === substr($friendDigits, -10)
        ) {
            return back()
                ->withErrors(['friend_phone' => "Your number and your friend's number cannot be the same."])
                ->withInput();
        }
        // ──────────────────────────────────────────────────────────────────────
    
        $userToken   = Str::random(32);
        $friendToken = Str::random(32);
    
        $submission = Submission::create([
            'user_name'    => $validated['user_name'],
            'user_phone'   => $validated['user_phone'],
            'friend_name'  => $validated['friend_name'],
            'friend_phone' => $validated['friend_phone'],
            'user_token'   => $userToken,
            'friend_token' => $friendToken,
            'expires_at'   => Carbon::now()->addDays(60),
        ]);
    
        $userLink   = route('gift', ['token' => $userToken]);
        $friendLink = route('gift', ['token' => $friendToken]);
    
        $userSms   = "Hey {$validated['user_name']}! \xF0\x9F\x8E\x81 Here's your exclusive surprise gift shopping link - pick something special for {$validated['friend_name']}!\n{$userLink}\n(Valid 60 days) - SurpriseMe";
        $friendSms = "Hey {$validated['friend_name']}! \xF0\x9F\x8E\x81 {$validated['user_name']} is planning a surprise just for you! Here's your gift shopping link:\n{$friendLink}\n(Valid 60 days) - SurpriseMe";
    
        $twilio->sendSms($validated['user_phone'], $userSms);
        $twilio->sendSms($validated['friend_phone'], $friendSms);
    
        session([
            'submission_id' => $submission->id,
            'user_name'     => $submission->user_name,
            'friend_name'   => $submission->friend_name,
        ]);
    
        return redirect()->route('voice');
    }
}