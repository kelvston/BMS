<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'added_by'
    ];

    // Relationship to User who added this customer
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    // Relationship to Customer Notes
    public function notes()
    {
        return $this->hasMany(CustomerNote::class);
    }

    // Relationship to Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}