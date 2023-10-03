<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardAndPaymentMethodIdFieldToTutorSubscriptionsTable extends Migration
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
                $table->unsignedBigInteger('payment_method_id')->nullable();
                $table->string('card_id', 150)->nullable();
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
                $table->dropColumn('payment_method_id'); 
                $table->dropColumn('card_id'); 
            }
        );
    }
}
