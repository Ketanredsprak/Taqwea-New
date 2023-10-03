<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTutorPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tutor_payouts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('transaction_id')->nullable();
                $table->double('amount', 10, 2)->nullable();
                $table->text('payout_response')->nullable();
                $table->enum(
                    'status',
                    ['failed', 'pending', 'success']
                )->default('pending');

                $table->unsignedBigInteger('tutor_id')
                    ->nullable();
                $table->foreign('tutor_id')
                    ->references('id')
                    ->on('users');
                $table->timestamps();
            }
        );
        DB::statement("ALTER TABLE tutor_payouts ADD account_number MEDIUMBLOB after id"); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_payouts');
    }
}
