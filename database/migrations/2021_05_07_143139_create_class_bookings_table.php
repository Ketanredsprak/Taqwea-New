<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'class_bookings',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('class_id');
                $table->unsignedBigInteger('student_id');
                $table->enum(
                    'status',
                    ['cancel', 'confirm', 'complete', 'pending']
                );
                $table->tinyInteger('is_joined')->default(0);
                $table->tinyInteger('is_live')->default(0);
                $table->unsignedBigInteger('cancelled_by')->nullable();
                $table->timestamps();

                $table->foreign('class_id')
                    ->references('id')
                    ->on('class_webinars')
                    ->onDelete('cascade');
                $table->foreign('student_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('cancelled_by')
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
        Schema::dropIfExists('class_bookings');
    }
}
