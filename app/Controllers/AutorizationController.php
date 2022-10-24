<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Helpers\ErrorHelper;
use App\Models\PhoneModel;
use App\Models\ProxyModel;
use App\Services\Authorization\Telegram;
use danog\MadelineProto\Stream\Proxy\HttpProxy;

class AutorizationController
{
  private $createSession = false;
  private ?array $settings = null;

  public function redirectCreateSession(ArgumentsHelpers $argument)
  {
    return response('true')->redirect(
      "/api/create-session-init?how={$argument->how}&phone={$argument->phone}&address={$argument->address}&port={$argument->port}&login={$argument->login}&password={$argument->password}&numeric_id={$argument->numeric_id}",
    );
  }

  public function createSession(ArgumentsHelpers $argument, PhoneModel $phones, ProxyModel $proxies)
  {
    try {
      if (isset($argument->how)) {
        $phone = $phones->last();
        $this->setting = [
          'connection_settings' => [
            'all' => [
              'retry' => false,
              'ipv6' => true,
              'proxy' => HttpProxy::class,
              'proxy_extra' => [
                'address' => $argument->address,
                'port' => $argument->port,
                'username' => $argument->login,
                'password' => $argument->password,
              ],
            ],
          ],
          'numeric_id' => $argument->numeric_id,
        ];
        $telegram = new \danog\MadelineProto\API($this->pathSession($argument->phone), $this->setting);
        $telegram->async(false);
        $telegram->start();
        if (!$telegram) {
          return response('Error. The client does not start. Please check free proxies for authorization.');
        }
        $userInformation = $telegram->getSelf();
        if (isset($userInformation)) {
          $user = $phones->where(['phone' => $userInformation['phone']])->first();
        }
        if ($userInformation && empty($user)) {
          $phones->insert([
            'phone' => $userInformation['phone'],
            'me_id' => $userInformation['id'],
            'status' => 1,
            'login' => session()->get('login'),
          ]);
          $proxies->where(['numeric_id' => $argument->numeric_id])->update(['who_used' => $userInformation['phone']]);
          $telegram->messages->sendMessage(peer: $argument->how, message: $argument->phone);
          return response('Success');
        }
        if ($user ?? false) {
          return response('This number is already registered');
        }
        return response('Not found exception');
      }
      return response('User not found to whom to send a message for verification');
    } catch (\Exception $e) {
      ErrorHelper::writeToFile($e);
    }
  }

  protected function pathSession(string $phone)
  {
    if (is_dir(root("storage/session/{$phone}"))) {
      return root("storage/session/{$phone}/{$phone}");
    } else {
      mkdir(root("storage/session/{$phone}"), 0755);
      return root("storage/session/{$phone}/{$phone}");
    }
  }
}
