<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Executes\MailingMessagesExecute;

class MailingMessagesController
{
  public function mailingMessages(
    ArgumentsHelpers $arguments,
    MailingMessagesExecute $execute
  ) {
    $execute
      ->setMsg($arguments->msg)
      ->setPhoto($arguments->photo ?? false)
      ->setUsers($arguments->users)
      ->execute($arguments->limit);
  }
}
