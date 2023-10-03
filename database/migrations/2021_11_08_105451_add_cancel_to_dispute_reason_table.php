<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelToDisputeReasonTable extends Migration
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
                $table->text('cancel_reason');
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
                $table->dropColumn('cancel_reason');
            }
        );
    }
}
