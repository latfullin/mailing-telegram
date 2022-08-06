<?php

use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use App\Services\Executes\InvitationsChannelExecute;

require_once 'vendor/autoload.php';


$a = InvitationsChannelExecute::instance('https://t.me/afdsfdssdfsdfdsf')->execute()->leaveChannel();








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
