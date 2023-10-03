<?php

return [
    'paths' => [
        "/tutor/dashboard" => [
            "get" => [
                "tags" => [
                    "tutor",
                ],
                "summary" => "Tutor dashboard",
                "description" => "",
                "operationId" => "tutorDashboard",
                "consumes" => [
                    "application/json",
                ],
                "parameters" => [
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
                    [
                        "type" => "string",
                        "name" => "timezone",
                        "in" => "header",
                        "required" => false,
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => [],
                    ],
                ],
            ],
        ],
        "/tutors" => [
            "get" => [
                "tags" => [
                    "tutor",
                ],
                "summary" => "Tutors list",
                "description" => "",
                "operationId" => "tutorList",
                "consumes" => [
                    "application/json",
                ],
                "parameters" => [
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
                    [
                        "type" => "string",
                        "name" => "timezone",
                        "in" => "header",
                        "required" => false,
                    ],
                    [
                        "type" => "string",
                        "name" => "search",
                        "in" => "query",
                        "required" => false,
                    ],
                    [
                        "in" => "query",
                        "name" => "level[]",
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        "in" => "query",
                        "name" => "featured",
                        'type' => 'string',
                        'enum' => ['No', 'Yes'],
                    ],
                    [
                        "in" => "query",
                        "name" => "grade[]",
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        "in" => "query",
                        "name" => "subject[]",
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        "in" => "query",
                        "name" => "generalknowledge[]",
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        "in" => "query",
                        "name" => "language[]",
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        "in" => "query",
                        "name" => "experience",
                        'type' => 'string',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => [],
                    ],
                ],
            ],
        ],
        "/tutor/bank-account" => [
            "put" => [
                "tags" => [
                    "tutor",
                ],
                "summary" => "bank account details update",
                "description" => "bank account details update",
                "operationId" => "updateBankAccount",
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
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Update request",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/updateBankAccount",
                        ],
                    ],
                ],
                "responses" => [],
                'security' => [
                    [
                        'Bearer' => [],
                    ],
                ],
            ],
        ],
    ],
    'definitions' => [
        'updateBankAccount' => [
            "type" => "object",
            'properties' => [
                'beneficiary_name' => [
                    'type' => 'string',
                ],
                'account_number' => [
                    'type' => 'string',
                ],
                'bank_code' => [
                    'type' => 'string',
                ],
                'address' => [
                    'type' => 'string',
                ],
            ],
        ],
    ],
];
