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

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

// app/Models/Invoice.php
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('invoice_number', 'like', '%'.$search.'%')
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%')
                            ->orWhere('phone', 'like', '%'.$search.'%');
                    });
            });
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when($filters['from'] ?? null, function ($query, $from) {
            $query->whereDate('created_at', '>=', Carbon::parse($from));
        })->when($filters['to'] ?? null, function ($query, $to) {
            $query->whereDate('created_at', '<=', Carbon::parse($to));
        });
    }

    public function scopeOrderByStatus($query)
    {
        return $query->orderByRaw("FIELD(status, 'unpaid', 'paid')");
    }
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
