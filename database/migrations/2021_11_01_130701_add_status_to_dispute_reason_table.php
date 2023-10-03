<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * AddStatusToDisputeReasonTable
 */
class AddStatusToDisputeReasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'class_refund_requests',
            function (Blueprint $table) {
                $table->enum("status", ['cancel', 'pending', 'refund'])->default('pending');
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
            'class_refund_requests',
            function (Blueprint $table) {
                $table->dropColumn('status');
            }
        );
    }
}
