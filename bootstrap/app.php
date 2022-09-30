<?php

use App\Kernel\Kernel;

include_once __DIR__ . '/function/function.php';

$app = new Kernel();
$app->callServices();
$app->app();

return $app;
