<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'category_grades',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('grade_id');
                $table->timestamps();

                $table->foreign('grade_id')
                    ->references('id')
                    ->on('grades')
                    ->onDelete('cascade');
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
                $table->unique(['category_id', 'grade_id']);
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
        Schema::dropIfExists('category_grades');
    }
}
