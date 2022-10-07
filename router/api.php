<?php

use App\Controllers\AutorizationController;
use App\Controllers\InvitationsController;
use App\Controllers\LoginController;
use App\Controllers\MailingMessagesController;
use App\Controllers\ParserController;
use App\Controllers\PrepareAccountController;
use App\Controllers\ProxyController;
use App\Controllers\SendController;
use App\Routers\Router;

Router::post('/api/created-session', [AutorizationController::class, 'createSession'])->middleware(['isAdmin', 'auth']);
Router::post('/api/send-message', [SendController::class, 'sendMessage'])->middleware(['auth']);
Router::post('/api/parser-channel', [ParserController::class, 'parseGroup'])->middleware(['auth']);
Router::post('/api/buy-proxy', [ProxyController::class, 'buyProxy'])->middleware(['isAdmin', 'auth']);
Router::post('/api/proxy-check-active', [ProxyController::class, 'checkActiveProxy'])->middleware(['token', 'auth']);
Router::post('/api/created-task-mailing', [MailingMessagesController::class, 'createTaskMailingMessages'])->middleware([
  'isAdmin',
  'auth',
]);
Router::post('/api/created-task-invitations', [InvitationsController::class, 'createTaskInvitations'])->middleware([
  'IsAdmin',
  'auth',
]);
Router::post('/api/continue-task', [MailingMessagesController::class, 'continueTask'])->middleware(['isAdmin', 'auth']);
Router::post('/api/login', [LoginController::class, 'login'])->middleware(['token']);
Router::post('/api/registration', [LoginController::class, 'registration'])->middleware(['token']);
Router::post('/api/logout', [LoginController::class, 'logout'])->middleware('auth');
Router::post('/api/redirect-create-session', [AutorizationController::class, 'redirectCreateSession']);
// Router::get('/api/edit-profile', [PrepareAccountController::class, 'prepareAccount']);
