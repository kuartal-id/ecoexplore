<?php

// Site-wide business settings. Anything marked [SUPPLY] must come from the owner before
// launch; until then the site shows neutral wording instead of invented details.
return [

    // Shown in the footer, emails and booking pages.
    'contact_email' => env('ECOEXPLORE_CONTACT_EMAIL'),       // [SUPPLY]
    'whatsapp' => env('ECOEXPLORE_WHATSAPP'),                 // [SUPPLY] e.g. +62 812...
    'legal_entity' => env('ECOEXPLORE_LEGAL_ENTITY'),         // [SUPPLY] registered company name

    // Where admins are notified of new bookings (log mailer until SMTP is configured).
    'ops_email' => env('ECOEXPLORE_OPS_EMAIL'),

    // Manual bank transfer details shown after checkout when bank_transfer is chosen.
    // Leave empty until the owner supplies the real account: the site then says the team
    // will send transfer details instead of displaying a made-up account.
    'bank_transfer' => [
        'bank_name' => env('ECOEXPLORE_BANK_NAME'),
        'account_name' => env('ECOEXPLORE_BANK_ACCOUNT_NAME'),
        'account_number' => env('ECOEXPLORE_BANK_ACCOUNT_NUMBER'),
    ],

    // No payment gateway is integrated yet. When the central Kuartal Financial Group
    // Midtrans integration exists, set this to 'midtrans' (see docs/PAYMENTS.md).
    'payment_gateway' => env('ECOEXPLORE_PAYMENT_GATEWAY', 'none'),
];
