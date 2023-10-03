<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldToTutorsTable extends Migration
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
                $table->float('allow_booking')->after('is_featured')->default(0);
                $table->float('class_hours')->after('allow_booking')->default(0);
                $table->float('webinar_hours')->after('class_hours')->default(0);
                $table->integer('blog')->after('webinar_hours')->default(0);
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
            'tutors',
            function (Blueprint $table) {
                $table->dropColumn('allow_booking');
                $table->dropColumn('class_hours');
                $table->dropColumn('webinar_hours');
                $table->dropColumn('blog');
            }
        );
    }
}
