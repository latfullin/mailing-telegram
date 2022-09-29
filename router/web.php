<?php

use App\Controllers\ViewController;
use App\Routers\Router;

Router::get('/proxy', [ViewController::class, 'viewProxy']);
Router::get('/send-message', [ViewController::class, 'sendMessage']);
Router::get('/task', [ViewController::class, 'task'])->middleware('auth');
Router::get('/created-task', [ViewController::class, 'createdTask']);
Router::get('/parsing', [ViewController::class, 'createdTask']);
Router::get('/sessions', [ViewController::class, 'sessions'])->middleware('auth');
Router::get('/login', [ViewController::class, 'login']);
Router::get('/', [ViewController::class, 'home']);
