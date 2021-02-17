<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\CreateConfigRequest;
use App\Http\Requests\Core\UpdateConfigRequest;
use App\Repositories\Core\ConfigRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ConfigController extends AppBaseController
{
    /** @var  ConfigRepository */
    private $configRepository;

    public function __construct(ConfigRepository $configRepo)
    {
        parent::__construct();
        $this->configRepository = $configRepo;

        $this->middleware($this->configRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->configRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        // $this->middleware($this->configRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->configRepository->model()::CREATE_TAG, ['only' => ['create']]);
        // $this->middleware($this->configRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->configRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->configRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->configRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Config.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $configs = $this->configRepository->all();
        $this->setSeo([
            'title'=>'configs index',
            'description'=>'configs description',
            'keywords'=>'configs keywords',
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
        return view('core.configs.index')
            ->with('configs', $configs);
    }


    // public function create()
    // {
    //     return view('core.configs.create');
    // }

    /**
     * Store a newly created Config in storage.
     *
     * @param CreateConfigRequest $request
     *
     * @return Response
     */
    // public function store(CreateConfigRequest $request)
    // {
    //     $input = $request->all();

    //     $config = $this->configRepository->create($input);

    //     Flash::success('Config saved successfully.');

    //     return redirect(route('configs.index'));
    // }

    /**
     * Display the specified Config.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $config = $this->configRepository->find($id);

    //     if (empty($config)) {
    //         Flash::error('Config not found');

    //         return redirect(route('configs.index'));
    //     }

    //     return view('core.configs.show')->with('config', $config);
    // }

    /**
     * Show the form for editing the specified Config.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }
        $this->setSeo([
            'title'=>'config edit '.$config->code,
            'description'=>'config description',
            'keywords'=>'config keywords',
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
        return view('core.configs.edit')->with('config', $config);
    }

    /**
     * Update the specified Config in storage.
     *
     * @param int $id
     * @param UpdateConfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConfigRequest $request)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }

        $config = $this->configRepository->update($request->all(), $id);

        Flash::success('Config updated successfully.');

        return redirect(route('configs.index'));
    }

    /**
     * Remove the specified Config from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $config = $this->configRepository->find($id);

        if (empty($config)) {
            Flash::error('Config not found');

            return redirect(route('configs.index'));
        }

        $this->configRepository->delete($id);

        Flash::success('Config deleted successfully.');

        return redirect(route('configs.index'));
    }
}
