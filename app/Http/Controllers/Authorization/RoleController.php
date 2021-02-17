<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Requests\Authorization\CreateRoleRequest;
use App\Http\Requests\Authorization\UpdateRoleRequest;
use App\Repositories\Authorization\RoleRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Authorization\PermissionRepository;
use Illuminate\Http\Request;
use Flash;
use Response;

class RoleController extends AppBaseController
{
    /** @var  RoleRepository */
    private $roleRepository;
    private $permissionRepository;

    public function __construct(RoleRepository $roleRepo,PermissionRepository $permissionRepository)
    {
        parent::__construct();
        $this->roleRepository = $roleRepo;
        $this->permissionRepository = $permissionRepository;

        $this->middleware($this->roleRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->roleRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->roleRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->roleRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->roleRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->roleRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->roleRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->roleRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Role.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->merge(['include'=>"permissions"]);
        $roles = $this->roleRepository->paginate();
        $this->setSeo([
            'title'=>'roles index',
            'description'=>'roles description',
            'keywords'=>'roles keywords',
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
        return view('authorization.roles.index')
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        $all = $this->permissionRepository->all();
        $permissions = collect([]);
        $permissions->push(['id'=>0,'text'=>'All']);
        foreach ($all as $value) {
            $category = collect([]);

            $category->put(
                'id',
                $value->id

            );
            $category->put(
                'text',
                $value->name

            );
            $permissions->push($category);
        }
        $permissions = $permissions->toArray();
        $this->setSeo([
            'title'=>'roles create',
            'description'=>'roles description',
            'keywords'=>'roles keywords',
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
        return view('authorization.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->categoryRepository->model()::getAddRules());

        $input = $request->all();
        if($input['name'] === 'Super Admin'){
            abort(404);
        }
        $permissionRequest = $request->permissionIds;

        $permissions = collect();
        foreach ($permissionRequest as $value) {
            $permission = $this->permissionRepository->findById($value);
            // dd($permission);
            if(isset($permission)){
                $permissions->push($permission->name);
            }
        }
        $role = $this->roleRepository->create($input);

        $role->syncPermissions($permissions);
        Flash::success('Role saved successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $role = $this->roleRepository->find($id);

    //     if (empty($role)) {
    //         Flash::error('Role not found');

    //         return redirect(route('roles.index'));
    //     }

    //     return view('authorization.roles.show')->with('role', $role);
    // }

    /**
     * Show the form for editing the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }
        $this->setSeo([
            'title'=>'roles edit '.$role->name,
            'description'=>'roles description',
            'keywords'=>'roles keywords',
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
        return view('authorization.roles.edit')->with('role', $role);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param int $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }
        $validatedData = $request->validate(array_merge($this->categoryRepository->model()::getEditRules($role->id) ));

        $role = $this->roleRepository->update($request->all(), $id);

        Flash::success('Role updated successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $this->roleRepository->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('roles.index'));
    }
}
