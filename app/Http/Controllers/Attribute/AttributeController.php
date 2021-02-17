<?php

namespace App\Http\Controllers\Attribute;

use App\Http\Requests\Attribute\CreateAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Repositories\Attribute\AttributeRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Attribute\AttributeGroupRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;

class AttributeController extends AppBaseController
{
    /** @var  AttributeRepository */
    private $attributeRepository;
    private $attributeGroupRepository;

    public function __construct(AttributeRepository $attributeRepo,AttributeGroupRepository $attributeGroupRepository)
    {
        parent::__construct();
        $this->attributeRepository = $attributeRepo;
        $this->attributeGroupRepository=$attributeGroupRepository;

        $this->middleware($this->attributeRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->attributeRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->attributeRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->attributeRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    

    /**
     * Display a listing of the Attribute.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        request()->merge(['include'=>"options,attributeGroup"]);
        $attributes = $this->attributeRepository->paginate();
        $groups =  $this->attributeGroupRepository->getAll();
        $this->setSeo([
            'title'=>'attributes index',
            'description'=>'attributes description',
            'keywords'=>'attributes keywords',
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
        return view('attribute.attributes.index',compact('groups'))
            ->with('attributes', $attributes);
    }

    /**
     * Show the form for creating a new Attribute.
     *
     * @return Response
     */
    public function create()
    {
        $group =  $this->attributeGroupRepository->getAll();
        $this->setSeo([
            'title'=>'attributes create',
            'description'=>'attributes description',
            'keywords'=>'attributes keywords',
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
        return view('attribute.attributes.create',compact('group'));
    }

    /**
     * Store a newly created Attribute in storage.
     *
     * @param CreateAttributeRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // $input = $request->all();
        $validatedData = $request->validate($this->attributeRepository->model()::getAddRules());

        $attribute = $this->attributeRepository->create($request);

        Flash::success('Attribute saved successfully.');

        return redirect(route('attribute.attributes.index'));
    }

    /**
     * Display the specified Attribute.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error('Attribute not found');

            return redirect(route('attribute.attributes.index'));
        }

        return view('attribute.attributes.show')->with('attribute', $attribute);
    }

    /**
     * Show the form for editing the specified Attribute.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error('Attribute not found');

            return redirect(route('attribute.attributes.index'));
        }
        $this->setSeo([
            'title'=>'attributes edit '.$attribute->translate(app()->getLocale(),true)->name,
            'description'=>'attributes description',
            'keywords'=>'attributes keywords',
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
        return view('attribute.attributes.edit')->with('attribute', $attribute);
    }

    /**
     * Update the specified Attribute in storage.
     *
     * @param int $id
     * @param UpdateAttributeRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error('Attribute not found');

            return redirect(route('attribute.attributes.index'));
        }
        $validatedData = $request->validate(array_merge($this->attributeRepository->model()::getEditRules($attribute->id) ));

        $attribute = $this->attributeRepository->update($request->all(), $id);

        Flash::success('Attribute updated successfully.');

        return redirect(route('attribute.attributes.index'));
    }

    /**
     * Remove the specified Attribute from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error('Attribute not found');

            return redirect(route('attribute.attributes.index'));
        }

        $this->attributeRepository->delete($id);

        Flash::success('Attribute deleted successfully.');

        return redirect(route('attribute.attributes.index'));
    }
}
