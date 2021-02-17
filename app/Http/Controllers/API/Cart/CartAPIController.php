<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\AppBaseController;
use App\Providers\CartFacade;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API\Category
 */

class CartAPIController extends AppBaseController
{

    // public function __construct()
    // {

    // }

    public function index()
    {
        return CartFacade::getFullInfoFromCart();
        // $categories = ResourcesCategory::collection($this->categoryRepository->paginate(1));

        // return $this->sendResponse($categories, 'Categories retrieved successfully');
    }
    public function add($productId)
    {
        $add = CartFacade::addProduct($productId,request());
        return $add;
        // return $this->sendResponse($categories, 'Categories retrieved successfully');
    }
    public function update()
    {
        CartFacade::updateItems(request()->all());
    }

    public function destroy()
    {
        return CartFacade::deleteCart();
    }
}
