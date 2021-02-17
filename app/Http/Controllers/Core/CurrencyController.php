<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\CreateCurrencyRequest;
use App\Http\Requests\Core\UpdateCurrencyRequest;
use App\Repositories\Core\CurrencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CurrencyController extends AppBaseController
{
    /** @var  CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepo;

        $this->middleware($this->currencyRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->currencyRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->currencyRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->currencyRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->currencyRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->currencyRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->currencyRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->currencyRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Currency.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $currencies = $this->currencyRepository->all();
        $this->setSeo([
            'title'=>'currency index',
            'description'=>'currency description',
            'keywords'=>'currency keywords',
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
        return view('core.currencies.index')
            ->with('currencies', $currencies);
    }

    /**
     * Show the form for creating a new Currency.
     *
     * @return Response
     */
    public function create()
    {
        $this->setSeo([
            'title'=>'currency create',
            'description'=>'currency description',
            'keywords'=>'currency keywords',
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
        return view('core.currencies.create');
    }

    /**
     * Store a newly created Currency in storage.
     *
     * @param CreateCurrencyRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->currencyRepository->model()::getAddRules());
        
        $input = $request->only('name','code','symbol','format','exchange_rate','active');

        $currency = $this->currencyRepository->create($input);

        Flash::success('Currency saved successfully.');

        return redirect(route('currencies.index'));
    }

    /**
     * Display the specified Currency.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $currency = $this->currencyRepository->find($id);
    //     if (empty($currency)) {
    //         Flash::error('Currency not found');

    //         return redirect(route('currencies.index'));
    //     }

    //     return view('core.currencies.show')->with('currency', $currency);
    // }

    /**
     * Show the form for editing the specified Currency.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $currency = $this->currencyRepository->find($id);
        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }
        $this->setSeo([
            'title'=>'currency edit '.$currency->name,
            'description'=>'currency description',
            'keywords'=>'currency keywords',
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
        return view('core.currencies.edit')->with('currency', $currency);
    }

    /**
     * Update the specified Currency in storage.
     *
     * @param int $id
     * @param UpdateCurrencyRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }
        $validatedData = $request->validate(array_merge($this->currencyRepository->model()::getEditRules($currency->id) ));

        $currency = $this->currencyRepository->update($request->except('_token','_method','currency'), $currency);

        Flash::success('Currency updated successfully.');

        return redirect(route('currencies.index'));
    }

    /**
     * Remove the specified Currency from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $currency = $this->currencyRepository->find($id);
        if (empty($currency)) {
            Flash::error('Currency not found');

            return redirect(route('currencies.index'));
        }

        $this->currencyRepository->delete($currency);

        Flash::success('Currency deleted successfully.');

        return redirect(route('currencies.index'));
    }
}
