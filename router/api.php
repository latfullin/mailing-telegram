<?php

use App\Controllers\AutorizationController;
use App\Controllers\ProxyController;
use App\Controllers\SendController;
use App\Routers\Router;

Router::post('/api/created-session', [AutorizationController::class, 'createSession']);

Router::post('/api/send-message', [SendController::class, 'sendMessage']);
Router::post('/api/buy-proxy', [ProxyController::class, 'buyProxy']);
Router::post('/api/proxy-check-active', [ProxyController::class, 'checkActiveProxy']);
