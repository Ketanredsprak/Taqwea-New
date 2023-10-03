<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'blog_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('blog_id');
                $table->string('language', 10);
                $table->string('blog_title');
                $table->longText('blog_description');
                $table->timestamps();

                $table->foreign('blog_id')
                    ->references('id')
                    ->on('blogs')
                    ->onDelete('cascade');
                $table->unique(['blog_id', 'language']);
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
        Schema::dropIfExists('blog_translations');
    }
}