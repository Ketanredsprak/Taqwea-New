<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'faqs',
            function (Blueprint $table) {
                $table->enum(
                    'type',
                    ['image', 'text', 'video']
                )
                    ->default('text')
                    ->after('id');
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
            'faqs',
            function (Blueprint $table) {
                $table->dropColumn('type');
            }
        );
    }
}
