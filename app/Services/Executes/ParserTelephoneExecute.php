<?php

/**
 * code 400; PHONE_NOT_OCCUPIED - not found users in telegram or user hidden number in profile.
 * code 400;
 */

namespace App\Services\Executes;

use App\Helpers\Storage;
use App\Models\ParserModel;
use App\Services\Authorization\Telegram;

class ParserTelephoneExecute extends ParserExecute
{
  protected array $users = [];
  protected array $notFoundPhone = [];

  public function __construct(ParserModel $connect)
  {
    parent::__construct($connect);
  }

  public function checkPhones(array $phonesNumbers): object
  {
    $this->startClient($this->sessionList[0]->phone);
    if ($phonesNumbers) {
      $result = [];
      foreach ($phonesNumbers as $phone) {
        try {
          $result[] = Telegram::instance($this->sessionList[0]->phone)->getInformationByNumber($phone);
        } catch (\Exception $e) {
          if ($e->getMessage() == 'PHONE_NOT_OCCUPIED') {
            $this->notFoundPhone[$phone] = $phone;
          }
          continue;
        }
      }
      $this->treatmentPhones($result);
      return $this;
    }

    return false;
  }

  public function save(): string
  {
    $path = $this->usersProcessing();
    $path = parent::save();
    Storage::disk('task')->put($this->task, ['Не найденные или скрытые номера']);
    foreach ($this->notFoundPhone as $notPhone) {
      Storage::disk('task')->put($this->task, [$notPhone]);
    }

    return $path;
  }

  // public function test()
  // {
  //   $disk = Storage::disk('task');
  //   foreach ($this->data as $key => $items) {
  //     if (is_array($items)) {
  //       $lang = timeLang($key);
  //       $disk->put("{$this->task}", "\n{$lang}\n");
  //       foreach ($items as $item) {
  //         $disk->put("{$this->task}", "$item");
  //       }
  //       continue;
  //     }
  //     $disk->put($this->task, "$items");
  //   }

  //   $this->modelTask->where(['task' => $this->task])->update(['status' => 2]);
  //   return $disk->getPath("{$this->task}");
  // }

  public function treatmentPhones($result)
  {
    for ($s = 0; $s < count($result); $s++) {
      $user['id'] = $result[$s]['users'][0]['id'];

      if ($result[$s]['users'][0]['status']['userStatusOnline'] ?? false) {
        $user['time'] = $this->now;
      } else {
        $user['time'] = $result[$s]['users'][0]['status']['was_online'] ?? false;
      }

      if ($result[$s]['users'][0]['username'] ?? false) {
        $user['username'] = '@' . $result[$s]['users'][0]['username'];
        [
          'id' => $this->participants[$result[$s]['users'][0]['id']]['id'],
          'time' => $this->participants[$result[$s]['users'][0]['id']]['time'],
          'username' => $this->participants[$result[$s]['users'][0]['id']]['username'],
        ] = $user;
        continue;
      }

      if ($this->needUsersId) {
        $user['username'] = $result[$s]['users'][0]['id'];
        [
          'id' => $this->participants[$result[$s]['users'][0]['id']]['id'],
          'time' => $this->participants[$result[$s]['users'][0]['id']]['time'],
          'username' => $this->participants[$result[$s]['users'][0]['id']]['username'],
        ] = $user;
      }
    }
  }
}
