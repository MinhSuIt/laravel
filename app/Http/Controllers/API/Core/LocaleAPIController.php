<?php

namespace App\Http\Controllers\API\Core;

use App\Http\Requests\API\Core\CreateLocaleAPIRequest;
use App\Http\Requests\API\Core\UpdateLocaleAPIRequest;
use App\Models\Core\Locale;
use App\Repositories\Core\LocaleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LocaleController
 * @package App\Http\Controllers\API\Core
 */

class LocaleAPIController extends AppBaseController
{
    /** @var  LocaleRepository */
    private $localeRepository;

    public function __construct(LocaleRepository $localeRepo)
    {
        $this->localeRepository = $localeRepo;
    }

    /**
     * Display a listing of the Locale.
     * GET|HEAD /locales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $locales = $this->localeRepository->all();

        return $this->sendResponse($locales, 'Locales retrieved successfully');
    }

    /**
     * Store a newly created Locale in storage.
     * POST /locales
     *
     * @param CreateLocaleAPIRequest $request
     *
     * @return Response
     */
    // public function store(CreateLocaleAPIRequest $request)
    // {
    //     $input = $request->all();

    //     $locale = $this->localeRepository->create($input);

    //     return $this->sendResponse($locale->toArray(), 'Locale saved successfully');
    // }

    /**
     * Display the specified Locale.
     * GET|HEAD /locales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Locale $locale */
        $locale = $this->localeRepository->find($id);

        if (!$locale) {
            return $this->sendError('Locale not found');
        }

        return $this->sendResponse($locale, 'Locale retrieved successfully');
    }

    /**
     * Update the specified Locale in storage.
     * PUT/PATCH /locales/{id}
     *
     * @param int $id
     * @param UpdateLocaleAPIRequest $request
     *
     * @return Response
     */
    // public function update($id, UpdateLocaleAPIRequest $request)
    // {
    //     $input = $request->all();

    //     /** @var Locale $locale */
    //     $locale = $this->localeRepository->find($id);

    //     if (empty($locale)) {
    //         return $this->sendError('Locale not found');
    //     }

    //     $locale = $this->localeRepository->update($input, $id);

    //     return $this->sendResponse($locale->toArray(), 'Locale updated successfully');
    // }

    /**
     * Remove the specified Locale from storage.
     * DELETE /locales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    // public function destroy($id)
    // {
    //     /** @var Locale $locale */
    //     $locale = $this->localeRepository->find($id);

    //     if (empty($locale)) {
    //         return $this->sendError('Locale not found');
    //     }

    //     $locale->delete();

    //     return $this->sendSuccess('Locale deleted successfully');
    // }
}
