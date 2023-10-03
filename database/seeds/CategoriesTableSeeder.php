<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * CategoriesTableSeeder
 */
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'handle' => 'education',
                'en' => ['name' => 'Education'],
                'ar' => ['name' => 'تعليم عام'],
            ],
            [
                'id' => 2,
                'handle' => 'general-knowledge',
                'en' => ['name' => 'General Knowledge'],
                'ar' => ['name' => 'دورات تدريبية'],
            ],
            [
                'id' => 3,
                'handle' => 'language',
                'en' => ['name' => 'Languages'],
                'ar' => ['name' => 'لغات'],
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $educationCategories = [
            [
                'parent_id' => 1,
                'handle' => 'level',
                'en' => ['name' => 'Graduate'],
                'ar' => ['name' => 'دراسات عليا'],
            ],
            [
                'parent_id' => 1,
                'handle' => 'level',
                'en' => ['name' => 'Undergraduate'],
                'ar' => ['name' => 'المرحلة الجامعية'],
            ],
            [
                'parent_id' => 1,
                'handle' => 'level',
                'en' => ['name' => 'Secondry School'],
                'ar' => ['name' => 'المرحلة الثانوية'],
                'grades' => [1, 2, 3]
            ],
            [
                'parent_id' => 1,
                'handle' => 'level',
                'en' => ['name' => 'Middle School'],
                'ar' => ['name' => 'المرحلة المتوسطة'],
                'grades' => [1, 2, 3]
            ],
            [
                'parent_id' => 1,
                'handle' => 'level',
                'en' => ['name' => 'Elementry School'],
                'ar' => ['name' => 'المرحلة الابتدائية'],
                'grades' => [1, 2, 3, 4, 5, 6]
            ],
            [
                'parent_id' => 1,
                'handle' => 'level',
                'en' => ['name' => 'KG'],
                'ar' => ['name' => 'رياض اطفال'],
            ],
        ];

        foreach ($educationCategories as $educationCategory) {
            $categoryData = [
                'parent_id' => $educationCategory['parent_id'],
                'en' => $educationCategory['en'],
                'ar' => $educationCategory['ar'],
            ];
            $category = Category::create($categoryData);
            if ($category && !empty($educationCategory['grades'])) {
                $category->grades()->attach($educationCategory['grades']);
            }
        }
    }
}
