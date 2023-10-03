<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateClassSubTopicTranslationsTable
 */
class CreateClassSubTopicTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'class_sub_topic_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('class_sub_topic_id');
                $table->string('language', 10);
                $table->string('sub_topic');
                $table->timestamps();

                $table->foreign('class_sub_topic_id')
                    ->references('id')
                    ->on('class_sub_topics')
                    ->onDelete('cascade');
                $table->unique(['class_sub_topic_id', 'language']);
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
        Schema::dropIfExists('class_sub_topic_translations');
    }
}
