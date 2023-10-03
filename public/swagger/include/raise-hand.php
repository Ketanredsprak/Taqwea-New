<?php
return [
    'paths' => [
        "/classes/{class}/raise-hand" => [
            "get" => [
                "tags" => [
                    "raise-hand"
                ],
                "summary" => "get raise hand requests",
                "description" => "get raise hand requests",
                "operationId" => "getRequests",
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
                    "raise-hand"
                ],
                "summary" => "Create Raise Hand Request",
                "description" => "Create Raise Hand Request",
                "operationId" => "createRequest",
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
                        "description" => "Create request",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/createRequest"
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
        "/classes/{class}/raise-hand/{raise_hand}" => [
            "put" => [
                "tags" => [
                    "raise-hand"
                ],
                "summary" => "update request",
                "description" => "update request",
                "operationId" => "updateRequest",
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
                        "type" => "integer",
                        "name" => "raise_hand",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Update request",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/updateRequest"
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
    ],
    'definitions' => [
        'createRequest' => [
            "type" => "object",
            'properties' => [
                'student_id' => [
                    'type' => 'integer'
                ],
            ],
        ],
        'updateRequest' => [
            "type" => "object",
            'properties' => [
                'status' => [
                    'type' => 'string',
                    'enum' => ['accept', 'reject', 'complete']
                ],
            ],
        ],
    ]
];
