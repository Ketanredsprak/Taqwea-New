<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsForceLogoutToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'users', 
            function (Blueprint $table) {
                $table->unsignedTinyInteger('is_force_logout')
                    ->default(0)
                    ->after('is_notification_allow');
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
            'users', 
            function (Blueprint $table) {
                $table->dropColumn('is_force_logout');
            }
        );
    }
}
