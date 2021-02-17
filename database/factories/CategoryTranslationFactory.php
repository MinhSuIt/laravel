<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Category\CategoryTranslation;
use Faker\Generator as Faker;


$factory->define(CategoryTranslation::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'description'=>$faker->word,
        // 'locale'=>'vi',
        // 'category_id'=>1,
        'slug'=>'',
        'meta_title'=>'',
        'meta_description'=>'',
        'meta_keywords'=>'',

    ];
});