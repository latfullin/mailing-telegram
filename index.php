<?php
require_once 'src/kernel.php';

use App\Services\Executes\ParcerExecute;

// $a = InvitationsChannelExecute::instance('https://t.me/sa12dasdas')->execute();
// MailingMessagesExecute::instance()->executes('helllo');
$a = ParcerExecute::instance(true, true)->channel('https://t.me/laravel_web')->executes();

// ->collectParticipants()->breakTime();
// $a->start();