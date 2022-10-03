<?php

use App\Controllers\AutorizationController;
use App\Controllers\ViewController;
use App\Routers\Router;

Router::get('/proxy', [ViewController::class, 'viewProxy'])->middleware('auth');
Router::get('/send-message', [ViewController::class, 'sendMessage'])->middleware('auth');
Router::get('/task', [ViewController::class, 'task'])->middleware('auth');
Router::get('/created-task', [ViewController::class, 'createdTask']);
Router::get('/parsing', [ViewController::class, 'createdTask'])->middleware('auth');
Router::get('/sessions', [ViewController::class, 'sessions'])->middleware(['auth', 'isAdmin']);
Router::get('/login', [ViewController::class, 'login']);
Router::get('/registration', [ViewController::class, 'registration']);
Router::get('/', [ViewController::class, 'home'])->middleware(['auth']);
Router::get('/create-session', [ViewController::class, 'createSession']);
// Need realise for autorization
Router::get('/create-session-init', [AutorizationController::class, 'createSession']);
// Router::get('/404', [ViewController::class, 'notFound']);
