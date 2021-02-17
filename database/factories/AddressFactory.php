<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {

    return [
        'addressable_id' => $faker->randomDigitNotNull,
        'addressable_type' => $faker->randomDigitNotNull,
        'info' => $faker->text
    ];
});
