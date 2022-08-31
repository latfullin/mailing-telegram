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

// function getAddicted($class)
// {
//   $type = ["string", "int", "bool", "array"];
//   $reflection = new ReflectionMethod($class, "__construct");
//   foreach ($reflection->getParameters() as $param) {
//     if ($param->getType()?->getName() ?? false) {
//       $className = $param->getType()->getName();
//       if (!in_array($className, $type)) {
//         print_r($className);
//         return new $className();
//       }
//     }
//   }
// }
// $a = ["https://t.me/United_global_friends"];
$a = ["@dubai_jobstreet"];
// $b = [];
$reflection = new ReflectionClass("App\Services\Executes\ParserExecute");
// $a = $reflection->getConstructor();
// echo $a;
// print_r(
//   $a
//     ->getParameters()[0]
//     ->getType()
//     ->getName()
// );
// die();
// foreach ($reflection->getParameters() as $item) {
//   $b[] = getAddicted($item->getType()?->getName());
// }
// print_r($b);
// $reflection->invokeArgs(new $controller(), $class);

// die();
new Providers(ParserController::class, "parseGroup", ["channel" => $a[0]]);
// }
// new Controller(AutorizationController::class, 'createSession', ['phone' => $item]);
// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// ]);
