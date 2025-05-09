<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'category',
        'date',
        'added_by',
        'description'
    ];

    // Relationship to User who added the expense
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}