<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Cart\Order;
use App\Models\Cart\OrderItem;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Order::class, function (Faker $faker) {
    $created_at = Arr::random([2014,2015,2016,2018,2019,2020]).'-'.rand(1,12).'-'.rand(1,30);
    $created_at = Carbon::createFromFormat('Y-m-d', $created_at);
    $order = new Order();
    return [
        "email"=>$faker->email,
        "name"=>$faker->userName,
        // "items_count"=>1,
        // "items_qty",
        // "subTotal",
        // "total"=>,
        // "customer_id"=>1,

        "address"=>$faker->address,
        "phoneNumber"=>$faker->phoneNumber,
        "coupon"=>null,
        "status"=>$faker->randomElement(array_keys($order->statusLabel)),
        "currency"=>"USD",
        'created_at' =>  $created_at,
        "exchange_rate"=>'12.00'
    ];
});
