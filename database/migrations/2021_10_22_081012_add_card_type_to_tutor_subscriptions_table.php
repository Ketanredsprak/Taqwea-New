<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardTypeToTutorSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'tutor_subscriptions',
            function (Blueprint $table) {
                $table->string("card_type", 30)->nullable();
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
            'tutor_subscriptions',
            function (Blueprint $table) {
                $table->dropColumn('card_type'); 
            }
        );
    }
}
