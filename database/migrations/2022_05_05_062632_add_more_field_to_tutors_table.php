<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddMoreFieldToTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'tutors', function (Blueprint $table) {
                $table->string("beneficiary_name")->nullable();
            }
        );
        // once the table is created use a raw query to ALTER it and add the BLOB, MEDIUMBLOB or LONGBLOB
        DB::statement("ALTER TABLE tutors ADD account_number MEDIUMBLOB after id");  
        DB::statement("ALTER TABLE tutors ADD bank_code MEDIUMBLOB after id");  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'tutors',
            function (Blueprint $table) {
                $table->dropColumn('account_number');
                $table->dropColumn('bank_code');
                $table->dropColumn('beneficiary_name');
            }
        );
    }
}
