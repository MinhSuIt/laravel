<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Attribute\AttributeOption;
use Faker\Generator as Faker;

$factory->define(AttributeOption::class, function (Faker $faker) {
    return [
        'sort_order'=>0
    ];
});
