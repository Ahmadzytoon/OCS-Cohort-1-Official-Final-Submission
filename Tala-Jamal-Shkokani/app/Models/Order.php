<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'tax_amount',
        'shipping_amount',
        'currency',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'stripe_payment_intent_id',
        'stripe_customer_id',
        'billing_address',
        'shipping_address',
        'notes'
    ];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    public function markAsPaid($transactionId, $paymentMethod)
    {
        $this->update([
            'payment_status' => 'paid',
            'status' => 'processing',
            'transaction_id' => $transactionId,
            'payment_method' => $paymentMethod,
            // 'paid_at' => now(), // Assuming column doesn't exist yet, avoiding error.
        ]);
    }
}
