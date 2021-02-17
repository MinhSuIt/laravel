<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\AppBaseController;
use App\Models\Cart\Order;
use App\Providers\CartFacade;
use App\Repositories\Cart\OrderRepository;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;

class OrderController extends AppBaseController
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->middleware($this->orderRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->orderRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->orderRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->orderRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->orderRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->orderRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->orderRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->orderRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    public function index()
    {
        $requestQuery = request()->merge(['include' => 'orderItems']);

        $orders = $this->orderRepository->paginate();
        $status = $this->orderRepository->makeModel()->statusLabel;

        $this->setSeo([
            'title'=>'order  index',
            'description'=>'order  description',
            'keywords'=>'order  keywords',
            'canonical'=>url()->current(),//ko bao gồm # (nội link) và ko có các query string

            'og:type'=>'og type',
            'og:title'=>'og title',
            'og:description'=>'og decs',
            'og:url'=>url()->current(),
            'og:site_name'=>config('app.name'),

            'wt:type'=>'wt:type',
            'wt:title'=>'wt:title',
            'wt:description'=>'wt:description',
            'wt:url'=>url()->current(),
            'wt:site'=>config('app.name'),
        ]);
        return view('order.orders.index', compact('orders','status'));
    }
    public function changeStatus(Request $request)
    {
        $order = $this->orderRepository->find($request->id);
        if (!$order) {
            return response()->json(['message' => 'fail']);
        }
        $order->status = $request->status;
        $order->save();
        return response()->json(['message' => $order]);
    }
}
