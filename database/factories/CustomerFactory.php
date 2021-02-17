<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer\Customer;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

$factory->define(Customer::class, function (Faker $faker) {

    $created_at = Arr::random([2014,2015,2016,2018,2019,2020]).'-'.rand(1,12).'-'.rand(1,30);
    $created_at = Carbon::createFromFormat('Y-m-d', $created_at);
    return [
        'name' => $faker->word,
        'email' => $faker->email,
        'password'=>Hash::make('123456'),
        'status' => true,
        'token' => '',
        'remember_token' => '',
        'phoneNumber'=>"091".rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9),
        'created_at' =>  $created_at,
        // 'updated_at' => $faker->date('Y-m-d H:i:s'),
        'customer_group_id'=>rand(1,2),
        'address'=>$faker->address                             ,
    ];
});
