<?php

namespace App\Services\Authorization;

use App\Models\PhoneModel;
use App\Traits\Account\AccountMethodsTelegram;
use App\Traits\Channels\ChannelsMethodsTelegram;
use App\Traits\Message\MessageMethodsTelegram;
use danog\MadelineProto\Settings\Connection;
use danog\MadelineProto\Stream\Proxy\SocksProxy;
use Exception;

class Telegram
{
  use AccountMethodsTelegram;
  use ChannelsMethodsTelegram;
  use MessageMethodsTelegram;

  protected array $proxy = [
    [
      "address" => "217.29.63.93",
      "login" => "9BHbPq",
      "password" => "R0MXLT",
      "port" => "11605",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "9BHbPq",
      "password" => "R0MXLT",
      "port" => "11604",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "9BHbPq",
      "password" => "R0MXLT",
      "port" => "11603",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11602",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11602",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11601",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11600",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "HnUkmf",
      "password" => "qLkNnp",
      "port" => "11599",
    ],
    [
      "address" => "217.29.53.112",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "13143",
    ],
    [
      "address" => "217.29.53.112",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "13142",
    ],
    [
      "address" => "217.29.63.224",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "11984",
    ],
    [
      "address" => "217.29.53.66",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "10114",
    ],
    [
      "address" => "217.29.62.231",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "13488",
    ],
  ];

  protected int $phone;
  protected $telegram;
  protected ?array $me = null;
  protected static array $intsances = [];

  public function __construct($phone, $async)
  {
    try {
      $conntect = mt_rand(0, 11);
      $setting = ["logger" => ["logger" => 0]];
      $settings["connection_settings"]["all"]["proxy"] = "\SocksProxy";
      $settings["connection_settings"]["all"]["proxy_extra"] = [
        "address" => $this->proxy[$conntect]["address"],
        "port" => $this->proxy[$conntect]["port"],
        "username" => $this->proxy[$conntect]["login"],
        "password" => $this->proxy[$conntect]["password"],
      ];
      $this->phone = $phone;
      $this->telegram = new \danog\MadelineProto\API(
        $this->pathSession($phone, $setting)
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
    // $settings = new Connection();
    // $settings->addProxy(SocksProxy::class, [
    //   "address" => $this->proxy[$conntect]["address"],
    //   "port" => $this->proxy[$conntect]["port"],
    //   "username" => $this->proxy[$conntect]["login"],
    //   "password" => $this->proxy[$conntect]["password"],
    // ]);
    // $this->telegram->updateSettings($settings);
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
}
