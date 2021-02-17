<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    public $table = 'product_images';
    public $timestamps = false;

    public $fillable = [
        'image',
    ];
    const IMAGE_DISK = "public";
    const IMAGE_DIR = "/product-images"; //chưa lưu image theo id của product,có thể chỉnh lại sau

    const IMAGE_WIDTH = 300;
    const IMAGE_HEIGHT = 300;
    public function image_url()
    {
        if (! $this->image)
            return;

        return Storage::url($this->image);
    }
}
