<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product\ProductTranslation;
use Faker\Generator as Faker;

$factory->define(ProductTranslation::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'slug'=>$faker->sentence(10,true),
        'description'=>$faker->sentence(20,true),
        'content'=>$faker->paragraph(50,true),
        'meta_title'=>$faker->sentence(10,true),
        'meta_description'=>$faker->sentence(20,true),
        'meta_keywords'=>$faker->sentence(10,true),
        // product_id
        //locale

    ];
});
