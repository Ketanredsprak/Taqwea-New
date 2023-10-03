<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tutor_educations', 
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tutor_id');
                $table->string('certificate')->nullable();
                $table->timestamps();

                $table->foreign('tutor_id')
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
        Schema::dropIfExists('tutor_education');
    }
}
