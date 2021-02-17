<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Attribute\AttributeOptionTranslation;
use Faker\Generator as Faker;

$factory->define(AttributeOptionTranslation::class, function (Faker $faker) {
    return [
        'name' =>$faker->word
    ];
});
