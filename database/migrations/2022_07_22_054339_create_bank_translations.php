<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bank_translations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('bank_id');
                $table->string('language', 10);
                $table->text('bank_name')->nullable();
                $table->timestamps();

                $table->foreign('bank_id')
                    ->references('id')
                    ->on('banks')
                    ->onDelete('cascade');
                $table->unique(['bank_id', 'language']);
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
        Schema::dropIfExists('bank_translations');
    }
}
