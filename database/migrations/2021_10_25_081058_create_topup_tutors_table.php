<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'topup_tutors',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('transaction_id');
                $table->string('tutor_id');
                $table->float('class_per_hours');
                $table->float('webinar_per_hours');
                $table->float('blog');
                $table->enum('status', ['active', 'inactive', 'cancel', 'pending']);
                $table->timestamps();
                $table->foreign('transaction_id')
                    ->references('id')
                    ->on('transactions')
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
        Schema::dropIfExists('topup_tutors');
    }
}
