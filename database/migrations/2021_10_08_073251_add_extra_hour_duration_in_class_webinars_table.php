<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraHourDurationInClassWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'class_webinars',
            function (Blueprint $table) {
                $table->integer('extra_duration')
                    ->nullable()
                    ->after('extra_hour_charge')
                    ->comment('in minutes');
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
            'class_webinars',
            function (Blueprint $table) {
                $table->dropColumn('extra_duration');
            }
        );
    }
}
