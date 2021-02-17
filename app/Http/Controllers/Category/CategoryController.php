<?php

namespace App\Http\Controllers\Category;

use App\Exports\CategoryExport;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepository;
use App\Http\Controllers\AppBaseController;
use App\Imports\CategoryImport;
use App\Models\Product\ProductCategory;
use App\Repositories\Attribute\AttributeGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laracasts\Flash\Flash;
use Response;

class CategoryController extends AppBaseController
{
    private $categoryRepository;
    private $attributeGroupRepository;
    public function __construct(CategoryRepository $categoryRepo, AttributeGroupRepository $attributeGroupRepository)
    {
        // dd(config('seeder.'.ProductCategory::class));
        parent::__construct();
        $this->categoryRepository = $categoryRepo;
        $this->attributeGroupRepository = $attributeGroupRepository;

        $this->middleware($this->categoryRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->categoryRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->categoryRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->categoryRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Category.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
    {
        //request la singleton
        //them bang category_attribute de hien thi cac attribute va attribute option tai trang category
        //attribute group la dung san 1 nhom attribute cho cac san pham thuoc danh muc nay
        request()->merge([
            'include' => 'attributeGroups,productsCount',
            'fields' => [
                'categories' => 'id,position,image,status',
                //chưa fields đc các bảng khác
            ],
        ]);
        // dd(request()->query());
        $categories = $this->categoryRepository->paginate();
        $attributeGroups = $this->attributeGroupRepository->getAll();
        $this->setSeo([
            'title' => 'category index',
            'description' => 'category description',
            'keywords' => 'category keywords',
            'canonical' => url()->current(), //ko bao gồm # (nội link) và ko có các query string

            'og:type' => 'og type',
            'og:title' => 'og title',
            'og:description' => 'og decs',
            'og:url' => url()->current(),
            'og:site_name' => config('app.name'),

            'wt:type' => 'wt:type',
            'wt:title' => 'wt:title',
            'wt:description' => 'wt:description',
            'wt:url' => url()->current(),
            'wt:site' => config('app.name'),
        ]);

        return view('category.categories.index',compact('attributeGroups'))
            ->with('categories', $categories)
            ->with('importType', 'category') //view index của tất cả controller đều phải trả về cái này
        ;
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        $attributeGroups = $this->prepareDataForSelectTag($this->attributeGroupRepository->getAll(), false, collect([]));

        $this->setSeo([
            'title' => 'category create',
            'description' => 'category description',
            'keywords' => 'category keywords',
            'canonical' => url()->current(), //ko bao gồm # (nội link) và ko có các query string

            'og:type' => 'og type',
            'og:title' => 'og title',
            'og:description' => 'og decs',
            'og:url' => url()->current(),
            'og:site_name' => config('app.name'),

            'wt:type' => 'wt:type',
            'wt:title' => 'wt:title',
            'wt:description' => 'wt:description',
            'wt:url' => url()->current(),
            'wt:site' => config('app.name'),
        ]);
        return view('category.categories.create', compact('attributeGroups'));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate($this->categoryRepository->model()::getAddRules());

        $data = $request->all();
        if (request()->hasFile('image') && request()->image->isValid()) {
            $data['fromUrl'] = $request->file('image')->getRealPath();
        }
        $category = $this->categoryRepository->create($data);

        Flash::success('Category saved successfully.');

        return redirect(route('category.categories.index'));
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        request()->merge([
            'include' => 'attributeGroups',
        ]);
        $category = $this->categoryRepository->find($id);
        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('category.categories.index'));
        }

        // dd($attributeGroupRequest->query(),$categoryRequest->query());
        $attributeGroups = $this->prepareDataForSelectTag($this->attributeGroupRepository->getAll(), true, $category->attributeGroups);
        // $attributeGroups = [];
        $this->setSeo([
            'title' => 'edit category ' . $category->translate(app()->getLocale(), true)->name,
            'description' => 'category description',
            'keywords' => 'category keywords',
            'canonical' => url()->current(), //ko bao gồm # (nội link) và ko có các query string

            'og:type' => 'og type',
            'og:title' => 'og title',
            'og:description' => 'og decs',
            'og:url' => url()->current(),
            'og:site_name' => config('app.name'),

            'wt:type' => 'wt:type',
            'wt:title' => 'wt:title',
            'wt:description' => 'wt:description',
            'wt:url' => url()->current(),
            'wt:site' => config('app.name'),
        ]);
        return view('category.categories.edit', compact('attributeGroups'))->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $category = $this->categoryRepository->findById($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('category.categories.index'));
        }
        $validatedData = $request->validate(array_merge($this->categoryRepository->model()::getEditRules($category->id)));
        $data = $request->all();
        if (request()->hasFile('image') && request()->image->isValid()) {
            $data['fromUrl'] = $request->file('image')->getRealPath();
        }

        $category = $this->categoryRepository->update($category, $data);

        Flash::success('Category updated successfully.');

        return redirect(route('category.categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('category.categories.index'));
        }

        // $this->categoryRepository->delete($id);
        $this->categoryRepository->delete($category);

        Flash::success('Category deleted successfully.');

        return redirect(route('category.categories.index'));
    }
    public function forceDelete($id)
    {
        $category = $this->categoryRepository->find($id);
        if (empty($category)) {
            Flash::error('Category not found');
            return back();
        }

        if ($this->categoryRepository->forceDelete($category)) {
            Flash::success('Category deleted successfully.');
        } else {
            Flash::success('Category not delete');
        }

        return back();
    }
    public function export ()
    {
        return $this->categoryRepository->export();
    }
    public function import ()
    {
        return $this->categoryRepository->import();
    }

}
