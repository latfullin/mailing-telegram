<?php
require_once 'src/kernel.php';

use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use App\Services\Executes\InvitationsChannelExecute;
use App\Services\Executes\MailingMessagesExecute;
use App\Services\Executes\ParcerExecute;

// $a = InvitationsChannelExecute::instance('https://t.me/sa12dasdas')->execute();
// MailingMessagesExecute::instance()->executes('helllo');
$a = ParcerExecute::instance()->channel('https://t.me/stepnru')->collectParticipants()->breakInfoTime();
// $a->start();


// try {
// $a = Telegram::instance('79776782207')->getParticipants('https://t.me/stepnru');

// print_r($a);
