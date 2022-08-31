<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Bot\TelegramBot;
use App\Services\Executes\InvitationsChannelExecute;

class InvitationsController
{
  public function invitationsChannel(
    ArgumentsHelpers $argumets,
    InvitationsChannelExecute $invitations,
    TelegramBot $bot
  ): void {
    /**
     * not function save. Need realization
     */

    $filePath = $invitations
      ->setChannel($argumets->channel)
      ->setUsersList($argumets->users)
      ->setNeedCheckUser($argumets->checkUsers)
      ->execute()
      ->save();

    $bot->setChatId($argumets->userId)->sendFile($filePath);
  }
}
