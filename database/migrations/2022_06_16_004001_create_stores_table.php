<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('chain_id');
            $table->string('store_number',40)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->timestamps();
            
            $table->foreign('chain_id')->references('id')->on('store_chains');
            $table->foreign('user_id')->references('id')->on('users');
            
                       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
