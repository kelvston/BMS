<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'issued_by',
        'total_amount',
        'tax_amount',
        'discount',
        'status',
        'due_date'
    ];

    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship to User who issued the invoice
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // Relationship to Invoice Items
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}