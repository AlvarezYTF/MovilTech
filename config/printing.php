<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Thermal Printer Hint
    |--------------------------------------------------------------------------
    |
    | Optional printer name or alias used by the frontend when selecting
    | the target printer via QZ Tray.
    |
    */
    'default_printer' => env('QZ_DEFAULT_PRINTER', ''),

    /*
    |--------------------------------------------------------------------------
    | QZ Tray Signing
    |--------------------------------------------------------------------------
    |
    | Enable signed requests so QZ Tray identifies this app with a certificate
    | and allows permanent access decisions in Site Manager.
    |
    */
    'qz' => [
        'enabled' => env('QZ_SIGNING_ENABLED', false),
        'signature_algorithm' => env('QZ_SIGNATURE_ALGORITHM', 'SHA512'),
        'certificate_path' => env('QZ_CERTIFICATE_PATH', ''),
        'private_key_path' => env('QZ_PRIVATE_KEY_PATH', ''),
        'private_key_passphrase' => env('QZ_PRIVATE_KEY_PASSPHRASE', ''),
    ],
];
