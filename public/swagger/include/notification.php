<?php

return [
    'paths' => [
        "/notifications" => [
            "get" => [
                "tags" => [
                    "notification"
                ],
                "summary" => "User notifications",
                "description" => "",
                "operationId" => "User notifications",
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
            "post" => [
                "tags" => [
                    "notification"
                ],
                "summary" => "save notifications",
                "description" => "",
                "operationId" => "save notifications",
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
                        "in" => "body",
                        "name" => "body",
                        "description" => "Notification data",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/saveNotification"
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
        "/notifications/{id}" => [
            "delete" => [
                "tags" => [
                    "notification"
                ],
                "summary" => "Delete notification",
                "description" => "",
                "operationId" => "Delete notification",
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
        ],
        "/notifications/clear-all" => [
            "get" => [
                "tags" => [
                    "notification"
                ],
                "summary" => "Clear all notifications",
                "description" => "",
                "operationId" => "Clear all notifications",
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
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ],
        ],
        "/notifications/read-all" => [
            "patch" => [
                "tags" => [
                    "notification"
                ],
                "summary" => "Read all notifications",
                "description" => "",
                "operationId" => "Read all notifications",
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
        'saveNotification'=> [
            'type' => "object",
            'properties' => [
                'to_id' => [
                    'type' => 'string'
                ],
                'type' => [
                    'type' => 'string'
                ],
                'notification_data' => [
                    'type' => 'string'
                ],
                'notification_message' => [
                    'type' => 'string'
                ],
            ],
            'xml' => [
                'name' => "change_password"
            ]
        ]
    ]
];
