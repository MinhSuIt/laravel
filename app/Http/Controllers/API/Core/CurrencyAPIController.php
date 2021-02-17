<?php

namespace App\Http\Controllers\API\Core;

use App\Http\Requests\API\Core\CreateCurrencyAPIRequest;
use App\Http\Requests\API\Core\UpdateCurrencyAPIRequest;
use App\Models\Core\Currency;
use App\Repositories\Core\CurrencyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CurrencyController
 * @package App\Http\Controllers\API\Core
 */

class CurrencyAPIController extends AppBaseController
{
    /** @var  CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the Currency.
     * GET|HEAD /currencies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $currencies = $this->currencyRepository->all();

        return $this->sendResponse($currencies, 'Currencies retrieved successfully');
    }

    /**
     * Store a newly created Currency in storage.
     * POST /currencies
     *
     * @param CreateCurrencyAPIRequest $request
     *
     * @return Response
     */
    // public function store(CreateCurrencyAPIRequest $request)
    // {
    //     $input = $request->all();

    //     $currency = $this->currencyRepository->create($input);

    //     return $this->sendResponse($currency->toArray(), 'Currency saved successfully');
    // }

    /**
     * Display the specified Currency.
     * GET|HEAD /currencies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Currency $currency */
        $currency = $this->currencyRepository->find($id);

        if (!$currency) {
            return $this->sendError('Currency not found');
        }

        return $this->sendResponse($currency->toArray(), 'Currency retrieved successfully');
    }

    /**
     * Update the specified Currency in storage.
     * PUT/PATCH /currencies/{id}
     *
     * @param int $id
     * @param UpdateCurrencyAPIRequest $request
     *
     * @return Response
     */
    // public function update($id, UpdateCurrencyAPIRequest $request)
    // {
    //     $input = $request->all();

    //     /** @var Currency $currency */
    //     $currency = $this->currencyRepository->find($id);

    //     if (empty($currency)) {
    //         return $this->sendError('Currency not found');
    //     }

    //     $currency = $this->currencyRepository->update($input, $id);

    //     return $this->sendResponse($currency->toArray(), 'Currency updated successfully');
    // }

    /**
     * Remove the specified Currency from storage.
     * DELETE /currencies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    // public function destroy($id)
    // {
    //     /** @var Currency $currency */
    //     $currency = $this->currencyRepository->find($id);

    //     if (empty($currency)) {
    //         return $this->sendError('Currency not found');
    //     }

    //     $currency->delete();

    //     return $this->sendSuccess('Currency deleted successfully');
    // }
}
