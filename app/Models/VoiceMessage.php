<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoiceMessage extends Model
{
    protected $fillable = [
        'submission_id',
        'file_name',
        'share_token',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function getAudioUrlAttribute(): string
    {
        return asset('storage/voices/' . $this->file_name);
    }
}