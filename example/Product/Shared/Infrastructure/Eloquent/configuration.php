<?php

use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../database/database.sqlite',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();