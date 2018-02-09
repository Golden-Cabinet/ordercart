<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('patients_id');
            $table->integer('formulas_id');
            $table->string('sub_total');
            $table->string('shipping_cost');
            $table->string('discount');
            $table->string('total_cost');
            $table->string('numberOfScoops');
            $table->string('timesPerDay');
            $table->string('refills');
            $table->string('shipOrPick');
            $table->string('pickUpOption');
            $table->string('shipOption');
            $table->string('billing');
            $table->text('notes');
            $table->text('instructions');
            $table->integer('status');
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
        Schema::dropIfExists('orders');
    }
}
