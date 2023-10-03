<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionAndTotalAmountToTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'transaction_items',
            function (Blueprint $table) {
                $table->float("commission", 8, 2)->nullable();
                $table->float("total_amount", 8, 2)->nullable();
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
            'transaction_items',
            function (Blueprint $table) {
                $table->dropColumn('commission');
                $table->dropColumn('total_amount');
            }
        );
    }
}
