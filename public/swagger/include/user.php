<?php
return [
    'paths' => [
       "/users/{id}" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "get user profile",
                "description" => "get user profile",
                "operationId" => "getUserProfile",
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
                        "name" => "app-version",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "id",
                        "in" =>  "path",
                        "required" => true
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Update Profile",
                "description" => "Update Profile",
                "operationId" => "updateProfile",
                "consumes" => [
                    "application/x-www-form-urlencoded"
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
                        "in" =>  "path",
                        "type" => "integer",
                        "name" => "id",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "app-version",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        "name" => "_method",
                        "in" =>  "formData",
                        "enum" => [ "PUT" ],
                        "required" => true
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'profile_image',
                        'description' => 'Profile Image',
                        'type' => 'file',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'name',
                        'description' => 'Name',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'email',
                        'description' => 'Email',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'phone_number',
                        'description' => 'Phone Number',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'introduction_video',
                        'description' => 'Introduction Video',
                        'type' => 'file',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'experience',
                        'description' => 'Experience',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'bio',
                        'description' => 'Bio',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'address',
                        'description' => 'Address',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'levels',
                        'description' => 'Levels',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'grades',
                        'description' => 'Grade',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'subjects',
                        'description' => 'Subjects',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'general_knowledge',
                        'description' => 'General Knowledge',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'languages',
                        'description' => 'Languages',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'id_card',
                        'description' => 'ID Card',
                        'type' => 'file',
                        'required' => false,
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ],
        "/users/{id}/complete-profile" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Complete profile",
                "description" => "Complete profile",
                "operationId" => "completeProfile",
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
                        "in" =>  "path",
                        "type" => "integer",
                        "name" => "id",
                        "required" => true
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'profile_image',
                        'description' => 'Profile Image',
                        'type' => 'file',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'introduction_video',
                        'description' => 'Introduction Video',
                        'type' => 'file',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'experience',
                        'description' => 'Experience',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'bio',
                        'description' => 'Bio',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'levels',
                        'description' => 'Levels',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'grades',
                        'description' => 'Grade',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'subjects',
                        'description' => 'Subjects',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'general_knowledge',
                        'description' => 'General Knowledge',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'languages',
                        'description' => 'Languages',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'address',
                        'description' => 'Address',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        "type" => "string",
                        'enum' => ['pending'],
                        "name" => "approval_status",
                        "required" => false
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'id_card',
                        'description' => 'ID Card',
                        'type' => 'file',
                        'required' => false,
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ],
        "/users/{user}/support-request" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Send support request",
                "description" => "Send support request",
                "operationId" => "supportRequest",
                "consumes" => [
                    "application/json",
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
                        "name" => "app-version",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "in" =>  "path",
                        "type" => "integer",
                        "name" => "user",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/supportRequest"
                        ]
                    ]
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ]
        ],
        "/users/{user}/ratings" => [
            "get" => [
                "tags" => [
                    "user"
                ],
                "summary" => "get ratings of user",
                "description" => "get ratings of user",
                "operationId" => "getUserRating",
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
                        "name" => "app-version",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "user",
                        "in" =>  "path",
                        "required" => true
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ],
        "/change-password" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Change user password",
                "description" => "Change user password",
                "operationId" => "changePassword",
                "consumes" => [
                    "application/json",
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
                        "name" => "app-version",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "reset password",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/changePassword"
                        ]
                    ]
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ]
        ],
        "/logout" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "Logout User",
                "description" => "",
                "operationId" => "logout",
                "consumes" => [
                    "application/json"
                ],
                "parameters" => [],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ],
        "/users/set-lanaguage" => [
            "post" => [
                "tags" => [
                    "user"
                ],
                "summary" => "set user lang",
                "description" => "",
                "operationId" => "setLang",
                "consumes" => [
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
                        "name" => "app-version",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" =>  "header",
                        "required" => false
                    ]
                    
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ],
    ],
    'definitions' => [
        'changePassword' => [
            'type' => "object",
            'properties' => [
                'current_password' => [
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
                'name' => "change_password"
            ]
        ],
        'supportRequest' => [
            'type' => "object",
            'properties' => [
                'message' => [
                    'type' => 'string'
                ],
            ],
            'xml' => [
                'name' => "supportRequest"
            ]
        ],
    ]
];
