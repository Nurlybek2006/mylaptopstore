<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$ref = new ReflectionClass($kernel);
echo "Kernel class: " . $ref->getName() . "\n";
echo "File: " . $ref->getFileName() . "\n\n";
if (method_exists($kernel, 'getRouteMiddleware')) {
    echo json_encode($kernel->getRouteMiddleware(), JSON_PRETTY_PRINT);
} else {
    echo json_encode($kernel->routeMiddleware, JSON_PRETTY_PRINT);
}
