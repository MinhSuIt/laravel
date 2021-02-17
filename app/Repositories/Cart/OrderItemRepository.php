<?php

namespace App\Repositories\Cart;

use App\Library\QueryBuilder;
use App\Models\Cart\Order;
use App\Models\Cart\OrderItem;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class OrderItemRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return Mixed
     */

    function model()
    {
        return OrderItem::class;
    }


    public function allQuery($builder = null)
    {
        $allQuery = $this->getQueryBuilder();;

        $allQuery->allowedFields([
        ])
            ->allowedIncludes([
               
            ]);
        return $allQuery;
    }
    public function create($data)
    {
        $this->model->create($data);
        return true;
    }
}