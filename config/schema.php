<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Organization geo (JSON-LD GeneralContractor)
    |--------------------------------------------------------------------------
    | Replace placeholders with real coordinates for 14 ต.บางกร่าง อ.เมืองนนทบุรี
    */
    'geo' => [
        'latitude' => '13.000000',
        'longitude' => '100.000000',
    ],

    'opening_hours_specification' => [
        'dayOfWeek' => [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        ],
        'opens' => '08:00',
        'closes' => '18:00',
    ],

    'logo' => [
        'path' => 'images/tp-logo.png',
        'width' => 112,
        'height' => 112,
    ],

    'r2_base' => env('AWS_URL', 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev'),

];
