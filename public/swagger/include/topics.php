<?php
return [
    'paths' => [
        "/classes/{class}/topics" => [
            "get" => [
                "tags" => [
                    "topics"
                ],
                "summary" => "get topic list",
                "description" => "get topic lis",
                "operationId" => "getTopics",
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
                    "topics"
                ],
                "summary" => "Add Topic",
                "description" => "Add Topic",
                "operationId" => "addTopic",
                "consumes" => [
                    "multipart/form-data"
                ],
                "produces" => [
                    "multipart/form-data"
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
                        'in' => 'formData',
                        'name' => 'en[topic_title]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'en[topic_description]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                   
                    [
                        'in' => 'formData',
                        'name' => 'sub_topics[]',
                        'description' => 'add sub topic',
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'ar[topic_title]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'ar[topic_description]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'sub_topics_ar[]',
                        'description' => 'add sub topic',
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                        'required' => false,
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
        "/classes/{class}/topics/{topic}" => [
            "get" => [
                "tags" => [
                    "topics"
                ],
                "summary" => "get topic detail",
                "description" => "get topic detail",
                "operationId" => "getTopic",
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
                        "name" => "topic",
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
                    "topics"
                ],
                "summary" => "Update Topic",
                "description" => "Update Topic",
                "operationId" => "updateTopic",
                "consumes" => [
                    "application/x-www-form-urlencoded"
                ],
                "produces" => [
                    "application/x-www-form-urlencoded"
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
                        'in' => 'formData',
                        'name' => '_method',
                        'type' => 'string',
                        'format' => 'int64',
                        'enum' => ['PUT'],
                        'required' => true,
                    ],
                    [
                        "type" => "integer",
                        "name" => "class",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "type" => "integer",
                        "name" => "topic",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'en[topic_title]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'en[topic_description]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => true,
                    ],
                   
                    [
                        'in' => 'formData',
                        'name' => 'sub_topics[]',
                        'description' => 'add sub topic',
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'ar[topic_title]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'ar[topic_description]',
                        'type' => 'string',
                        'format' => 'string',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'sub_topics_ar[]',
                        'description' => 'add sub topic',
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                        'required' => false,
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
                    "topics"
                ],
                "summary" => "delete topic",
                "description" => "delete topic",
                "operationId" => "deleteTopic",
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
                        "name" => "topic",
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
        'addTopic' => [
            "type" => "object",
            'properties' => [
                'en["topic_title"]' => [
                    'type' => 'string'
                ],
                'en["topic_description"]' => [
                    "type" => "string"
                ],
                "sub_topics" => [
                    "type" => "array",
                    "items" => [
                        "type" => "string"
                    ]
                ]
            ],
        ],
        'updateTopic' => [
            "type" => "object",
            'properties' => [
                'topic_title' => [
                    'type' => 'string'
                ],
                "topic_description" => [
                    "type" => "string"
                ],
                "sub_topics" => [
                    "type" => "array",
                    "items" => [
                        "type" => "string"
                    ]
                ]
            ],
        ],
    ]
];
