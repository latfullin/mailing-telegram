<?php

namespace App\Services\Authorization;

use App\Traits\Channels\ChannelsMethodsTelegram;
use App\Traits\Message\MessageMethodsTelegram;

class Telegram
{
  use MessageMethodsTelegram;
  use ChannelsMethodsTelegram;

  protected int $phone;
  protected $telegram;

  public function __construct($phone, $async)
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
  /**
   * @param phone - session. Kept storage/session.
   */
  public static function instance($phone, $async = false)
  {
    return new self($phone, $async);
  }

  public function echo($type)
  {
    echo $this->{$type};
  }

  private function pathSession()
  {
    if (is_dir("src/storage/session/{$this->phone}")) {
      return "src/storage/session/{$this->phone}/{$this->phone}";
    } else {
      mkdir("src/storage/session/{$this->phone}", 0755);
      return "src/storage/session/{$this->phone}/{$this->phone}";
    }
  }
}
