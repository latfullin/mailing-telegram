<?php

namespace App\Services\Proxy;

use App\Models\ProxyModel;
use danog\MadelineProto\Stream\Proxy\HttpProxy;
use danog\MadelineProto\Settings\Connection;

class GetProxy
{
  private ?ProxyModel $proxy = null;
  private mixed $setting;

  public function __construct($phone)
  {
    $this->proxy = new ProxyModel();
    $setting = $this->proxy->where(['who_used' => $phone, 'active' => true])->first();
    empty($setting) ? $this->newSettingProxy($phone) : $this->setSettings($setting);
  }

  public function newSettingProxy($phone): void
  {
    $data = $this->proxy->where(['who_used' => false, 'active' => true])->first();
    if (!empty($data)) {
      $this->proxy->where(['id' => $data['id']])->update(['who_used' => $phone]);

      $this->proxy->where(['who_used' => $phone])->first()
        ? $this->setUpdateSettings($data)
        : $this->setSettings($data);
    } else {
      $this->setting = false;
    }
  }

  public function setUpdateSettings(array $settings): void
  {
    $this->setting = new Connection();

    $this->setting->addProxy(HttpProxy::class, [
      'retry' => false,
      'ipv6' => true,
      'address' => $settings['address'],
      'port' => $settings['port'],
      'username' => $settings['login'],
      'password' => $settings['password'],
    ]);
  }

  private function setSettings(array $settings): void
  {
    $this->setting = [
      'connection_settings' => [
        'all' => [
          'retry' => false,
          'ipv6' => true,
          'proxy' => HttpProxy::class,
          'proxy_extra' => [
            'address' => $settings['address'],
            'port' => $settings['port'],
            'username' => $settings['login'],
            'password' => $settings['password'],
          ],
        ],
      ],
      'numeric_id' => $settings['numeric_id'],
    ];
  }

  public static function getProxy(string $phone): self
  {
    return new self($phone);
  }

  public function getSetting(): array|bool|Connection
  {
    return $this->setting;
  }
}
