<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'transaction_items', 
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('transaction_id');
                $table->unsignedBigInteger('student_id');
                $table->unsignedBigInteger('class_id')
                    ->nullable();
                $table->unsignedBigInteger('blog_id')
                    ->nullable();

                $table->double('amount', 10, 2)->default('0.00');
                $table->enum(
                    'status',
                    ['pending', 'confirm', 'refund', 'failed']
                )->default('pending');
                $table->timestamps();

                $table->foreign('transaction_id')
                    ->references('id')
                    ->on('transactions')
                    ->onDelete('cascade');
                $table->foreign('student_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('class_id')
                    ->references('id')
                    ->on('class_webinars')
                    ->onDelete('cascade');
                $table->foreign('blog_id')
                    ->references('id')
                    ->on('blogs')
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
        Schema::dropIfExists('transaction_items');
    }
}
