<?php

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * LanguagesTableSeeder
 */
class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'id' => 1,
                'name' => 'English',
                'code' => "en"
            ],
            [
                'id' => 2,
                'name' => 'العربية',
                'code' => "ar"
            ]
        ];
        $language = new Language();
        DB::table($language->getTable())->insert($languages);
    }
}
