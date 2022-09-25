<?php

use App\Controllers\AutorizationController;
use App\Controllers\InvitationsController;
use App\Controllers\MailingMessagesController;
use App\Controllers\ParserController;
use App\Controllers\ProxyController;
use App\Controllers\SendController;
use App\Routers\Router;

Router::post('/api/created-session', [AutorizationController::class, 'createSession']);
Router::post('/api/send-message', [SendController::class, 'sendMessage']);
Router::post('/api/parser-channel', [ParserController::class, 'parseGroup']);
Router::post('/api/buy-proxy', [ProxyController::class, 'buyProxy']);
Router::post('/api/proxy-check-active', [ProxyController::class, 'checkActiveProxy']);
Router::post('/api/created-task-mailing', [MailingMessagesController::class, 'createTaskMailingMessages']);
Router::post('/api/created-task-invitations', [InvitationsController::class, 'createTaskInvitations']);
