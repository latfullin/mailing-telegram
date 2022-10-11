<?php

namespace App\Services\Authorization;

use App\Helpers\ErrorHelper;
use App\Models\PhoneModel;
use App\Services\Bot\TelegramBot;
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
  private bool $start = false;
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
      if ($this->setting instanceof \danog\MadelineProto\Settings\Connection) {
        $this->telegram = new \danog\MadelineProto\API($this->pathSession($phone), $this->setting);
        $this->telegram->updateSettings($this->setting);
      } else {
        $this->telegram = new \danog\MadelineProto\API($this->pathSession($phone, $this->setting));
      }
      $this->params($async);
    } catch (\Exception $e) {
      $this->checkError($e, $phone);
      ErrorHelper::writeToFile($e);
      TelegramBot::exceptionError($e->getMessage());
    }
  }

  private function params($async)
  {
    try {
      $this->telegram->async($async);
      $this->telegram->start();
      $this->start = true;
    } catch (\Exception $e) {
      return;
    }
  }

  public function getMe()
  {
    try {
      $this->me = $this->telegram->getSelf();
      return $this;
    } catch (\Exception $e) {
      TelegramBot::exceptionError($e->getMessage());
    }
  }

  /**
   * @param phone session. Kept storage/session.
   */
  public static function instance(string|int $phone, bool $async = false)
  {
    // if (!is_dir(root("storage/session/{$phone}"))) {
    //   return false;
    // }
    try {
      return new self($phone, $async);
    } catch (\Exception $e) {
      ErrorHelper::writeToFile($e);
    }
  }

  protected function pathSession()
  {
    if (is_dir(root("storage/session/{$this->phone}"))) {
      return root("storage/session/{$this->phone}/{$this->phone}");
    } else {
      mkdir(root("storage/session/{$this->phone}"), 0755);
      return root("storage/session/{$this->phone}/{$this->phone}");
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

  public function getSetting()
  {
    return $this->setting;
  }

  public function getStart()
  {
    return $this->start;
  }
}
