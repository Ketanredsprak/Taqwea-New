<?php
return [
    'paths' => [
        "/signup" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "Student Signup",
                "description" => "Student Signup",
                "operationId" => "studentSignup",
                "consumes" => [
                    "multipart/form-data"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'user_type',
                        'type' => 'string',
                        'format' => 'string',
                        'enum' => ['student', 'tutor'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'gender',
                        'type' => 'string',
                        'format' => 'string',
                        'enum' => ['male', 'female', 'other'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'device_type',
                        'type' => 'string',
                        'format' => 'string',
                        'enum' => ['android', 'ios'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'device_id',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'certification_type',
                        'type' => 'string',
                        'format' => 'string',
                        'enum' => ['development', 'production'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'en[name]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'email',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'phone_number',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'referral_code',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'password',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'confirm_password',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'terms_of_service',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => true,
                    ],
                ],
                "responses" => [],
            ],
        ],
        "/login" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "Login a user",
                "description" => "Login a user",
                "operationId" => "login",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Login a user",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/login"
                        ]
                    ]
                ],
                "responses" => [
                ]
            ]
        ],
        "/get-social-user" => [
            "get" => [
                "tags" => [
                    "account"
                ],
                "summary" => "get social user",
                "description" => "get social user",
                "operationId" => "getSocialUser",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "social_id",
                        "in" =>  "query",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "provider",
                        "in" =>  "query",
                        'enum' => ['facebook', 'google', 'linkedin'],
                        "required" => true
                    ],
                ],
                "responses" => [
                ]
            ]
        ],
        "/social-login/{provider}" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "Login a user with social providers",
                "description" => "Login a user with social providers",
                "operationId" => "socialLogin",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        "name" => "provider",
                        "in" =>  "path",
                        "enum" => ["apple", "google", 'twitter'],
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Login a user with social providers",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/socialLogin"
                        ]
                    ]
                ],
                "responses" => [
                ]
            ]
        ],
        "/forgot-password" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "user forgot password",
                "description" => "user forgot password",
                "operationId" => "forget-password",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "forgot password",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/forgotPassword"
                        ]
                    ]
                ],
                "responses" => [
                ]
            ]
        ],
        "/send-otp" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "verify & send OTP",
                "description" => "verify & send OTP",
                "operationId" => "send-otp",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Send OTP",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/sendOtp"
                        ]
                    ]
                ],
                "responses" => [
                ]
            ]
        ],
        "/verify-otp" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "verify OTP",
                "description" => "verify OTP",
                "operationId" => "verify-otp",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Verify OTP",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/verifyOtp"
                        ]
                    ]
                ],
                "responses" => [
                ]
            ]
        ],
        "/reset-password" => [
            "post" => [
                "tags" => [
                    "account"
                ],
                "summary" => "user reset password",
                "description" => "user reset password",
                "operationId" => "resetPassword",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "reset password",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/resetPassword"
                        ]
                    ]
                ],
                "responses" => [
                ]
            ]
        ],
    ],
    'definitions' => [
        'login' => [
            "type" => "object",
            'properties' => [
                'email' => [
                    'type' => 'string'
                ],
                "password" => [
                    "type" => "string"
                ],
                "device_id" => [
                    "type" => "string"
                ],
                "device_type" => [
                    "type" => "string",
                    "enum" => ["ios", "android"]
                ],
                "certification_type" => [
                    "type" => "string",
                    'enum' => ['development', 'distribution']
                ],
            ],
        ],
        'socialLogin' => [
            "type" => "object",
            'properties' => [
                'email' => [
                    'type' => 'string'
                ],
                'name' => [
                    'type' => 'string'
                ],
                'profile_image' => [
                    'type' => 'string'
                ],
                "token" => [
                    "type" => "string"
                ],
                "phone_number" => [
                    "type" => "string"
                ],
                "referral_code" => [
                    "type" => "string"
                ],
                "device_id" => [
                    "type" => "string"
                ],
                "user_type" => [
                    "type" => "string",
                    "enum" => ["student", "tutor"]
                ],
                "device_type" => [
                    "type" => "string",
                    "enum" => ["ios", "android"]
                ],
                "certification_type" => [
                    "type" => "string",
                    'enum' => ['development', 'distribution']
                ],
                "gender" => [
                    "type" => "string",
                    'example' => 'male|female|other'
                ],
                "terms_of_service" => [
                    "type" => "integer"
                ],  
            ],
        ],
        'forgotPassword' => [
            'type' => "object",
            'properties' => [
                'email' => [
                    'type' => 'string'
                ],
            ],
            'xml' => [
                'name' => "forgot_password"
            ]
        ],
        'resetPassword' => [
            'type' => "object",
            'properties' => [
                'otp' => [
                    'type' => 'string'
                ],
                'new_password' => [
                    'type' => 'string'
                ],
                'confirm_password' => [
                    'type' => 'string'
                ],
            ],
            'xml' => [
                'name' => "reset_password"
            ]
        ],
        'sendOtp' => [
            'type' => "object",
            'properties' => [
                'email' => [
                    'type' => 'string'
                ],
                'type' => [
                    'type' => 'string',
                    'enum' => ['registration', 'forgot_password', 'update_profile']
                ],
                'user_id' => [
                    'type' => 'integer',
                ]
            ],
            'xml' => [
                'name' => "Otp"
            ]
        ],
        'verifyOtp' => [
            'type' => "object",
            'properties' => [
                'type' => [
                    'type' => 'string',
                    'enum' => ['registration', 'reset_password']
                ],
                'otp' => [
                    'type' => 'string'
                ],
                'user_id' => [
                    'type' => 'integer',
                ]
            ],
            'xml' => [
                'name' => "Otp"
            ]
        ],
    ]
];



