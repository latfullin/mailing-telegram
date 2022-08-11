<?php
require_once 'src/kernel.php';

use App\Services\Executes\ParcerExecute;

// $a = InvitationsChannelExecute::instance('https://t.me/sa12dasdas')->execute();
// MailingMessagesExecute::instance()->executes('helllo');
$a = ParcerExecute::instance(true, true)->channel('https://t.me/laravel_web')->executes();
// $a = ParcerExecute::instance(false, false)->channel('https://t.me/laravel_web')->extractData()->save();
// $a = ParcerExecute::instance(false, true)->channel('https://t.me/laravel_web')->save();

// ->collectParticipants()->breakTime();
// $a->start();