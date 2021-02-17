<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Attribute\AttributeTranslation;
use Faker\Generator as Faker;

$factory->define(AttributeTranslation::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'slug'=>$faker->slug,
    ];
});
