<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckoutIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'transactions',
            function (Blueprint $table) {
                $table->string("checkout_id", 255)->nullable();
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
            'transactions',
            function (Blueprint $table) {
                $table->dropColumn('checkout_id');
                $table->dropColumn('card_type');
            }
        );
    }
}
