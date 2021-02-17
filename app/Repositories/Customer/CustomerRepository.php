<?php

namespace App\Repositories\Customer;

use App\Library\QueryBuilder;
use App\Models\Customer\Customer;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class CustomerRepository
 * @package App\Repositories\Customer
 * @version September 11, 2020, 2:52 pm UTC
 */

class CustomerRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }
    public function allQuery($builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);;

        $allQuery->allowedFields([])
            ->allowedFilters([
                'name','email',
                AllowedFilter::callback('customer_group_id', function ($query,$value) {
                    $results = $query->whereHas('customerGroup', function ($q) use ($value) {
                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('customer_group_id', $value);
                    });
                    return $results;
                }),
            ])
            ->allowedIncludes([
                'customerGroup'
            ]);
        return $allQuery;
    }
}
