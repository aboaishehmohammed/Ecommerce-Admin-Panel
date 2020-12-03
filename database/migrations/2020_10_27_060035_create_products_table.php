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
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedDouble('price');
            $table->unsignedBigInteger('image_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->foreign('image_id')->references('id')->on('images');


        });
        Schema::create('product_image', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("image_id");
            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("image_id")->references("id")->on("images");
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
