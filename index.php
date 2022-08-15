<?php
require_once 'src/kernel.php';

use App\Services\Authorization\Telegram;
use App\Services\Executes\EditProfileExecute;
use App\Services\Executes\ParserTelephoneExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = new AccountWarmingUp($b);
// $a->warmingUpAccount();

// $a = new ParserTelephoneExecute();
// 
// $a->checkPhones(['7937312242389', '79874018497']);

// $a = ['@AnthonyFedorov', '@hitThat'];
// for ($i = 0; $i < count($a); $i++) {

//   Telegram::instance('79874018497')->sendMessage($a[$i], 'hello');
// }
