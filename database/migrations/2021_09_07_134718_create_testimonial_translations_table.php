<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'testimonial_translations',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('testimonial_id');
                $table->string('language', 10);
                $table->string('name', 100)->nullable();
                $table->text('content')->nullable();
                $table->timestamps();

                $table->foreign('testimonial_id')
                    ->references('id')
                    ->on('testimonials')
                    ->onDelete('cascade');
                $table->unique(['testimonial_id', 'language']);
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
        Schema::dropIfExists('testimonial_translations');
    }
}
