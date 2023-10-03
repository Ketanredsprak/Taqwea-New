<?php
return [
    'paths' => [
        "/top-ups" => [
            "get" => [
                "tags" => [
                    "top-up"
                ],
                "summary" => "get top up list",
                "description" => "get top up list",
                "operationId" => "getTopUp",
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
                    "top-up"
                ],
                "summary" => "Top up purchase",
                "description" => "Top up purchase",
                "operationId" => "getTopUp",
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
                        "in" => "body",
                        "name" => "body",
                        "description" => "Top Up Purchase",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/topUpPurchase"
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
        "/top-ups/purchases" => [
            "get" => [
                "tags" => [
                    "top-up"
                ],
                "summary" => "Purchase list",
                "description" => "Purchase list",
                "operationId" => "",
                "consumes" => [
                    "application/json",
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
                    ]
                ],
                "responses" => [
                    "default" => [
                        "description" => "successful operation"
                    ]
                ],
                'security' => [
                    [
                        'Bearer' => []
                    ]
                ],
            ]
        ],
        
    ],
    'definitions' => [
        'topUpPurchase' => [
            "type" => "object",
            'properties' => [
                'top_up_id' => [
                    'type' => 'integer'
                ],
                "class_hours" => [
                    "type" => "integer"
                ],
                "webinar_hours" => [
                    "type" => "integer",
                    
                ],
                "blog_count" => [
                    "type" => "integer",
                    
                ],
                "is_featured" => [
                    "type" => "integer",
                    
                ],
                "payment_method" => [
                    "type" => "string",
                    "example" => 'wallet|direct_payment'
                ],
                "card_type" => [
                    "type" => "string"
                ],
            ],
        ],
        
    ]
];
