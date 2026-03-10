<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            abort(404);
        }

        $submission = Submission::where('user_token', $token)
            ->orWhere('friend_token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$submission) {
            return view('gift-expired');
        }

        $isUser        = $submission->user_token === $token;
        $recipientName = $isUser ? $submission->user_name  : $submission->friend_name;
        $senderName    = $isUser ? $submission->friend_name : $submission->user_name;
        $shopUrl       = $isUser
            ? env('SHOP_URL_USER',   null)
            : env('SHOP_URL_FRIEND', null);

        return view('gift', compact('recipientName', 'senderName', 'token', 'shopUrl'));
    }
}