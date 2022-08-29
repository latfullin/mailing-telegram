<?php

namespace App\Controllers;

use App\Models\InvitationsModel;
use App\Services\Bot\SendMessageBot;
use App\Services\Executes\InvitationsChannelExecute;

class InvitationsController
{
  public function invitationsChannel($argumets, InvitationsChannelExecute $invitations, SendMessageBot $bot): void
  {
    /**
     * not function save. Need realization
     */

    $filePath = $invitations->setChannel($argumets->channel)->setUsersList($argumets->users)->setNeedCheckUser($argumets->checkUsers)->execute()->save();
    $bot->setChatId('@hitThat')->sendFile($filePath);
  }
}
