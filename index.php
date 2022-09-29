<?php

session_start();
if (empty($_SESSION['auth'])) {
  $_SESSION['auth'] = false;
}
if (empty($_SESSION['is_admin'])) {
  $_SESSION['is_admin'] = false;
}

require_once 'app/kernel.php';

// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// // ]);

// new Providers(WakeUpAccountsController::class, "joinChannel", [
//   "channel" => "https://t.me/+vZ57IK_pcghiOWZi",
//   "limit" => [78, 12],
// ]);

// new Providers(ProxyController::class, "checkActiveProxy", [
//   "count" => 9,
// ]);

// new Providers(MailingMessagesController::class, "continueTask", [
//   "task" => 115,
//   "msg" => "zdarova brat",
//   "country" => "nl",
// ]);
// new Providers(MailingMessagesController::class, "continueTask", [
//   "task" => 111,
//   "msg" => "zdarova brat",
//   "country" => "nl",
// ]);
// 16257535
// 82258b80b4bfb2ed89de17879ea566e9
// Telegram::instance(79874018497);

// new Providers(CheckMessageController::class, "update", [
//   "phone" => 79874018497,
// ]);
