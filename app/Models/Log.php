<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}