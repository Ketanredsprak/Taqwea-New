<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'class_webinars', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tutor_id');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('level_id');
                $table->unsignedBigInteger('grade_id')->nullable();
                $table->enum(
                    'class_type',
                    ['class', 'webinar']
                )->default('class');
                $table->enum(
                    'gender_preference',
                    ['both', 'female', 'male']
                )->default('both');
                $table->string('class_image')->nullable();
                $table->dateTime('start_time')->nullable();
                $table->dateTime('end_time')->nullable();
                $table->double('hourly_fees', 10, 2)->default('0.00');
                $table->double('total_fees', 10, 2)->default('0.00');
                $table->double('extra_hour_charge', 10, 2)->default('0.00');
                $table->integer('no_of_attendee');
                $table->integer('duration')->comment('in minutes');
                $table->tinyInteger('is_started')->default(0);
                $table->tinyInteger('is_live')->default(0);
                $table->enum(
                    'status',
                    ['active', 'inactive', 'completed', 'cancelled']
                )->default('inactive');
                $table->timestamps();

                $table->foreign('tutor_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
                $table->foreign('level_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
                $table->foreign('grade_id')
                    ->references('id')
                    ->on('grades')
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
        Schema::dropIfExists('classes');
    }
}
