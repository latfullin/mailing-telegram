<?php

namespace App\Traits\Account;

trait AccountMethodsTelegram
{
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
}
