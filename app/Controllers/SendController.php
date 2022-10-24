<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Models\TaskSendMessagesModel;
use App\Services\Authorization\Telegram;

class SendController
{
  public function sendMessage(ArgumentsHelpers $arg, TaskSendMessagesModel $sendTask, PhoneModel $phones)
  {
    // Telegram::instance('79874018497')->sendMessage(
    //   '@hitThat',
    //   'helsad asdasdasasd asdasdas dasdoasdas djnasjikd nasllo',
    // );
    // return;
    $phone = $phones->where(['login' => session()->get('login'), 'phone' => $arg->phone])->first();
    if (!$phone) {
      return response('Не найден данный телефон');
    }
    $task = $sendTask->where(['user_id' => session()->get('login'), 'status' => 10])->last();
    if ($task) {
      return response('Прошлое задание в статусе выполнения!', status: 300);
    }
    $sendTask->insert([
      'user_id' => session()->get('login'),
      'message' => $arg->msg,
      'status' => 1,
      'to_whom' => $arg->how,
    ]);
    $this->startClient($arg->phone);
    try {
      $result = Telegram::instance($arg->phone)->sendMessage($arg->how, $arg->msg);
      if ($result) {
        @$sendTask->where(['user_id' => session()->get('login'), 'status' => 1])->update(['status' => 2]);
        return response('Сообщение успешно отправлено');
      }
      return response(
        'Number doesn\'t exist! Need phone authorization or write admin, all contacts find in page contacts\'!',
      );
    } catch (\Exception $e) {
      $error = $sendTask->where(['user_id' => session()->get('login'), 'status' => 1])->last();
      if ($error) {
        @$sendTask->where(['user_id' => $error['user_id'], 'status' => 1])->update(['status' => 3]);
      }
      return response('Error send message', status: 404);
    }
  }

  public function startClient(...$phones)
  {
    foreach ($phones as $phone) {
      try {
        Telegram::instance($phone);
      } catch (\Exception $e) {
        continue;
      }
    }
  }
}
