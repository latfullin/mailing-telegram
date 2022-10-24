<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\UsersModel;
use App\Response\Response;
use App\Services\Bot\TelegramBot;
use App\Services\Executes\ParserExecute;
use App\Services\Executes\ParserTelephoneExecute;

class ParserController
{
  public function checkPhone(ArgumentsHelpers $arg, ParserTelephoneExecute $parser, TelegramBot $telegram): void
  {
    $filePath = $parser
      ->checkPhones($arg->phones)
      ->usersProcessing()
      ->save();

    $telegram->setChatId($arg->userId)->sendFile($filePath);
  }

  public function parseGroup(ArgumentsHelpers $arg, ParserExecute $parser, TelegramBot $telegram): Response
  {
    try {
      if (!$arg->userId || !$arg->channel) {
        return response(false);
      }
      $filePath = $parser
        ->channel($arg->channel)
        ->executes()
        ->save();
      $telegram->setChatId($arg->userId)->sendFile($filePath);

      return response(true);
    } catch (\Exception $e) {
      $telegram->setChatId('365047507')->sendMsg($e->getMessage());

      return response('Неизвестная ошибка');
    }
  }

  public function parseGroupForTelegram(
    ArgumentsHelpers $arg,
    ParserExecute $parser,
    TelegramBot $telegram,
    UsersModel $users,
  ) {
    $user = $users->where(['name' => $arg->json['message']['from']['id']])->first();
    if ($user) {
      try {
        $link = preg_match("/^https:\/\/t\.me\/\+?[a-z0-9@_]+$/i", trim($arg->json['message']['text']));
        if ($link) {
          $filePath = $parser
            ->channel(trim($arg->json['message']['text']))
            ->executes()
            ->save();
          $telegram->setChatId($arg->json['message']['from']['id'])->sendFile($filePath);
        } else {
          $telegram->setChatId($arg->json['message']['from']['id'])->sendMsg('Not correct link');
        }
      } catch (\Exception $e) {
        $telegram->setChatId($arg->json['message']['from']['id'])->sendMsg('Not found error');
      }
    } else {
      $telegram->setChatId($arg->json['message']['from']['id'])->sendMsg('You have not access');
    }
  }
}
