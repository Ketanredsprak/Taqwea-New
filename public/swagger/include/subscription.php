<?php
return [
    'paths' => [
        "/subscriptions" => [
            "get" => [
                "tags" => [
                    "subscription"
                ],
                "summary" => "Subscription list",
                "description" => "Subscription list",
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
            ],
            "post" => [
                "tags" => [
                    "subscription"
                ],
                "summary" => "Subscription purchase",
                "description" => "Subscription purchase",
                "operationId" => "subscriptionPurchase",
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
                    ],
                    [
                        "in" => "body",
                        "name" => "body",
                        "description" => "Purchase plan",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/subscriptionPurchase"
                        ]
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
        "/subscriptions/purchases" => [
            "get" => [
                "tags" => [
                    "subscription"
                ],
                "summary" => "Subscription list",
                "description" => "Subscription list",
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
        'subscriptionPurchase' => [
            "type" => "object",
            'properties' => [
                "plan_id" => [
                    "type" => "integer"
                ],
                "duration" => [
                    "type" => "integer"
                ],
                "amount" => [
                    "type" => "integer"
                ],
                "wallet_amount" => [
                    "type" => "integer"
                ],
                "payment_method" => [
                    "type" => "string",
                    "example" => 'wallet|direct_payment'
                ],
                "card_type" => [
                    "type" => "string"
                ],
               
            ],
        ] 
    ]
];



