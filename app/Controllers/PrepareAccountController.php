<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;
use danog\MadelineProto\phone;

class PrepareAccountController
{
  public function prepareAccount(ArgumentsHelpers $argument, PhoneModel $phoneModel)
  {
    $phones = $phoneModel
      ->limit([0, 10])
      ->where(['status' => 10, 'ban' => 0])
      ->get();
    foreach ($phones as $phone) {
      // if ($argument->photo ?? false) {
      $telegram = Telegram::instance($phone->phone);
    }
    foreach ($phones as $phone) {
      // $telegram->updateNameProfile('Дмитрий', 'выф', '');
      $telegram->deleteMePhotoProfile();
      $telegram->updatePhotoProfile('image-20.jpeg');
    }
    // $telegram->updateNameProfile('Kilkenny', '', '');
    // $telegram->sendMessage('@hitThat', 'hello');
    // $phoneModel->increment($phone->phone, 'count_action');
  }

  public function start($phone)
  {
    Telegram::instance($phone);
  }
}
