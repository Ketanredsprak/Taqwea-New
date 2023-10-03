<?php

use Illuminate\Database\Seeder;
use App\Models\TopUp;

class TopUpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topup::Create(
            [
                'class_per_hours_price' => 0,
                'webinar_per_hours_price' => 0,
                'blog_per_hours_price' => 0,
                'is_featured_price' => 0,
            ]
        );
    }
}
