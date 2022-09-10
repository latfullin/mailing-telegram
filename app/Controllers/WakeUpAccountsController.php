<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;
use App\Services\WarmingUp\AccountWarmingUp;
use danog\MadelineProto\phone;

class WakeUpAccountsController
{
  public function wakeUpAccounts(ArgumentsHelpers $arg, PhoneModel $session)
  {
    $phones = $session->limit([$arg->limit[0], $arg->limit[1]])->getAll();
    $this->startClient($phones);
    $value = count($phones);
    foreach ($phones as $key => $phone) {
      try {
        $telegram = Telegram::instance($phone->phone, false);
        if (!$telegram->getTelegram()) {
          continue;
        }
        $me = $telegram->getSelf();
        $i = $key + 1;
        echo "dsa";
        $telegram->sendMessage(
          $arg->channel,
          "Я {$me["first_name"]},  номер:'{$phone->phone}'.Сообщений из {$i} из {$value}."
        );
        $session
          ->where(["phone" => $phone->phone])
          ->update(["ban" => 0, "flood_wait" => 0]);

        sleep(5);
      } catch (\Exception $e) {
        if ($e->getMessage() == "PEER_FLOOD") {
          sleep(5);
          $session
            ->where(["phone" => $phone->phone])
            ->update(["flood_wait" => 1]);
          continue;
        }
        if ($e->getMessage() == "USER_DEACTIVATED_BAN") {
          $session->where(["phone" => $phone->phone])->update(["ban" => 1]);
          continue;
        }
        $session->where(["phone" => $phone->phone])->update(["ban" => 2]);
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

  public function joinChannel(ArgumentsHelpers $arguments, PhoneModel $phones)
  {
    $phones = $phones->getAll();
    $channelId = Telegram::instance($phones[0]->phone)->getInfo(
      $arguments->channel
    )["channel_id"];
    foreach ($phones as $phone) {
      try {
        $telegram = Telegram::instance($phone->phone);
        $dialogs = $telegram->getDialogs();
        $inGroup = [];
        $inGroup = array_filter(
          $dialogs,
          fn($i) => ($i["channel_id"] ?? false) == $channelId
        );
        if (!$inGroup) {
          $telegram->joinChannel($arguments->channel);
        }
        sleep(10);
      } catch (\Exception $e) {
        print_r($e);
      }
    }
  }

  private function startClient($phones): void
  {
    foreach ($phones as $phone) {
      echo $phone->phone;
      Telegram::instance($phone->phone);
    }
  }
}
