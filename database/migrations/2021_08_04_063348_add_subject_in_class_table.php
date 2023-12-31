<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectInClassTable extends Migration
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
                $table->unsignedBigInteger('subject_id')
                    ->after('grade_id')
                    ->nullable();

                $table->foreign('subject_id')
                    ->references('id')
                    ->on('subjects')
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
        Schema::table(
            'class_webinars',
            function (Blueprint $table) {
                $table->dropForeign('class_webinars_subject_id_foreign');
                $table->dropColumn('subject_id');
            }
        );
    }
}
