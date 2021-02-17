<?php

namespace App\Repositories\Cart;

use App\Library\QueryBuilder;
use App\Models\Cart\CartItem;
use App\Models\Product\Product;
use App\Repositories\BaseRepository;

class CartItemRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return CartItem::class;
    }
    public function allQuery()
    {
        $allQuery = $this->getQueryBuilder();;

        $allQuery->allowedFields([
        ])
            ->allowedIncludes([
               
            ]);
        return $allQuery;
    }
    // public function getProduct($cartItemId)
    // {
    //     return $this->model->find($cartItemId)->product->id;
    // }
    
}