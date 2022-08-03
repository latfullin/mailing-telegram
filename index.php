<?php
require_once 'vendor/autoload.php';

use App\Services\Authorization\LoginTelegram;

$a = ['@Joranaminawilai911', '@MatthewFucks', '@Kris2504', '@AbGrEnoO', '@maria120179', '@Halid582888', '@Jenie2000', '@Jdjdjdjdjhh', '@elenaaimetova', '@kyryto12', '@elsieshasta', '@Elvina_69', '@arjunsonifaizan', '@Monstr_Q', '@armina_showroom', '@veremdem', '@Rybaken4ik', '@SagtianaFathir', '@Alena_arb', '@Vega_spb', '@Shodkom', '@ws2123', '@Lidia_Dodonova', '@velascod', '@Anastyyv', '@Sab188', '@Tengiz3838', '@RomanTopWb', '@cameliya777', '@idehehddi', '@fghn158', '@seven11d', '@tethertrc', '@Bema_024', '@KaTeRiNa_NNN', '@olgawb96', '@V_Baldo'];

$users = array_chunk($a, 5);

$number = ['79874018497', '79776782207'];
for ($i = 0; $i < count($number); $i++) {
  global $users;
  $zz = array_pop($users);
  LoginTelegram::instance($number[$i])->joinChannel('https://t.me/esxasfsax')->inviteToChannel('https://t.me/esxasfsax', $zz);
  // sleep(180);
}
// print_r($a);


// $result = $MadelineProto->getFullInfo('-1001403580104');
// $MadelineProto->channels->createChannel(megagroup: true, title: $InputChannel, about: 'My test challengses');
// $MadelineProto->channels->joinChannel(channel: "https://t.me/mjbyxbrb" ); 
