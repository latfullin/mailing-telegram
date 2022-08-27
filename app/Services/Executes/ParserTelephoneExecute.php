<?php

/**
 * code 400; PHONE_NOT_OCCUPIED - not found users in telegram or user hidden number in profile.
 * code 400; 
 */

namespace App\Services\Executes;

use App\Helpers\Storage;
use App\Services\Authorization\Telegram;

class ParserTelephoneExecute extends ParserExecute
{
  protected array $users = [];
  protected array $notFoundPhone = [];

  public function __construct(bool $needUserId, bool $sortOnTime, string $phone = '')
  {
    parent::__construct($needUserId, $sortOnTime);
    $this->instance = Telegram::instance('79585596738');
  }

  public function checkPhones(array $phonesNumbers): object
  {
    if ($phonesNumbers) {
      $result = [];
      foreach ($phonesNumbers as $phone) {
        try {
          $result[] = $this->instance->getInformationByNumber($phone)['users'];
        } catch (\Exception $e) {
          if ($e->getMessage() == 'PHONE_NOT_OCCUPIED') {
            $this->notFoundPhone[$phone] = $phone;
          }
          continue;
        }
        $this->treatmentResult($result);
      }
      return $this;
    }

    return false;
  }

  public function save(): string
  {
    $path = parent::save();
    Storage::disk('task')->put($this->task, ['Не найденные или скрытые номера', $this->notFoundPhone]);
    return $path;
  }
}
