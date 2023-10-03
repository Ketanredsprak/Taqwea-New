<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'subscriptions', 
            function (Blueprint $table) {
                $table->integer('duration')->after('allow_booking');
                $table->integer('amount')->after('allow_booking');
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
            'subscriptions',
            function (Blueprint $table) {
                $table->dropColumn('duration');
                $table->dropColumn('amount');
            }
        );
    }
}
