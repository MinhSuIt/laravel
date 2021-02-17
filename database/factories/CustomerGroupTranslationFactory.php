<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer\CustomerGroupTranslation;
use Faker\Generator as Faker;

$factory->define(CustomerGroupTranslation::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'descriptions' => $faker->word,
    ];
});
