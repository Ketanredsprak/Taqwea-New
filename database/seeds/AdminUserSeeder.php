<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            [
                'email' => 'taqwea@mailinator.com',
            ],
            [
                'user_type' => User::TYPE_ADMIN,
                'email' => 'taqwea@mailinator.com',
                'password' => Hash::make('Test@123'),
                'status' => User::STATUS_ACTIVE,
                'is_verified' => 1,
                'name' => 'Admin',
                'bio' => 'This is test about me'
            ]
        );
    }
}
