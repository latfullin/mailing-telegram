<?php

namespace App\Services\Proxy;

use App\Models\ProxyModel;
use danog\MadelineProto\Stream\Proxy\HttpProxy;

class GetProxy
{
  private ?ProxyModel $proxy = null;
  private mixed $setting;

  public function __construct($phone)
  {
    $this->proxy = new ProxyModel();
    $setting = $this->proxy
      ->where(["who_used" => $phone, "active" => true])
      ->first();

    empty($setting)
      ? $this->newSettingProxy($phone)
      : $this->setSettings($setting);
  }

  private function setSettings(array $settings): void
  {
    $this->setting = [
      "connection_settings" => [
        "all" => [
          "retry" => false,
          "ipv6" => true,
          "proxy" => HttpProxy::class,
          "proxy_extra" => [
            "address" => $settings["address"],
            "port" => $settings["port"],
            "username" => $settings["login"],
            "password" => $settings["password"],
          ],
        ],
      ],
    ];
  }

  public function newSettingProxy($phone): void
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

  public function getSetting(): array|bool
  {
    return $this->setting;
  }
}
