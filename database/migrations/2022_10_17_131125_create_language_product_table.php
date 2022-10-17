<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_product', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('products');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_product');
    }
};
