<?php

use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeOption;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductAttributeOption;
use Illuminate\Database\Seeder;

class ProductAttributeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {





        for ($i = 1; $i <= config('seeder.' . Product::class); $i++) {

            for ($j = 1; $j <= config('seeder.' . AttributeOption::class); $j++) {
                $arr[] = $j;
            }
            $rand = array_rand($arr, config('seeder.' . ProductAttributeOption::class));




            foreach ($rand as $key => $value) {
                factory(ProductAttributeOption::class)->create([
                    'product_id' => $i,
                    'attribute_option_id' => $arr[$value],
                ]);
            }
        }
    }
}
