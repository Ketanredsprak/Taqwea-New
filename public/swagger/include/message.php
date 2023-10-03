<?php

return [
    'paths' => [
        "/messages" => [
            "get" => [
                "tags" => [
                    "message"
                ],
                "summary" => "user matches",
                "description" => "",
                "operationId" => "user matches",
                "consumes" => [
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
                        "name" => "search",
                        "in" =>  "query",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "class_id",
                        "in" =>  "query",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "page",
                        "in" =>  "query",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "per_page",
                        "in" =>  "query",
                        "required" => false
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
        "/messages/{uuid}/{studentId}" => [
            "get" => [
                "tags" => [
                    "message"
                ],
                "summary" => "Thread messages",
                "description" => "",
                "operationId" => "Thread messages",
                "consumes" => [
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
                        "name" => "uuid",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "type" => "integer",
                        "name" => "studentId",
                        "in" =>  "path",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "page",
                        "in" =>  "query",
                        "required" => false
                    ],
                    [
                        "type" => "integer",
                        "name" => "per_page",
                        "in" =>  "query",
                        "required" => false
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
    'definitions' => []
];
