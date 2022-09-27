<?php

namespace App\Services\Authorization;

use App\Helpers\ErrorHelper;
use App\Models\PhoneModel;
use App\Services\Proxy\GetProxy;
use App\Traits\Account\AccountMethodsTelegram;
use App\Traits\Channels\ChannelsMethodsTelegram;
use App\Traits\Message\MessageMethodsTelegram;

class Telegram
{
  use AccountMethodsTelegram;
  use ChannelsMethodsTelegram;
  use MessageMethodsTelegram;

  private array $proxy = [];
  private bool $usedProxy = true;
  protected int $phone;
  protected $telegram;
  private $setting = [];
  private ?array $me = null;
  private static array $intsances = [];

  public function __construct($phone, $async)
  {
    if ($this->usedProxy) {
      $this->setting = GetProxy::getProxy($phone)->getSetting();
    }
    try {
      if (!$this->setting && $this->usedProxy) {
        throw new \Exception('Error proxy');
      }

      $this->phone = $phone;
      $this->telegram = new \danog\MadelineProto\API($this->pathSession($phone), $this->setting ?? []);
      if ($this->setting instanceof \danog\MadelineProto\Settings\Connection) {
        $this->telegram->updateSettings($this->setting);
      }
      $this->params($async);
    } catch (\Exception $e) {
      ErrorHelper::writeToFile($e);
      $this->checkError($e, $phone);
    }
  }

  private function params($async)
  {
    $this->telegram->async($async);
    $this->telegram->start();
  }

  public function getMe()
  {
    $this->me = $this->telegram->getSelf();

    return $this;
  }

  /**
   * @param phone session. Kept storage/session.
   */
  public static function instance($phone, bool $async = false)
  {
    try {
      return new self($phone, $async);
    } catch (\Exception $e) {
    }
  }

  protected function pathSession()
  {
    if (is_dir("storage/session/{$this->phone}")) {
      return "storage/session/{$this->phone}/{$this->phone}";
    } else {
      mkdir("storage/session/{$this->phone}", 0755);
      return "storage/session/{$this->phone}/{$this->phone}";
    }
  }

  public function checkError(\Exception $e, int $phone)
  {
    ErrorHelper::writeToFile($e);
    if ($e->getMessage() == 'PEER_FLOOD') {
      $session = new PhoneModel();
      $session->where(['phone' => $phone])->update(['flood_wait' => true]);
      return;
    }
    if ($e->getMessage() == 'USER_DEACTIVATED_BAN') {
      $session = new PhoneModel();
      $session->where(['phone' => $phone])->update(['ban' => 1]);
      return;
    }
  }

  public function setUsedProxy(bool $bool): object
  {
    $this->usedProxy = $bool;

    return $this;
  }

  public function stop()
  {
    $this->telegram->stop();
  }

  public function getTelegram(): object|null
  {
    return $this->telegram;
  }
}
