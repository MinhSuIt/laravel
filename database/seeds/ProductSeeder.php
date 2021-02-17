<?php

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductAttributeOption;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductTranslation;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('products')->insert([
        //     'id'=>1,
        //     'sku'=>'SSS',
        //     'amount'=>10,
        //     'price' => 1,
        //     'image' => '',
        //     // 'status' => 1,
        // ]);
        // DB::table('product_translations')->insert([
        //     'name'=>'Máy tính 1',
        //     'description'=>'Máy tính 1',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'product_id'=>1,
        //     'content'=>'<h5>asdsadsadsadsadasdsad ấ ssd  asdsad asd asd </h5>'
        // ]);
        // DB::table('product_translations')->insert([
        //     'name'=>'Laptop 1',
        //     'description'=>'Laptop 1',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'product_id'=>1,
        //     'content'=>'<h5>asdsadsadsadsadasdsad ấ ssd  asdsad asd asd </h5>'

        // ]);
        // DB::table('category_product')->insert([
        //     'category_id'=>1,
        //     'product_id' => 1,
        // ]);
        // DB::table('category_product')->insert([
        //     'category_id'=>2,
        //     'product_id' => 1,
        // ]);

        // DB::table('product_attribute')->insert([
        //     'attribute_id'=>1,
        //     'product_id' => 1,
        // ]);
        // DB::table('product_attribute')->insert([
        //     'attribute_id'=>3,
        //     'product_id' => 1,
        // ]);

        // DB::table('products')->insert([
        //     'id'=>2,
        //     'sku'=>'SSS2',
        //     'amount'=>102,
        //     'price' => 2,
        //     'image' => '',
        //     // 'status' => 1,
        // ]);
        // DB::table('product_translations')->insert([
        //     'name'=>'Máy tính 2',
        //     'description'=>'Máy tính 2',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'product_id'=>2,
        //     'content'=>'<h5>asdsadsadsadsadasdsad ấ ssd  asdsad asd asd </h5>'

        // ]);
        // DB::table('product_translations')->insert([
        //     'name'=>'Laptop 2',
        //     'description'=>'Laptop 2',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'product_id'=>2,
        //     'content'=>'<h5>asdsadsadsadsadasdsad ấ ssd  asdsad asd asd </h5>'

        // ]);
        // DB::table('category_product')->insert([
        //     'category_id'=>1,
        //     'product_id' => 2,
        // ]);
        // DB::table('category_product')->insert([
        //     'category_id'=>3,
        //     'product_id' => 2,
        // ]);

        // DB::table('product_attribute')->insert([
        //     'attribute_id'=>2,
        //     'product_id' => 2,
        // ]);
        // DB::table('product_attribute')->insert([
        //     'attribute_id'=>4,
        //     'product_id' => 2,
        // ]);

        factory(Product::class, config('seeder.'.Product::class))->create()->each(function ($product) {
            $product->translations()->save(factory(ProductTranslation::class)->make([
                'product_id'=>$product->id,
                'locale'=>'vi'
            ]));
            $product->translations()->save(factory(ProductTranslation::class)->make([
                'product_id'=>$product->id,
                'locale'=>'en'
            ]));

            // factory(ProductImage::class, 3)->create([
            //     'product_id'=>$product->id
            // ]);


        });
    }
}
