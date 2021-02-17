<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable  = [
        "sku",
        "name",
        "quantity",
        "price",
        "total",
        "product_id",
        "additional"
    ];
    protected $attributes = [
        'additional' => null,
    ];
}
