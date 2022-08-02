<?php

namespace App\Services\Authorization;

use App\Traits\Message\MessageMethodsTelegram;

class LoginTelegram
{
  use MessageMethodsTelegram;

  protected $phone;
  protected $telegram;

  public function __construct($phone, $async = false)
  {
    $this->phone = $phone;
    $this->telegram = new \danog\MadelineProto\API($this->pathSession($phone));
    $this->params($async);
  }

  private function params($async)
  {
    $this->telegram->async($async);
    $this->telegram->start();
  }

  public static function instance($phone)
  {
    return new self($phone);
  }

  public function echo($type)
  {
    echo $this->{$type};
  }

  private function pathSession()
  {
    if (is_dir("src/storage/session/{$this->phone})")) {
      return "src/storage/session/{$this->phone}/{$this->phone}";
    } else {
      mkdir("src/storage/session/{$this->phone}", 0644);
      return "src/storage/session/{$this->phone}/{$this->phone}";
    }
  }
}
