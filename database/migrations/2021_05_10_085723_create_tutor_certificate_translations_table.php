<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorCertificateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tutor_certificate_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tutor_certificate_id');
                $table->string('language', 10);
                $table->string('certificate_name');
                $table->timestamps();

                $table->foreign('tutor_certificate_id')
                    ->references('id')
                    ->on('tutor_certificates')
                    ->onDelete('cascade');
                $table->unique(
                    ['tutor_certificate_id', 'language'],
                    'tutor_certificates_unique'
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
        Schema::dropIfExists('tutor_certificate_translations');
    }
}
