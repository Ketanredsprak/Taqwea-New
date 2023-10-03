<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldToTutorSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'tutor_subscriptions',
            function (Blueprint $table) {
                $table->integer('plan_duration')->nullable()->after('id');
                $table->integer('allow_booking')->nullable()->after('plan_duration');
                $table->integer('class_hours')->nullable()->after('allow_booking');
                $table->integer('webinar_hours')->nullable()->after('class_hours');
                $table->enum('featured', ['Yes', 'No'])->default('No')
                    ->after('webinar_hours');
                $table->double('commission', 4, 2)->nullable()->after('featured');
                $table->integer('blog')->nullable()->after('commission');
                $table->string('subscription_name', 255)->nullable()->after('blog');
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
            'tutor_subscriptions',
            function (Blueprint $table) {
                $table->dropColumn('plan_duration');
                $table->dropColumn('allow_booking');
                $table->dropColumn('class_hours');
                $table->dropColumn('webinar_hours');
                $table->dropColumn('featured');
                $table->dropColumn('commission');
                $table->dropColumn('blog');
                $table->dropColumn('subscription_name');
            }
        );
    }
}
