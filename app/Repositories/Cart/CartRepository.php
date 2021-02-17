<?php

namespace App\Repositories\Cart;

use App\Library\QueryBuilder;
use App\Models\Cart\Cart;
use App\Repositories\BaseRepository;

class CartRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return Mixed
     */

    function model()
    {
        return Cart::class;
    }


    // public function update(array $data, $id)
    // {
    //     $cart = $this->find($id);

    //     $cart->update($data);

    //     return $cart;
    // }


    // public function deleteParent($cartId) {
    //     $cart = $this->model->find($cartId);

    //     return $this->model->destroy($cartId);
    // }
    public function allQuery()
    {
        $allQuery = $this->getQueryBuilder();;

        $allQuery->allowedFields([
        ])
            ->allowedIncludes([
               
            ]);
        return $allQuery;
    }

}