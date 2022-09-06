<?php

namespace App\Services\Authorization;

use App\Models\PhoneModel;
use App\Traits\Account\AccountMethodsTelegram;
use App\Traits\Channels\ChannelsMethodsTelegram;
use App\Traits\Message\MessageMethodsTelegram;
use danog\MadelineProto\Settings\Connection;
use Exception;

class Telegram
{
  use AccountMethodsTelegram;
  use ChannelsMethodsTelegram;
  use MessageMethodsTelegram;

  protected array $proxy = [];
  private bool $usedProxy = true;
  protected int $phone;
  protected $telegram;
  private $setting = null;
  protected ?array $me = null;
  protected static array $intsances = [];

  public function __construct($phone, $async)
  {
    $this->setting = Proxy::getProxy($phone)->getSetting();

    if (!$this->setting && $this->usedProxy) {
      throw "Error proxy";
    }
    try {
      $this->phone = $phone;
      $this->telegram = new \danog\MadelineProto\API(
        $this->pathSession($phone),
        $this->setting
      );
      $this->params($async);
    } catch (\Exception $e) {
      $this->checkError($e, $phone);
    }
  }

  private function params($async)
  {
    $this->telegram->async($async);
    $this->telegram->start();
  }

  public function autorizationSession(string $msg = "success")
  {
    $this->sendMessage("@hitThat", $msg);
  }

  public function getMe()
  {
    $this->me = $this->telegram->getSelf();

    return $this;
  }

  /**
   * @param phone session. Kept storage/session.
   */
  public static function instance($phone, $async = false)
  {
    $key = "{$phone}-" . ($async ? 1 : 0);
    if (!isset(self::$intsances[$key])) {
      echo "new intance";
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

  public function checkError(Exception $e, int $phone): void
  {
    $session = new PhoneModel();
    if ($e->getMessage() == "PEER_FLOOD") {
      $session->where(["phone" => $phone])->update(["flood_wait" => true]);
      return;
    }
    if ($e->getMessage() == "USER_DEACTIVATED_BAN") {
      $session->where(["phone" => $phone])->update(["ban" => 1]);
      return;
    }
  }

  public function setUsedProxy(bool $bool): self
  {
    $this->usedProxy = $bool;

    return $this;
  }
}
