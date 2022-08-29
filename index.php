<?php
require_once "app/kernel.php";

use App\Controllers\AutorizationController;
use App\Controllers\Controller;
use App\Controllers\InvitationsController;
use App\Controllers\ParserController;
use App\Models\InvitationsModel;
use App\Models\PhoneModel;
use App\Models\TasksModel;
use App\Services\Authorization\Telegram;
use App\Services\Bot\TelegramBot;

// $a = new ParserController();
// $a->parseGroup('https://t.me/design_ads_best');

// $a = Telegram::instance('79375756789');
// $c = [];
// foreach ($channel as $item)
// $c[] = $a->getMessages('https://t.me/laravel_web');

$a = [
  // '@al_xr18',
  // '@minintahvladimir',
  // '@kobzarorlando',
  // '@yqusryabche',
  // '@chevkinixevsevolod',
  // '@vazoheb86',
  // '@yagettadomozhir15',
  // '@mihajlyutiw',
  // '@mustafinadaniella',
  // '@Waftage_adumbrations',
  // '@qunafez92',
  // '@zuxiqyb24',
  // '@ecybozub41',
  // '@gubinfilipp2009',
  // '@akulovpazo28',
  // '@nelliamukarelo',
  // '@vasilmitrofa2001',
  // '@pestovapalberta',
  // '@nikoljskpraskov2007',
  // '@afanakopilo',
  // '@rozhnova13florentina',
  // '@anosovaangelin',
  // '@loskutovagaliya25',
  // '@stepansobakin18',
  // '@afanasij1986tkachenko',
  // '@narkev19emma',
  // '@osipsipchenko1993'
];
// $invitationsModel = new InvitationsModel();
// $invitationsModel->where(['task' => '12', 'user' => '@myriophyllite1826'])->update(['performed' => true]);
// $telegram = new TelegramBot();
// $telegram->setChatId('365047507')->sendFile('storage/task/17.txt');

// $a = ["https://t.me/vopros_otvet_dubai"];
$a = ["@dubai_jobstreet"];

// foreach ($a as $item) {
//   new Controller(ParserController::class, "parseGroup", ["channel" => $item]);
// }
// new Controller(AutorizationController::class, 'createSession', ['phone' => $item]);
new Controller(InvitationsController::class, "invitationsChannel", [
  "channel" => "https://t.me/asdasdasdzxew",
  "users" => $a,
  "checkUsers" => false,
]);
