<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorEducationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tutor_education_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tutor_education_id');
                $table->string('language', 10);
                $table->string('degree');
                $table->string('university');
                $table->timestamps();

                $table->foreign('tutor_education_id')
                    ->references('id')
                    ->on('tutor_educations')
                    ->onDelete('cascade');
                $table->unique(
                    ['tutor_education_id', 'language'],
                    'tutor_education_unique'
                );
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
        Schema::dropIfExists('tutor_education_translations');
    }
}
