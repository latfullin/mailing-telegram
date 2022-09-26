<?php

use App\Controllers\AutorizationController;
use App\Models\PhoneModel;
use App\Providers\Providers;

require_once 'app/kernel.php';

$a = new AutorizationController();
$a->createSession(6281346726519, new PhoneModel());
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
