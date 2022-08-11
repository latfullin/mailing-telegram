<?php
require_once 'src/kernel.php';

use App\Services\Executes\ParcerExecute;

// $a = InvitationsChannelExecute::instance('https://t.me/sa12dasdas')->execute();
// MailingMessagesExecute::instance()->executes('helllo');
// $a = ParcerExecute::instance(true, true)->channel('https://t.me/laravel_web')->executes();
$a = ParcerExecute::instance(true, true)->channel('https://t.me/laravel_web')->extractData();

// ->collectParticipants()->breakTime();
// $a->start();

$handle = file('src/storage/temporary/385-temporary.txt');
// $handle = fopen('src/storage/temporary/385-temporary.txt', 'r');

print_r($handle);
while (true) {

  $a = fgets($handle);
  if ($a) {
    explode(';', $a);
  }
  if (!$a) {
    print_r($a);
    echo time();

    break;
  }
}
