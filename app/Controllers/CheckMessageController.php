<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\MessagesModel;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;
use Carbon\Carbon;

class CheckMessageController
{
  public function update(
    ArgumentsHelpers $arguments,
    PhoneModel $phones,
    MessagesModel $messages
  ) {
    $phone = $phones->where(["phone" => $arguments->phone])->first();
    if (!$phone) {
      throw new \Exception("not found session");
    }
    try {
      $telegram = Telegram::instance($phone["phone"]);
    } catch (\Exception $e) {
      if (!$telegram) {
        $telegram = Telegram::instance($phone["phone"]);
      }
    }

    $dialogs = $telegram->getFullDialogs();
    foreach ($dialogs as $dialog) {
      if ($dialog["peer"]["_"] === "peerUser") {
        $message = $messages
          ->where([
            "from" => [$dialog["peer"]["user_id"], $phone["me_id"]],
            "to" => [$dialog["peer"]["user_id"], $phone["me_id"]],
          ])
          ->orderByDesc("msg_id")
          ->first();
        $topMsg = $dialog["top_message"];
        $msgId = $message["msg_id"] ?? false;

        if ($msgId !== $topMsg) {
          $history = $telegram->getHistory(
            $dialog["peer"]["user_id"],
            $topMsg + 1
          );
          $telegram->readHistoryMsg($dialog["peer"]["user_id"], $topMsg + 1);
          foreach ($history["messages"] as $msg) {
            if (!$msg) {
              continue;
            }
            if ($msg["from_id"] ?? false) {
              $messages->insert([
                "from" => $msg["from_id"]["user_id"],
                "to" => $msg["peer_id"]["user_id"],
                "msg_id" => $msg["id"],
                "msg" => $msg["message"],
                "time_send" => Carbon::parse($msg["date"]),
              ]);
            } else {
              $messages->insert([
                "from" => $msg["peer_id"]["user_id"],
                "to" => $phone["me_id"],
                "msg_id" => $msg["id"],
                "msg" => $msg["message"],
                "time_send" => Carbon::parse($msg["date"]),
              ]);
            }
          }
        }
      }
    }
  }
}
