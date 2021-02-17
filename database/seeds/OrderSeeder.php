<?php

use App\Models\Cart\Order;
use App\Models\Cart\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Order::class, 50)->create([
        //     'customer_id' => rand(1, 2),
        //     "items_count" => 2,
        //     "items_qty" => 4,
        //     "subTotal" => 6,
        //     "total" => 6,
        // ])->each(function ($order) {
        //     $order->orderItems()->create(factory(OrderItem::class, 2)->create([
        //         "quantity" => 2,
        //         "price" => 2,
        //         "total" => 4,
        //     ]));
        // });



        for ($i=1; $i < 20; $i++) { 
            $id = rand(1,2);
            DB::table('order')->insert([
                "id"=>$i,
                "customer_id" => $id,
                "email" => "abc@gmal.com",
                "name" => "2342asdsaasd",
                "items_count" => 1,
                "items_qty" => 12,
                "subTotal" => 10,
                "total" => 10,
                "address" => "nha",
                "status" => "pending",
                "phoneNumber" => "0192321872",
                "coupon" => null,
                "currency" => "USD",
                "exchange_rate" => '12.00'
            ]);
            DB::table('order_items')->insert([
                "sku"=>"abc",
                "name"=>"acscac",
                "quantity"=>1,
                "price"=>1,
                "total"=>1,
                "product_id"=>$id,
                "order_id"=>$i,
                "additional"=>''
            ]);
        }
        
    }
}
