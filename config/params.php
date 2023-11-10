<?php

return [
    'adminEmail'  => env('DEFAULT_ADMIN_EMAIL'),
    'senderEmail' => env('SENDER_EMAIL'),
    'senderName'  => env('SENDER_NAME'),

    'statusActive'   => 10,
    'statusDisabled' => 0,

    'bsVersion' => '4.x',

    'alarmMethods' => [
        'sms'   => [],
        'email' => [],
    ],

    'shopName'           => 'books',

    /*
     * Значения по умолчанию для мета-тегов title, keywords и description
     */
    'defaultTitle'       => 'Почиталка',
    'defaultKeywords'    => 'Почиталка',
    'defaultDescription' => 'Лучшая почиталка для любителей почитать почитательно к прочитанному',

    'subscribeKey' => 'subscribeMessage',
];
