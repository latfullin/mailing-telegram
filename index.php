<?php
require_once "app/kernel.php";

use App\Controllers\AutorizationController;
use App\Controllers\Controller;
use App\Controllers\CreateMailingMessagesController;
use App\Controllers\InvitationsController;
use App\Controllers\MailingMessagesController;
use App\Controllers\ParserController;
use App\Controllers\PrepareAccountController;
use App\Controllers\WakeUpAccountsController;
use App\Models\InvitationsModel;
use App\Models\MailingModel;
use App\Models\PhoneModel;
use App\Models\TasksModel;
use App\Providers\Providers;
use App\Services\Authorization\Telegram;
use App\Services\Bot\TelegramBot;
use danog\MadelineProto\MyTelegramOrgWrapper;

// new Providers(ParserController::class, "parseGroup", ["channel" => $a[0]]);
// }

// 79346648049 -- need auto

// new Providers(AutorizationController::class, "createSession", [
//   "phone" => 6281375481475,
// ]);
// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// ]);

// new Providers(WakeUpAccountsController::class, "joinChannel", [
//   "channel" => "https://t.me/+vZ57IK_pcghiOWZi",
// ]);
// $a = Telegram::instance("79274271401")->deleteMePhotoProfile();
// print_r($a);

// $a = new PhoneModel();
// $b = $a->limit(5)->sessionList();

// print_r($b);

// new Providers(PrepareAccountController::class, "prepareAccount", [
//   "photo" => "DimaTelegram.jpg",
//   "firstName" => "Дмитрий",
//   "lastName" => "Бедарев",
//   "about" => "Актер и сценарист фильмов, которые Вы наверняка смотрели по ТВ.",
// ]);

$a = file("users");
$users = array_map(fn($i) => trim($i), $a);

new Providers(MailingMessagesController::class, "createMailingMessages", [
  "users" => $users,
  "photo" => "DimaTelegram.jpg",
  "limit" => 501,
  "msg" =>
    "Привет! Пишу Вам так как мы состоим в одном чате.\n\nМеня зовут Дмитрий Бедарев, я актер и сценарист фильмов, которые Вы наверняка смотрели по ТВ 🎬 «Тариф новогодний», «Домовой», «В ожидании чуда», «Беловодье» и пр.\n\nВсе эти фильмы связаны с чудесами и исполнением желаний и поэтому я создал настоящий вдохновляющий марафон ✨ «Ты можешь Все!»✨\n\nЯ хочу попросить Вас пройти этот марафон, Вы получите много ценности ну а для меня будет важен Ваш результат и отзыв 🤝\n\nХорошо? Вот ссылочка, там все описал - https://lifeskill.pro/?utm_source=telegram \n\nЭто 21-дневный марафон и за это время Вы достигнете любую свою поставленную цель!\n\n[ВАЖНО!] Старт марафона - 6 сентября\n\nБуду благодарен за обратную связь 🙏 и буду рад видеть Вас на марафоне \nВсе материалы по Марафону публикую в канале, подписывайтесь - https://t.me/+QNJdHU1TfU40ZGUy\n\nСпасибо!",
]);

// $tasksModel = new TasksModel();
// $task = $tasksModel->where(["task" => 150])->first();
// print_r($task);
// Telegram::instance(79962817558)->sendFoto(
//   "@hitThat",
//   "DimaTelegram.jpg",
//   $task["information"]
// );

// new Providers(MailingMessagesController::class, "continueTask", [
//   "task" => 111,
// ]);
