<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [
        'sku' => $faker->word,
        'amount' => $faker->numberBetween($min = 10, $max = 900),
        'price' => $faker->numberBetween($min = 10, $max = 900),
        'image' => '',
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
