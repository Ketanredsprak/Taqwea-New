<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPublishedToClassWebinarsTable extends Migration
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
                $table->unsignedTinyInteger('is_published')->default(0);

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
                $table->dropColumn('is_published');
            }
        );
    }
}
