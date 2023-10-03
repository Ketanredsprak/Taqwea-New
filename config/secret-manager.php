<?php

return [

    'enableSecretManager' => env('ENABLE_SECRET_MANAGER', false),
    'secretManagerProvider' => env('SECRET_MANAGER_PROVIDER', ''),
    'checkSecretManagerApi' => env('CHECK_SECRET_MANAGER_API'),

    'aws' => [
        'region' => env('AWS_DEFAULT_REGION', ''),
        'profileName' => env('AWS_PROFILE_NAME', ''),
        'secretName' => env('AWS_SECRET_NAME', ''),
        'credentialsPath' => env('AWS_CREDENTIALS_PATH', ''),
        'sharedConfig' => env('AWS_SHARED_CONFIG', false),
    ],

    'configVariables' => [

        // "LOG_CHANNEL" => "logging.default",

        'DB_CONNECTION' => 'database.default',
        'DB_READ_HOST' => 'database.connections.mysql.read.host',
        'DB_HOST' => 'database.connections.mysql.write.host',
        'DB_PORT' => 'database.connections.mysql.port',
        'DB_DATABASE' => 'database.connections.mysql.database',
        'DB_USERNAME' => 'database.connections.mysql.username',
        'DB_PASSWORD' => 'database.connections.mysql.password',

        //"BROADCAST_DRIVER" => "broadcasting.default",
        'CACHE_DRIVER' => 'cache.default',
        'QUEUE_CONNECTION' => 'queue.default',
        'SESSION_DRIVER' => 'session.driver',
        'SESSION_LIFETIME' => 'session.lifetime',
        'SESSION_DOMAIN' => 'session.domain',
        'SESSION_SECURE_COOKIE' => 'session.secure',

        'REDIS_PORT' => 'database.redis.default.port',
        'REDIS_HOST' => 'database.redis.default.host',
        'REDIS_PASSWORD' => 'database.redis.default.password',

        'JWT_SECRET' => 'jwt.secret',

        'STORAGE_TYPE' => 'filesystems.disks.s3.driver',
        'AWS_ACCESS_KEY_ID' => 'filesystems.disks.s3.key',
        'AWS_SECRET_ACCESS_KEY' => 'filesystems.disks.s3.secret',
        'AWS_DEFAULT_REGION' => 'filesystems.disks.s3.region',
        'AWS_BUCKET' => 'filesystems.disks.s3.bucket',

        'AWS_URL' => 'filesystems.disks.s3.url',
        'AWS_PRIVATE_BUCKET' => 'filesystems.disks.s3private.bucket',

        'GOOGLE_CLIENT_ID' => 'services.google.client_id',
        'GOOGLE_CLIENT_SECRET' => 'services.google.client_secret',

        'TWITTER_API_KEY' => 'services.twitter.client_id',
        'TWITTER_API_SECRET_KEY' => 'services.twitter.client_secret',

        'AGORA_APP_ID' => 'agora.app_id',
        'AGORA_APP_CERTIFICATE' => 'agora.app_certificate',
        'AGORA_ACCESS_KEY' => 'agora.access_key',
        'AGORA_SECRET_ACCESS_KEY' => 'agora.secret_access_key',
        'AGORA_APP_IDENTIFIER' => 'agora.app_identifier',
        'AGORA_APP_REGION' => 'agora.app_region',

        'FCM_SERVER_KEY' => 'fcm.http.server_key',
        'FCM_SENDER_ID' => 'fcm.http.sender_id',
        'FCM_API_KEY' => 'fcm.apiKey',
        'FCM_PROJECT_ID' => 'fcm.project_id',
        'FCM_APP_ID' => 'fcm.app_id',

        'HYPERPAY_API_URL' => 'services.hyper_pay_api_url',
        'HYPERPAY_PAYOUT_API_URL' => 'services.hyper_payout_api_url',
        'HYPERPAY_PAYOUT_CONFIG_ID' => 'services.hyper_payout_config_id',
        'HYPERPAY_PAYOUT_ACCESS_TOKEN' => 'services.hyper_payout_access_token',
        'HYPERPAY_ACCESS_TOKEN' => 'services.hyper_pay_access_token',
        'HYPERPAY_ENTITY_ID_VISA_MASTER' => 'services.hyper_pay_entity_id_visa_master',
        'HYPERPAY_ENTITY_ID_MADA' => 'services.hyper_pay_entity_id_mada',
        'WEBHOOK_SPLIT_URL_KEY' => 'services.webhook_split_url_key',

        'GOOGLE_PLACES_API_KEY' => 'services.google_places_api_key',

        'DEFAULT_PAYMENT_GATEWAY' => 'services.default_payment_gateway',

        'MAIL_DRIVER' => 'mail.default',
        'MAIL_HOST' => 'mail.host',
        'MAIL_PORT' => 'mail.port',
        'MAIL_USERNAME' => 'mail.username',
        'MAIL_PASSWORD' => 'mail.password',
        'MAIL_ENCRYPTION' => 'mail.encryption',
        'MAIL_FROM_ADDRESS' => 'mail.from.address',
        'WEBHOOK_URL_KEY' => 'services.webhook_url_key',

    ]

];
