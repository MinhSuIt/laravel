<?php

namespace App\Models\Cart;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Webkul\Product\Models\ProductProxy;
use Webkul\Product\Models\ProductFlatProxy;


class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $casts = [
        'additional' => 'array',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The Product Flat that belong to the product.
     */
    // public function product_flat()
    // {
    //     return (ProductFlatProxy::modelClass())
    //         ::where('product_flat.product_id', $this->product_id)
    //         ->where('product_flat.locale', app()->getLocale())
    //         ->where('product_flat.channel', core()->getCurrentChannelCode())
    //         ->select('product_flat.*');
    // }

    // /**
    //  * Get all of the attributes for the attribute groups.
    //  */
    // public function getProductFlatAttribute()
    // {
    //     return $this->product_flat()->first();
    // }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // /**
    //  * Get the child item.
    //  */
    // public function child()
    // {
    //     return $this->belongsTo(static::class, 'id', 'parent_id');
    // }

    // /**
    //  * Get the parent item record associated with the cart item.
    //  */
    // public function parent()
    // {
    //     return $this->belongsTo(self::class, 'parent_id');
    // }

    // /**
    //  * Get the children items.
    //  */
    // public function children()
    // {
    //     return $this->hasMany(self::class, 'parent_id');
    // }
}
