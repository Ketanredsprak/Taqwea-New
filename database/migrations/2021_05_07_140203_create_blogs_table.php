<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'blogs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tutor_id');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('level_id');
                $table->unsignedBigInteger('grade_id')->nullable();
                $table->double('total_fees', 10, 2)->default('0.00');
                $table->enum(
                    'type',
                    ['document', 'image', 'video']
                )->default('image');
                $table->string('media')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
