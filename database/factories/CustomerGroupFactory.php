<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer\CustomerGroup;
use Faker\Generator as Faker;

$factory->define(CustomerGroup::class, function (Faker $faker) {

    return [
        'sort_order' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
