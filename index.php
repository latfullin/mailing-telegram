<?php
require_once 'src/kernel.php';

use App\Services\Authorization\Telegram;
use App\Services\Executes\EditProfileExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = ParcerExecute::instance(false, true)->channel('https://t.me/+rL3fdT9q_EA2ZTgy')->executes()->save();


// $a = Telegram::instance('79776782207')->getInformationByNumber('79272045387');
// $dd = new mysqli('localhost', 'root', '', 'telegram_bot');
// var_dump($dd);
// $phone = file('phone');
// $b = [
//   '79776782207',
//   '9804752273',
//   '79630791322',
//   '79835444578',
//   '79913366955',
//   '79274271401',
//   '79585596738',
//   '9309922217',
//   '79775399190',
// ];
$a = new AccountWarmingUp(['79776782207']);
$a->warmingUpAccount('79874018497');
