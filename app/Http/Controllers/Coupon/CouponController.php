<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Requests\Coupon\CreateCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Repositories\Coupon\CouponRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Product\ProductRepository;
use Doctrine\DBAL\Types\BooleanType;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Collection;
use Response;

class CouponController extends AppBaseController
{
    private $couponRepository;
    private $productRepository;

    public function __construct(CouponRepository $couponRepo,ProductRepository $productRepository)
    {
        parent::__construct();
        $this->couponRepository = $couponRepo;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the Coupon.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        request()->merge([]);
        $cuopons = $this->couponRepository->paginate();
        $this->setSeo([
            'title'=>'cuopons index',
            'description'=>'cuopons description',
            'keywords'=>'cuopons keywords',
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
        return view('coupon.cuopons.index')
            ->with('cuopons', $cuopons);
    }



    public function create()
    {
        request()->merge([
            'include'=>'translations'
        ]);

        $products = $this->prepareDataForSelectTag($this->productRepository->getAll(),false,collect());
        $this->setSeo([
            'title'=>'cuopons create',
            'description'=>'cuopons description',
            'keywords'=>'cuopons keywords',
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
        return view('coupon.cuopons.create',compact('products'));
    }

    /**
     * Store a newly created Coupon in storage.
     *
     * @param CreateCouponRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponRequest $request)
    {
        $input = $request->all();

        $coupon = $this->couponRepository->create($input);

        Flash::success('Coupon saved successfully.');

        return redirect(route('coupon.cuopons.index'));
    }

    /**
     * Display the specified Coupon.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $coupon = $this->couponRepository->find($id);

    //     if (empty($coupon)) {
    //         Flash::error('Coupon not found');

    //         return redirect(route('coupon.cuopons.index'));
    //     }

    //     return view('coupon.cuopons.show')->with('coupon', $coupon);
    // }

    /**
     * Show the form for editing the specified Coupon.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        request()->merge([]);
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            Flash::error('Coupon not found');

            return redirect(route('coupon.cuopons.index'));
        }


        // $productRequest = app()->make(request::class);
        // $productquery = array_merge($this->getSharedQueryValue(),[
        //     'include'=>'translations'
        // ]);
        // $productRequest->merge($productquery);
        $products = $this->prepareDataForSelectTag($this->productRepository->getAll(),true,$coupon->products());
        $this->setSeo([
            'title'=>'cuopons edit '.$coupon->name,
            'description'=>'cuopons description',
            'keywords'=>'cuopons keywords',
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
        return view('coupon.cuopons.edit',compact('products'))->with('coupon', $coupon);
    }

    /**
     * Update the specified Coupon in storage.
     *
     * @param int $id
     * @param UpdateCouponRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponRequest $request)
    {
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            Flash::error('Coupon not found');

            return redirect(route('coupon.cuopons.index'));
        }

        $coupon = $this->couponRepository->update($request->all(), $id);

        Flash::success('Coupon updated successfully.');

        return redirect(route('coupon.cuopons.index'));
    }

    /**
     * Remove the specified Coupon from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            Flash::error('Coupon not found');

            return redirect(route('coupon.cuopons.index'));
        }

        $this->couponRepository->delete($id);

        Flash::success('Coupon deleted successfully.');

        return redirect(route('coupon.cuopons.index'));
    }
}
