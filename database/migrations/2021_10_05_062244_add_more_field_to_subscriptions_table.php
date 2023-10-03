<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'subscriptions',
            function (Blueprint $table) {
               
                $table->integer('allow_booking')->nullable()->after('id');
                $table->integer('class_hours')->nullable()->after('id');
                $table->integer('webinar_hours')->nullable()->after('id');
                $table->enum('featured', ['Yes', 'No'])->default('No')->after('id');
                $table->double('commission', 4, 2)->nullable()->after('id');
                $table->integer('blog')->nullable()->after('id');
                $table->softDeletes();
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
            'subscriptions',
            function (Blueprint $table) {
               
                $table->dropColumn('allow_booking');
                $table->dropColumn('class_hours');
                $table->dropColumn('webinar_hours');
                $table->dropColumn('featured');
                $table->dropColumn('commission');
                $table->dropColumn('blog');
                $table->dropColumn('deleted_at');
            }
        );
    }
}
