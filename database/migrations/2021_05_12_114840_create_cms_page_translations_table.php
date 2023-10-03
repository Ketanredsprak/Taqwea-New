<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsPageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'cms_page_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('cms_page_id');
                $table->string('language', 10);
                $table->string('page_title');
                $table->mediumText('page_content');
                $table->string('meta_title');
                $table->string('meta_keywords');
                $table->string('meta_description');
                $table->timestamps();

                $table->foreign('cms_page_id')
                    ->references('id')
                    ->on('cms_pages')
                    ->onDelete('cascade');
                $table->unique(['cms_page_id', 'language']);
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
        Schema::dropIfExists('cms_page_translations');
    }
}
