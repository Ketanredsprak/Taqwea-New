<?php

use App\Models\Grade;
use Illuminate\Database\Seeder;

/**
 * GradesTableSeeder
 */
class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
            [
                'id' => 1,
                'en' => ['grade_name' => 'Grade1'],
                'ar' => ['grade_name' => 'الصف 1'],
            ],
            [
                'id' => 2,
                'en' => ['grade_name' => 'Grade2'],
                'ar' => ['grade_name' => 'الصف 2'],
            ],
            [
                'id' => 3,
                'en' => ['grade_name' => 'Grade3'],
                'ar' => ['grade_name' => 'الصف 3'],
            ],
            [
                'id' => 4,
                'en' => ['grade_name' => 'Grade4'],
                'ar' => ['grade_name' => 'الصف 4'],
            ],
            [
                'id' => 5,
                'en' => ['grade_name' => 'Grade5'],
                'ar' => ['grade_name' => 'الصف 5'],
            ],
            [
                'id' => 6,
                'en' => ['grade_name' => 'Grade6'],
                'ar' => ['grade_name' => 'الصف 6'],
            ],
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}
