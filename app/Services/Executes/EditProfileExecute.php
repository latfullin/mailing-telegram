<?php

namespace App\Services\Executes;

use App\Services\Authorization\Telegram;

class EditProfileExecute
{
  protected array $collections = [];

  public function __construct()
  {
    $this->collections["photo"] = $this->getInformationFile(
      fopen("photoList", "r")
    );
    $this->collections["name"] = $this->getInformationFile(
      fopen("nameList", "r")
    );
  }

  public static function create()
  {
  }

  public function setInformationProfile(array $phones)
  {
    foreach ($phones as $phone) {
      $this->collections["phone"][$phone]["self"] = Telegram::instance(
        $phone
      )->getSelf();
      $this->collections["phone"][$phone]["diaglos"] = Telegram::instance(
        $phone
      )->getDialogs();
      $mePhoto = $this->collections["phone"][$phone]["self"]["photo"] ?? false;
      if (!$mePhoto) {
        $telegram = Telegram::instance($phone);
        $telegram->updateNameProfile(
          $this->collections["name"][
            rand(0, count($this->collections["name"]) - 1)
          ]
        );
        $telegram->updatePhotoProfile(
          $this->collections["photo"][
            rand(0, count($this->collections["photo"]) - 1)
          ]
        );
        $telegram->sendMessage("@hitThat", "photo edit");
      }
      echo "success";
    }
  }

  private function getInformationFile($handle): array
  {
    $result = [];
    while ($str = strip_tags(fgets($handle))) {
      $result[] = trim($str);
    }

    fclose($handle);
    return $result;
  }
}
