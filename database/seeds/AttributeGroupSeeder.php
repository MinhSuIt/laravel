<?php

use App\Models\Attribute\AttributeGroup;
use App\Models\Attribute\AttributeGroupTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('attribute_groups')->insert([
        //     'id'=>1,
        //     'status' => true,
        // ]);
        // DB::table('attribute_group_translation')->insert([
        //     'name'=>'Màu sắc',
        //     'locale'=>'vi',
        //     'attribute_group_id'=>1
        // ]);
        // DB::table('attribute_group_translation')->insert([
        //     'name'=>'Color',
        //     'locale'=>'en',
        //     'attribute_group_id'=>1
        // ]);
        // DB::table('category_attribute_group')->insert([
        //     'category_id'=>1,
        //     'attribute_group_id'=>1
        // ]);
        // DB::table('category_attribute_group')->insert([
        //     'category_id'=>2,
        //     'attribute_group_id'=>1
        // ]);
        // DB::table('attribute_groups')->insert([
        //     'id'=>2,
        //     'status' => true,
        // ]);
        // DB::table('attribute_group_translation')->insert([
        //     'name'=>'Kích cỡ',
        //     'locale'=>'vi',
        //     'attribute_group_id'=>2
        // ]);
        // DB::table('attribute_group_translation')->insert([
        //     'name'=>'Size',
        //     'locale'=>'en',
        //     'attribute_group_id'=>2
        // ]);
        // DB::table('category_attribute_group')->insert([
        //     'category_id'=>1,
        //     'attribute_group_id'=>2
        // ]);
        // DB::table('category_attribute_group')->insert([
        //     'category_id'=>3,
        //     'attribute_group_id'=>2
        // ]);

        factory(AttributeGroup::class, config('seeder.'.AttributeGroup::class))->create()->each(function ($attributeGroup) {
            $attributeGroup->translations()->save(factory(AttributeGroupTranslation::class)->make([
                'attribute_group_id'=>$attributeGroup->id,
                'locale'=>'vi'
            ]));
            $attributeGroup->translations()->save(factory(AttributeGroupTranslation::class)->make([
                'attribute_group_id'=>$attributeGroup->id,
                'locale'=>'en'
            ]));
        });
    }
}
