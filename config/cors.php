<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'apercu/*', 'configuration/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // ⚠️ Mets ici le domaine de ton frontend
    // Exemple : ['http://localhost:5173'] ou ['https://ton-site.com']
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
