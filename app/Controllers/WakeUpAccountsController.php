<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Helpers\ErrorHelper;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;

class WakeUpAccountsController
{
  public function wakeUpAccounts(ArgumentsHelpers $arg, PhoneModel $session)
  {
    $phones = $session->limit([$arg->limit[0], $arg->limit[1]])->get();
    $value = count($phones);

    foreach ($phones as $key => $phone) {
      try {
        $telegram = Telegram::instance($phone->phone, false);
        if (!$telegram->getTelegram()) {
          continue;
        }
        $me = $telegram->getSelf();
        $i = $key + 1;
        $telegram->sendMessage(
          $arg->channel,
          "Я {$me['first_name']},  номер:'{$phone->phone}'.Сообщений из {$i} из {$value}.",
        );
        $session->where(['phone' => $phone->phone])->update(['ban' => 0, 'flood_wait' => 0]);

        sleep(5);
      } catch (\Exception $e) {
        if ($e->getMessage() == 'PEER_FLOOD') {
          sleep(5);
          $session->where(['phone' => $phone->phone])->update(['flood_wait' => 1]);
          continue;
        }
        if ($e->getMessage() == 'USER_DEACTIVATED_BAN') {
          $session->where(['phone' => $phone->phone])->update(['ban' => 1]);
          continue;
        }
        $session->where(['phone' => $phone->phone])->update(['ban' => 2]);
      }
    }
  }

  //not work
  // public function warmingUpAccount()
  // {
  //   $phones = $this->getPhones();
  //   if ($phones) {
  //     $warmingUp = new AccountWarmingUp($phones);
  //     $warmingUp->warmingUpAccount();
  //   }
  // }

  public function joinChannel(ArgumentsHelpers $arguments, PhoneModel $session)
  {
    $phones = $session
      ->join(['proxies' => ['sessions.phone', '=', 'proxies.who_used']])
      ->where(['proxies.active' => '1', 'sessions.ban' => [0, 2]])
      ->limit([$arguments->limit[0], $arguments->limit[1]])
      ->get();
    $this->startClient($phones);

    $start = Telegram::instance(79874018497);

    $channelId = $start->getInfo($arguments->channel)['channel_id'];
    foreach ($phones as $phone) {
      try {
        $telegram = Telegram::instance($phone->phone);
        $dialogs = $telegram->getDialogs();
        $inGroup = [];
        $inGroup = array_filter($dialogs, fn($i) => ($i['channel_id'] ?? false) == $channelId);
        if (!$inGroup) {
          // print_r($inGroup);
          $telegram->joinChannel($arguments->channel);
          $session->where(['phone' => $phone->phone])->update(['ban' => 0, 'flood_wait' => 0]);
        }
        sleep(10);
      } catch (\Exception $e) {
        // print_r($e);
        ErrorHelper::writeToFile($e);
      }
    }
  }

  private function startClient($phones): void
  {
    foreach ($phones as $phone) {
      Telegram::instance($phone->phone);
    }
    Telegram::instance(79874018497);
  }
}
