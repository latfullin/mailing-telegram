<?php

/**
 * code 400; PHONE_NOT_OCCUPIED - not found users in telegram or user hidden number in profile.
 * code 400; 
 */

namespace App\Services\Executes;

use App\Services\Authorization\Telegram;
use Exception;

class ParserTelephoneExecute
{
  protected $instance = null;
  protected array $users = [];
  protected array $notFoundPhone = [];

  public function __construct(string $phone = '')
  {
    $this->instance = Telegram::instance('79274271401');
  }

  public function checkPhones(array $phonesNumbers): bool
  {
    if ($phonesNumbers) {

      foreach ($phonesNumbers as $phone) {
        try {
          $result = $this->instance->getInformationByNumber($phone)['users'][0];
          $time = $result['status']['_'] == 'userStatusOnline' ? time() : ($result['status']['was_online'] ?? false);
          $this->users[$result['id']] = ['id' => $result['id'], 'first_name' => $result['first_name'], 'username' => ($result['username'] ?? false), 'time' => $time];
          print_r($this->users);
        } catch (Exception $e) {
          if ($e->getMessage() == 'PHONE_NOT_OCCUPIED') {
            $this->notFoundPhone[$phone] = $phone;
          }
        }
      }

      return true;
    }

    return false;
  }
}
