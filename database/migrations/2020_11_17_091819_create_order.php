<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned();
            $table->string('email');
            $table->string('name');
            $table->string('address');
            $table->string('phoneNumber');
            $table->string('coupon')->nullable();
            $table->integer('items_count');
            $table->integer('items_qty');
            $table->float('subTotal');
            $table->float('total');
            $table->string('currency');
            $table->float("exchange_rate");
            //set null
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
