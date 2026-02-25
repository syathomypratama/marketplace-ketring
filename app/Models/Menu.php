<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'photo_path',
        'price',
        'category',
        'is_active',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
