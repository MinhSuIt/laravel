<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Requests\API\Category\CreateCategoryAPIRequest;
use App\Http\Requests\API\Category\UpdateCategoryAPIRequest;
use App\Models\Category\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Category as ResourcesCategory;
use Response;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API\Category
 */

class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $categories = ResourcesCategory::collection($this->categoryRepository->paginate());

        //do fields của laravel query builder chỉ xài đc ở bảng chính,nên ở các relationship sẽ ko dùng fields chỉ dùng fields ở bảng chính
        //điều kiện trả về của mỗi trường dạng fields :
        // sử dụng explode(,) thành mảng đoạn này=> request->has('fields[bảng chính]'),request->has('fields[relationship.relationship...]' ),
        //rôì check xem có trường đó trong mảng trả về có thì trả về trường
        //sử dụng api resource để lọc lại giá trị trả về thay vì sử dụng fields,ngoài ra có quyết định hiển thị các trường theo vai trò khi gọi api 
        return $this->sendResponse($categories, 'Categories retrieved successfully');
    }

    /**
     * Store a newly created Category in storage.
     * POST /categories
     *
     * @param CreateCategoryAPIRequest $request
     *
     * @return Response
     */
    // public function store(CreateCategoryAPIRequest $request)
    // {
    //     $input = $request->all();

    //     $category = $this->categoryRepository->create($input);

    //     return $this->sendResponse($category->toArray(), 'Category saved successfully');
    // }

    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = new ResourcesCategory($this->categoryRepository->find($id));

        if (!$category) {

            return $this->sendError('Category not found');
        }

        return $this->sendResponse($category, 'Category retrieved successfully');
    }

    /**
     * Update the specified Category in storage.
     * PUT/PATCH /categories/{id}
     *
     * @param int $id
     * @param UpdateCategoryAPIRequest $request
     *
     * @return Response
     */
    // public function update($id, UpdateCategoryAPIRequest $request)
    // {
    //     $input = $request->all();

    //     /** @var Category $category */
    //     $category = $this->categoryRepository->find($id);

    //     if (empty($category)) {
    //         return $this->sendError('Category not found');
    //     }

    //     $category = $this->categoryRepository->update($input, $id);

    //     return $this->sendResponse($category->toArray(), 'Category updated successfully');
    // }

    /**
     * Remove the specified Category from storage.
     * DELETE /categories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    // public function destroy($id)
    // {
    //     /** @var Category $category */
    //     $category = $this->categoryRepository->find($id);

    //     if (empty($category)) {
    //         return $this->sendError('Category not found');
    //     }

    //     $category->delete();

    //     return $this->sendSuccess('Category deleted successfully');
    // }
}
