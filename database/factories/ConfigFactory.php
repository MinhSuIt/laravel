<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Core\Config;
use Faker\Generator as Faker;

$factory->define(Config::class, function (Faker $faker) {

    return [
        'code' => $faker->word,
        'value' => $faker->text,
        'descriptions' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
