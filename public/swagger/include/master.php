<?php
return [
    'paths' => [
        "/categories" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all categories",
                "description" => "get all categories",
                "operationId" => "getCategories",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                ],
                "responses" => [
                ],
            ]
        ],
        "/categories/{category}/levels" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all levels",
                "description" => "get all levels",
                "operationId" => "getLevel",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        "name" => "category",
                        "in" =>  "path",
                        "required" => true
                    ],
                ],
                "responses" => [
                ],
            ]
        ],
        "/categories/grades" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all grades",
                "description" => "get all grades",
                "operationId" => "getGrades",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        "description" => "comma separated category ids",
                        "name" => "category_id",
                        "in" =>  "query",
                        "required" => true
                    ],
                ],
                "responses" => [
                ],
            ]
        ],
        "/subjects" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all subject",
                "description" => "get all subject",
                "operationId" => "getSubjects",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "string",
                        "name" => "category_id",
                        "in" =>  "query",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "grade_id",
                        "in" =>  "query",
                        "required" => false
                    ],
                ],
                "responses" => [
                ],
            ]
        ],
        "/categories/{category}/languages" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all languages",
                "description" => "get all languages",
                "operationId" => "getLanguages",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "category",
                        "in" =>  "path",
                        "required" => true
                    ],
                ],
                "responses" => [
                ],
            ]
        ],
        "/categories/{category}/general-knowledge" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all general knowledge category",
                "description" => "get all general knowledge category",
                "operationId" => "getGeneralKnowledge",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "category",
                        "in" =>  "path",
                        "required" => true
                    ],
                ],
                "responses" => [
                ],
            ]
        ],
        "/settings" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all Settings",
                "description" => "get all settings",
                "operationId" => "getCommission",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    
                ],
                "responses" => [
                ],
            ]
        ],
        "/categories/all" => [
            "get" => [
                "tags" => [
                    "master"
                ],
                "summary" => "get all Category",
                "description" => "get all category",
                "operationId" => "getCategory",
                "consumes" => [
                    "application/json"
                ],
                "produces" => [
                    "application/json"
                ],
                "parameters" => [
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
                        "name" => "language",
                        "in" =>  "header",
                        "required" => false
                    ],
                    
                ],
                "responses" => [
                ],
            ]
        ],
        "/banks" => [
            "get" => [
                "tags" => [
                    "master",
                ],
                "summary" => "all banks name",
                "description" => "All banks name",
                "operationId" => "",
                "consumes" => [
                    "application/json",
                ],
                "produces" => [
                    "application/json",
                ],
                "parameters" => [
                    [
                        "type" => "string",
                        "name" => "language",
                        "in" => "header",
                        "required" => true,
                    ],
                    [
                        "type" => "string",
                        "name" => "app-version",
                        "in" => "header",
                        "required" => false,
                    ],
                    [
                        "type" => "string",
                        'enum' => ['ios', 'android'],
                        "name" => "device-type",
                        "in" => "header",
                        "required" => false,
                    ],
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation",
                    ],
                ],
                'security' => [
                    [
                        'Bearer' => [],
                    ],
                ],
            ],

        ],        
    ],
    'definitions' => [
        
    ]
];