<?php
return [
    'paths' => [
       "/tutors/{id}/educations" => [
            "get" => [
                "tags" => [
                    "tutor-educations"
                ],
                "summary" => "Get list of tutor educations",
                "description" => "Get list of tutor educations",
                "operationId" => "getEducations",
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
            "post" => [
                "tags" => [
                    "tutor-educations"
                ],
                "summary" => "Add tutor education",
                "description" => "Add tutor education",
                "operationId" => "AddEducations",
                "consumes" => [
                    "application/x-www-form-urlencoded"
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
                        "type" => "integer",
                        "name" => "id",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'certificate',
                        'description' => 'Certificate',
                        'type' => 'file',
                        'format' => 'int64',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'degree',
                        'description' => 'Degree',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'university',
                        'description' => 'University',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
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
        "/tutors/{id}/educations/{education_id}" => [
            "delete" => [
                "tags" => [
                    "tutor-educations"
                ],
                "summary" => "Delete education",
                "description" => "Delete education",
                "operationId" => "deleteCertificate",
                "consumes" => [
                    "multipart/form-data"
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
                        "in" =>  "path",
                        "type" => "integer",
                        "name" => "id",
                        "required" => true
                    ],
                    [
                        "in" =>  "path",
                        "type" => "integer",
                        "name" => "education_id",
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
        
    ]
];
