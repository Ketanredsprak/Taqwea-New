<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateNotificationsTable
 */
class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'notifications',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('from_id')->nullable();
                $table->unsignedBigInteger('to_id')->nullable();
                $table->string('type')->nullable();
                $table->text('notification_data')->nullable();
                $table->string('notification_message');
                $table->tinyInteger('is_read')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
