<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectIdToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'blogs',
            function (Blueprint $table) {
                $table->unsignedBigInteger('subject_id')
                    ->nullable()->after('id');
                
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
            'blogs',
            function (Blueprint $table) {
                $table->dropForeign('blogs_subject_id_foreign');
                $table->dropColumn('subject_id');
            }
        );
    }
}
