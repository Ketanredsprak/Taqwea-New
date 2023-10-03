<?php
return [
    'paths' => [
       "/tutors/{id}/certificates" => [
            "get" => [
                "tags" => [
                    "tutor-certificates"
                ],
                "summary" => "Get list of tutor certificates",
                "description" => "Get list of tutor certificates",
                "operationId" => "getCertificates",
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
                    "tutor-certificates"
                ],
                "summary" => "Add tutor certificate",
                "description" => "Add tutor certificate",
                "operationId" => "AddCertificates",
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
                        'name' => 'certificate_name',
                        'description' => 'Name',
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
        "/tutors/{id}/certificates/{certificate_id}" => [
            "delete" => [
                "tags" => [
                    "tutor-certificates"
                ],
                "summary" => "Delete certificate",
                "description" => "Delete certificate",
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
                        "name" => "certificate_id",
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
