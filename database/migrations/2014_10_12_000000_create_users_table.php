<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('user_roles_id')->default(0);
            $table->string('username')->nullable();
            $table->integer('area_code')->nullable();
            $table->integer('phonePre')->nullable();
            $table->integer('phonePost')->nullable();
            $table->string('ext')->nullable();
            $table->integer('license_state')->nullable();
            $table->string('registration_token')->nullable();
            $table->integer('is_registered')->default(0);
            $table->integer('is_approved')->default(0);            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
