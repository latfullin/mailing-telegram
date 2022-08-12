<?php
require_once 'src/kernel.php';

use App\Services\Authorization\Telegram;
use App\Services\Executes\InvitationsChannelExecute;
use App\Services\Executes\ParcerExecute;

// $a = [
//   '9804752273',
//   '79630791322',
//   '79835444578',
//   '79913366955',
//   '79274271401',
//   '79585596738'
// ];

// Telegram::instance($a[$i])->autorizationSession();

// Telegram::instance('79835444578')->updatePhotoProfile('images.jpg');
// for ($i = 0; $i < count($a); $i++) {
// Telegram::instance($a[$i])->updatePhotoProfile('images.jpg');

// sleep(10);
// }
$a = InvitationsChannelExecute::instance('https://t.me/adsax123')->execute();
// MailingMessagesExecute::instance()->executes('helllo');
// $a = ParcerExecute::instance(true, true)->channel('https://t.me/ru2chnews')->executes();
// $a = ParcerExecute::instance(false, false)->channel('https://t.me/laravel_web')->extractData()->save();
// $a = ParcerExecute::instance(false, true)->channel('https://t.me/laravel_web')->save();

// ->collectParticipants()->breakTime();
// $a->start();