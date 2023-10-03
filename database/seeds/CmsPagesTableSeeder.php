<?php

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id' => 1,
                'slug' => 'about-us',
                'en' => [
                    'page_title' => 'About Us',
                    'page_content' => '',
                    'meta_title' => '',
                    'meta_keywords' => '',
                    'meta_description' => '',
                ],
                'ar' => [
                    'page_title' => '',
                    'page_content' => '',
                    'meta_title' => '',
                    'meta_keywords' => '',
                    'meta_description' => '',
                ],
            ],
            [
                'id' => 2,
                'slug' => 'terms-and-condition',
                'en' => [
                    'page_title' => 'Terms And Conditions',
                    'page_content' => '',
                    'meta_title' => '',
                    'meta_keywords' => '',
                    'meta_description' => '',
                ],
                'ar' => [
                    'page_title' => '',
                    'page_content' => '',
                    'meta_title' => '',
                    'meta_keywords' => '',
                    'meta_description' => '',
                ],
            ],
            [
                'id' => 3,
                'slug' => 'privacy-policy',
                'en' => [
                    'page_title' => 'Privacy Policy',
                    'page_content' => '',
                    'meta_title' => '',
                    'meta_keywords' => '',
                    'meta_description' => '',
                ],
                'ar' => [
                    'page_title' => '',
                    'page_content' => '',
                    'meta_title' => '',
                    'meta_keywords' => '',
                    'meta_description' => '',
                ],
            ],
        ];

        foreach ($pages as $page) {
            CmsPage::create($page);
        }
    }
}
