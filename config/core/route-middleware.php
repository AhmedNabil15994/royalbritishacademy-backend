<?php

return [
    'dashboard' => [
        'auth' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'dashboard.auth',
            'check.permission',
            'last.login',
        ],
        'guest' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
        ]
    ],

    'frontend' => [
        'auth' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'auth:web',
            'block-website',
        ],
        'guest' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'block-website',
        ]
    ],

    'api' => [
        'auth' => [
            'api',
             'auth:sanctum',
        ],
        'guest' => [
            'api',
        ]
    ],
];
