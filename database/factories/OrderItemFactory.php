<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Cart\Order;
use App\Models\Cart\OrderItem;
use Faker\Generator as Faker;


$factory->define(OrderItem::class, function (Faker $faker) {
    $quantity = $faker->numberBetween(1, 20);
    $price = $faker->numberBetween(1, 200);
    return [
        "sku"=>$faker->userName,
        "name"=>$faker->userName,
        "quantity"=>$quantity,
        "price"=>$price,
        "total"=>$quantity*$price,
        "additional"=>''
    ];
});