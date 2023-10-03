<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEnumTypeRevertInRewardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'reward_points',
            function (Blueprint $table) {
                DB::statement("ALTER TABLE `reward_points` CHANGE `type` `type` ENUM('credit','debit','revert') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT 'credit';");
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
        Schema::table('reward_points', function (Blueprint $table) {
            //
        });
    }
}
