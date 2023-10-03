<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedToTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'topups',
            function (Blueprint $table) {
                $table->float("is_featured_price", 8, 2)
                    ->nullable()
                    ->comment("Per day price");
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
            'topups',
            function (Blueprint $table) {
                $table->dropColumn('is_featured_price');
            }
        );
    }
}
