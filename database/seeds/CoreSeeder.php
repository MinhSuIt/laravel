<?php

use Illuminate\Database\Seeder;

class CoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->insert([
            'code' => 'vi',
            'name' => 'VietNamese',
            'direction' => 'ltr'
        ]);

        DB::table('locales')->insert([
            'code' => 'en',
            'name' => 'English',
            'direction' => 'rtl'
        ]);
        currency()->create([
            'name' => 'U.S. Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'format' => '$1,0.00',
            'exchange_rate' => 1.00000000,
            'active' => 1,
        ]);
        currency()->create([
            'name' => 'Vietnam dong',
            'code' => 'VND',
            'symbol' => 'd',
            'format' => '22000,0.00d',
            'exchange_rate' => 22000.00000000,
            'active' => 1,
        ]);
    }
}
