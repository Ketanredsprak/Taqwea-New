<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateCategoriesTable
 */
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'categories',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('category_image')->nullable();
                $table->string('handle', 100)->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->enum(
                    'status',
                    ['active', 'inactive']
                )->default('active');
                $table->timestamps();

                $table->foreign('parent_id')
                    ->references('id')
                    ->on('categories')
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
        Schema::dropIfExists('categories');
    }
}
