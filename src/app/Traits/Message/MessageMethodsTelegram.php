<?php

namespace App\Traits\Message;

trait MessageMethodsTelegram
{
  public function sendMessage($peer, $msg)
  {
    $this->telegram->messages->sendMessage(peer: $peer, message: $msg);

    return $this;
  }
}
