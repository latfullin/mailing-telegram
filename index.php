<?php
require_once 'vendor/autoload.php';

use App\Services\Authorization\LoginTelegram;



$number = ['79776782207', '79776782207'];
for ($i = 0; $i < count($number); $i++) {
  LoginTelegram::instance($number[$i])->sendMessage('@hitThat', 'tytyty');
}


// $result = $MadelineProto->getFullInfo('-1001403580104');
// $MadelineProto->channels->createChannel(megagroup: true, title: $InputChannel, about: 'My test challengses');
// $MadelineProto->channels->joinChannel(channel: "https://t.me/mjbyxbrb" ); 
