<?php

namespace App\Controllers;

use App\Services\Executes\InvitationsChannelExecute;

class InvitationsController
{
  public function invitationsChannel($argumets ,InvitationsChannelExecute $invitations): void
  {
    /**
     * not function save. Need realization
     */
    $filePath = $invitations->setChannel($argumets->channel)->setUsersList($argumets->users)->setNeedCheckUser($argumets->checkUsers)->execute()->leaveChannel()->save();
  }
}
