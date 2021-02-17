<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    //đã thêm trường category_id vào migration nhưng chưa sửa seeder và model
    protected $table="product_attribute_options";
    public $timestamps = false;
}
