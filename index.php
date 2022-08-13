<?php
require_once 'src/kernel.php';

use App\Services\Authorization\Telegram;
use App\Services\Executes\EditProfileExecute;

// $a = ParcerExecute::instance(false, true)->channel('https://t.me/+rL3fdT9q_EA2ZTgy')->executes()->save();


Telegram::instance('79874018497')->sendMessage('@hitThat', 'Hello');

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
// $a = new EditProfileExecute();
// $a->setInformationProfile($b);
