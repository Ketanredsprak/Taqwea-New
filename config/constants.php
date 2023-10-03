<?php 
return [
    'password_regex' => "/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/",
    'two_decimal_regex' => '/^\d+(\.\d{1,2})?$/',
    'profile_image' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'dimension' => '150X150', // width X height
        'acceptType' => '.jpg,.jpeg,.png',
    ],
    'id_card' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png,.pdf',
    ],
    'education_document' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png,.pdf',
    ],
    'certificate_document' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png,.pdf',
    ],
    'introduction_video' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.mp4,.3gp,.mov',
    ],
    'class_image' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png',
    ],
    'blog_media' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png,.pdf,.mp4,.3gp,.mov',
    ],
    'testimonial_file' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png',
    ],
    'faq_file' => [
        'readAs' => 'public',
        'maxSize' => 5, // Add size in mb
        'acceptType' => '.jpeg,.jpg,.png,.mp4,.3gp,.mov',
    ],
    'referral' => [
        'points' => 100,
        'sar_value' => 10
    ],
    
    'card_number' => '[0-9]{12,19}',
    'card_expiry_month' => '(0[1-9]|1[0-2])',
    'card_expiry_year' => '(19|20)([0-9]{2})',
    'card_cvv' => '[0-9]{3,4}',
 
    "hyper_pay_success_code" => '000.000.000',
    "hyper_pay_success_code_api" => '000.100.110',
    "date_format_direction" => '',
    "website_name" => 'taqwea.com '
];