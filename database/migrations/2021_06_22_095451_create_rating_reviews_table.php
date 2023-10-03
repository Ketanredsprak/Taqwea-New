<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'rating_reviews',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('from_id');
                $table->unsignedBigInteger('to_id');
                $table->double('rating', 10, 2)->default('0.00');
                $table->text('review')->nullable();
                $table->double('clarity', 10, 2)->default('0.00');
                $table->double('orgnization', 10, 2)->default('0.00');
                $table->double('give_homework', 10, 2)->default('0.00');
                $table->double('use_of_supporting_tools', 10, 2)->default('0.00');
                $table->double('on_time', 10, 2)->default('0.00');
                $table->timestamps();

                $table->foreign('from_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('to_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('rating_reviews');
    }
}
