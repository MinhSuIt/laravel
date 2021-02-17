<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Attribute\Attribute;
use App\Models\Category\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'position'=>0,
        'image'=>'',
        'status' => true,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});

