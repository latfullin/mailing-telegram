<?php
require_once 'vendor/autoload.php';

$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->async(false);
$MadelineProto->start();

$me = $MadelineProto->getSelf();

// $MadelineProto->logger($me);

if (!$me['bot']) {

  // This example uses PHP 8.0+ syntax with named arguments
  // $result = $MadelineProto->getFullInfo('-1001403580104');
  // var_dump($result);
  $InputUser = ['https://t.me/+79270370406'];
  $InputChannel = 'fasd9uasyh8912yhudhs8uiabd8awh7123';
  // $MadelineProto->channels->createChannel(megagroup: true, title: $InputChannel, about: 'My test challengses');
  // for($i = 0; $i < count($InputUser); $i++) {
    // $MadelineProto->channels->inviteToChannel(channel: "https://t.me/dhxhxjidjjd", users: [$InputUser[$i]], );
  // }
  $a = $MadelineProto->help->getUserInfo(user_id: '1147860595');
  echo $a;
  // $MadelineProto->help->getUserInfo('')
  // $MadelineProto->messages->sendMessage(peer: '@timmermans', message: 'hi');
  // echo $result;
  // $MadelineProto->channels->joinChannel(channel: '@MadelineProto');

  try {
    // $MadelineProto->messages->importChatInvite(hash: 'https://t.me/joinchat/Bgrajz6K-aJKu0IpGsLpBg');
  } catch (\danog\MadelineProto\RPCErrorException $e) {
    $MadelineProto->logger($e);
  }
}
$MadelineProto->echo('OK, done!');