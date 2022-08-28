<?php
require_once 'app/kernel.php';

use App\Controllers\AutorizationController;
use App\Controllers\Controller;
use App\Controllers\InvitationsController;
use App\Controllers\ParserController;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;


// $a = new ParserController();
// $a->parseGroup('https://t.me/design_ads_best'); 

// $a = Telegram::instance('79375756789');
// $c = [];
// foreach ($channel as $item) 
// $c[] = $a->getMessages('https://t.me/laravel_web');



new Controller(AutorizationController::class, 'createSession', ['phone' => $item]);
new Controller(InvitationsController::class, 'invitationsChannel', ['channel' => 'https://t.me/asdasdasdzxew', 'users' => ['@maskit_koshi'], 'checkUsers' => false]);
