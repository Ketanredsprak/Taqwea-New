<?php

$base ='localhost:80';
$baseUrl='http://localhost:80';

return [

    'apiVersion' => '1.0.0',
    'swaggerVersion' => '2.0',
    'title' => 'Taqwea Api Documentation',
    'basePath'=> '/api/v1',
    'basePathSwagger'=> $baseUrl.'swagger/include',
    'apiUrl'=> $baseUrl.'/api/v1',
    'base'=> $base,
    'baseUrl'=> $baseUrl,
    'schemes'=> [
        "http",
        "https"
    ]
];