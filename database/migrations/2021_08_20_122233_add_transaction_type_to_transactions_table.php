<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionTypeToTransactionsTable extends Migration
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
                $table->enum(
                    'transaction_type',
                    [
                        "add_to_wallet",
                        "booking",
                        "refund",
                        "subscription",
                        "top_up",
                        "redeem",
                        "extra_hours"
                    ]
                )->nullable();
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
                $table->dropColumn('transaction_type');
            }
        );
    }
}
