<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('class_request_id')->default(0);
            $table->integer('student_id')->default(0);
            $table->integer('tutor_id')->default(0);
            $table->integer('status')->default(0);
            $table->dateTime('reject_time')->nullable();
            $table->string('price')->nullable(); 
            $table->string('note')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_quotes');
    }
}
