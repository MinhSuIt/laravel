<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Customer\CreateCustomerGroupRequest;
use App\Http\Requests\Customer\UpdateCustomerGroupRequest;
use App\Repositories\Customer\CustomerGroupRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerGroupController extends AppBaseController
{
    /** @var  CustomerGroupRepository */
    private $customerGroupRepository;

    public function __construct(CustomerGroupRepository $customerGroupRepo)
    {
        parent::__construct();
        $this->customerGroupRepository = $customerGroupRepo;

        $this->middleware($this->customerGroupRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->customerGroupRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->customerGroupRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->customerGroupRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->customerGroupRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->customerGroupRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->customerGroupRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->customerGroupRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the CustomerGroup.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
    {
        request()->merge([
            'translations'
        ]);
        $customerGroups = $this->customerGroupRepository->paginate();
        $this->setSeo([
            'title'=>'customers group index',
            'description'=>'customers group description',
            'keywords'=>'customers group keywords',
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
        return view('customer.customer_groups.index')
            ->with('customerGroups', $customerGroups);
    }

    /**
     * Show the form for creating a new CustomerGroup.
     *
     * @return Response
     */
    public function create()
    {
        $this->setSeo([
            'title'=>'customers group create',
            'description'=>'customers group  description',
            'keywords'=>'customers group keywords',
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
        return view('customer.customer_groups.create');
    }

    /**
     * Store a newly created CustomerGroup in storage.
     *
     * @param CreateCustomerGroupRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->customerGroupRepository->model()::getAddRules());

        $input = $request->all();

        $customerGroup = $this->customerGroupRepository->create($request);

        Flash::success('Customer Group saved successfully.');

        return redirect(route('customerGroups.index'));
    }

    /**
     * Display the specified CustomerGroup.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $customerGroup = $this->customerGroupRepository->find($id);

    //     if (empty($customerGroup)) {
    //         Flash::error('Customer Group not found');

    //         return redirect(route('customerGroups.index'));
    //     }

    //     return view('customer.customer_groups.show')->with('customerGroup', $customerGroup);
    // }

    /**
     * Show the form for editing the specified CustomerGroup.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerGroup = $this->customerGroupRepository->find($id);

        if (empty($customerGroup)) {
            Flash::error('Customer Group not found');

            return redirect(route('customerGroups.index'));
        }
        $this->setSeo([
            'title'=>'customers group edit '.$customerGroup->translate(app()->getLocale(),true)->name,
            'description'=>'customers group description',
            'keywords'=>'customers group keywords',
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
        return view('customer.customer_groups.edit')->with('customerGroup', $customerGroup);
    }

    /**
     * Update the specified CustomerGroup in storage.
     *
     * @param int $id
     * @param UpdateCustomerGroupRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $customerGroup = $this->customerGroupRepository->find($id);

        if (empty($customerGroup)) {
            Flash::error('Customer Group not found');

            return redirect(route('customerGroups.index'));
        }
        $validatedData = $request->validate(array_merge($this->customerGroupRepository->model()::getEditRules($customerGroup->id) ));

        $customerGroup = $this->customerGroupRepository->update($request->all(), $id);

        Flash::success('Customer Group updated successfully.');

        return redirect(route('customerGroups.index'));
    }

    /**
     * Remove the specified CustomerGroup from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerGroup = $this->customerGroupRepository->find($id);

        if (empty($customerGroup)) {
            Flash::error('Customer Group not found');

            return redirect(route('customerGroups.index'));
        }

        $this->customerGroupRepository->delete($id);

        Flash::success('Customer Group deleted successfully.');

        return redirect(route('customerGroups.index'));
    }
}
