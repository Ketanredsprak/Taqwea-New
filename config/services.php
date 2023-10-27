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

    'google_places_api_key' => env('GOOGLE_PLACES_API_KEY', 'AIzaSyDbeNmQqwLkuTGv0y5_HuF3HPNeVP5vCp8'),

    'class_booking_before' => env('CLASS_BOOKING_BEFORE', 60),
    'class_max_student' => env('CLASS_MAX_STUDENT', 5),
    'class_cancel_before' => env('CLASS_CANCEL_BEFORE', 60),
    'message_day' => env('MESSAGE_DAYS', 3),

    'hyper_pay_api_url' => env('HYPERPAY_API_URL', 'https://test.oppwa.com'),
    'hyper_payout_api_url' => env('HYPERPAY_PAYOUT_API_URL', 'https://splits.sandbox.hyperpay.com'),
    'hyper_payout_config_id' => env('HYPERPAY_PAYOUT_CONFIG_ID', '18d4ba8ad968c9541fb6c22b0e07934d'),
    'hyper_payout_access_token' => env('HYPERPAY_PAYOUT_ACCESS_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBlYmFlYjU1ZTg5YjkzYmQ5ZTBhODQxMTI5NWRjNDRmMzA0NGE1YzcxNTg0YTI0NGM5MTU4MmJhMWJjN2NhZjIyZTBlNjQ5MDg1YmQwNDEwIn0.eyJhdWQiOiIzIiwianRpIjoiMGViYWViNTVlODliOTNiZDllMGE4NDExMjk1ZGM0NGYzMDQ0YTVjNzE1ODRhMjQ0YzkxNTgyYmExYmM3Y2FmMjJlMGU2NDkwODViZDA0MTAiLCJpYXQiOjE2NDcyNDgyMDcsIm5iZiI6MTY0NzI0ODIwNywiZXhwIjoxNjc4Nzg0MjA3LCJzdWIiOiIxODYiLCJzY29wZXMiOltdfQ.sPIXOJlGu0yEF3tat9GWzYolLzLoH5j8J6O4ynHr72qi5LIVVZRw5jLP71zt87T38bQJpA1BaFWcmMEt6XSis6BAvMrDt9m1Vv6SvN5aSgPCu7m8-UaxWc0vvQg3en3IWKRTKWiOVrFp8hAquqeG3V7bh9t0qSI8WVnWSAJ_NW4K9WMNJzNfWHXGYxPOv3M1kVHK5wkdEqirJmCeIr_qarRHJDOgFPAsxyeNu6_bUJlRkyUcWrkKkaiUQw5a7zfQLKuJ6By9G5jdVmxoTv-h83p57Xd02WgMoZ0RLscFAeVWwmXtPXhqtUTKxobxn_X-yMGuUfB4GadlWrgK3CXggr7mPWaJ4xGMZrvJexfQ-uu2PaED5NYmA9iRa13p5xn-kVbNbrFQoJiti2VEDLKmjLRiiWTxq9AppE2Mevsa_qgq5cDAIN7dnUCe3wQTIdwp0Nf2H7ZomiRAWPnN_QKy7eU5EjVi50u9Ao8TEQNC3FojB-ZXGvv7HM-FuX-9uGDnWEG9Ud1lXtXP-IKXI0lZWnmlvkqjRXTOXkrlEjerNmN5hHxPU73a4IUxKfGzBZCUjIfbdKQT9VlqqJ3qcV2QlsjCmVZe7ieq-J2rZlfLAhKGdzxvKJDFJyj-a9FiCqh4Rvx49nsTnh2HCdNqDLe0i7ms9i6wZFdifYApuT0IIKg'),
    'hyper_pay_access_token' => env('HYPERPAY_ACCESS_TOKEN', 'OGFjN2E0Yzc3YzAwYjUzMzAxN2MwMjM1MmFhNTAyODJ8VDhleG1XdFBUNQ=='),
    'hyper_pay_entity_id_visa_master' => env('HYPERPAY_ENTITY_ID_VISA_MASTER', '8ac7a4c77c00b533017c0236569f028b'),
    'hyper_pay_entity_id_mada' => env('HYPERPAY_ENTITY_ID_MADA', '8ac7a4c77c00b533017c0235af800286'),
    'default_payment_gateway' => env('DEFAULT_PAYMENT_GATEWAY', ''),
    'webhook_url_key' => env('WEBHOOK_URL_KEY', '58AD0BF8A5E8CE2C4EC6137B85F507EE228077B4D59A2CF44A6186642FD63DD4'),
    'webhook_split_url_key' => env('WEBHOOK_SPLIT_URL_KEY', '4E8FC8D605B1EEA44115E3241D6C0B93056500CBF2385A3B4D0480F3DCC5C657'),
    'google_analytics_enabled' => env('GOOGLE_ANALYTICS_ENABLED', false),
    'google_analytics_key' => env('GOOGLE_ANALYTICS_KEY', false),

];
