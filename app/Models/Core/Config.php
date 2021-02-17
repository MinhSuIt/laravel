<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Config
 * @package App\Models\Core
 * @version September 11, 2020, 2:39 pm UTC
 *
 * @property string $code
 * @property string $value
 * @property string $descriptions
 */
class Config extends Model
{
    use SoftDeletes;

    public $table = 'configs';

    const COLLECTION_TAG = 'configs';
    // const CREATE_TAG = 'create-config';
    const SHOW_TAG = 'show-config';
    const EDIT_TAG = 'edit-config';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    // const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    //tạo thêm bảng page -page translations nữa để làm thêm nội dung tĩnh như trang giới thiệu,...
    // ['super-high','high', 'medium','normal','slow','super-slow']


    protected $dates = ['deleted_at'];
    const send_mail_after_customer_registed = 'send_mail_after_customer_registed';
    const notify_sale_product = 'notify_sale_product';
    const notify_new_product = 'notify_new_product';
    const CONFIGS = [
        [
            'code'=>self::send_mail_after_customer_registed,
            'descriptions'=>'gửi mail sau khi đăng ký',
            'value'=>true,
            'priority'=>'high'
        ],
        [
            'code'=>self::notify_sale_product,
            'descriptions'=>'thông báo khi sản phẩm được giảm giá',
            'value'=>true,
            'priority'=>'super-high'

        ],
        [
            'code'=>self::notify_new_product,
            'descriptions'=>'thông báo khi có sản phẩm mới',
            'value'=>true,
            'priority'=>'medium'
        ],
    ];

    public $fillable = [
        'code',
        'value',
        'descriptions'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'value' => 'string',
        'descriptions' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'value' => 'required',
        'descriptions' => 'required'
    ];

    public function getValue()
    {
        if($this->value){
            return 'Có';
        }
        return 'Không';
    }
    
}
