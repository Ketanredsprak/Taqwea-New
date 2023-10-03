<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFineCollectedTranscationTypeFieldToTransationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'transactions',
            function (Blueprint $table) {
                DB::statement("ALTER TABLE `transactions` CHANGE COLUMN `transaction_type` `transaction_type` ENUM('add_to_wallet','booking','refund','subscription','top_up','redeem','extra_hours','fine') NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `updated_at`");
                $table->unsignedTinyInteger('is_fine_collected')->default(0)
                    ->comment('if fine collected set to 1 for tutor');
                $table->string('class_id', 255)->nullable()
                    ->comment('if transaction_type = fine then add class_id');
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
            'banks',
            function (Blueprint $table) {
                DB::statement("ALTER TABLE `transactions` CHANGE COLUMN `transaction_type` `transaction_type` ENUM('add_to_wallet','booking','refund','subscription','top_up','redeem','extra_hours') NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `updated_at`");
                $table->dropColumn('is_fine_collected');
                $table->dropColumn('class_id');
            }
        );
    }
}
