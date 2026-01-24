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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'hikerapi' => [
        'base_url' => env('HIKERAPI_BASE_URL', 'https://api.hikerapi.com'),
        'access_key' => env('HIKERAPI_ACCESS_KEY'),
    ],

    'whatsapp' => [
        // Ex: https://wa.me/5511999999999?text=Quero%20saber%20mais%20sobre%20Engajamento%20Inteligente
        'engajamento_inteligente_url' => env('WHATSAPP_ENGAJAMENTO_INTELIGENTE_URL'),
    ],

    'client' => [
        // URL do portal do cliente (futuro Vue). Ex: https://cliente.seudominio.com
        'app_url' => env('CLIENT_APP_URL'),
    ],

];
