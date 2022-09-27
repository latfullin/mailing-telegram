<?php

use App\Controllers\ViewController;
use App\Routers\Router;

Router::get('/proxy', [ViewController::class, 'viewProxy']);
Router::get('/send-message', [ViewController::class, 'sendMessage']);
Router::get('/task', [ViewController::class, 'task']);
Router::get('/created-task', [ViewController::class, 'createdTask']);
Router::get('/parsing', [ViewController::class, 'createdTask']);
Router::get('/sessions', [ViewController::class, 'sessions']);
