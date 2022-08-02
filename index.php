<?php
require_once 'vendor/autoload.php';
$nameBot = '79776782207';
$MadelineProto = new \danog\MadelineProto\API("session/session.$nameBot");
$MadelineProto->async(false);
$MadelineProto->start();

$me = $MadelineProto->getSelf();

$InputUser = [];
// $MadelineProto->logger($me);

if (!$me['bot']) {
  // '@timmermans', '@kraftwerkflorian','@assest_Aleks','@winnerforever07','@BorziyOchen1','@kalinnikoff','@dimaoblakovd','@niktihe999','@denis_468','@Lusya_qp','@grizzly92929292','@ipakholkol','@ShaTarget','@Zjaaaaaaaaaa','@konstantin601990','@oleg_ben_059','@Mihail_Ishin','@bublgams','@ber_roman','@yakimov778','@SVG_DO','@Serik1009','@KhairutdinovMarsel','@Michael02021986','@RomanKomaroff','@Alex_Manz','@FuadRus',
  // This example uses PHP 8.0+ syntax with named arguments
  // $result = $MadelineProto->getFullInfo('-1001403580104');
  // var_dump($result);
  $a = ['@kraftwerkflorian', '@assest_Aleks', '@winnerforever07', '@BorziyOchen1', '@kalinnikoff', '@dimaoblakovd', '@niktihe999', '@denis_468', '@Lusya_qp', '@grizzly92929292', '@ipakholkol', '@ShaTarget', '@Zjaaaaaaaaaa', '@konstantin601990', '@oleg_ben_059', '@Mihail_Ishin', '@bublgams', '@ber_roman', '@yakimov778', '@SVG_DO', '@Serik1009', '@KhairutdinovMarsel', '@Michael02021986', '@RomanKomaroff', '@Alex_Manz', '@FuadRus', '@philtekil', '@NikDem16', '@sserigo', '@vamyamsc', '@vlselkov', '@Tewabey', '@Kopatich1986', '@evgen1375', '@alekseewand', '@PavelTo', '@ives12', '@nechaev9996', '@xzxzxz5', '@DVDvol', '@artur2137', '@Fenixname', '@Konstantin_Golubev_1', '@serg20s', '@michaylovandrey', '@ilyak2021', '@Al66777', '@Balkin_Oleg', '@dan4798', '@Ussr1900', '@Deviant021', '@Andrvot', '@egorshavel1', '@ValeriyLogvinov2', '@artem_dvd', '@Viktor_Matorin', '@Promokos', '@denis_344', '@Sasssp', '@Frangart', '@dfgwt', '@Weber8', '@Nikcristi21', '@oonlIyselfmade', '@fillaleon', '@kirriltt', '@aleksa_assisten', '@romankolomna', '@Jose566', '@alexey_frolov1990', '@manager_wb_N1', '@AnS7021', '@wool7', '@fancher75', '@bonaccorsi12', '@maltas82', '@holm80', '@stuck35', '@schneeman93', '@fondren24', '@lindell51', '@IvanChilov'];

  $InputUser = array_chunk($a, 9);
  $InputChannel = 'Hello World!!';
  // $MadelineProto->channels->createChannel(megagroup: true, title: $InputChannel, about: 'My test challengses');
  $MadelineProto->channels->joinChannel(channel: "https://t.me/mjbyxbrb" );

  // for ($i = 0; $i < count($InputUser); $i++) {
  //   $MadelineProto->channels->inviteToChannel("https://t.me/zzzzzaaae", $InputUser[$i],);
  //   echo $i;
  //   sleep(190);
  // }

  // $a = $MadelineProto->help->getUserInfo(link: 'https://t.me/+79270370406');
  // echo $a;
  // $a = $MadelineProto->getPwrChat(user: ['_' => 'peerUser', 'user_id' => '1147860595']);
  // $a = $MadelineProto->users->getUsers( id: ['1147860595']);
  // $MadelineProto->messages->sendMessage(peer: '@timmermans', message: 'hi');

  try {
    // $MadelineProto->messages->importChatInvite(hash: 'https://t.me/joinchat/Bgrajz6K-aJKu0IpGsLpBg');
  } catch (\danog\MadelineProto\RPCErrorException $e) {
    $MadelineProto->logger($e);
  }
}
$MadelineProto->echo('OK, done!');
