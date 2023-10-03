<?php
return [
    'paths' => [
        "/ratings" => [
            "get" => [
                "tags" => [
                    "rating"
                ],
                "summary" => "get ratings",
                "description" => "get ratings",
                "operationId" => "getRatings",
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
                        "name" => "rating_type",
                        "in" =>  "query",
                        "required" => true,
                        "enum" => ['received', 'given']
                    ],
                    [
                        "type" => "integer",
                        "name" => "class_id",
                        "in" =>  "query",
                        "required" => false,
                        
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
                    "rating"
                ],
                "summary" => "Add rating",
                "description" => "Add rating",
                "operationId" => "addRating",
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
                        'in' => 'body',
                        'name' => 'body',
                        'required' => true,
                        "schema" => [
                            '$ref' => "#/definitions/addRating"
                        ]
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
        "/ratings/give-feedback" => [
            "get" => [
                "tags" => [
                    "rating"
                ],
                "summary" => "get feedback list",
                "description" => "get feedback list",
                "operationId" => "getFeedbackList",
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
                        "name" => "class_id",
                        "in" =>  "query",
                        "required" => false,
                        
                    ],
                    [
                        "type" => "string",
                        "name" => "search",
                        "in" =>  "query",
                        "required" => false,
                        
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
    ],
    'definitions' => [
        'addRating' => [
            "type" => "object",
            'properties' => [
                'class_id' => [
                    'type' => 'integer'
                ],
                "from_id" => [
                    "type" => "integer"
                ],
                "to_id" => [
                    "type" => "integer"
                ],
                'rating' => [
                    "type" => "string"
                ],
                'review' => [
                    "type" => "string"
                ],
                'clarity' => [
                    "type" => "string"
                ],
                'orgnization' => [
                    "type" => "string"
                ],
                'give_homework' => [
                    "type" => "string"
                ],
                'use_of_supporting_tools' => [
                    "type" => "string"
                ],
                'on_time' => [
                    "type" => "string"
                ],
            ],
        ],
    ]
];
