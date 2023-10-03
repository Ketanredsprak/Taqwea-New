<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'threads', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')->nullable();
                $table->unsignedBigInteger('class_id')->nullable();
                $table->unsignedBigInteger('student_id')->nullable();
                $table->unsignedBigInteger('tutor_id')->nullable();
                $table->unsignedBigInteger('booking_id')->nullable();

                $table->timestamps();

                $table->foreign('class_id')
                    ->references('id')
                    ->on('class_webinars')
                    ->onDelete('cascade');
                $table->foreign('student_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('tutor_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->unique(['uuid']);

                $table->foreign('booking_id')
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
        Schema::dropIfExists('threads');
    }
}
