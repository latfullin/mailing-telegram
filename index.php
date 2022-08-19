<?php
require_once 'src/kernel.php';

use App\Controllers\InvitationsController;
use App\Controllers\ParserController;
use App\Controllers\WakeUpAccountsController;
use App\Services\Authorization\Telegram;
use App\Services\Executes\EditProfileExecute;
use App\Services\Executes\ParserTelephoneExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = new AccountWarmingUp($b);
// $a->warmingUpAccount();

// $a = new ParserTelephoneExecute(false, false);


$result = file('users');
$result = array_map(fn ($i) => trim($i), $result);
$users = array_filter($result, fn ($i) => $i !== '');

$a = new InvitationsController();
$a->invitationsChannel('https://t.me/dasd312', $users);

// $parser = new ParserTelephoneExecute(true, true);
// $parser->checkPhones(['79874018497', '+79270370406'])->usersProcessing()->saveToFile();


// $a = new ParserController();
// $a->parseGroup('https://t.me/AutorynokKzn');


// $a = new WakeUpAccountsController();
// $a->joinChannel('https://t.me/+vZ57IK_pcghiOWZi');
// $a->warmingUpAccount();
// $a->wakeUpAccounts('https://t.me/+vZ57IK_pcghiOWZi');
// Telegram::instance('79309768458')->autorizationSession();
