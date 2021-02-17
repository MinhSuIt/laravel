<?php

namespace App\Http\Controllers\API\Cart;

class PriceBuilder
{
    protected $cart;
    protected $total = 0;
    protected $subTotal = 0;
    public function __construct($cart)
    {
        $this->cart = $cart;
        $this->builder();
    }

    public function coupon()

    {
        return $this->cart->coupon;
    }
    public function couponIsAvaluable()
    {
        return $this->coupon()->isValuable();
    }
    public function isPercentCoupon()
    {
        return $this->coupon()->isPercent;
    }
    public function hasCoupon()
    {
        if ($coupon = $this->coupon())
            return true;
        return false;
    }
    public function isForTotalCoupon()
    {
        return $this->coupon()->isTotalCoupon;
    }

    public function builder()
    {
        $items = $this->cart->items()->get();
        $isForProduct = !$this->isForTotalCoupon();
        if ($this->hasCoupon() && $this->couponIsAvaluable()) {
            $productsOfCoupon = $this->coupon()->product_ids;

            // dd($this->isForTotalCoupon());
            foreach ($items as $item) {
                if ($isForProduct) {
                    if (in_array($item->product->id, $productsOfCoupon)) {
                        if ($this->isPercentCoupon()) {
                            $this->total = (float) $this->total + $item->quantity * $item->product->price * (1 - $this->coupon()->value);
                            $this->subTotal = (float) $this->subTotal + $item->quantity * $item->product->price;
                        } else {
                            $this->total = (float) $this->total + $item->quantity * $item->product->price - $this->coupon()->value * $item->quantity;
                            $this->subTotal = (float) $this->subTotal + $item->quantity * $item->product->price;

                        }
                    } else {
                        $this->total = (float) $this->total + $item->quantity * $item->product->price;
                        $this->subTotal = (float) $this->subTotal + $item->quantity * $item->product->price;

                    }
                } else {
                    $this->total = (float) $this->total + $item->quantity * $item->product->price;
                }
            }
            if($this->isForTotalCoupon()){
                if ($this->isPercentCoupon()) {
                    $this->subTotal = $this->total;
                    $this->total = (float) $this->total * (1-$this->coupon()->value);
                } else {
                    $this->subTotal = $this->total;
                    $this->total = (float) $this->total - $this->coupon()->value;
                }
            }

        } else {
            foreach ($items as $item) {
                $this->total = (float) $this->subTotal = $this->subTotal + $item->quantity * $item->product->price;
            }
            $this->subTotal = $this->total;
        }
        if ($this->total < 0) {
            $this->total = 0;
        }
        if ($this->subTotal < 0) {
            $this->subTotal = 0;
        }
        // dd($this->subTotal,$this->total);
    }
    public function getTotal()
    {

        return (float) $this->total;
    }
    public function getSubTotal()
    {
        return (float) $this->subTotal;
    }
}
