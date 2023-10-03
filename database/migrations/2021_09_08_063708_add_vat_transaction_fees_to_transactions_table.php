<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatTransactionFeesToTransactionsTable extends Migration
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
                $table->double('vat', 10, 2)->default(0)->after('admin_commision');
                $table->double('transaction_fees', 10, 2)->default(0)->after('vat');
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
                $table->dropColumn('vat');
                $table->dropColumn('transaction_fees');
            }
        );
    }
}
