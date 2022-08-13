<?php

namespace App\Services\Executes;

use App\Services\Authorization\Telegram;

class EditProfileExecute
{
  protected array $collections = [];

  public function __construct()
  {
    $this->collections['photo'] = $this->getInformationFile(fopen('photoList', 'r'));
    $this->collections['name'] = $this->getInformationFile(fopen('nameList', 'r'));
  }

  public static function create()
  {
  }

  public function setInformationProfile(array $phones)
  {
    foreach ($phones as $phone) {
      $me = Telegram::instance($phone)->getSelf();
      $mePhoto = $me['photo'] ?? false;
      // if (!$mePhoto) {
      Telegram::instance($phone)->updateNameProfile($this->collections['name'][rand(0, (count($this->collections['name']) - 1))]);
      Telegram::instance($phone)->updatePhotoProfile($this->collections['photo'][rand(0, (count($this->collections['photo']) - 1))]);
      // }
      Telegram::instance($phone)->sendMessage('@hitThat', 'photo edit');
      echo 'success';
    }
  }

  private function getInformationFile($handle): array
  {
    $result = [];
    while (true) {
      $str = strip_tags(fgets($handle));
      if ($str) {
        $result[] = trim($str);
      } else {
        break;
      }
    };

    fclose($handle);
    return $result;
  }
}
