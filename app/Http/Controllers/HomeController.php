<?php

namespace App\Http\Controllers;

use App\Events\RegisterCustomerEvent;
use App\Exports\CategoryExport;
use App\Helper\ImageHelper;
use App\Models\Cart\Order;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Repositories\Cart\OrderItemRepository;
use App\Repositories\Cart\OrderRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Customer\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\ResponseCache\Facades\ResponseCache;
use Intervention\Image\ImageManagerStatic as Image;




use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
// OR with multi
use Artesaos\SEOTools\Facades\JsonLdMulti;

// OR
use Artesaos\SEOTools\Facades\SEOTools;
use Astrotomic\Translatable\Locales;

class HomeController extends AppBaseController
{
    private $startDate;
    private $endDate;
    private $orderRepository;
    private $orderItemRepository;
    private $customerRepository;
    private $categoryRepository;
    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository, CustomerRepository $customerRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
    }
    // số đơn hàng,tổng số customer,tổng doanh thu theo ngày bắt đầu,ngày end (nếu ko có ngày begin,end thì trả về tổng tất cả)

    // số customer đăng ký mới theo từng tháng của năm (lựa chọn)
    // số đơn hàng mới theo từng tháng của năm (lựa chọn)
    public function index()
    {
        $getTotalSalePerMonthOfYear = collect($this->getTotalSalePerMonthOfYear())->map(function ($item) {
            $itemTemp = collect($item)->toArray();
            $result = ['month' => $itemTemp['month'], 'total' => currency($itemTemp['total'], config('currency.default'), currency()->getUserCurrency(), false)];
            $result = json_decode(collect($result)->toJson());
            return $result;
        });
        $getCustomerWithMostSales = collect($this->getCustomerWithMostSales($this->startDate, $this->endDate))->map(function ($item) {
            $itemTemp = collect($item)->toArray();
            $result = [
                'money' => currency($itemTemp['money'], config('currency.default'), currency()->getUserCurrency()),
                'total_orders' => $itemTemp['total_orders'],
                'name' => $itemTemp['name'],
                'email' => $itemTemp['email'],
            ];
            $result = json_decode(collect($result)->toJson());
            return $result;
        });
        // dd($getTotalSalePerMonthOfYear,$this->getTotalSalePerMonthOfYear());
        $this->setStartEndDate();

        $statistics = [
            'orderPendingNumber' => $this->getOrderPending()->count(),
            'total_customers'          => [
                'total' => $this->getCustomersBetweenDates()->count(),
                'between'  => $this->getCustomersBetweenDates($this->startDate, $this->endDate)->count(),
                'perMonthOfYear' => $this->getCustomerPerMonthOfYear()

            ],
            'total_orders'             =>  [
                'total' => $previous = $this->getOrdersBetweenDate()->count(),
                'between'  => $current = $this->getOrdersBetweenDate($this->startDate, $this->endDate)->count(),
                'perMonthOfYear' => $this->getOrderPerMonthOfYear()

            ],
            'total_sales'              =>  [
                'total' => currency($this->totalSale(), config('currency.default'), currency()->getUserCurrency()),
                'between' => $this->totalSaleBetWeen($this->startDate, $this->endDate),
                'perMonthOfYear' => $getTotalSalePerMonthOfYear
            ],
            'top_selling_categories'   => $this->getTopSellingCategories($this->startDate, $this->endDate),
            'top_selling_products'     => $this->getTopSellingProducts($this->startDate, $this->endDate),
            'customer_with_most_sales' => $getCustomerWithMostSales,
            'inMonth'                  => $this->inMonth(),
        ];
        // return $statistics;
        return view('dashboard.index', compact('statistics'))->with(['startDate' => $this->startDate, 'endDate' => $this->endDate]);
    }
    public function inMonth()
    {
        $proceeds = DB::table('order')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status', Order::STATUS_CLOSED)->sum('total');
        $newCustomerNumber = DB::table('customers')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count('id');
        $order = DB::table('order')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
        $result = [
            //tiền thu
            'proceeds' => currency($proceeds, config('currency.default'), currency()->getUserCurrency()),
            'newCustomerNumber' => $newCustomerNumber,
            'OrderNumber' => $order->count('id'),
            'successOrderNumber' => $order->where('status', Order::STATUS_CLOSED)->count('id')
        ];
        return $result;
    }
    public function setStartEndDate()
    {
        $this->startDate = request()->get('start')
            ? Carbon::createFromTimeString(request()->get('start') . " 00:00:01")
            : Carbon::createFromTimeString(Carbon::now()->subDays(30)->format('Y-m-d') . " 00:00:01");

        $this->endDate = request()->get('end')
            ? Carbon::createFromTimeString(request()->get('end') . " 23:59:59")
            : Carbon::now();

        if ($this->endDate > Carbon::now()) {
            $this->endDate = Carbon::now();
        }

        // $this->lastStartDate = clone $this->startDate;
        // $this->lastEndDate = clone $this->startDate;

        // $this->lastStartDate->subDays($this->startDate->diffInDays($this->endDate));
        // $this->lastEndDate->subDays($this->lastStartDate->diffInDays($this->lastEndDate));
    }
    public function getTopSellingCategories($startDate = null, $endDate = null)
    {
        $result =  DB::table('order_items')
            // ->leftJoin('products', 'products.id', 'order_items.product_id')
            ->leftJoin('category_product', 'category_product.product_id', 'order_items.product_id')
            ->leftJoin('categories',  'categories.id', 'category_product.category_id')
            ->leftJoin('category_translations', 'category_translations.category_id', 'categories.id')
            ->where('category_translations.locale', app()->getLocale())
            ->select(DB::raw('SUM(order_items.quantity) as quantity'), 'order_items.product_id as productId', 'category_product.category_id')
            ->addSelect('category_translations.name as name')
            ->groupBy('order_items.product_id', 'category_product.category_id', 'name')
            ->orderBy('quantity', 'DESC')
            ->limit(10)
            ->get();
        // if($startDate){
        //     $result->where('order_items.created_at', '>=', $startDate);
        // }
        // if($endDate){
        //     $result->where('order_items.created_at', '<=', $endDate);
        // }
        return $result;
    }
    public function getCustomerWithMostSales($startDate = null, $endDate = null)
    {
        $result =  DB::table('order')
            // if($startDate){
            //     $result->where('order.created_at', '>=', $startDate);
            // }
            // if($endDate){
            //     $result->where('order.created_at', '<=', $endDate);
            // }
            ->leftJoin('customers', 'customers.id', 'order.customer_id')
            ->select(DB::raw('SUM(order.total) as money'), DB::raw('COUNT(order.id) as total_orders'))
            ->addSelect('customers.name as name', 'customers.email as email')
            ->where('order.status', Order::STATUS_CLOSED)
            ->groupBy('email', 'name')
            ->orderBy('money', 'DESC')
            ->limit(10)->get();

        return $result;
    }
    public function getTopSellingProducts($startDate, $endDate)
    {
        return $this->orderItemRepository->getModel()
            ->leftJoin('products', 'products.id', 'order_items.product_id')
            ->leftJoin('product_translations', 'products.id', 'product_translations.product_id')
            ->select(DB::raw('SUM(quantity) as total_quantity'))
            ->addSelect('product_translations.name')
            ->where('product_translations.locale', app()->getLocale())
            // ->leftJoin('order','order.id','order_items.order_id')
            // ->where('order.status', 'completed')
            // ->where('order_items.created_at', '>=', $startDate)
            // ->where('order_items.created_at', '<=', $endDate)
            ->groupBy('product_translations.name')
            ->orderBy('total_quantity', 'DESC')
            ->limit(10)
            ->get();
    }
    private function getCustomersBetweenDates($start = null, $end = null)
    {
        $result = $this->customerRepository->getModel();
        // ->select(DB::raw('SUM(id) as total_customer'));
        if ($start) {
            $result->where('created_at', ">=", $start);
        }
        if ($end) {
            $result->where('created_at', "<=", $end);
        }
        return $result;
    }
    public function getCustomerPerMonthOfYear($year = 2020)
    {
        $result = DB::table('customers')
            ->select(DB::raw('month(created_at) as month'), DB::raw('count(id) as customerNumber'))
            ->groupBy('month')
            ->whereYear('created_at', $year)->get();
        return ($result);
    }
    public function getOrderPerMonthOfYear($year = 2020)
    {
        $result = DB::table('order')
            ->select(DB::raw('month(created_at) as month'))
            ->addSelect(DB::raw('count(id) as orderNumber'), DB::raw('avg(total) as avgOrder'))
            ->groupBy('month')
            ->whereYear('created_at', $year)->get();
        return ($result);
    }
    public function getTotalSalePerMonthOfYear($year = 2020)
    {
        $result = DB::table('order')
            ->select(DB::raw('month(created_at) as month'))
            ->addSelect(DB::raw('sum(total) as total'))
            ->groupBy('month')
            ->whereYear('created_at', $year)->get();
        return ($result);
    }
    private function totalSale()
    {
        $result = $this->orderRepository->getModel()->sum("total");

        return $result;
    }
    private function totalSaleBetWeen($start, $end)
    {
        $result = $this->orderRepository->getModel()->where('created_at', ">=", "2020-11-19")->where('created_at', "<=", "2020-11-30")->sum("total");


        return $result;
    }
    private function getOrdersBetweenDate($start = null, $end = null)
    {
        $result = $this->orderRepository->getModel();
        if ($start) {
            $result->where('created_at', ">=", $start);
        }
        if ($end) {
            $result->where('created_at', "<=", $end);
        }
        return $result;
    }
    public function getOrderPending()
    {
        return DB::table('order')->where('status', Order::STATUS_PENDING)->get();
    }
    public function dashboard()
    {
        return view('dashboard.index');
    }
    public function changePage()
    {
        $previousRequest = request()->create(url()->previous());
        $previousQuery = $previousRequest->query();
        $previousRoute = app('router')->getRoutes()->match($previousRequest)->getName();
        $defaultQueryForChangeLanguageAndCurrency = ['language' => session('language'), 'currency' => session('currency')];
        return redirect()->route($previousRoute, array_merge($previousQuery, $defaultQueryForChangeLanguageAndCurrency));
    }
    public function upload(Request $request)
    {
        $imgpath = $request->file('file')->store('post', 'public');
        // return response()->json(['location' => "/storage/$imgpath"]);
        return response()->json(['location' => $request->file('file')->getRealPath()]);

        // $link = ImageHelper::upload($this->model()::IMAGE_DIR, $data['fromUrl'], $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT, $this->model()::IMAGE_DIR);
        // $data['image'] = $link;
        // return response()->json(['location' => $request->file('file')->getRealPath()]);
    }
    public function clearCache()
    {
        //phai config cache laravel la redis thi moi xai dc cai nay
        ResponseCache::clear(['categories']);

        // or
        // Cache::tags('categories')->flush();
    }
    public function test(Locales $locales)
    {
        // input
        // Cache::tags(['people', 'artists'])->put('John', 123,1021);
        // Cache::tags(['people'])->put('John1', 'john1',1021);
        // Cache::tags(['artists'])->put('John2', 'john2',1021);
        // response 1
        // Cache::tags([ 'artists'])->flush();
        
        // dd(Cache::tags(['people', 'artists'])->get('John'));

        // dd(Cache::tags(['people'])->get('John1'));

        //response 2
        // Cache::tags(['people', 'artists'])->forget('John');
        // dd(Cache::tags(['people'])->get('John1'));
        
        // Cache::tags(['artists'])->forget('John');
        // dd(Cache::tags(['people', 'artists'])->get('John'),Cache::tags(['people'])->get('John1'));

        //other
        Cache::tags(['people', 'artists'])->put('John', 'John' );

        Cache::tags(['people', 'authors'])->put('Anne', 'Anne');
        Cache::tags(['authors'])->flush();
        $john = Cache::tags(['people', 'artists'])->get('John');

        $anne = Cache::tags(['people', 'authors'])->get('Anne');
        dd($john,$anne);

        // dd($locales->all());
        $product = Product::find(1);
        dd($product->trashed());
        dd($product->isForceDeleting());
    }
    public function abc()
    {
        response(123);
    }
}
