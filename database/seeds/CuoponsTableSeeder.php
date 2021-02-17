<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuoponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('cuopons')->insert([
            'id' => 1,
            'name' => 'mã giảm giá 1',
            'description' => 'mã giảm giá 1',
            'starts_from' => '2020-12-02',
            'ends_till' => '2020-12-12',
            'amount' => 12,
            'status' => true,
            'isPercent' => true,
            'isTotalCoupon' => true,
            'value' => 0.3,
            'product_ids' => null,
        ]);
        // DB::table('cart')->insert([
        //     'id' => 1,
        //     'is_active' => true,
        //     'customer_id' => 1,
        //     'coupon_id' => 1
        // ]);
        // DB::table('cart_items')->insert([
        //     'id' => 1,
        //     'quantity' => 1,
        //     'additional' => '',
        //     'product_id' => 1,
        //     "cart_id" => 1
        // ]);
        // DB::table('cart_items')->insert([
        //     'id' => 2,
        //     'quantity' => 2,
        //     'additional' => '',
        //     'product_id' => 2,
        //     "cart_id" => 1
        // ]);
    }
}
