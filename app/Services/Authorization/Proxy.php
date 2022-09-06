<?php

namespace App\Services\Authorization;

use App\Models\ProxyModel;
use danog\MadelineProto\Stream\Proxy\SocksProxy;

class Proxy
{
  private ?ProxyModel $proxy = null;
  private mixed $setting;
  public function __construct($phone)
  {
    $this->proxy = new ProxyModel();
    $setting = $this->proxy
      ->where(["who_used" => $phone, "active" => true])
      ->first();

    empty($setting) ? $this->test($phone) : $this->setSettings($setting);
  }

  private function setSettings(array $settings)
  {
    $this->setting = new \danog\MadelineProto\Settings\Connection();
    $this->setting->addProxy(SocksProxy::class, [
      "address" => $settings["address"],
      "port" => $settings["port"],
      "username" => $settings["login"],
      "password" => $settings["password"],
    ]);
    $this->setting->setIpv6(true);
    $this->setting->setRetry(false);
    $this->setting->setTestMode(true);
  }

  public function test($phone)
  {
    $data = $this->proxy
      ->where(["who_used" => false, "active" => true])
      ->first();
    if (!empty($data)) {
      $this->proxy
        ->where(["id" => $data["id"]])
        ->update(["who_used" => $phone]);
      $this->setSettings($data);
    } else {
      $this->setting = false;
    }
  }

  public static function getProxy(string $phone): self
  {
    return new self($phone);
  }

  public function getSetting()
  {
    return $this->setting;
  }
}
