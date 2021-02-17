<?php

namespace App\Repositories\Cart;

use App\Library\QueryBuilder;
use App\Models\Cart\Order;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class OrderRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return Mixed
     */

    function model()
    {
        return Order::class;
    }

    public function allQuery($builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);;

        $allQuery->allowedFields([
        ])
            ->allowedIncludes([
               'orderItems'
            ])
            ->allowedSorts([
                'status',
                
            ])
            ->allowedFilters([
                'name','email',AllowedFilter::exact('status')
            ]);
        return $allQuery;
    }
    public function create($data)
    {
        $this->model->create($data);
        return true;
    }
}