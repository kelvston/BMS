<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Log;
use App\Notifications\LowStockNotification;

class ProductObserver
{
    public function updated(Product $product)
    {
        if ($product->quantity < $product->low_stock_alert) {
            // Log activity
            Log::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'low_stock',
                'model' => 'Product',
                'model_id' => $product->id,
                'description' => 'Low stock alert for ' . $product->name
            ]);

            // Send notification (if you have this set up)
            // $admins = User::whereRoleIs('admin')->get();
            // Notification::send($admins, new LowStockNotification($product));
        }
    }
}