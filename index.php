<?php
// use App\Controllers\AutorizationController;
// use App\Controllers\Controller;
// use App\Controllers\CreateMailingMessagesController;
// use App\Controllers\InvitationsController;
// use App\Controllers\MailingMessagesController;
// use App\Controllers\ParserController;
// use App\Controllers\PrepareAccountController;
// use App\Controllers\WakeUpAccountsController;
// use App\Models\InvitationsModel;
// use App\Models\MailingModel;
// use App\Models\PhoneModel;
// use App\Models\TasksModel;
// use App\Providers\Providers;
// use App\Services\Authorization\Telegram;
// use App\Services\Bot\TelegramBot;
// use danog\MadelineProto\Logger;
// use danog\MadelineProto\messages;
// use danog\MadelineProto\MyTelegramOrgWrapper;
// use danog\MadelineProto\Tools;

use App\Helpers\Storage;
use App\Services\Authorization\Proxy;
use App\Services\Authorization\Telegram;
use danog\MadelineProto\Stream\Proxy\HttpProxy;
use danog\MadelineProto\Stream\Proxy\SocksProxy;

require_once "app/kernel.php";

// new Providers(ParserController::class, "parseGroup", ["channel" => $a[0]]);
// }

// 79346648049 -- need auto
// new Providers(AutorizationController::class, "createSession", [
//   "phone" => 84923592238,
// ]);

// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// // ]);

// new Providers(WakeUpAccountsController::class, "wakeUpAccounts", [
//   "channel" => "https://t.me/+vZ57IK_pcghiOWZi",
// ]);

$a = [79585596738, 79309971649];

foreach ($a as $item) {
  Telegram::instance($item)->sendMessage("@hitThat", "hsadsaidsahu dhhds");
}
