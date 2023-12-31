<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalletIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            Schema::table(
                'transactions', 
                function (Blueprint $table) {
                    $table->unsignedBigInteger('wallet_id')
                        ->after('id')
                        ->nullable();
    
                    $table->foreign('wallet_id')
                        ->references('id')
                        ->on('wallets')
                        ->onDelete('cascade');
                }
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            Schema::table(
                'transactions',
                function (Blueprint $table) {
                    $table->dropForeign('transactions_wallet_id_foreign');
                    $table->dropColumn('wallet_id');
                }
            );
        });
    }
}
