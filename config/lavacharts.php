<?php

/*
|--------------------------------------------------------------------------
| Default Lavacharts Configuration
|--------------------------------------------------------------------------
|
| Here is where you can customize some of the default values that lavacharts
| uses when creating charts.
|
*/
return [

    /*
    |--------------------------------------------------------------------------
    | Auto Run
    |--------------------------------------------------------------------------
    |
    | Toggle for whether or not the lava.js module will run on page load. This
    | can be set to false for you to manually call lava.run() when ready.
    |
    */
    'auto_run' => true,


    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | When aspects of the chart have writing generated by Google, it will be in
    | this language.
    |
    */
    'locale' => 'en',


    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | When date, time, and datetime columns are used, they will be based upon
    | this timezone.
    |
    */
    'timezone' => 'Asia/Tehran',


    /*
    |--------------------------------------------------------------------------
    | DateTime Format
    |--------------------------------------------------------------------------
    |
    | This is the format string that Carbon will use to try and parse datetime
    | strings. Only applies to date, time, and datetime columns.
    |
    */
    'datetime_format' => 'Y-m-d H:i:s',


    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Set your API key here to quiet the warnings that get thrown for using the
    | public API.
    |
    | https://developers.google.com/maps/documentation/javascript/get-api-key
    |
    */
    'maps_api_key' => '',
];
