<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateMessagesTable
 */
class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'messages',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('from_id')->nullable();
                $table->unsignedBigInteger('to_id')->nullable();
                $table->longText('message')->nullable();
                $table->timestamps();
                
               
                $table->foreign('from_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('to_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('messages');
    }
}
