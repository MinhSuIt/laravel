<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\AppBaseController;
use App\Providers\CartFacade;
use App\Repositories\Cart\OrderItemRepository;
use App\Repositories\Cart\OrderRepository;

class OrderAPIController extends AppBaseController
{
    private $orderRepository;
    private $orderItemRepository;
    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
    }
    public function order()
    {
        $cart = CartFacade::prepareDataForOrder();
        $this->orderRepository->create($cart);
        $items = $cart->items;
        foreach ($items as $item) {
            $this->orderItemRepository->create($item);
        }
        return $cart;
    }
}
