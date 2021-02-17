<?php

namespace App\Http\Controllers\Product;

use App\Exports\ProductsExport;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\Product\ProductRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Product\Product;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Category\CategoryRepository;
use DOMDocument;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;
use Response;

class ProductController extends AppBaseController
{
    private $productRepository;
    private $attributeRepository;
    private $categoryRepository;

    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepository, AttributeRepository $attributeRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepo;
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attributeRepository;

        $this->middleware($this->categoryRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::COLLECTION_TAG, ['only' => ['index']] );
        $this->middleware($this->categoryRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->categoryRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->categoryRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->categoryRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
    {
        // làm chức năng tìm sản phẩm theo attributeoption theo danh muc ví dụ các sản phẩm có màu đỏ (dựa vào bảng product attribute option by category)
        $attributes = $this->attributeRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        request()->merge([
            'include' => 'categories,attributes,attributeOptions,media',
        ]);
        // dd(request()->query());
        $products = $this->productRepository->paginate();
        $this->setSeo([
            'title'=>'product index',
            'description'=>'product description',
            'keywords'=>'product keywords',
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
        return view('product.products.index', compact('products', 'attributes', 'categories'))->with('importType', 'product');
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $categoriesCus = $this->prepareDataForSelectTag($this->categoryRepository->getAll(),false,collect());
        $this->setSeo([
            'title'=>'product create',
            'description'=>'product description',
            'keywords'=>'product keywords',
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
        return view('product.products.create', compact('categoriesCus'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */



    public function store(Request $request)
    {
        // dd($this->categoryRepository->get_images($request->all()['vi']['content']));
        // dd(Storage::disk('public')->put('abc.png', $request->all()['vi']['content']));
        $data = $request->all();

        // $validatedData = $request->validate($this->productRepository->model()::getAddRules());

        if (request()->hasFile('image') && request()->image->isValid()) {
            $data['fromUrl'] = $request->file('image')->getRealPath();
        }
        if ($request->has('images')) {
            $images = $request->images;
            $urls = [];
            foreach ($images as $image) {
                $urls[] = $image->getRealPath();
            }
            $data['urlListOfImages'] = $urls;
        }

        $product = $this->productRepository->create($data);

        Flash::success('Product saved successfully.');

        return redirect(route('product.products.index'));
    }

    // public function show($id)
    // {
    //     $product = $this->productRepository->find($id);

    //     if (empty($product)) {
    //         Flash::error('Product not found');

    //         return redirect(route('product.products.index'));
    //     }

    //     return view('product.products.show')->with('product', $product);
    // }

    /**
     * Show the form for editing the specified Product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        request()->merge([
            'include' => 'translations,categories',
        ]);
        $product = $this->productRepository->find($id);
        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('product.products.index'));
        }

        $categoriesCus = $this->prepareDataForSelectTag($this->categoryRepository->getAll(),true,$product->categories);

        $this->setSeo([
            'title'=>'edit product '.$product->translate(app()->getLocale(),true)->name,
            'description'=>'product description',
            'keywords'=>'product keywords',
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
        return view('product.products.edit', compact('product', 'categoriesCus'));
    }

    /**
     * Update the specified Product in storage.
     *
     * @param int $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();

        $product = $this->productRepository->findById($id);
        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('product.products.index'));
        }


        // $validatedData = $request->validate($this->productRepository->model()::getEditRules($product));


        if (request()->hasFile('image') && request()->image->isValid()) {
            $data['fromUrl'] = $request->file('image')->getRealPath();
        }
        if ($request->has('images')) {
            $images = $request->images;
            $urls = [];
            foreach ($images as $image) {
                $urls[] = $image->getRealPath();
            }
            $data['urlListOfImages'] = $urls;
        }


        $product = $this->productRepository->update($product,$data);

        Flash::success('Product updated successfully.');

        return redirect(route('product.products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('product.products.index'));
        }

        $this->productRepository->delete($product);

        Flash::success('Product deleted successfully.');

        return redirect(route('product.products.index'));
    }
    public function forceDelete($id)
    {
        $product = $this->productRepository->find($id);
        if (empty($product)) {
            Flash::error('product not found');
            return back();
        }

        if ($this->productRepository->forceDelete($product)) {
            Flash::success('product deleted successfully.');
        } else {
            Flash::success('product not delete');
        }

        return back();
    }
    // public function setExport()
    // {
    //     return ProductsExport::class;
    // }
}
