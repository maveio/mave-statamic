<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mave Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and settings for Mave.
    | These settings can be set via environment variables or directly here.
    |
    */

    'key'    => env('MAVE_KEY', ''),
    'sub'    => env('MAVE_SUB', ''),
    'theme'  => env('MAVE_THEME', ''),
    'upload' => filter_var(env('MAVE_UPLOAD', false), FILTER_VALIDATE_BOOLEAN),

];