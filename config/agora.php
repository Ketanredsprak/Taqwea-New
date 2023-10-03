<?php

return [

    'app_id' => env('AGORA_APP_ID'),

    'app_certificate' => env('AGORA_APP_CERTIFICATE'),
    'access_key' => env('AGORA_ACCESS_KEY'),
    'secret_access_key' => env('AGORA_SECRET_ACCESS_KEY'),
    'app_identifier' => env('AGORA_APP_IDENTIFIER'),
    'app_region' => env('AGORA_APP_REGION'),

    'expiry_time' => env('AGORA_EXPIRY_TIME', 3600),
];