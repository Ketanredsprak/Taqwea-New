<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidAndTokenColumnToClassWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_webinars', function (Blueprint $table) {
            $table->text('uuid')->nullable()->after('status');
            $table->text('room_token')->nullable()->after('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_webinars', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('room_token');
        });
    }
}
