<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'price',
        'supplier_id',
        'low_stock_alert'
    ];

    // Relationship to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relationship to Invoice Items
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}