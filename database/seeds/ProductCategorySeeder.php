<?php

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= config('seeder.' . Product::class); $i++) {

            for ($j = 1; $j <= config('seeder.' . Category::class); $j++) {
                $arr[] = $j;
            }
            $rand = array_rand($arr, config('seeder.' . ProductCategory::class));




            foreach ($rand as $key => $value) {
                factory(ProductCategory::class)->create([
                    'product_id' => $i,
                    'category_id' => $arr[$value],
                ]);
            }
        }
    }
}
