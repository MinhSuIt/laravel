<?php

namespace App\Models\Cart;

use App\Models\Coupon\Coupon;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model 
{
    protected $table = 'cart';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'items',
    ];
    protected $attributes = [
        'currency'=>'USD',
    ];
    /**
     * To get relevant associated items with the cart instance
     */
    public function items() {
        return $this->hasMany(CartItem::class);
    }

    // public function addresses()
    // {
    //     return $this->hasMany(CartAddressProxy::modelClass());
    // }

    // /**
    //  * Get the biling address for the cart.
    //  */
    // public function billing_address()
    // {
    //     return $this->addresses()->where('address_type', CartAddress::ADDRESS_TYPE_BILLING);
    // }

    // /**
    //  * Get billing address for the cart.
    //  */
    // public function getBillingAddressAttribute()
    // {
    //     return $this->billing_address()->first();
    // }

    // /**
    //  * Get the shipping address for the cart.
    //  */
    // public function shipping_address()
    // {
    //     return $this->addresses()->where('address_type', CartAddress::ADDRESS_TYPE_SHIPPING);
    // }

    // /**
    //  * Get shipping address for the cart.
    //  */
    // public function getShippingAddressAttribute()
    // {
    //     return $this->shipping_address()->first();
    // }

    // /**
    //  * Get the shipping rates for the cart.
    //  */
    // public function shipping_rates()
    // {
    //     return $this->hasManyThrough(CartShippingRateProxy::modelClass(), CartAddressProxy::modelClass(), 'cart_id', 'cart_address_id');
    // }

    // /**
    //  * Get all of the attributes for the attribute groups.
    //  */
    // public function selected_shipping_rate()
    // {
    //     return $this->shipping_rates()->where('method', $this->shipping_method);
    // }

    // /**
    //  * Get all of the attributes for the attribute groups.
    //  */
    // public function getSelectedShippingRateAttribute()
    // {
    //     return $this->selected_shipping_rate()->where('method', $this->shipping_method)->first();
    // }

    // /**
    //  * Get the payment associated with the cart.
    //  */
    // public function payment()
    // {
    //     return $this->hasOne(CartPaymentProxy::modelClass());
    // }

    // /**
    //  * Checks if cart have stockable items
    //  *
    //  * @return boolean
    //  */
    public function isValuable()
    {
        foreach ($this->items as $item) {
            if (!$item->product->isValuable($item->quantity)) {
                return false;
            }
        }
        return true;
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    // /**
    //  * Checks if cart has downloadable items
    //  *
    //  * @return boolean
    //  */
    // public function hasDownloadableItems()
    // {
    //     foreach ($this->items as $item) {
    //         if (stristr($item->type,'downloadable') !== false) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }

    // /**
    //  * Returns true if cart contains one or many products with quantity box.
    //  * (for example: simple, configurable, virtual)
    //  * @return bool
    //  */
    // public function hasProductsWithQuantityBox(): bool
    // {
    //     foreach ($this->items as $item) {
    //         if ($item->product->getTypeInstance()->showQuantityBox() === true) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // /**
    //  * Checks if cart has items that allow guest checkout
    //  *
    //  * @return boolean
    //  */
    // public function hasGuestCheckoutItems()
    // {
    //     foreach ($this->items as $item) {
    //         if ($item->product->getAttribute('guest_checkout') === 0) {
    //             return false;
    //         }
    //     }

    //     return true;
    // }
}
