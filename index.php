<?php

use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use App\Services\Executes\InvitationsChannelExecute;
use App\Services\Executes\MailingMessagesExecute;
use App\Services\Executes\ParcerExecute;

require_once 'vendor/autoload.php';


// $a = InvitationsChannelExecute::instance('https://t.me/sa12dasdas')->execute();
// MailingMessagesExecute::instance()->executes('helllo');
$a = ParcerExecute::instance('https://t.me/sa12dasdas')->start()->breakInfoTime();
// $a->start();
// print_r($a);


// try {
// $a = Telegram::instance('79776782207')->getInfo('5187729151');
// $a = Telegram::instance('79874018497')->getInfo('@Artur_Gerd');
// var_dump($a);
// } catch (Exception $e) {
//   print_r($e);
// }
  




// $b = Telegram::instance('79776782207')->getChannel('https://t.me/devworden');
// $c = $b['full_chat']['participants_count'];
// $ite = ceil(($c / 100));
// $offset = 0;
// for ($i = 0; $i < $ite; $i++) {
//   $a = Telegram::instance('79776782207')->getParticipants('https://t.me/devworden', $offset);
//   for ($t = 0; $t < count($a['users']); $t++) {
//     $name  = $a['users'][$t]['username'] ?? $a['users'][$t]['id'];
//     WorkingFileHelper::writeToFile('src/storage/test', "{$name}\n");
//   }
//   $offset += 100;
// }
// $a->execute();
