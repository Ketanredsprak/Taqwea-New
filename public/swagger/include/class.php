<?php
return [
    'paths' => [
        "/classes" => [
            "get" => [
                "tags" => [
                    "class"
                ],
                "summary" => "get class list",
                "description" => "get class lis",
                "operationId" => "getClasses",
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
                        "type" => "string",
                        "name" => "class_type",
                        "in" =>  "query",
                        "required" => true,
                        "enum" => ['class', 'webinar']
                    ],
                    [
                        "type" => "string",
                        "name" => "class_status",
                        "in" =>  "query",
                        "required" => true,
                        "enum" => ['upcoming', 'past']
                    ],
                    [
                        "type" => "integer",
                        "name" => "tutor_id",
                        "in" =>  "query",
                        "required" => false,
                    ],
                    [
                        "type" => "string",
                        "name" => "search",
                        "in" =>  "query",
                        "required" => false,
                        "example" => ' search by tutor, course name, subject name'
                    ],
                    [
                        'in' => 'query',
                        'name' => 'category[]',
                        'description' => 'By filter category id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'level[]',
                        'description' => 'By filter level id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'grade[]',
                        'description' => 'By filter grade id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'subject[]',
                        'description' => 'By filter subject id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'language_level[]',
                        'description' => 'By filter language level',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'min_price',
                        'description' => 'By filter price',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'max_price',
                        'description' => 'By filter price',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'gender',
                        'description' => 'Class is for',
                        'type' => 'string',
                        'required' => false,
                        'example' => 'both|male|female'
                    ],
                    [
                        'in' => 'query',
                        'name' => 'start_date',
                        'description' => 'class start date ',
                        'type' => 'string',
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
            "post" => [
                "tags" => [
                    "class"
                ],
                "summary" => "Add Class",
                "description" => "Add Class",
                "operationId" => "addClass",
                "consumes" => [
                    "application/x-www-form-urlencoded"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "time-zone",
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_image',
                        'description' => 'Image',
                        'type' => 'file',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_name',
                        'description' => 'Class Name',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_description',
                        'description' => 'Description',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_type',
                        'description' => 'Class Type',
                        'type' => 'string',
                        'enum' => ['class', 'webinar'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'gender_preference',
                        'description' => 'Class is for',
                        'type' => 'string',
                        'enum' => ['both', 'male', 'female'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'category_id',
                        'description' => 'Category',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'level_id',
                        'description' => 'Class Level',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'grade_id',
                        'description' => 'Class Grade',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'subject_id',
                        'description' => 'Subject',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => false,
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
        "/classes/{class}" => [
            "get" => [
                "tags" => [
                    "class"
                ],
                "summary" => "get class detail",
                "description" => "get class detail",
                "operationId" => "getClass",
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
                        "name" => "class",
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
                    "class"
                ],
                "summary" => "Update Class",
                "description" => "Update Class",
                "operationId" => "updateClass",
                "consumes" => [
                    "application/x-www-form-urlencoded"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "_method",
                        "in" =>  "formData",
                        "enum" => ["PUT"],
                        "required" => true
                    ],
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
                        "type" => "string",
                        "name" => "time-zone",
                        "in" =>  "header",
                        "required" => true
                    ],
                    [
                        "type" => "integer",
                        "name" => "class",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_image',
                        'type' => 'file',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_name',
                        'type' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_description',
                        'type' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'class_type',
                        'type' => 'string',
                        'enum' => ['class', 'webinar'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'gender_preference',
                        'description' => 'Class is for',
                        'type' => 'string',
                        'enum' => ['both', 'male', 'female'],
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'category_id',
                        'type' => 'integer',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'level_id',
                        'type' => 'integer',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'grade_id',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'subject_id',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'duration',
                        'type' => 'integer',
                        'format' => 'in minutes',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'start_time',
                        'type' => 'string',
                        'format' => 'YYYY-MM-DD H:i',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'hourly_fees',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'total_fees',
                        'type' => 'integer',
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
        "/classes/{class}/publish" => [
            "patch" => [
                "tags" => [
                    "class"
                ],
                "summary" => "publish class",
                "description" => "publish class",
                "operationId" => "publishClass",
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
                        "name" => "class",
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
        "/classes/{class}/raise-dispute" => [
            "post" => [
                "tags" => [
                    "class"
                ],
                "summary" => "Refund request",
                "description" => "Refund request",
                "operationId" => "raiseDispute",
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
                        "name" => "class",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Refund request",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/raiseDispute"
                        ]
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
        "/classes/{class}/{action}" => [
            "put" => [
                "tags" => [
                    "class"
                ],
                "summary" => "update booking status",
                "description" => "update booking status",
                "operationId" => "updateBookingStatus",
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
                        "name" => "class",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "action",
                        "in" =>  "path",
                        "enum" => ["completed", "cancelled", 'started'],
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
        "/classes/available" => [
            "get" => [
                "tags" => [
                    "class"
                ],
                "summary" => "Available classes",
                "description" => "Available classes",
                "operationId" => "availableClasses",
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
                        "type" => "string",
                        "name" => "class_type",
                        "in" =>  "query",
                        "enum" => ["class", "webinar"],
                        "required" => true
                    ],
                    [
                        "type" => "integer",
                        "name" => "tutor_id",
                        "in" =>  "query",
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
        "/classes/token" => [
            "get" => [
                "tags" => [
                    "class"
                ],
                "summary" => "Token for calling",
                "description" => "Token for calling",
                "operationId" => "tokenCalling",
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
                        "name" => "class",
                        "in" =>  "query",
                    ],
                   
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ]
    ],
    'definitions' => [
        'raiseDispute' => [
            "type" => "object",
            'properties' => [
                'dispute_reason' => [
                    'type' => 'string'
                ]
            ],
        ]
    ]
];
