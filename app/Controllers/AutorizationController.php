<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Models\ProxyModel;
use App\Services\Authorization\Telegram;

class AutorizationController
{
  private $createSession = false;

  public function redirectCreateSession(ArgumentsHelpers $argument)
  {
    return response('true')->redirect("/create-session-init?how={$argument->how}");
  }

  public function createSession(ArgumentsHelpers $argument, PhoneModel $phones, ProxyModel $proxies)
  {
    try {
      if (isset($argument->how)) {
        $phone = $phones->last();
        $telegram = Telegram::instance($phone['id'] + 1);
        if (!$telegram->getStart()) {
          return response('Error. The client does not start. Please check free proxies for authorization.');
        }
        $userInformation = $telegram->getMeInformations();
        if (isset($userInformation)) {
          $user = $phones->where(['phone' => $userInformation['phone']])->first();
        }
        if ($userInformation && empty($user)) {
          $phones->insert(['phone' => $userInformation['phone'], 'me_id' => $userInformation['id'], 'status' => 10]);
          $proxy = $telegram->getSetting();
          $proxies->where(['numeric_id' => $proxy['numeric_id']])->update(['who_used' => $userInformation['phone']]);
          return response('Success');
        }
        if ($user ?? false) {
          return response('This number is already registered');
        }
        return response('Not found exception');
      }
      return response('User not found to whom to send a message for verification');
    } catch (\Exception $e) {
      print_r($e);
    }
  }
}
