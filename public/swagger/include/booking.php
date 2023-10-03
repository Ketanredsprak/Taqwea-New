<?php
return [
    'paths' => [
        "/bookings" => [
            "get" => [
                "tags" => [
                    "bookings"
                ],
                "summary" => "get booking list",
                "description" => "get booking list",
                "operationId" => "getBookings",
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
                        "type" => "string",
                        "name" => "class_type",
                        "in" =>  "query",
                        "required" => true,
                        "enum" => ['class', 'webinar']
                    ],
                    [
                        "type" => "string",
                        "name" => "booking_status",
                        "in" =>  "query",
                        "required" => true,
                        "enum" => ['request', 'upcoming', 'past']
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
                    "bookings"
                ],
                "summary" => "Create booking",
                "description" => "Create booking",
                "operationId" => "addBooking",
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
                        'in' => 'body',
                        'name' => 'body',
                        'required' => true,
                        "schema" => [
                            '$ref' => "#/definitions/createBooking"
                        ]
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
        "/bookings/{booking}" => [
            "get" => [
                "tags" => [
                    "bookings"
                ],
                "summary" => "get booking detail",
                "description" => "get booking detail",
                "operationId" => "getClassBooking",
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
                        "name" => "booking",
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
        "/bookings/{booking}/{action}" => [
            "put" => [
                "tags" => [
                    "bookings"
                ],
                "summary" => "update booking status",
                "description" => "update booking status",
                "operationId" => "updateBookingStatus",
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
                        "name" => "booking",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "action",
                        "in" =>  "path",
                        "enum" => ["confirm", "reject", "cancel", 'joined'],
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
        "/bookings/student-list/{class}" => [
            "get" => [
                "tags" => [
                    "bookings"
                ],
                "summary" => "Get the booking list",
                "description" => "Get the booking list",
                "operationId" => "getBooking",
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
                    ]
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
        'createBooking' => [
            "type" => "object",
            'properties' => [
                'class_id' => [
                    'type' => 'integer'
                ],
                'blog_id' => [
                    'type' => 'integer'
                ],
                "student_id" => [
                    "type" => "integer"
                ],
                "booking_total" => [
                    "type" => "integer"
                ],
                "wallet_amount" => [
                    "type" => "integer"
                ],
                "payment_method" => [
                    "type" => "string",
                    "example" => 'wallet|direct_payment'
                ],
                "transaction_fees" => [
                    "type" => "integer"
                ],
                "card_type" => [
                    "type" => "string"
                ],
                 
            ],
        ],
    ]
];
