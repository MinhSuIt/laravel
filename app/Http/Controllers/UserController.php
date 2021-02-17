<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Authorization\RoleRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Hash;
use Request as GlobalRequest;

class UserController extends AppBaseController
{
    /** @var $userRepository UserRepository */
    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepo,RoleRepository $roleRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepository;

        $this->middleware($this->userRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->userRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->userRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->userRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->userRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->userRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->userRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->userRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->merge(['include'=>"roles"]);
        $users = $this->userRepository->paginate();
        $this->setSeo([
            'title'=>'user index',
            'description'=>'user description',
            'keywords'=>'user keywords',
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
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */

    public function create()
    {
        $roles = $this->prepareDataForSelectTag($this->roleRepository->getAll(['*'],false),false,collect());
        $this->setSeo([
            'title'=>'user create',
            'description'=>'user description',
            'keywords'=>'user keywords',
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
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->userRepository->model()::getAddRules());

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = $this->userRepository->create($input);
        if($request->roleIds){
            $user->syncRoles($request->roleIds);
        }
        Flash::success('User saved successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $user = $this->userRepository->find($id);

    //     if (empty($user)) {
    //         Flash::error('User not found');

    //         return redirect(route('users.index'));
    //     }

    //     return view('users.show')->with('user', $user);
    // }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // request()->merge(['include'=>'roles']);
        $user = $this->userRepository->find($id);
        $roles = $this->getRoles();
        // dd($user->roles);
        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }
        $this->setSeo([
            'title'=>'user edit '.$user->name,
            'description'=>'user description',
            'keywords'=>'user keywords',
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
        return view('users.edit',compact('user','roles'));
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        // dd($request);
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }
        $validatedData = $request->validate($this->userRepository->model()::getEditRules($user->id));

        $input =  $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
        $user = $this->userRepository->update($input, $id);
        if($request->roleIds){
            // $roleIds = array_values($request->roleIds);
            $user->syncRoles($roleIds);
        }
        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }
}
