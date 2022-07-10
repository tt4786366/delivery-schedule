<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('price');
            $table->integer('lot');
            $table->unsignedSmallInteger('category_id');
            $table->unsignedSmallInteger('factory_id');
            $table->unsignedBigInteger('chain_id')->nullable();
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->timestamps();

            $table->foreign('chain_id')->references('id')->on('store_chains');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('factory_id')->references('id')->on('factories');

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
