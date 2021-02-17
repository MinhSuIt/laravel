<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Core\Currency;
use Faker\Generator as Faker;

$factory->define(Currency::class, function (Faker $faker) {

    return [
        'code' => $faker->word,
        'name' => $faker->word,
        'rate' => 1,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
