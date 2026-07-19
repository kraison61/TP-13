<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Frontend data cache TTL (minutes)
    |--------------------------------------------------------------------------
    | Caches DB queries for layout components and the home page to reduce TTFB.
    | Clear with: php artisan cache:clear
    */
    'data_ttl' => (int) env('FRONTEND_DATA_CACHE_TTL', 60),
];
