<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * AccountantUserSeeder class
 */
class AccountantUserSeeder extends Seeder
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
                'email' => 'accountant@mailinator.com',
            ],
            [
                'user_type' => User::TYPE_ACCOUNTANT,
                'email' => 'accountant@mailinator.com',
                'password' => Hash::make('Test@123'),
                'status' => User::STATUS_ACTIVE,
                'is_verified' => 1,
                'name' => 'Accountant',
                'bio' => 'This is test about me',
                'is_profile_completed' => 1
            ]
        );
    }
}
