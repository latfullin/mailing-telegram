<?php

namespace App\Controllers;

use App\Services\Executes\InvitationsChannelExecute;

class InvitationsController
{
  public function invitationsChannel(string $channel, array $users, bool $checkUsers = false): void
  {
    /**
     * not function save. Need realization
     */
    $filePath = InvitationsChannelExecute::instance($channel, $users, $checkUsers)->execute()->leaveChannel()->save();
  }
}
