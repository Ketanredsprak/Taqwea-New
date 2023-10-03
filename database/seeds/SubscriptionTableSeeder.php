<?php

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\SubscriptionPrice;
use Illuminate\Support\Facades\Log;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions = [
            [
                'en' => [
                    'subscription_name' => 'Basic',
                    'subscription_description' => 'Free'
                ],
                'ar' => [
                    'subscription_name' => 'أساسي',
                    'subscription_description' => 'حر'
                ],
                'blog' => 0,
                'commission' => 20,
                'blog_commission' => 20,
                'featured' => 'No',
                'webinar_hours' => 0,
                'class_hours' => 20,
                'allow_booking' => 5,
                'default_plan' => 'Yes',
                'amount' => 0,
                'duration' => 0

            ],
            [
                'en' => [
                    'subscription_name' => 'Tutor Premium 1 Month',
                    'subscription_description' =>
                    'Monthly plan Pay 1 month for 399'
                ],
                'ar' => [
                    'subscription_name' => 'قسط المعلم 1 شهر',
                    'subscription_description' => 'خطة شهرية
                    399 ادفع 1 أشهر مقابل )'
                ],
                'blog' => 4,
                'commission' => 0,
                'blog_commission' => 20,
                'featured' => 'No',
                'webinar_hours' => 0,
                'class_hours' => 40,
                'allow_booking' => 5,
                'amount' => 399,
                'duration' => 1

            ],
            [
                'en' => [
                    'subscription_name' => 'Tutor Premium 6 Months',
                    'subscription_description' =>
                    'Monthly plan Pay 6 month for 2,300 (save SAR 94)'
                ],
                'ar' => [
                    'subscription_name' => 'قسط المعلم 6 شهر',
                    'subscription_description' => 'خطة شهرية
                    ادفع 6 أشهر مقابل 2،300 (وفر 94 ريال سعودي)'
                ],
                'blog' => 24,
                'commission' => 0,
                'blog_commission' => 20,
                'featured' => 'No',
                'webinar_hours' => 0,
                'class_hours' => 240,
                'allow_booking' => 5,
                'amount' => 2300,
                'duration' => 6

            ],
            [
                'en' => [
                    'subscription_name' => 'Trainer Package 1 Month',
                    'subscription_description' =>
                    'Monthly plan Pay 1 month for 799'
                ],
                'ar' => [
                    'subscription_name' => 'باقة المدرب 1 شهر',
                    'subscription_description' => 'خطة شهرية
                    399 ادفع 1 أشهر مقابل )'
                ],
                'blog' => 16,
                'commission' => 20,
                'blog_commission' => 20,
                'featured' => 'No',
                'webinar_hours' => 10,
                'class_hours' => 0,
                'allow_booking' => 5,
                'amount' => 799,
                'duration' => 1

            ],
            [
                'en' => [
                    'subscription_name' => 'Trainer Package 6 Months',
                    'subscription_description' =>
                    'Monthly plan Pay 6 month for 4,600 (save SAR 194)'
                ],
                'ar' => [
                    'subscription_name' => 'باقة المدرب 6 شهر',
                    'subscription_description' => 'خطة شهرية
                    ادفع 6 أشهر مقابل 4،600 (وفر 194 ريال سعودي)'
                ],
                'blog' => 96,
                'commission' => 20,
                'blog_commission' => 20,
                'featured' => 'No',
                'webinar_hours' => 60,
                'class_hours' => 0,
                'allow_booking' => 5,
                'amount' => 4600,
                'duration' => 6

            ]
        ];

        foreach ($subscriptions as $subscription) {
            $subscriptionCreate = $subscription;
            Subscription::create($subscriptionCreate);
        }
    }
}
