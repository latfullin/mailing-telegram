<?php

use App\Controllers\AutorizationController;
use App\Controllers\Controller;
use App\Controllers\CreateMailingMessagesController;
use App\Controllers\InvitationsController;
use App\Controllers\MailingMessagesController;
use App\Controllers\ParserController;
use App\Controllers\PrepareAccountController;
use App\Controllers\ProxyController;
use App\Controllers\WakeUpAccountsController;
use App\Models\InvitationsModel;
use App\Models\MailingModel;
use App\Models\PhoneModel;
use App\Models\ProxyModel;
use App\Models\TasksModel;
use App\Providers\Providers;
use App\Services\Authorization\Telegram;
use App\Services\Bot\TelegramBot;
use App\Services\Proxy\Ipv6Proxy;
use Carbon\Carbon;
use danog\MadelineProto\Logger;
use danog\MadelineProto\messages;
use danog\MadelineProto\MyTelegramOrgWrapper;
use danog\MadelineProto\Tools;

require_once "app/kernel.php";

// new Providers(AutorizationController::class, "createSession", [
//   "phone" => 31231232412412,
//   "proxy" => [
//     "address" => "217.29.63.40",
//     "port" => 11247,
//     "login" => "SsPqUX",
//     "password" => "pBfCut",
//   ],
// ]);
// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// // ]);

new Providers(WakeUpAccountsController::class, "wakeUpAccounts", [
  "channel" => "https://t.me/+vZ57IK_pcghiOWZi",
  "limit" => [11, 20],
]);

// foreach ($a as $item) {
//   Telegram::instance($item)->sendMessage("@hitThat", "hsadsaidsahu dhhds");
// }

// new Providers(ProxyController::class, "checkProxy", [
//   "count" => 1,
//   "period" => 3,
//   "country" => "nl",
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
