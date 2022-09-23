<?php

use App\Controllers\AutorizationController;
use App\Controllers\CheckMessageController;
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
use danog\MadelineProto\Settings\Connection;
use danog\MadelineProto\Stream\Proxy\HttpProxy;
use danog\MadelineProto\Tools;

require_once "app/kernel.php";

// new Providers(AutorizationController::class, "createSession", [
//   "phone" => 6285248517444,
// ]);

// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// // ]);

// new Providers(WakeUpAccountsController::class, "joinChannel", [
//   "channel" => "https://t.me/+vZ57IK_pcghiOWZi",
//   "limit" => [78, 12],
// ]);

// foreach ($a as $item) {
//   Telegram::instance($item)->sendMessage("@hitThat", "hsadsaidsahu dhhds");
// }

new Providers(ProxyController::class, "checkActiveProxy", [
  "count" => 9,
]);

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

foreach ([79874018497] as $item) {
  $a = Telegram::instance(79874018497);
}
sleep(10);
Telegram::instance(79874018497)->sendMessage(
  "@hitThat",
  "hedas das das dasdas dasdasd asdpo kaopsdk asopngpd klasldoasopi dmoias ndiokasaslldsadso"
);
