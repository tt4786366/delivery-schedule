<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreChainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_chains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 40);
            $table->unsignedBigInteger('chain_id');
            $table->unsignedTinyInteger('pricetag_id');
            $table->unsignedTinyInteger('container_color_id');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('container_color_id')->references('id')->on('container_colors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_chains');
    }
}
