<?php

use App\Models\Category\Category;
use App\Models\Category\CategoryAttributeGroup;
use App\Models\Category\CategoryTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('categories')->insert([
        //     'id'=>1,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Máy tính',
        //     'description'=>'Máy tính',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>1
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Laptop',
        //     'description'=>'Laptop',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>1
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>2,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Điện thoại',
        //     'description'=>'Điện thoại',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>2
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Smartphone',
        //     'description'=>'Smartphone',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>2
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>3,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Accessories',
        //     'description'=>'Accessories',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>3
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Phụ kiện',
        //     'description'=>'Phụ kiện',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>3
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>4,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Watch',
        //     'description'=>'Watch',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>4
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Đồng hồ',
        //     'description'=>'Đồng hồ',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>4
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>5,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Backpack',
        //     'description'=>'Backpack',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>5
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Ba lô',
        //     'description'=>'Ba lô',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>5
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>6,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Shoe',
        //     'description'=>'Shoe',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>6
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Giày',
        //     'description'=>'Giày',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>6
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>7,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Shirt',
        //     'description'=>'Shirt',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>7
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Áo',
        //     'description'=>'Áo',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>7
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>8,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Ring',
        //     'description'=>'Ring',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>8
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Nhẫn',
        //     'description'=>'Nhẫn',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>8
        // ]);
        // DB::table('categories')->insert([
        //     'id'=>9,
        //     'position' => 0,
        //     'image' => '',
        //     'status' => 1,
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Hat',
        //     'description'=>'Hat',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'en',
        //     'category_id'=>9
        // ]);
        // DB::table('category_translations')->insert([
        //     'name'=>'Nón',
        //     'description'=>'Nón',
        //     'slug'=>'',
        //     'meta_title'=>'',
        //     'meta_description'=>'',
        //     'meta_keywords'=>'',
        //     'locale'=>'vi',
        //     'category_id'=>9
        // ]);
        factory(Category::class, config('seeder.'.Category::class))->create()->each(function ($category) {
            $category->translations()->save(factory(CategoryTranslation::class)->create([
                'category_id'=>$category->id,
                'locale'=>'vi'
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->create([
                'category_id'=>$category->id,
                'locale'=>'en'
            ]));
        });
    }
}
