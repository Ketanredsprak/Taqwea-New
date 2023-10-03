<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email');
                $table->timestamp('account_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->enum(
                    'gender',
                    ['female', 'male', 'other']
                )->nullable();
                $table->enum(
                    'user_type',
                    ['accountant', 'admin', 'student', 'tutor']
                )->nullable();
                $table->string('profile_image')->nullable();
                $table->string('address')->nullable();
                $table->integer('phone_code')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('referral_code', 25)->nullable();
                $table->unsignedTinyInteger('is_verified')->default(0);
                $table->unsignedTinyInteger('is_approved')->default(0);
                $table->unsignedTinyInteger('is_online')->default(1);
                $table->unsignedTinyInteger('is_profile_completed')->default(0);
                $table->unsignedTinyInteger('is_notification_allow')->default(1);
                $table->enum('status', ['active', 'blocked', 'inactive'])
                    ->default('active');
                $table->string('otp', 6)->nullable();
                $table->string('language', 10)->nullable();
                $table->rememberToken();
                $table->softDeletes();
                $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
