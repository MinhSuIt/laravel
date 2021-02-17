<?php

namespace App\Models\Coupon;

use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Product\ProductRepository;
use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class Coupon
 * @package App\Models\Coupon
 * @version November 16, 2020, 1:03 pm UTC
 *
 * @property boolean $isPercent
 * @property boolean $isTotalCoupon
 * @property unsignedInteger $product_id
 */
class Coupon extends Model
{
    use SoftDeletes;

    public $table = 'cuopons';


    protected $dates = ['deleted_at'];



    public $fillable = [
        "name",
        "amount",
        "value",
        "status",
        "description",
        'product_ids',
        'starts_from',
        'ends_till',
        'isPercent',
        'isTotalCoupon',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "name" => 'string',
        "amount" => 'integer',
        "value" => 'float',
        "status" => 'boolean',
        "description" => 'string',
        'product_ids' => 'array',
        'starts_from' => 'date',
        'ends_till' => 'date',
        'id' => 'integer',
        'isPercent' => 'boolean',
        'isTotalCoupon' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'isPercent' => 'required',
        // 'isTotalCoupon' => 'required'
    ];
    public function isValuable()
    {
        // dd( now() > $this->starts_from);
        if ($this->status && $this->amount > 0 && now() < $this->ends_till) {
            return true;
        }
        return false;
    }
    public function getValue()
    {
        if (
            currency()->getUserCurrency() ||
            request()->query('currency')
        ) {
            if ($this->isPercent) {
                return (float) $this->value . "(%)";
            }
            return currency($this->value, config('currency.default'), currency()->getUserCurrency());
        }
        return $this->price;
    }
    public function getKindOfCoupon()
    {
        if ($this->isTotalCoupon) {
            return "Coupon cho giỏ hàng";
        } else {
            return "Coupon cho product";
        }
    }
    public function products() : Collection
    {
        //xóa các method getAll thay vào đó tạo request như bên dưới để tạo đường dẫn cho allQuery
        if (!$this->isTotalCoupon) {
            $productRepository = app()->make(ProductRepository::class);
            $requestQuery = app(Request::class);
            $requestQuery->merge([
                'filter' => ['id' => implode(",", $this->product_ids)],
            ]);

            return $productRepository->all($requestQuery);
        }
        return collect([]);
    }
    public function getDateStart()
    {
        return $this->starts_from->format('Y-m-d');
        // return Carbon::parse($this->starts_from)->format('Y-m-d\TH:i');
    }

    public function getDateEnd()
    {
        return $this->ends_till->format('Y-m-d');

    }
}
