<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;
use danog\MadelineProto\phone;

class PrepareAccountController
{
  public function prepareAccount(
    ArgumentsHelpers $argument,
    PhoneModel $phoneModel
  ) {
    $phones = $phoneModel->getAll();
    foreach ($phones as $phone) {
      if ($argument->photo ?? false) {
        echo $phone->phone;
        Telegram::instance($phone->phone)->deleteMePhotoProfile();
        Telegram::instance($phone->phone)->updatePhotoProfile($argument->photo);
      }

      Telegram::instance($phone->phone)->updateNameProfile(
        $argument->firstName,
        $argument->lastName ?? "",
        $argument->about ?? ""
      );
      $phoneModel->increment($phone->phone, "count_action");
    }
  }
}
