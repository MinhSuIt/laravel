<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Coupon\Coupon;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

$factory->define(Coupon::class, function (Faker $faker) {
    // 'name' => 'mã giảm giá 1',
    // 'description' => 'mã giảm giá 1',
    // 'starts_from' => '2020-12-02',
    // 'ends_till' => '2020-12-12',
    // 'amount' => 12,
    // 'status' => true,
    // 'isPercent' => true,
    // 'isTotalCoupon' => true,
    // 'value' => 0.3,
    // 'product_ids' => null,
    $starts_from = Arr::random([2020,2019,2018,2016,2015]).'-'.rand(1,12).'-'.rand(1,30);
    $ends_till = Carbon::createFromTimeString($starts_from)->addDays(8);
    $isPercent =rand(0,1);
    if($isPercent==1){
        $value = Arr::random([0.1,0.2,0.3,0.4,0.5]);
    }else{
        $value = rand(1,10);
    }
    $isTotalCoupon = rand(0,1);
    if($isTotalCoupon==1){
        $product_ids = null;
    }else{
        $product_ids = [
            rand(1,400),
            rand(1,400),
            rand(1,400),
            rand(1,400),
        ];
    }
    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'starts_from' =>$starts_from,
        'ends_till' =>  $ends_till,
        'amount' => rand(1,20),
        'isPercent' => $isPercent,
        'status' => true,
        'isTotalCoupon' => $isTotalCoupon,
        'product_ids' => $product_ids,
        'value'=> $value,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
