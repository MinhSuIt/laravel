<?php

namespace App\Repositories\Coupon;

use App\Library\QueryBuilder;
use App\Models\Coupon\Coupon;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class CouponRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/

    public function model()
    {
        return Coupon::class;
    }
    public function allQuery( $builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);
        $allQuery->allowedFilters([
            AllowedFilter::trashed(),
        ]);
        return $allQuery;
    }
    public function create($data){
        if(!$data['isTotalCoupon']){
            if(isset($data['product_id']) && is_array($data['product_id'])){
                parent::create((array_merge($data,['product_ids'=>$data['product_id']])));
            }
        }else{
            parent::create(array_merge($data,['product_id'=>null]));
        }
    }
    public function update($data,$id){
        if(!$data['isTotalCoupon']){
            if(isset($data['product_id']) && is_array($data['product_id'])){
                parent::update((array_merge($data,['product_ids'=>$data['product_id']])),$id);
            }
        }else{
            parent::create(array_merge($data,['product_id'=>null]),$id);
        }
    }
    public function getProductsOfCoupon(Coupon $coupon)
    {
        return $coupon->products();
    }
}
