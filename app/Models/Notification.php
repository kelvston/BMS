<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'read_status'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}