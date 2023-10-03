<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'aesEncrypt' => [
        'key' => env('APP_AESENCRYPT_KEY'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => config('app.url').'/login/google/callback',
    ],
    'twitter' => [
        'client_id' => env('TWITTER_API_KEY'),
        'client_secret' => env('TWITTER_API_SECRET_KEY'),
        'redirect' => config('app.url').'/login/linkedin/callback',
    ],
    'apple' => [    
        'client_id' => env('APPLE_CLIENT_ID'),  
        'client_secret' => env('APPLE_CLIENT_SECRET'),  
        'redirect' => config('app.url').'/login/apple/callback' 
    ],

    'google_places_api_key' => env('GOOGLE_PLACES_API_KEY', ''),

    'class_booking_before' => env('CLASS_BOOKING_BEFORE', 60),
    'class_max_student' => env('CLASS_MAX_STUDENT', 5),
    'class_cancel_before' => env('CLASS_CANCEL_BEFORE', 60),
    'message_day' => env('MESSAGE_DAYS', 3),

    'hyper_pay_api_url' => env('HYPERPAY_API_URL', ''),
    'hyper_payout_api_url' => env('HYPERPAY_PAYOUT_API_URL', ''),
    'hyper_payout_config_id' => env('HYPERPAY_PAYOUT_CONFIG_ID', ''),
    'hyper_payout_access_token' => env('HYPERPAY_PAYOUT_ACCESS_TOKEN', ''),
    'hyper_pay_access_token' => env('HYPERPAY_ACCESS_TOKEN', ''),
    'hyper_pay_entity_id_visa_master' => env('HYPERPAY_ENTITY_ID_VISA_MASTER', ''),
    'hyper_pay_entity_id_mada' => env('HYPERPAY_ENTITY_ID_MADA', ''),
    'default_payment_gateway' => env('DEFAULT_PAYMENT_GATEWAY', ''),
    'webhook_url_key' => env('WEBHOOK_URL_KEY', ''),
    'webhook_split_url_key' => env('WEBHOOK_SPLIT_URL_KEY', ''),
    'google_analytics_enabled' => env('GOOGLE_ANALYTICS_ENABLED', false),
    'google_analytics_key' => env('GOOGLE_ANALYTICS_KEY', false),

];
