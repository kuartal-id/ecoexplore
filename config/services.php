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

    // Kuartal ID -- the central OAuth2/OIDC identity provider (id.kuartal.id, repo
    // kuartal-id/kuartal-login, Laravel Passport). client_id/client_secret come from
    // `php artisan passport:client` run in kuartal-login for an "ecoexplore-web" client;
    // `redirect` must exactly match one of that client's registered redirect URIs
    // (https://<domain>/auth/kuartal-id/callback). See
    // App\Http\Controllers\Auth\KuartalIdLoginController (authorization code + PKCE S256,
    // state, nonce, RS256 id_token verified against /oauth/jwks).
    'kuartal_id' => [
        'base_url' => env('KUARTAL_ID_BASE_URL', 'https://id.kuartal.id'),
        'client_id' => env('KUARTAL_ID_CLIENT_ID'),
        'client_secret' => env('KUARTAL_ID_CLIENT_SECRET'),
        'redirect' => env('KUARTAL_ID_REDIRECT_URI'),
        // Expected `iss` of Kuartal ID id_tokens; defaults to base_url.
        'issuer' => env('KUARTAL_ID_ISSUER', env('KUARTAL_ID_BASE_URL', 'https://id.kuartal.id')),
        // Space-separated OAuth scopes requested at /oauth/authorize.
        'scopes' => env('KUARTAL_ID_SCOPES', 'openid profile email'),
    ],

];
