<?php

use App\Models\Attribute\AttributeGroup;
use App\Models\Category\Category;
use App\Models\Category\CategoryAttributeGroup;
use App\Models\Category\CategoryTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAttributeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < config('seeder.'.Category::class); $i++) {
            for ($j=1; $j <= config('seeder.'.AttributeGroup::class); $j++) { 
                $arr[] = $j;
            }
            $rand = array_rand($arr,config('seeder.'.CategoryAttributeGroup::class));
            foreach ($rand as $value) {
                factory(CategoryAttributeGroup::class)->create([
                    'category_id' => $i+1,
                    'attribute_group_id' => $arr[$value],
                ]);
            }

        }
    }
}
