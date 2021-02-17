<?php

namespace App\Http\Controllers\Attribute;

use App\Http\Requests\Attribute\CreateAttributeGroupRequest;
use App\Http\Requests\Attribute\UpdateAttributeGroupRequest;
use App\Repositories\Attribute\AttributeGroupRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use Flash;
use Request as GlobalRequest;
use Response;

class AttributeGroupController extends AppBaseController
{
    private $attributeGroupRepository;
    private $categoryRepository;

    public function __construct(AttributeGroupRepository $attributeGroupRepo,CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->attributeGroupRepository = $attributeGroupRepo;
        $this->categoryRepository = $categoryRepository;

        $this->middleware($this->attributeGroupRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeGroupRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->attributeGroupRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeGroupRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->attributeGroupRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeGroupRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->attributeGroupRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware')."," . $this->attributeGroupRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the AttributeGroup.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request,AttributeRepository $attributeRepository)
    {

        request()->merge([
            'include'=>"attributes.options,categories"
        ]);

        $attributeGroups = $this->attributeGroupRepository->paginate();
        $categories = $this->categoryRepository->getAll();
        $this->setSeo([
            'title'=>'attributeGroups index',
            'description'=>'attributeGroups description',
            'keywords'=>'attributeGroups keywords',
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
        return view('attribute.attribute_groups.index',compact('categories'))
            ->with('attributeGroups', $attributeGroups);
    }

    /**
     * Show the form for creating a new AttributeGroup.
     *
     * @return Response
     */
    public function create(CategoryRepository $categoryRepository)
    {
        $categoriesCus = $this->prepareDataForSelectTag($categoryRepository->getAll(),false,collect());
        $this->setSeo([
            'title'=>'attributeGroups create',
            'description'=>'attributeGroups description',
            'keywords'=>'attributeGroups keywords',
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
        return view('attribute.attribute_groups.create',compact('categoriesCus'));
    }

    /**
     * Store a newly created AttributeGroup in storage.
     *
     * @param CreateAttributeGroupRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(array_merge($this->attributeGroupRepository->model()::getAddRules() ));

        $attributeGroup = $this->attributeGroupRepository->create($request);
        Flash::success('Attribute Group saved successfully.');

        return redirect(route('attributeGroups.index'));
    }

    /**
     * Display the specified AttributeGroup.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $attributeGroup = $this->attributeGroupRepository->find($id);

    //     if (empty($attributeGroup)) {
    //         Flash::error('Attribute Group not found');

    //         return redirect(route('attributeGroups.index'));
    //     }

    //     return view('attribute.attribute_groups.show')->with('attributeGroup', $attributeGroup);
    // }

    /**
     * Show the form for editing the specified AttributeGroup.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $attributeGroupRequest = app()->make(request::class);
        $query = array_merge($this->getSharedQueryValue(),[
            'include'=>"translations"
        ]);
        $attributeGroupRequest->merge($query);

        $attributeGroup = $this->attributeGroupRepository->find($attributeGroupRequest,$id);

        if (empty($attributeGroup)) {
            Flash::error('Attribute Group not found');

            return redirect(route('attributeGroups.index'));
        }
        $this->setSeo([
            'title'=>'edit attributeGroups '.$attributeGroup->translate(app()->getLocale(),true)->name,
            'description'=>'attributeGroups description',
            'keywords'=>'attributeGroups keywords',
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
        return view('attribute.attribute_groups.edit')->with('attributeGroup', $attributeGroup);
    }

    /**
     * Update the specified AttributeGroup in storage.
     *
     * @param int $id
     * @param UpdateAttributeGroupRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);

        if (empty($attributeGroup)) {
            Flash::error('Attribute Group not found');

            return redirect(route('attributeGroups.index'));
        }
        $validatedData = $request->validate(array_merge($this->attributeGroupRepository->model()::getEditRules($attributeGroup->id) ));

        $attributeGroup = $this->attributeGroupRepository->update($request->all(), $id);

        Flash::success('Attribute Group updated successfully.');

        return redirect(route('attributeGroups.index'));
    }

    /**
     * Remove the specified AttributeGroup from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);

        if (empty($attributeGroup)) {
            Flash::error('Attribute Group not found');

            return redirect(route('attributeGroups.index'));
        }

        $this->attributeGroupRepository->delete($id);

        Flash::success('Attribute Group deleted successfully.');

        return redirect(route('attributeGroups.index'));
    }
}
