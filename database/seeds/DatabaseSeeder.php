<?php

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(GradesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(CmsPagesTableSeeder::class);
        $this->call(AccountantUserSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(TopUpsTableSeeder::class);
    }
}
