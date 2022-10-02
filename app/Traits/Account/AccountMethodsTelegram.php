<?php

namespace App\Traits\Account;

use App\Services\Bot\TelegramBot;

trait AccountMethodsTelegram
{
  protected ?array $mePhotos = null;
  /**
   * @param firstName field name.
   * @param lastName surname.
   * @param about description profile. Max Max length 70 symbol.
   */
  public function updateNameProfile(string $firstName, ?string $lastName = null, ?string $about = null): void
  {
    $this->telegram->account->updateProfile(first_name: $firstName, last_name: $lastName, about: $about);
  }

  /**
   * @param path path before images (format jpg) or link on the images.
   */
  public function updatePhotoProfile(string $path)
  {
    $this->telegram->photos->uploadProfilePhoto(file: $path);
  }

  public function start()
  {
    return $this->telegram->start();
  }

  public function getMePhoto()
  {
    if ($this->me === null) {
      $this->getMe();
    }
    $this->mePhotos = $this->telegram->photos->getUserPhotos(
      user_id: $this->me['id'],
      offset: 0,
      limit: 10,
      max_id: 100,
    )['photos'];

    return $this;
  }

  public function deleteMePhotoProfile()
  {
    if ($this->mePhotos === null) {
      $this->getMePhoto();
    }
    if ($this->mePhotos) {
      $id = [];
      foreach ($this->mePhotos as $photo) {
        $id[] = [
          'id' => $photo['id'],
          '_' => 'inputPhoto',
          'access_hash' => $photo['access_hash'],
        ];
      }
      $this->telegram->photos->deletePhotos(id: $id);
    }
  }

  public function getSelf()
  {
    try {
      return $this->telegram->getSelf();
    } catch (\Exception $e) {
      TelegramBot::exceptionError($e->getMessage());
    }
  }

  public function getInformationByNumber($phone)
  {
    return $this->telegram->contacts->resolvePhone(phone: $phone);
  }

  public function getMeInformations()
  {
    try {
      if (isset($this->me)) {
        return $this->me;
      } else {
        $this->getMe();
        return $this->me;
      }
    } catch (\Exception $e) {
      TelegramBot::exceptionError($e->getMessage());
    }
  }
}
