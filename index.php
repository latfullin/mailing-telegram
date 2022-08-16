<?php
require_once 'src/kernel.php';

use App\Services\Authorization\Telegram;
use App\Services\Executes\EditProfileExecute;
use App\Services\Executes\ParserTelephoneExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = new AccountWarmingUp($b);
// $a->warmingUpAccount();

// $a = new ParserTelephoneExecute(false, false);

$parser = new ParserTelephoneExecute(true, true);
$parser->checkPhones(['79874018497', '+79270370406'])->usersProcessing()->saveToFile();
