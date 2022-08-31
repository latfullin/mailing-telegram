<?php
require_once "app/kernel.php";

use App\Controllers\AutorizationController;
use App\Controllers\Controller;
use App\Controllers\InvitationsController;
use App\Controllers\ParserController;
use App\Models\InvitationsModel;
use App\Models\PhoneModel;
use App\Models\TasksModel;
use App\Providers\Providers;
use App\Services\Authorization\Telegram;
use App\Services\Bot\TelegramBot;
use danog\MadelineProto\MyTelegramOrgWrapper;

// $a = new ParserController();
// $a->parseGroup('https://t.me/design_ads_best');

// $a = Telegram::instance('79375756789');
// $c = [];
// foreach ($channel as $item)
// $c[] = $a->getMessages('https://t.me/laravel_web');

// $invitationsModel = new InvitationsModel();
// $invitationsModel->where(['task' => '12', 'user' => '@myriophyllite1826'])->update(['performed' => true]);
// $telegram = new TelegramBot();
// $telegram->setChatId('365047507')->sendFile('storage/task/17.txt');

// die();
// new Providers(ParserController::class, "parseGroup", ["channel" => $a[0]]);
// }

new Providers(AutorizationController::class, "createSession", [
  "phone" => 79962817558,
]);
// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// ]);
// $wrapper = new MyTelegramOrgWrapper([]);
// $wrapper->async(false);

// $wrapper->login(79361783365);

// sleep(10);
// $wrapper->completeLogin($wrapper->readline("Enter the code"));

// if ($wrapper->loggedIn()) {
//   if ($wrapper->hasApp()) {
//     $app = $wrapper->getApp();
//   } else {
//     $app_title = $wrapper->readLine('Enter the app\'s name, can be anything: ');
//     $short_name = $wrapper->readLine(
//       'Enter the app\'s short name, can be anything: '
//     );
//     $url = $wrapper->readLine(
//       'Enter the app/website\'s URL, or t.me/yourusername: '
//     );
//     $description = $wrapper->readLine("Describe your app: ");

//     $app = $wrapper->createApp([
//       "app_title" => $app_title,
//       "app_shortname" => $short_name,
//       "app_url" => $url,
//       "app_platform" => "web",
//       "app_desc" => $description,
//     ]);
//   }

//   \danog\MadelineProto\Logger::log($app);
// }
