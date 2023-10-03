<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassIdInRatingReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'rating_reviews', 
            function (Blueprint $table) {
                $table->unsignedBigInteger('class_id')
                    ->after('to_id')
                    ->nullable();

                $table->foreign('class_id')
                    ->references('id')
                    ->on('class_webinars')
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
        Schema::table(
            'rating_reviews',
            function (Blueprint $table) {
                $table->dropForeign('rating_reviews_class_id_foreign');
                $table->dropColumn('class_id');
            }
        );
    }
}
