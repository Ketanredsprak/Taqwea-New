<?php

use App\Models\Subject;
use Illuminate\Database\Seeder;

/**
 * SubjectsTableSeeder
 */
class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [
                'en' => ['subject_name' => 'Mathematics'],
                'ar' => ['subject_name' => 'الرياضيات'],
            ],
            [
                'en' => ['subject_name' => 'Physics'],
                'ar' => ['subject_name' => 'الفيزياء'],
            ],
            [
                'en' => ['subject_name' => 'Chemistry'],
                'ar' => ['subject_name' => 'كيمياء'],
            ],
            [
                'en' => ['subject_name' => 'Biology'],
                'ar' => ['subject_name' => 'مادة الاحياء'],
            ],
            [
                'en' => ['subject_name' => 'English'],
                'ar' => ['subject_name' => 'الإنجليزية'],
            ],
            [
                'en' => ['subject_name' => 'Hindi'],
                'ar' => ['subject_name' => 'هندي'],
            ],
            [
                'en' => ['subject_name' => 'Sociology'],
                'ar' => ['subject_name' => 'علم الاجتماع'],
            ],
            [
                'en' => ['subject_name' => 'General Awareness'],
                'ar' => ['subject_name' => 'الوعي العام'],
            ],
            [
                'en' => ['subject_name' => 'Accounting'],
                'ar' => ['subject_name' => 'محاسبة'],
            ],
            [
                'en' => ['subject_name' => 'Business Studies'],
                'ar' => ['subject_name' => 'دراسات الأعمال'],
            ]
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
