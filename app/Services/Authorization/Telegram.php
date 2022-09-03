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
      "ivp6" => "2a0b:1586:30bb:40e6:a369:9d23:bb0f:f6fc",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "9BHbPq",
      "password" => "R0MXLT",
      "port" => "11604",
      "ivp6" => "2a0b:1581:4612:cf40:a0a8:973e:2a45:24ca",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "9BHbPq",
      "password" => "R0MXLT",
      "port" => "11603",
      "ivp6" => "2a0b:1585:7d00:d810:91f3:a9f9:9aa0:a05f",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11602",
      "ivp6" => "2a0b:1582:67c7:c4f6:cac9:d0ed:a8bd:b3cf",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11601",
      "ivp6" => "2a0b:1582:f9a6:8b1e:6e1d:57b1:7e35:58ee",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "U5oeFY",
      "password" => "EvdqKV",
      "port" => "11600",
      "ivp6" => "2a0b:1587:e4be:f7b1:5427:7035:586b:6b20",
    ],
    [
      "address" => "217.29.63.93",
      "login" => "HnUkmf",
      "password" => "qLkNnp",
      "port" => "11599",
      "ivp6" => "2a0b:1581:1fa7:d685:ce6b:2bb6:1120:2010",
    ],
    [
      "address" => "217.29.53.112",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "13143",
      "ivp6" => "2a0b:1584:c636:09ab:9039:7b57:26eb:f563",
    ],
    [
      "address" => "217.29.53.112",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "13142",
      "ivp6" => "2a0b:1581:c38b:4ced:551c:2d87:3f4d:24d8",
    ],
    [
      "address" => "217.29.63.224",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "11984",
      "ivp6" => "2a0b:1583:76db:2060:4221:7b4e:cc0c:d819",
    ],
    [
      "address" => "217.29.53.66",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "10114",
      "ivp6" => "2a0b:1585:a657:19db:bb02:36d9:1107:51dc",
    ],
    [
      "address" => "217.29.62.231",
      "login" => "QqnGvk",
      "password" => "j7HwhV",
      "port" => "13488",
      "ivp6" => "2a0b:1583:eab5:44f4:0fea:99f8:2ecd:53bc",
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
      $settings["connection_settings"]["app_info"]["app_id"] = 14163580;
      $settings["connection_settings"]["app_info"]["app_hash"] =
        "9818dc57ed5f3209842a591605978db5";
      $settings["connection_settings"]["all"]["proxy"] = "\SocksProxy";
      $settings["connection_settings"]["all"]["proxy_extra"] = [
        "address" => $this->proxy[$conntect]["address"],
        "port" => $this->proxy[$conntect]["port"],
        "username" => $this->proxy[$conntect]["login"],
        "password" => $this->proxy[$conntect]["password"],
        "ipv6" => $this->proxy[$conntect]["ivp6"],
      ];

      $this->phone = $phone;
      $this->telegram = new \danog\MadelineProto\API(
        $this->pathSession($phone),
        $setting
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
}
