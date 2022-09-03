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
use danog\MadelineProto\Logger;
use danog\MadelineProto\messages;
use danog\MadelineProto\MyTelegramOrgWrapper;
use danog\MadelineProto\Tools;

// new Providers(ParserController::class, "parseGroup", ["channel" => $a[0]]);
// }

// 79346648049 -- need auto

new Providers(AutorizationController::class, "createSession", [
  "phone" => 84923592238,
]);

// new Controller(InvitationsController::class, "invitationsChannel", [
//   "channel" => "https://t.me/asdasdasdzxew",
//   "users" => $a,
//   "checkUsers" => false,
// // ]);

// new Providers(WakeUpAccountsController::class, "wakeUpAccounts", [
//   "channel" => "https://t.me/+vZ57IK_pcghiOWZi",
// ]);

// $msg =
//   "Привет! Пишу Вам так как мы состоим в одном чате.\n\nМеня зовут Дмитрий Бедарев, я актер и сценарист фильмов, которые Вы наверняка смотрели по ТВ 🎬 «Тариф новогодний», «Домовой», «В ожидании чуда», «Беловодье» и пр.\n\nВсе эти фильмы связаны с чудесами и исполнением желаний и поэтому я создал настоящий вдохновляющий марафон ✨ «Ты можешь Все!»✨\n\nЯ хочу попросить Вас пройти этот марафон, Вы получите много ценности ну а для меня будет важен Ваш результат и отзыв 🤝\n\nХорошо? Вот ссылочка, там все описал - https://lifeskill.pro/?utm_source=telegram \n\nЭто 21-дневный марафон и за это время Вы достигнете любую свою поставленную цель!\n\n[ВАЖНО!] Старт марафона - 6 сентября\n\nБуду благодарен за обратную связь 🙏 и буду рад видеть Вас на марафоне \nВсе материалы по Марафону публикую в канале, подписывайтесь - https://t.me/+QNJdHU1TfU40ZGUy\n\nСпасибо!";
// $uniq = 3;

// foreach($phone as $item)
// Telegram::instance($item)->sendFoto(
//   "@hitThat",
//   "DimaTelegram.jpg",
//   $msg . $uniq
// );
// print_r($a);

// $a = new PhoneModel();
// $b = $a->limit(5)->sessionList();

// print_r($b);

// new Providers(PrepareAccountController::class, "prepareAccount", [
//   "photo" => "imag.jpg",
//   "firstName" => "Дмитрий",
//   "lastName" => "Бедарев",
//   "about" => "Актер и сценарист фильмов, которые Вы наверняка смотрели по ТВ.",
// ]);

// $a = file("users");
// $users = array_map(fn($i) => trim($i), $a);

// new Providers(MailingMessagesController::class, "createMailingMessages", [
//   "users" => $users,
//   "photo" => "DimaTelegram.jpg",
//   "limit" => 501,
//   "msg" =>
//     "Привет! Пишу Вам так как мы состоим в одном чате.\n\nМеня зовут Дмитрий Бедарев, я актер и сценарист фильмов, которые Вы наверняка смотрели по ТВ 🎬 «Тариф новогодний», «Домовой», «В ожидании чуда», «Беловодье» и пр.\n\nВсе эти фильмы связаны с чудесами и исполнением желаний и поэтому я создал настоящий вдохновляющий марафон ✨ «Ты можешь Все!»✨\n\nЯ хочу попросить Вас пройти этот марафон, Вы получите много ценности ну а для меня будет важен Ваш результат и отзыв 🤝\n\nХорошо? Вот ссылочка, там все описал - https://lifeskill.pro/?utm_source=telegram \n\nЭто 21-дневный марафон и за это время Вы достигнете любую свою поставленную цель!\n\n[ВАЖНО!] Старт марафона - 6 сентября\n\nБуду благодарен за обратную связь 🙏 и буду рад видеть Вас на марафоне \nВсе материалы по Марафону публикую в канале, подписывайтесь - https://t.me/+QNJdHU1TfU40ZGUy\n\nСпасибо!",
// ]);

// $tasksModel = new TasksModel();
// $task = $tasksModel->where(["task" => 150])->first();
// print_r($task);

// $proxy = [
//   [
//     "address" => "217.29.63.93",
//     "login" => "9BHbPq",
//     "password" => "R0MXLT",
//     "port" => "11605",
//     "ivp6" => "2a0b:1586:30bb:40e6:a369:9d23:bb0f:f6fc",
//   ],
//   [
//     "address" => "217.29.63.93",
//     "login" => "9BHbPq",
//     "password" => "R0MXLT",
//     "port" => "11604",
//     "ivp6" => "2a0b:1581:4612:cf40:a0a8:973e:2a45:24ca",
//   ],
//   [
//     "address" => "217.29.63.93",
//     "login" => "9BHbPq",
//     "password" => "R0MXLT",
//     "port" => "11603",
//     "ivp6" => "2a0b:1585:7d00:d810:91f3:a9f9:9aa0:a05f",
//   ],
//   [
//     "address" => "217.29.63.93",
//     "login" => "U5oeFY",
//     "password" => "EvdqKV",
//     "port" => "11602",
//     "ivp6" => "2a0b:1582:67c7:c4f6:cac9:d0ed:a8bd:b3cf",
//   ],
//   [
//     "address" => "217.29.63.93",
//     "login" => "U5oeFY",
//     "password" => "EvdqKV",
//     "port" => "11601",
//     "ivp6" => "2a0b:1582:f9a6:8b1e:6e1d:57b1:7e35:58ee",
//   ],
//   [
//     "address" => "217.29.63.93",
//     "login" => "U5oeFY",
//     "password" => "EvdqKV",
//     "port" => "11600",
//     "ivp6" => "2a0b:1587:e4be:f7b1:5427:7035:586b:6b20",
//   ],
//   [
//     "address" => "217.29.63.93",
//     "login" => "HnUkmf",
//     "password" => "qLkNnp",
//     "port" => "11599",
//     "ivp6" => "2a0b:1581:1fa7:d685:ce6b:2bb6:1120:2010",
//   ],
//   [
//     "address" => "217.29.53.112",
//     "login" => "QqnGvk",
//     "password" => "j7HwhV",
//     "port" => "13143",
//     "ivp6" => "2a0b:1584:c636:09ab:9039:7b57:26eb:f563",
//   ],
//   [
//     "address" => "217.29.53.112",
//     "login" => "QqnGvk",
//     "password" => "j7HwhV",
//     "port" => "13142",
//     "ivp6" => "2a0b:1581:c38b:4ced:551c:2d87:3f4d:24d8",
//   ],
//   [
//     "address" => "217.29.63.224",
//     "login" => "QqnGvk",
//     "password" => "j7HwhV",
//     "port" => "11984",
//     "ivp6" => "2a0b:1583:76db:2060:4221:7b4e:cc0c:d819",
//   ],
//   [
//     "address" => "217.29.53.66",
//     "login" => "QqnGvk",
//     "password" => "j7HwhV",
//     "port" => "10114",
//     "ivp6" => "2a0b:1585:a657:19db:bb02:36d9:1107:51dc",
//   ],
//   [
//     "address" => "217.29.62.231",
//     "login" => "QqnGvk",
//     "password" => "j7HwhV",
//     "port" => "13488",
//     "ivp6" => "2a0b:1583:eab5:44f4:0fea:99f8:2ecd:53bc",
//   ],
// ];
// foreach ($aa as $key => $item) {
//   try {
// $setting["app_info"]["app_id"] = "14163580";
// $setting["app_info"]["app_hash"] = "9818dc57ed5f3209842a591605978db5";
// $settings["connection_settings"]["all"]["proxy"] = "\SocksProxy";
// $settings["connection_settings"]["all"]["proxy_extra"] = [
//   "address" => $proxy[0]["address"],
//   "port" => $proxy[0]["port"],
//   "username" => $proxy[0]["login"],
//   "password" => $proxy[0]["password"],
//   "ipv6" => $proxy[0]["ivp6"],
// ];
// $a = new \danog\MadelineProto\API("84563207844", $setting);
//         "address" => $item["address"],
//         "port" => $item["port"],
//         "username" => $item["login"],
//         "password" => $item["password"],
//         "ipv6" => $item["ivp6"],
//       ]
//     );

//     $a->messages->sendMessage(
//       peer: "@hitThat",
//       message: "{$key} hell MY {$key} fried{$key}ndo"
//     );
//   } catch (\Exception $e) {
//     print_r($e->getMessage());
//   }
// }

// $a = new \danog\MadelineProto\API(
//   "storage/session/{$phone[$key]}/{$phone[$key]}"
// );

// new Providers(MailingMessagesController::class, "continueTask", [
//   "task" => 214,
//   "msg" =>
//     "Привет! Пишу Вам так как мы состоим в одном чате.\n\nМеня зовут Дмитрий Бедарев, я актер и сценарист фильмов, которые Вы наверняка смотрели по ТВ 🎬 «Тариф новогодний», «Домовой», «В ожидании чуда», «Беловодье» и пр.\n\nВсе эти фильмы связаны с чудесами и исполнением желаний и поэтому я создал настоящий вдохновляющий марафон ✨ «Ты можешь Все!»✨\n\nЯ хочу попросить Вас пройти этот марафон, Вы получите много ценности ну а для меня будет важен Ваш результат и отзыв 🤝\n\nХорошо? Вот ссылочка, там все описал - https://lifeskill.pro/?utm_source=telegram \n\nЭто 21-дневный марафон и за это время Вы достигнете любую свою поставленную цель!\n\n[ВАЖНО!] Старт марафона - 6 сентября\n\nБуду благодарен за обратную связь 🙏 и буду рад видеть Вас на марафоне \nВсе материалы по Марафону публикую в канале, подписывайтесь - https://t.me/+QNJdHU1TfU40ZGUy\n\nСпасибо!",
//   "photo" => "DimaTelegram.jpg",
// ]);
