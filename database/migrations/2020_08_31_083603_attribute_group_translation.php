<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttributeGroupTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_group_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('locale')->nullable();

            $table->unique(['attribute_group_id', 'locale']);

            $table->integer('attribute_group_id')->unsigned();
            $table->foreign('attribute_group_id')->references('id')->on('attribute_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_group_translation');
    }
}
