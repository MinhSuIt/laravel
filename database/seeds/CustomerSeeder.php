<?php

use App\Models\Cart\Order;
use App\Models\Cart\OrderItem;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerGroup;
use App\Models\Customer\CustomerGroupTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('customer_groups')->insert([
        //     'id'=>1,
        //     'sort_order' => 0,
        // ]);
        // DB::table('customer_group_translations')->insert([
        //     'name'=>'Vàng',
        //     'descriptions'=>'Vàng',
        //     'customer_group_id'=>1,
        //     'locale'=>'vi',
        // ]);
        // DB::table('customer_group_translations')->insert([
        //     'name'=>'Gold',
        //     'descriptions'=>'Gold',
        //     'customer_group_id'=>1,
        //     'locale'=>'en',
        // ]);
        // DB::table('customer_groups')->insert([
        //     'id'=>2,
        //     'sort_order' => 0,
        // ]);
        // DB::table('customer_group_translations')->insert([
        //     'name'=>'Kim cương',
        //     'descriptions'=>'Kim cương',
        //     'customer_group_id'=>2,
        //     'locale'=>'vi',
        // ]);
        // DB::table('customer_group_translations')->insert([
        //     'name'=>'Diamond',
        //     'descriptions'=>'Diamond',
        //     'customer_group_id'=>2,
        //     'locale'=>'en',
        // ]);

        // DB::table('customers')->insert([
        //     'name'=>'Trần Văn Tèo',
        //     'email'=>'tranvanteo@gmail.com',
        //     'phoneNumber'=>'xxxxxxxxxx',
        //     'address'=>'xxxxxxxx',
        //     'password'=>Hash::make('tranvanteo@gmail.com'),
        //     'status'=>true,
        //     'token'=>'',
        //     'remember_token'=>'',
        //     'customer_group_id'=>1
        // ]);
        // DB::table('customers')->insert([
        //     'name'=>'Trần Văn Tủn',
        //     'email'=>'tranvantun@gmail.com',
        //     'phoneNumber'=>'xxxxxxxxxx',
        //     'address'=>'xxxxxxxx',
        //     'password'=>Hash::make('tranvantun@gmail.com'),
        //     'status'=>true,
        //     'token'=>'',
        //     'remember_token'=>'',
        //     'customer_group_id'=>2
        // ]);



        factory(CustomerGroup::class,config('seeder.'.CustomerGroup::class))->create()->each(function($customerGroup){
            $customerGroup->translations()->save(factory(CustomerGroupTranslation::class)->create([
                'customer_group_id'=>$customerGroup->id,
                'locale'=>'vi'
            ]));
            $customerGroup->translations()->save(factory(CustomerGroupTranslation::class)->create([
                'customer_group_id'=>$customerGroup->id,
                'locale'=>'en'
            ]));
            factory(Customer::class, config('seeder.'.Customer::class))->create([
                'customer_group_id' =>$customerGroup->id
            ])->each(function($customer){
                $randomOrderNumber = rand(1,5);

                for ($i=1; $i < $randomOrderNumber; $i++) { 
                    $customer->orders()->save(factory(Order::class)->create([
                        'customer_id'=>$customer->id,
                        'total'=>rand(10,4012),
                        'subTotal'=>rand(10,3720),
                        'items_qty'=>rand(1,10),
                        'items_count'=>rand(1,15)
                    ]))->each(function($order){
                        $randomOrderItemNumber = rand(1,5);

                        factory(OrderItem::class, $randomOrderItemNumber)->create([
                            'order_id'=>$order->id,
                            'product_id'=>rand(1,100)
                        ]);
                    });
                }
                
            });
        });
    }
}
