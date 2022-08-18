<?php
require_once 'src/kernel.php';

use App\Controllers\ParserController;
use App\Controllers\WakeUpAccountsController;
use App\Services\Authorization\Telegram;
use App\Services\Executes\EditProfileExecute;
use App\Services\Executes\ParserTelephoneExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = new AccountWarmingUp($b);
// $a->warmingUpAccount();

// $a = new ParserTelephoneExecute(false, false);


// $parser = new ParserTelephoneExecute(true, true);
// $parser->checkPhones(['79874018497', '+79270370406'])->usersProcessing()->saveToFile();


// $a = new ParserController();
// $a->parseGroup('https://t.me/laravel_web');


$a = new WakeUpAccountsController();
$a->joinChannel('https://t.me/+vZ57IK_pcghiOWZi');
// $a->warmingUpAccount();
// $a->wakeUpAccounts();
// Telegram::instance('79299204367')->autorizationSession();
