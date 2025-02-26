<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'line' => [
        'message' => [
            'channel_id'=>env('LINE_MESSAGE_CHANNEL_ID', ''),
            'channel_secret'=>env('LINE_MESSAGE_CHANNEL_SECRET', ''),
            'channel_token'=>env('LINE_MESSAGE_CHANNEL_TOKEN', ''),
            'liffId'=>env('LINE_MESSAGE_CHANNEL_TOKEN', ''),
            'liff_channel_id'=>env('LINE_MESSAGE_CHANNEL_TOKEN', ''),
        ]
    ],

    'yoyaku_url' => env('APP_URL', ''),
    
];
