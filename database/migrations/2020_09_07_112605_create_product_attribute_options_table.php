<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_options', function (Blueprint $table) {
            // $table->integer('amount')->default(0);
            // $table->integer('price')->default(0);
            // $table->unique(['attribute_option_id', 'product_id']);

            $table->integer('attribute_option_id')->unsigned();
            $table->foreign('attribute_option_id')->references('id')->on('attribute_options')->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->integer('category_id')->unsigned();
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_options');
    }
}
