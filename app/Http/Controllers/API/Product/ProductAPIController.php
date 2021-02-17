<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Requests\API\Product\CreateProductAPIRequest;
use App\Http\Requests\API\Product\UpdateProductAPIRequest;
use App\Models\Product\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\API\Product
 */

class ProductAPIController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     * GET|HEAD /products
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->paginate();

        return $this->sendResponse($products, 'Products retrieved successfully');
    }

    /**
     * Store a newly created Product in storage.
     * POST /products
     *
     * @param CreateProductAPIRequest $request
     *
     * @return Response
     */
    // public function store(CreateProductAPIRequest $request)
    // {
    //     $input = $request->all();

    //     $product = $this->productRepository->create($input);

    //     return $this->sendResponse($product->toArray(), 'Product saved successfully');
    // }

    /**
     * Display the specified Product.
     * GET|HEAD /products/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (!$product) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product, 'Product retrieved successfully');
    }

    /**
     * Update the specified Product in storage.
     * PUT/PATCH /products/{id}
     *
     * @param int $id
     * @param UpdateProductAPIRequest $request
     *
     * @return Response
     */
    // public function update($id, UpdateProductAPIRequest $request)
    // {
    //     $input = $request->all();

    //     /** @var Product $product */
    //     $product = $this->productRepository->find($id);

    //     if (empty($product)) {
    //         return $this->sendError('Product not found');
    //     }

    //     $product = $this->productRepository->update($input, $id);

    //     return $this->sendResponse($product->toArray(), 'Product updated successfully');
    // }

    /**
     * Remove the specified Product from storage.
     * DELETE /products/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    // public function destroy($id)
    // {
    //     /** @var Product $product */
    //     $product = $this->productRepository->find($id);

    //     if (empty($product)) {
    //         return $this->sendError('Product not found');
    //     }

    //     $product->delete();

    //     return $this->sendSuccess('Product deleted successfully');
    // }
}
