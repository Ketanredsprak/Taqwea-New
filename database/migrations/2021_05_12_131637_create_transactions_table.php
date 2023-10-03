<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'transactions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('external_id');
                $table->unsignedBigInteger('user_id');
                $table->enum(
                    'payment_mode',
                    ['direct_payment', 'wallet']
                );
                $table->double('total_amount', 10, 2);
                $table->double('amount', 10, 2);
                $table->double('admin_commision', 10, 2);
                $table->double('wallet_amount', 10, 2)->nullable();
                $table->enum(
                    'status',
                    ['failed', 'pending', 'success', 'refunded']
                );
                $table->enum(
                    'booking_by',
                    ['cart', 'booking']
                )->default('booking');
                $table->timestamps();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
