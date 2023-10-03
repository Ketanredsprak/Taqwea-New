<?php
return [
    'paths' => [
        "/wallets" => [
            "get" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Wallets list",
                "description" => "Wallets list",
                "operationId" => "Wallets list",
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
                    "wallet"
                ],
                "summary" => "add amount Wallet",
                "description" => "add amount Wallet",
                "operationId" => "addWallet",
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
                        "description" => "Transaction",
                        "required" => true,
                        "schema" => [
                            '$ref' => "#/definitions/addWallet"
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
            ],       
        ],
        "/redeem-points" => [            
            "post" => [
                "tags" => [
                    "wallet"
                ],
                "summary" => "Redeem points",
                "description" => "Redeem points",
                "operationId" => "redeemPoints",
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
                        "description" => "Transaction",
                        "required" => true,
                        "schema" => [
                            '$ref' => "#/definitions/redeemPoints"
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
            ],
           
           
        ],
        
    ],
    'definitions' => [
        'addWallet' => [
            "type" => "object",
            'properties' => [
                'amount' => [
                    'type' => 'integer'
                ],
                "payment_method" => [
                    "type" => "string",
                    "example" => 'direct_payment'
                ],
                "card_type" => [
                    "type" => "string"
                ],
            ],
        ],
        'redeemPoints' => [
            "type" => "object",
            'properties' => [
                'points' => [
                    'type' => 'string'
                ]
            ],
        ]   
    ]
];
