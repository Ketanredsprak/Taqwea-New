<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTopicTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'class_topic_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('class_topic_id');
                $table->string('language', 10);
                $table->string('topic_title');
                $table->text('topic_description');
                $table->timestamps();

                $table->foreign('class_topic_id')
                    ->references('id')
                    ->on('class_topics')
                    ->onDelete('cascade');
                $table->unique(['class_topic_id', 'language']);
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
        Schema::dropIfExists('class_topic_translations');
    }
}
