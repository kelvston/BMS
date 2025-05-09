<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'department',
        'position',
        'join_date'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Leave Requests
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}