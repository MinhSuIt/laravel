<?php

namespace App\Http\Controllers\API\Cart;

use App\Models\Cart\CartItem;
use App\Repositories\Cart\CartItemRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Product\ProductRepository;
use Currency;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Arr;

class Cart
{
    protected $cartRepository;
    protected $cartItemRepository;
    protected $cartAddressRepository;
    protected $productRepository;
    protected $customer;
    // protected $taxCategoryRepository;
    // protected $wishlistRepository;
    // protected $customerAddressRepository;


    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        ProductRepository $productRepository
    ) {
        $this->cartRepository = $cartRepository;

        $this->cartItemRepository = $cartItemRepository;

        $this->productRepository = $productRepository;
        if ($this->getCurrentCustomer()->check()) {
            $this->customer = $this->getCurrentCustomer()->user();
        }else{
            
        }
    }

    public function getCurrentCustomer()
    {
        return auth()->guard('api');
    }

    public function addProduct($productId, $data)
    {

        $cart = $this->getCart();
        if (!$cart && !$cart = $this->create()) {
            return false;
        }

        $product = $this->productRepository->findById($productId);
        if (!$product) return false;
        $cartItem = $product->getItemByCartId($cart->id);
        if ($cartItem === null) {
            $cartItem = $this->cartItemRepository->create([
                'quantity' => $data->quantity,
                'additional' => $data->additional,
                'product_id' => $product->id,
                'cart_id' => $cart->id
            ]);
        } else {
            $cartItem = $this->cartItemRepository->update(array_merge($data->toArray(), ['quantity' => $cartItem->quantity + $data->quantity]), $cartItem->id);
        }


        return $this->getCart();
    }


    public function create()
    {
        $cartData = [
            'items_count'           => 1,
        ];

        // Fill in the customer data, as far as possible:
        if ($this->getCurrentCustomer()->check()) {
            $cartData['customer_id'] = $this->customer->id;
            $cartData['is_guest'] = 0;
            $cartData['customer_name'] = $this->customer->name;
            $cartData['customer_email'] = $this->customer->email;
        } else {
            $cartData['is_guest'] = 1;
        }

        $cart = $this->cartRepository->create($cartData);

        if (!$cart) {
            return false;
        }
        return $cart;
    }

    public function updateItems($data)
    {
        if (!$cart = $this->getCart()) {
            return false;
        }
        foreach ($data['qty'] as $itemId => $quantity) {
            $item = $this->cartItemRepository->findById($itemId);

            if (!$item) {
                continue;
            }

            if ($quantity <= 0) {
                $this->removeItem($itemId);
                return false;
                // throw new \Exception(trans('shop::app.checkout.cart.quantity.illegal'));
            }


            $this->cartItemRepository->update([
                'quantity'          => $quantity,
            ], $itemId);
        }


        return true;
    }



    public function removeItem($itemId)
    {
        if (!$cart = $this->getCart()) {
            return false;
        }

        $this->cartItemRepository->delete($itemId);

        if ($cart->items()->get()->count() == 0) {
            $this->cartRepository->delete($cart->id);
        }

        return true;
    }




    public function getCart()
    {
        $cart = null;

        if ($this->getCurrentCustomer()->check()) {

            $cart  = $this->customer->cart;
        }
        return $cart ? $cart : null;
    }

    public function getFullInfoFromCart()
    {
        if (!$cart = $this->getCart()) {
            return false;
        }

        $cart->total = 0;
        // Event::dispatch('checkout.cart.collect.totals.before', $cart);
        $cart->products = collect();
        //có thể check có coupon ko ,là loại nào rồi tính tổng cho chính xác
        foreach ($cart->items()->get() as $item) {
            //chỗ này set lại total nếu coupon là cho 1 product

            $cart->products->push($item->product);
        }

        $quantities = 0;

        foreach ($cart->items as $item) {
            $quantities = $quantities + $item->quantity;
        }

        $cart->items_count = $cart->items->count();

        $cart->items_qty = $quantities;

        // $cart->subTotal = (float)$cart->total + $item->product->price*$item->quantity;

        $priceBuilder = new PriceBuilder($cart);
        $cart->subTotal = $priceBuilder->getSubTotal();
        $cart->total = $priceBuilder->getTotal();

        // Event::dispatch('checkout.cart.collect.totals.after', $cart);
        return $cart;
    }

    public function deleteCart()
    {
        if (!$cart = $this->getCart()) {
            return false;
        }
        $this->customer->cart->delete();
        return true;
    }
    /**
     * Validate order before creation
     *
     * @return array
     */
    public function prepareDataForOrder()
    {
        $finalData = [
            'cart_id'               => $this->getCart()->id,
            'customer_id'           => $this->customer->id,
            'email'                 => $this->customer->email,
            'phoneNumber'                 => $this->customer->phoneNumber,
            'address'                 => $this->customer->address,
            'name'   => $this->customer->name,
            'items_count'      => $this->getFullInfoFromCart()->items_count,
            'items_qty'     => $this->getFullInfoFromCart()->items_qty,
            'subTotal'             => $this->getFullInfoFromCart()->subTotal,
            'total'             => $this->getFullInfoFromCart()->total,
            'coupon' => $this->getCart()->coupon,
            "status" => "pending",
            "currency" => currency()->getUserCurrency(),
            "exchange_rate" => currency()->getCurrency(currency()->getUserCurrency())['exchange_rate']
        ];
        //check các item còn đủ hàng cho order hay ko
        if ($this->getCart()->isValuable()) {
            $items = $this->getCart()->items()->get();
            foreach ($items as $item) {
                $finalData['items'][] = $this->prepareDataForOrderItem($item);
            }
        }


        return $finalData;
    }

    // /**
    //  * Prepares data for order item
    //  *
    //  * @param  array  $data
    //  * @return array
    //  */
    public function prepareDataForOrderItem($data)
    {
        $finalData = [
            'product'              => $this->productRepository->findById($data->product_id),
            'sku'                  => $data->product->sku,
            'name'                 => $data->product->translate(app()->getLocale(), true)->name,
            'quantity'          => $data->quantity,
            'product_id' => $data->product->id,
            'price'                => $data->product->price,
            'total'                => $data->product->price * $data->quantity,
            'additional'           => $data['additional'],
        ];

        return $finalData;
    }



    // /**
    //  * Set coupon code to the cart
    //  *
    //  * @param  string  $code
    //  */
    public function setCouponCode($code)
    {
        $cart = $this->getCart();

        $cart->coupon_code = $code;

        $cart->save();

        return $this;
    }

    // /**
    //  * Remove coupon code from cart
    //  *
    //  */
    public function removeCouponCode()
    {
        $cart = $this->getCart();

        $cart->coupon_code = null;

        $cart->save();

        return $this;
    }
}
