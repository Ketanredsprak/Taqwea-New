<?php
return [
    'paths' => [
        "/blogs" => [
            "get" => [
                "tags" => [
                    "blogs"
                ],
                "summary" => "get blog list",
                "description" => "get blog lis",
                "operationId" => "getBlogs",
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
                        'in' => 'query',
                        'name' => 'category[]',
                        'description' => 'By filter category id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'level[]',
                        'description' => 'By filter level id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'grade[]',
                        'description' => 'By filter grade id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'subject[]',
                        'description' => 'By filter subject id',
                        'type' => 'array',
                        'items' => ['type' => 'integer'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'min_price',
                        'description' => 'By filter price',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'max_price',
                        'description' => 'By filter price',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'search',
                        'description' => 'By blog title',
                        'type' => 'string',
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
            "post" => [
                "tags" => [
                    "blogs"
                ],
                "summary" => "Add Blog",
                "description" => "Add Blog",
                "operationId" => "addBlog",
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
                        'in' => 'formData',
                        'name' => 'media',
                        'description' => 'Image, video, document',
                        'type' => 'file',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'category_id',
                        'description' => 'Category',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'level',
                        'description' => 'Class Level',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'grade',
                        'description' => 'Class Grade',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'subject',
                        'description' => 'Class subject',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'en[blog_title]',
                        'description' => 'Title',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'en[blog_description]',
                        'description' => 'Description',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'total_fees',
                        'description' => 'Total Fees',
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
        "/blogs/{blog}" => [
            "get" => [
                "tags" => [
                    "blogs"
                ],
                "summary" => "get blog detail",
                "description" => "get blog detail",
                "operationId" => "getBlog",
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
                        "name" => "blog",
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
                    "blogs"
                ],
                "summary" => "Update Blog",
                "description" => "Update Blog",
                "operationId" => "updateBlog",
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
                        "name" => "blog",
                        "in" =>  "path",
                        "required" => true
                    ],
                    [
                        "type" => "string",
                        "name" => "app-version",
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
                        'in' => 'formData',
                        'name' => 'media',
                        'description' => 'Image, video, document',
                        'type' => 'file',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'category_id',
                        'description' => 'Category',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'level_id',
                        'description' => 'Class Level',
                        'type' => 'integer',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'grade_id',
                        'description' => 'Class Grade',
                        'type' => 'integer',
                        'required' => false,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'blog_title',
                        'description' => 'Title',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'blog_description',
                        'description' => 'Description',
                        'type' => 'string',
                        'format' => 'int64',
                        'required' => true,
                    ],
                    [
                        'in' => 'formData',
                        'name' => 'total_fees',
                        'description' => 'Total Fees',
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
            "delete" => [
                "tags" => [
                    "blogs"
                ],
                "summary" => "delete blog",
                "description" => "delete blog",
                "operationId" => "deleteBlog",
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
                        "name" => "blog",
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
        "/blogs/purchase" => [
            "get" => [
                "tags" => [
                    "blogs"
                ],
                "summary" => "get blog purchases detail",
                "description" => "get blog purchases detail",
                "operationId" => "getBlogPurchases",
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
        ],
        "/blogs/download/{blog}" => [
            "get" => [
                "tags" => [
                    "blogs"
                ],
                "summary" => "get blog download link",
                "description" => "get blog download link",
                "operationId" => "getBlogDownload",
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
                        "type" => "integer",
                        "name" => "blog",
                        "in" =>  "path",
                        "required" => true
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
        ],
    ],
    'definitions' => [
        
    ]
];
