<?php
return [
    'paths' => [
        "/payment-methods" => [
            "get" => [
                "tags" => [
                    "payment-methods"
                ],
                "summary" => "User cards",
                "description" => "",
                "operationId" => "User cards",
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
            "post" => [
                "tags" => [
                    "payment-methods"
                ],
                "summary" => "Add user card",
                "description" => "",
                "operationId" => "addCard",
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
                        "description" => "add card",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/addCard"
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
        "/payment-methods/{id}" => [
            "get" => [
                "tags" => [
                    "payment-methods"
                ],
                "summary" => "User card detail",
                "description" => "",
                "operationId" => "User card detail",
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
            "delete" => [
                "tags" => [
                    "payment-methods"
                ],
                "summary" => "User cards",
                "description" => "",
                "operationId" => "User cards",
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
       
              
    ],
    'definitions' => [
        'addCard' => [
            'type' => "object",
            "properties" => [
                "card_type" => [
                    "type" => "string",
                    "enum" => ["VISA", "MASTER", "MADA", "APPLEPAY"]
                ],
                "card_number" => [
                    "type" => "string",
                    "example" => '4111111111111111'
                ],
                "card_holder_name" => [
                    "type" => "string"
                ],
                "exp_month" => [
                    "type" => "string",
                    "enum" => [
                        "01", 
                        "02", 
                        "03", 
                        "04", 
                        "05", 
                        "06", 
                        "07", 
                        "08", 
                        "09", 
                        "10", 
                        "11", 
                        "12" 
                    ]
                ],
                "exp_year" => [
                    "type" => "string",
                    "enum" => ["2021", "2022", "2023", "2024", "2025", "2026"]
                ],
                "card_cvv" => [
                    "type" => "string",
                    "example" => "123"
                ]
            ],
            'xml' => [
                'name' => "add to cart"
            ]
        ],
    ]
];