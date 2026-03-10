<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'user_name',
        'user_phone',
        'friend_name',
        'friend_phone',
        'user_token',
        'friend_token',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function voiceMessages()
    {
        return $this->hasMany(VoiceMessage::class);
    }
}