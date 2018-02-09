<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pinyin')->nullable();
            $table->string('latin_name')->nullable();
            $table->string('common_name')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('concentration')->nullable();
            $table->string('costPerGram')->nullable();
            $table->integer('deleted')->default('0');;
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
        Schema::dropIfExists('products');
    }
}
