<?php
require_once 'app/kernel.php';

use App\Controllers\InvitationsController;
use App\Controllers\ParserController;
use App\Controllers\WakeUpAccountsController;
use App\Models\Model;
use App\Services\Authorization\Telegram;
use App\Services\Bot\SendMessageBot;
use App\Services\Executes\EditProfileExecute;
use App\Services\Executes\ParserTelephoneExecute;
use App\Services\WarmingUp\AccountWarmingUp;

// $a = new AccountWarmingUp($b);
// $a->warmingUpAccount();

// $a = new ParserTelephoneExecute(false, false);


// $result = file('users');
// $result = array_map(fn ($i) => trim($i), $result);
// $users = array_filter($result, fn ($i) => $i !== '');

// $a = new InvitationsController();
// $a->invitationsChannel('https://t.me/dasd312', $users);

// $parser = new ParserTelephoneExecute(true, true);
// $parser->checkPhones(['79874018497', '+79270370406'])->usersProcessing()->saveToFile();



$a = new ParserController();
$a->parseGroup('https://t.me/design_ads_best');

// curl_init();
// $a = new WakeUpAccountsController();
// $a->joinChannel('https://t.me/+vZ57IK_pcghiOWZi');
// $a->warmingUpAccount();
// $a->wakeUpAccounts('https://t.me/+vZ57IK_pcghiOWZi');

// $a = Telegram::instance('79274271401')
// ->sendMessage('@hitThat', 'Hi');

// sleep(5);
// $a->closeConnection();

// $a = fopen(STDIN, 'r');
// print_r($a);
// $a = new PDO('mysql:dbname=telegram-bot;host=mysql', 'kilkenny', 'password');
// $z = "SELECT * FROM sessions";
// $zz = $a->query($z, PDO::FETCH_ASSOC);
// $row = $zz->fetchAll();
// $ss = $a->fetch(PDO::FETCH_ASSOC);
// SendMessageBot::create('365047507')->sendMsg('pdasdort');
// print_r($row);

// Model::connect('sessions')->insert(['phone' => '12345678', 'ban' => '0', 'count_action' => '0']);
// Model::connect('sessions')->insert(['phone' => '47475636262', 'ban' => '0', 'count_action' => '0']);
// Model::connect('sessions')->where(['phone', '=', '89874018497'])->update(['ban' => '1']);
$a = Telegram::instance('79375756789');
$c = [];
// foreach ($channel as $item) 
$c[] = $a->getMessages('https://t.me/laravel_web');
