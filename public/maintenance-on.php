<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

\Illuminate\Support\Facades\Artisan::call('down');

echo "<h1>Maintenance Mode is ON!</h1>";
echo "<p>Your website is now offline and showing the maintenance page.</p>";
echo "<a href='/'>Go to Home Page</a>";
