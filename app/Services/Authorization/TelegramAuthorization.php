<?php

namespace App\Services\Authorization;

use danog\MadelineProto\API;
use danog\MadelineProto\Stream\Proxy\HttpProxy;

class TelegramAuthorization extends Telegram
{
  private $setting;
  private $session;
  public function __construct(string $phone, array $proxy = [])
  {
    $this->phone = $phone;
    $this->setting($proxy);
    $this->session = new \danog\MadelineProto\API($this->pathSession($phone), $this->setting);
    $this->session->async(false);
    $this->session->start();
  }
  public function setting(array $settings)
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
    ];
  }

  public function autorizationSession(string $msg = 'success')
  {
    $this->session->messages->sendMessage(peer: '@hitThat', message: $msg);
  }
}
