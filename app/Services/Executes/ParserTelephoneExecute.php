<?php

/**
 * code 400; PHONE_NOT_OCCUPIED - not found users in telegram or user hidden number in profile.
 * code 400;
 */

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\Storage;
use App\Models\CheckItPhonesModel;
use App\Models\ParserModel;
use App\Services\Authorization\Telegram;

class ParserTelephoneExecute extends ParserExecute
{
  protected array $users = [];
  protected array $notFoundPhone = [];
  protected array $notEnd = [];
  protected $model = null;

  public function __construct(ParserModel $connect, CheckItPhonesModel $model)
  {
    $this->model = $model;
    parent::__construct($connect);
  }

  public function checkPhones(array $users): object
  {
    $phonesNumbers = $users;
    if ($phonesNumbers) {
      $result = [];
      foreach ($this->sessionList as $phone) {
        if (!$phonesNumbers) {
          break;
        }
        $error = 0;
        $this->startClient($phone->phone);
        for ($i = 0; $i < 5; $i++) {
          sleep(2);
          $user = array_pop($phonesNumbers);
          if (!$user) {
            break;
          }
          $this->incrementActions($phone->phone);
          try {
            $data = Telegram::instance($phone->phone)->getInformationByNumber($user);
            if ($data) {
              $this->model->insert([
                'user_name' => $data['users'][0]['username'] ?? '',
                'user_id' => $data['users'][0]['id'],
                'phone' => $user,
              ]);
              $result[] = $data;
            } else {
              $this->notFoundPhone[] = $data;
              $this->model->insert([
                'user_id' => 0,
                'phone' => $user,
              ]);
            }
          } catch (\Exception $e) {
            ErrorHelper::writeToFile($e);
            if ($e->getMessage() == 'PHONE_NOT_OCCUPIED') {
              $this->notFoundPhone[$phone] = $user;
              $this->model->insert([
                'user_id' => 0,
                'phone' => $user,
              ]);
            }
            $error++;
            if ($error >= 2) {
              continue 2;
            }
            continue;
          }
        }
      }
      $this->treatmentPhones($result);
      $this->notEnd = $phonesNumbers;
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
    $this->notEnd();
    return $path;
  }

  public function notEnd()
  {
    foreach ($this->notEnd as $phone) {
      Storage::disk('task')->put("{$this->task}-not-work", $phone);
    }
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
