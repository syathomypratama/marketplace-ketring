<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'merchant_id',
        'delivery_date',
        'delivery_address',
        'status',
        'invoice_number',
        'subtotal',
        'tax',
        'total'
    ];
    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
