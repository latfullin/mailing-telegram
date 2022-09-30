<?php

use App\Controllers\ViewController;
use App\Routers\Router;

Router::get('/proxy', [ViewController::class, 'viewProxy'])->middleware('auth');
Router::get('/send-message', [ViewController::class, 'sendMessage'])->middleware('auth');
Router::get('/task', [ViewController::class, 'task'])->middleware('auth');
Router::get('/created-task', [ViewController::class, 'createdTask']);
Router::get('/parsing', [ViewController::class, 'createdTask'])->middleware('auth');
Router::get('/sessions', [ViewController::class, 'sessions'])->middleware('auth');
Router::get('/login', [ViewController::class, 'login']);
Router::get('/', [ViewController::class, 'home'])->middleware(['auth']);
