<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by'
    ];

    // Relationship to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship to User who approved (if approved)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}