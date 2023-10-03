<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsExtraHourBookingInClassBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'class_bookings',
            function (Blueprint $table) {
                $table->tinyInteger('is_extra_hour')->default(0);
                $table->unsignedBigInteger('parent_id')->nullable();

                $table->foreign('parent_id')
                    ->references('id')
                    ->on('class_bookings')
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
            'class_bookings',
            function (Blueprint $table) {
                $table->dropForeign('class_bookings_parent_id_foreign');
                $table->dropColumn('parent_id');
                $table->dropColumn('is_extra_hour');
            }
        );
    }
}
