<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('product_id');
            $table->date('deliver_date');
            $table->smallInteger('quantity');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
            
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('approved_by')->references('id')->on('users');
        
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
