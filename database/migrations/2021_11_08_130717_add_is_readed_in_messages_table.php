<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadedInMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'messages', function (Blueprint $table) {
                $table->boolean('is_readed')->after('message')->default(0);
                $table->uuid('thread_uuid')->nullable();
                $table->unsignedBigInteger('thread_id')->nullable();
                $table->foreign('thread_id')
                    ->references('id')
                    ->on('threads')
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
        Schema::table(
            'messages', function (Blueprint $table) {
                $table->dropForeign('messages_thread_id_foreign');
                $table->dropColumn('is_readed');
                $table->dropColumn('thread_uuid');
                $table->dropColumn('thread_id');
            }
        );
    }
}
