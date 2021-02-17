<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PENDING_PAYMENT = 'pending_payment';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_FRAUD = 'fraud';

    public $statusLabel = [
        self::STATUS_PENDING         => 'Pending', //đơn hàng mới
        self::STATUS_PENDING_PAYMENT => 'Pending Payment', //chờ thanh toán
        self::STATUS_PROCESSING      => 'Processing', //trong quá trình chuẩn bị hàng hoặc vận chuyển
        self::STATUS_COMPLETED       => 'Completed',//đã gửi
        self::STATUS_CANCELED        => 'Canceled',//đã hủy
        self::STATUS_CLOSED          => 'Closed',//đã xử lý xong,tính doanh thu tại bước này
        self::STATUS_FRAUD           => 'Fraud',//nghi vấn gian lận
    ];
    
    protected $table = 'order';

    const COLLECTION_TAG = 'order';
    const CREATE_TAG = 'create-order';
    const SHOW_TAG = 'show-order';
    const EDIT_TAG = 'edit-order';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    // protected $with = 'orderItems';
    protected $fillable  = [
        "customer_id",
        "email",
        "name",
        "items_count",
        "items_qty",
        "subTotal",
        "total",
        "address",
        "phoneNumber",
        "coupon",
        "currency",
        "exchange_rate"
    ];
    protected $casts = [
        'coupon' => 'json',
    ];
    protected $attributes = [
        'coupon' => null,
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
