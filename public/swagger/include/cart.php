<?php
return [
    'paths' => [
        "/carts" => [
            "get" => [
                "tags" => [
                    "cart"
                ],
                "summary" => "Cart item list",
                "description" => "Cart item list",
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
                    "cart"
                ],
                "summary" => "Add item in cart",
                "description" => "Add item in cart",
                "operationId" => "addToCart",
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
                        "description" => "cart Item",
                        "required" => false,
                        "schema" => [
                            '$ref' => "#/definitions/addToCart"
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
        "/carts/{id}/{item_id}" => [
            "delete" => [
                "tags" => [
                    "cart"
                ],
                "summary" => "Delete item in cart",
                "description" => "Delete item in cart",
                "operationId" => "deleteItemInCart",
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
                        "type" => "integer",
                        "name" => "id",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "type" => "integer",
                        "name" => "item_id",
                        "in" =>  "path",
                        "required" => true
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
        'addToCart' => [
            "type" => "object",
            'properties' => [
                'class_id' => [
                    'type' => 'integer'
                ],               
                'blog_id' => [
                    'type' => 'integer'
                ],
                'qty' => [
                    'type' => 'integer'
                ],
                'unit_price' => [
                    'type' => 'integer'
                ],
                'price' => [
                    'type' => 'integer'
                ]
            ],
        ]
    ]
];



