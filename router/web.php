<?php

use App\Controllers\ViewController;
use App\Routers\Router;

Router::get('/proxy', [ViewController::class, 'viewProxy']);
Router::get('/send-message', [ViewController::class, 'sendMessage']);
