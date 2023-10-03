<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'cart_items',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('cart_id')->index();
                $table->unsignedBigInteger('class_id')->nullable()->index();
                $table->unsignedBigInteger('blog_id')->nullable()->index();
                $table->integer('qty')->default(1);
                $table->integer('unit_price');
                $table->integer('price');
                $table->timestamps();

                $table->foreign('cart_id')
                    ->references('id')
                    ->on('carts')
                    ->onDelete('cascade');
                $table->foreign('class_id')
                    ->references('id')
                    ->on('class_webinars')
                    ->onDelete('cascade');
                $table->foreign('blog_id')
                    ->references('id')
                    ->on('blogs')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
