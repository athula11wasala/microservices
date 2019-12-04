<?php

return [
    'asset' => [
        'base_uri' => env('SERVICE_BASE_URL'),
        'secret' => env('SERVICE_SECRET'),
       ],
    'sms' => [
        'base_uri' => env('SERVICE_SMS_URL'),
        'companyId' => env('SERVICE_SMS_COM_ID'),
        'pword' => env('SERVICE_SMS_PWD'),
    ],
];
