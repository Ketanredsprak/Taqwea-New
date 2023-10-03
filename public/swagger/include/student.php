<?php

return [
    'paths' => [
        "/student/dashboard" => [
            "get" => [
                "tags" => [
                    "student"
                ],
                "summary" => "Student dashboard",
                "description" => "",
                "operationId" => "studentDashboard",
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
        
    ]
];
