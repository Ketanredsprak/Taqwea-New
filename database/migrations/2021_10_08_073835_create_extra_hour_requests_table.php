<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraHourRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'extra_hour_requests',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('class_id');
                $table->unsignedBigInteger('student_id');
                $table->enum(
                    'status',
                    [
                        'accepted',
                        'pending',
                        'rejected'
                    ]
                )->default('pending');
                $table->timestamps();

                $table->foreign('class_id')
                    ->references('id')
                    ->on('class_webinars')
                    ->onDelete('cascade');

                $table->foreign('student_id')
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
        Schema::dropIfExists('extra_hour_requests');
    }
}
