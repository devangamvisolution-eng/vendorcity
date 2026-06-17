<?php

return [
    'secret_key' => env('TABBY_SECRET_KEY'),
    'public_key' => env('TABBY_PUBLIC_KEY'),
    'base_url' => env('TABBY_BASE_URL', 'https://api.tabby.ai/api/v2/'),
    'merchant_code' => env('TABBY_MERCHANT_CODE', env('APP_NAME')),
];
