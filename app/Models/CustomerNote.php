<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    protected $fillable = [
        'customer_id',
        'note',
        'created_by'
    ];

    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship to User who created the note
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}