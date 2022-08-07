<?php

use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use App\Services\Executes\InvitationsChannelExecute;

require_once 'vendor/autoload.php';


$a = InvitationsChannelExecute::instance('https://t.me/TheBadComedian')->execute();

$aaa = [
  '@artem_dvd',
  '@Viktor_Matorin',
  '@Promokos',
  '@denis_344',
  '@Sasssp',
  '@Frangart',
  '@dfgwt',
  '@Weber8',
  '@Nikcristi21',
  '@oonlIyselfmade',
  '@fillaleon',
  '@kirriltt',
  '@aleksa_assisten',
  '@romankolomna',
  '@Jose566',
  '@alexey_frolov1990',
  '@manager_wb_N1',
  '@AnS7021',
  '@wool7',
  '@fancher75',
  '@bonaccorsi12',
  '@maltas82',
  '@holm80',
  '@stuck35',
  '@schneeman93',
  '@fondren24',
  '@lindell51',
  '@coburn22',
  '@curran6',
  '@cervantes67',
  '@hawkes4',
  '@biros17',
  '@galyean85',
  '@beech64',
  '@scribner30',
  '@boggs7',
  '@Starbucksgh',
  '@top88890',
  '@dlog12',
  '@Orznv',
  '@vanofaseo',
  '@KelvinVereen',
  '@alex03866',
  '@namesvoboda',
  '@seoprodvigeni',
  '@dmiorlov',
  '@zaitsev_yu',
  '@Filipp_Milly',
  '@mikhailgggggh',
  '@Timof43',
  '@OnlyBestKontent',
  '@kingsman_only',
  '@popoiop13',
  '@pva21',
  '@wise60',
  '@Serokurov_Maxim',
  '@cbytl',
  '@Sergey_zaytsev94',
  '@Artur_Gerd',
  '@galioon',
  '@Pavel_Alenin',
  '@Alexxa161',
  '@itacimucujo',
  '@sarkis29',
  '@galibibi34',
  '@anver21',
  '@osaulenkop',
  '@manager_pavel77',
  '@igormsk5',
  '@sergrycak',
  '@AkInar',
  '@mindigo1',
  '@den4_ekimov',
  '@MidGold',
  '@Shurik_1990',
];

// try {
//   $a = Telegram::instance('https://t.me/asdasxasxasee')->inviteToChannel('https://t.me/vdgdvvdvrvr', $aaa);
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
