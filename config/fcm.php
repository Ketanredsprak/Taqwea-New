<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAXn0wTJ0:APA91bFVnnxt1bIF9l3f7Wd8MGrICGsc5E7x1xnoDcg5w8z6mtx29Tqqu_9zpWAeerCxcBHevlwQEwiRcrm8CvN-_LsNFkPZV19JGzy_s2l1YDXck3c4IueIf_2OaqDlB9Pc6XWXjH3d'),
        'sender_id' => env('FCM_SENDER_ID', 'f8OFWXtTRNKGZJYD7lma6f:APA91bE5KMAWrNcmePHnGva1dzm4wusYcXLH3Yu-ttMGCQGBaEf6yqhNgaV1WuZF-A4Oxd6pSbOvLN4pHSTIj4gdpkMN0fpVBhRPA42teTXe_Acq_yzNjzfX0wGODaQeJueapK5Q8Kiv'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
    'apiKey' => env('FCM_API_KEY', ''),
    'project_id' => env('FCM_PROJECT_ID', ''),
    'app_id' => env('FCM_APP_ID', ''),
];
