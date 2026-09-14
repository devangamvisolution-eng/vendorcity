<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
print_r(DB::select('SHOW COLUMNS FROM ci_orders'));
print_r(DB::select('SHOW COLUMNS FROM ci_order_item'));
