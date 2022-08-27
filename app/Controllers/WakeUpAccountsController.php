<?php

namespace App\Controllers;

use App\Services\Authorization\Telegram;
use App\Services\WarmingUp\AccountWarmingUp;

class WakeUpAccountsController
{
  public function wakeUpAccounts($peer = '@hitThat')
  {
    $phones = $this->getPhones();
    $value = count($phones);
    foreach ($phones as $key => $phone) {
      $telegram = Telegram::instance($phone);
      $me = $telegram->getSelf();
      echo $phone;
      $i = $key + 1;
      $telegram->sendMessage($peer, "Я {$me['first_name']},  номер:'{$phone}'.Сообщений из {$i} из {$value}.");

      sleep(10);
    }
  }

  public function warmingUpAccount()
  {
    $phones = $this->getPhones();
    if ($phones) {
      $warmingUp = new AccountWarmingUp($phones);
      $warmingUp->warmingUpAccount();
    }
  }

  public function joinChannel(string $channel)
  {
    $phones = $this->getPhones();
    $channelId = Telegram::instance('79299204367')->getInfo($channel)['channel_id'];
    foreach ($phones as $phone) {
      try {
        print_r($phone);
        $telegram = Telegram::instance($phone);
        $dialogs = $telegram->getDialogs();
        $inGroup = [];
        $inGroup = array_filter($dialogs, fn ($i) => ($i['channel_id'] ?? false) == $channelId);
        if (!$inGroup) {
          $telegram->joinChannel($channel);
        }
        sleep(10);
      } catch (\Exception $e) {
        print_r($e);
      }
    }
  }

  private function lookChannel(string $phone, string $channel)
  {
    Telegram::instance($phone)->lookChannel($channel);
  }

  private function getPhones()
  {
    return array_map(fn ($i) => trim($i), file('phone'));
  }
}
