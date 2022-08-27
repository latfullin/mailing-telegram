<?php

namespace App\Services\Authorization;

use App\Traits\Account\AccountMethodsTelegram;
use App\Traits\Channels\ChannelsMethodsTelegram;
use App\Traits\Message\MessageMethodsTelegram;

class Telegram
{
  use AccountMethodsTelegram;
  use ChannelsMethodsTelegram;
  use MessageMethodsTelegram;

  protected int $phone;
  protected $telegram;
  protected static array $intsances = [];

  public function __construct($phone, $async)
  {
    $setting = ['logger' => ['logger' => 0]];
    $this->phone = $phone;
    $this->telegram = new \danog\MadelineProto\API($this->pathSession($phone, $setting));
    $this->params($async);
  }

  private function params($async)
  {
    $this->telegram->async($async);
    $this->telegram->start();
  }

  public function autorizationSession(string $msg = "success")
  {
    $this->sendMessage('@hitThat', $msg);
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
    if (is_dir("storage/session/{$this->phone}")) {
      return "storage/session/{$this->phone}/{$this->phone}";
    } else {
      mkdir("storage/session/{$this->phone}", 0755);
      return "storage/session/{$this->phone}/{$this->phone}";
    }
  }
}
