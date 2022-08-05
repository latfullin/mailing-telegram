<?php

use App\Services\Executes\InvitationsChannelExecute;

require_once 'vendor/autoload.php';


// $a = Telegram::instance('79776782207', false)->getChannel('https://t.me/laravel_web');
// $a = Telegram::instance('79776782207', false)->getParticipants('https://t.me/laravel_web');
InvitationsChannelExecute::instance('https://t.me/innokadriu')->joinChannel();
