<?php
require_once 'src/kernel.php';

use App\Controllers\InvitationsController;
use App\Controllers\ParserController;
use App\Controllers\WakeUpAccountsController;
use App\Services\Authorization\Telegram;
use App\Services\Bot\SendMessageBot;
use App\Services\Executes\EditProfileExecute;
use App\Services\Executes\ParserTelephoneExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = new AccountWarmingUp($b);
// $a->warmingUpAccount();

// $a = new ParserTelephoneExecute(false, false);


// $result = file('users');
// $result = array_map(fn ($i) => trim($i), $result);
// $users = array_filter($result, fn ($i) => $i !== '');

// $a = new InvitationsController();
// $a->invitationsChannel('https://t.me/dasd312', $users);

// $parser = new ParserTelephoneExecute(true, true);
// $parser->checkPhones(['79874018497', '+79270370406'])->usersProcessing()->saveToFile();


// $a = new ParserController();
// $a->parseGroup('https://t.me/devworden');

// curl_init();
// $a = new WakeUpAccountsController();
// $a->joinChannel('https://t.me/+vZ57IK_pcghiOWZi');
// $a->warmingUpAccount();
// $a->wakeUpAccounts('https://t.me/+vZ57IK_pcghiOWZi');

// $a = Telegram::instance('79274271401')
// ->sendMessage('@hitThat', 'Hi');

// sleep(5);
// $a->closeConnection();

// $a = fopen(STDIN, 'r');
// print_r($a);

SendMessageBot::create('365047507')->sendMsg('pdasdort');
