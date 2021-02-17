<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\CreateLocaleRequest;
use App\Http\Requests\Core\UpdateLocaleRequest;
use App\Repositories\Core\LocaleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class LocaleController extends AppBaseController
{
    /** @var  LocaleRepository */
    private $localeRepository;

    public function __construct(LocaleRepository $localeRepo)
    {
        parent::__construct();
        $this->localeRepository = $localeRepo;

        $this->middleware($this->localeRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->localeRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->localeRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->localeRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->localeRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->localeRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->localeRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->localeRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Locale.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $locales = $this->localeRepository->all();
        $this->setSeo([
            'title'=>'locales index',
            'description'=>'locales description',
            'keywords'=>'locales keywords',
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
        return view('core.locales.index')
            ->with('locales', $locales);
    }

    /**
     * Show the form for creating a new Locale.
     *
     * @return Response
     */
    public function create()
    {
        $this->setSeo([
            'title'=>'locale create',
            'description'=>'locale description',
            'keywords'=>'locale keywords',
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
        return view('core.locales.create');
    }

    /**
     * Store a newly created Locale in storage.
     *
     * @param CreateLocaleRequest $request
     *
     * @return Response
     */
    public function store(CreateLocaleRequest $request)
    {
        $input = $request->all();

        $locale = $this->localeRepository->create($input);

        Flash::success('Locale saved successfully.');

        return redirect(route('locales.index'));
    }

    /**
     * Display the specified Locale.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $locale = $this->localeRepository->find($id);

    //     if (empty($locale)) {
    //         Flash::error('Locale not found');

    //         return redirect(route('locales.index'));
    //     }

    //     return view('core.locales.show')->with('locale', $locale);
    // }

    /**
     * Show the form for editing the specified Locale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $locale = $this->localeRepository->find($id);

        if (empty($locale)) {
            Flash::error('Locale not found');

            return redirect(route('locales.index'));
        }
        $this->setSeo([
            'title'=>'edit locale '.$locale->name,
            'description'=>'locales description',
            'keywords'=>'locales keywords',
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
        return view('core.locales.edit')->with('locale', $locale);
    }

    /**
     * Update the specified Locale in storage.
     *
     * @param int $id
     * @param UpdateLocaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocaleRequest $request)
    {
        $locale = $this->localeRepository->find($id);

        if (empty($locale)) {
            Flash::error('Locale not found');

            return redirect(route('locales.index'));
        }

        $locale = $this->localeRepository->update($request->all(), $id);

        Flash::success('Locale updated successfully.');

        return redirect(route('locales.index'));
    }

    /**
     * Remove the specified Locale from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $locale = $this->localeRepository->find($id);

        if (empty($locale)) {
            Flash::error('Locale not found');

            return redirect(route('locales.index'));
        }

        $this->localeRepository->delete($id);

        Flash::success('Locale deleted successfully.');

        return redirect(route('locales.index'));
    }
}
