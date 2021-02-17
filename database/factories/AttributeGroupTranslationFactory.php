<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Attribute\AttributeGroupTranslation;
use Faker\Generator as Faker;

$factory->define(AttributeGroupTranslation::class, function (Faker $faker) {
    return [
        'name' =>$faker->word,
        // 'locale' =>,
        // 'attribute_group_id'
    ];
});
