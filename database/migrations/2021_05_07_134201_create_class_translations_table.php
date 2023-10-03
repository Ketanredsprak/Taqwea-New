<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'class_webinar_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('class_webinar_id');
                $table->string('language', 10);
                $table->string('class_name');
                $table->text('class_detail');
                $table->mediumText('class_description');
                $table->timestamps();

                $table->foreign('class_webinar_id')
                    ->references('id')
                    ->on('class_webinars')
                    ->onDelete('cascade');
                $table->unique(['class_webinar_id', 'language']);
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
        Schema::dropIfExists('class_translations');
    }
}
