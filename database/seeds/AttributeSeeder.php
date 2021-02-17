<?php

use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Attribute\AttributeTranslation;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('attributes')->insert([
        //     'id'=>1,
        //     'status' => true,
        //     'attribute_group_id'=>1
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Đỏ',
        //     'slug'=>'do',
        //     'locale'=>'vi',
        //     'attribute_id'=>1
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Red',
        //     'slug'=>'red',
        //     'locale'=>'en',
        //     'attribute_id'=>1
        // ]);
        // DB::table('attributes')->insert([
        //     'id'=>2,
        //     'status' => true,
        //     'attribute_group_id'=>1
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Xanh',
        //     'slug'=>'Xanh',
        //     'locale'=>'vi',
        //     'attribute_id'=>2
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Green',
        //     'slug'=>'Green',
        //     'locale'=>'en',
        //     'attribute_id'=>2
        // ]);

        // DB::table('attributes')->insert([
        //     'id'=>3,
        //     'status' => true,
        //     'attribute_group_id'=>2
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Cỡ vừa',
        //     'slug'=>'co-vua',
        //     'locale'=>'vi',
        //     'attribute_id'=>3
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Medium',
        //     'slug'=>'Medium',
        //     'locale'=>'en',
        //     'attribute_id'=>3
        // ]);
        // DB::table('attributes')->insert([
        //     'id'=>4,
        //     'status' => true,
        //     'attribute_group_id'=>2
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Cỡ lớn',
        //     'slug'=>'co-lon',
        //     'locale'=>'vi',
        //     'attribute_id'=>4
        // ]);
        // DB::table('attribute_translations')->insert([
        //     'name'=>'Large',
        //     'slug'=>'Large',
        //     'locale'=>'en',
        //     'attribute_id'=>4
        // ]);

        for ($i=0; $i < config('seeder.'.AttributeGroup::class); $i++) { 
            factory(Attribute::class, config('seeder.'.Attribute::class))->create([
                'attribute_group_id' => $i+1,
            ])->each(function ($attribute) {
                $attribute->translations()->save(factory(AttributeTranslation::class)->make([
                    'attribute_id' => $attribute->id,
                    'locale' => 'vi'
                ]));
                $attribute->translations()->save(factory(AttributeTranslation::class)->make([
                    'attribute_id' => $attribute->id,
                    'locale' => 'en'
                ]));
            });
        }
        
    }
}
