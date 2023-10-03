<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedDaysToTopupTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'topup_tutors',
            function (Blueprint $table) {
                $table->integer("is_featured_day")
                    ->nullable();
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
            'topup_tutors',
            function (Blueprint $table) {
                $table->dropColumn('is_featured_day');
            }
        );
    }
}
