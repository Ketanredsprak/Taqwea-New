<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateClassSubTopicsTable
 */
class CreateClassSubTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'class_sub_topics',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('class_topic_id');
                $table->timestamps();

                $table->foreign('class_topic_id')
                    ->references('id')
                    ->on('class_topics')
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
        Schema::dropIfExists('class_sub_topics');
    }
}
