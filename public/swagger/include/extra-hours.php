<?php
return [
    'paths' => [
        "/classes/{class}/extra-hours" => [   
            "get" => [
                "tags" => [
                    "extra-hours"
                ],
                "summary" => "get extra hours requests",
                "description" => "get extra hours requests",
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
                    "extra-hours"
                ],
                "summary" => "Create Extra Hours Request",
                "description" => "Create Extra Hours Request",
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
                            '$ref' => "#/definitions/createExtraHourRequest"
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
        "/classes/{class}/update-extra-hours" => [
            "patch" => [
                "tags" => [
                    "extra-hours"
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
                        "in" => "body",
                        "name" => "body",
                        "description" => "Update request",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/updateExtraHourRequest"
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
        'createExtraHourRequest' => [
            "type" => "object",
            'properties' => [
                'duration' => [
                    'type' => 'string',
                    'enum' => ['0.5', '1', '1.5','2', '2.5', '3','3.5','4']
                ],
                'extra_hour_charge' => [
                    'type' => 'integer'
                ],
            ],
        ],
        'updateExtraHourRequest' => [
            "type" => "object",
            'properties' => [
                'status' => [
                    'type' => 'string',
                    'enum' => ['accepted', 'rejected']
                ],
            ],
        ],
    ]
];
