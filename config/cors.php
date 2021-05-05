<?php


// $local_url = env('APP_URL', 'http://localhost');
$regex_local_url = "/http:\/\/localhost:*/";
// $regex_local_url= new RegExp($local_url);
// $regex_local_url= $local_url;
// print $regex_local_url;

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['/*', 'api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [''],

    'allowed_origins_patterns' => ['/localhost:*/', $regex_local_url], 
    // 'allowed_origins_patterns' => [$regex_local_url], 

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
