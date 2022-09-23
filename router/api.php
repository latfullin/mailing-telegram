<?php

use App\Controllers\AutorizationController;
use App\Controllers\SendController;
use App\Routers\Router;

Router::post("/api/created-session", [
  AutorizationController::class,
  "createSession",
]);

Router::post("/api/send-message", [SendController::class, "sendMessage"]);
