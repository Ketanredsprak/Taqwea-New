<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionIdToClassBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'class_bookings',
            function (Blueprint $table) {
                $table->unsignedBigInteger('transaction_id')
                    ->nullable()->after('id');
                $table->foreign('transaction_id')
                    ->references('id')
                    ->on('transactions');
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
            'class_bookings', function (Blueprint $table) {
                $table->dropForeign('class_bookings_transaction_id_foreign');
                $table->dropColumn('transaction_id');
            }
        );
    }
}
