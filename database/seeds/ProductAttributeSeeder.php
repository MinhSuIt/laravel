<?php

use App\Models\Attribute\Attribute;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= config('seeder.' . Product::class); $i++) {

            for ($j = 1; $j <= config('seeder.' . Attribute::class); $j++) {
                $arr[] = $j;
            }
            $rand = array_rand($arr, config('seeder.' . ProductAttribute::class));




            foreach ($rand as $key => $value) {
                factory(ProductAttribute::class)->create([
                    'product_id' => $i,
                    'attribute_id' => $arr[$value],
                ]);
            }
        }
    }
}
