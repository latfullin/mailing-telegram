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
  protected static array $intsances = [];

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
   * @param phone session. Kept storage/session.
   */
  public static function instance($phone, $async = false)
  {
    $key = "{$phone}-" . ($async ? 1 : 0);
    if (!isset(self::$intsances[$key])) {
      self::$intsances[$key] = new self($phone, $async);
    }
    return self::$intsances[$key];
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
