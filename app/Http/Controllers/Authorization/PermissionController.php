<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Requests\Authorization\CreatePermissionRequest;
use App\Http\Requests\Authorization\UpdatePermissionRequest;
use App\Repositories\Authorization\PermissionRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Authorization\RoleRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Route;
use Response;

class PermissionController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;
    private $roleRepository;

    public function __construct(PermissionRepository $permissionRepo,RoleRepository $roleRepository)
    {
        parent::__construct();
        $this->permissionRepository = $permissionRepo;
        $this->roleRepository = $roleRepository;

        $this->middleware($this->permissionRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->permissionRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
    }

    /**
     * Display a listing of the Permission.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->merge(['include'=>"roles"]);
        $permissions = $this->permissionRepository->paginate();
        $roles = $this->roleRepository->getAll(['*'],false);
        $this->setSeo([
            'title'=>'permissions index',
            'description'=>'permissions description',
            'keywords'=>'permissions keywords',
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
        return view('authorization.permissions.index',compact('roles'))
            ->with('permissions', $permissions);
    }

    /**
     * Show the form for creating a new Permission.
     *
     * @return Response
     */
    public function create()
    {
        // dd($this->permissionRepository->model()::count());
        if(!$this->permissionRepository->model()::count()){
            $arr = collect();
            //phải cache route mới lấy đc
            $routes = Route::getRoutes()->getIterator();
            // dd($routes);
            
            foreach ($routes as $route) {
                $name =$route->getName();
                if(!is_null($name) && strpos($name,'api') !== 0)
                    $permission = $this->permissionRepository->create(['name'=>$route->getName()]);
            }
        }
        
        return back();
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param CreatePermissionRequest $request
     *
     * @return Response
     */
    // public function store(CreatePermissionRequest $request)
    // {
    //     $input = $request->all();

    //     $permission = $this->permissionRepository->create($input);

    //     Flash::success('Permission saved successfully.');

    //     return redirect(route('authorization.permissions.index'));
    // }

    /**
     * Display the specified Permission.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $permission = $this->permissionRepository->find($id);

    //     if (empty($permission)) {
    //         Flash::error('Permission not found');

    //         return redirect(route('authorization.permissions.index'));
    //     }

    //     return view('authorization.permissions.show')->with('permission', $permission);
    // }

    /**
     * Show the form for editing the specified Permission.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function edit($id)
    // {
    //     $permission = $this->permissionRepository->find($id);

    //     if (empty($permission)) {
    //         Flash::error('Permission not found');

    //         return redirect(route('authorization.permissions.index'));
    //     }

    //     return view('authorization.permissions.edit')->with('permission', $permission);
    // }

    /**
     * Update the specified Permission in storage.
     *
     * @param int $id
     * @param UpdatePermissionRequest $request
     *
     * @return Response
     */
    // public function update($id, UpdatePermissionRequest $request)
    // {
    //     $permission = $this->permissionRepository->find($id);

    //     if (empty($permission)) {
    //         Flash::error('Permission not found');

    //         return redirect(route('authorization.permissions.index'));
    //     }

    //     $permission = $this->permissionRepository->update($request->all(), $id);

    //     Flash::success('Permission updated successfully.');

    //     return redirect(route('authorization.permissions.index'));
    // }

    /**
     * Remove the specified Permission from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    // public function destroy($id)
    // {
    //     $permission = $this->permissionRepository->find($id);

    //     if (empty($permission)) {
    //         Flash::error('Permission not found');

    //         return redirect(route('authorization.permissions.index'));
    //     }

    //     $this->permissionRepository->delete($id);

    //     Flash::success('Permission deleted successfully.');

    //     return redirect(route('authorization.permissions.index'));
    // }
}
