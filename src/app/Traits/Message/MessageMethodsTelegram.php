<?php

namespace App\Traits\Message;

use danog\MadelineProto\channels;
use Exception;

trait MessageMethodsTelegram
{
  public array $channel;

  public function sendMessage(string $peer, string $msg): object
  {
    $this->telegram->messages->sendMessage(peer: $peer, message: $msg);

    return $this;
  }

  public function sendFoto(string $peer, string $pathFoto, string $msg = ''): object
  {
    if (is_file($pathFoto)) {
      $this->telegram->messages->sendMedia([
        'peer' => $peer,
        'media' => [
          '_' => 'inputMediaUploadedPhoto',
          'file' => $pathFoto
        ],
        'message' => $msg,
        'parse_mode' => 'Markdown'
      ]);
    } else {
      echo 'Need actual path!. Error';
    }

    return $this;
  }

  public function sendVideo(string $peer, string $pathVideo, string $msg = '', string $renameFile = ''): object
  {
    if (is_file($pathVideo)) {
      $this->telegram->messages->sendMedia([
        'peer' => $peer,
        'media' => [
          '_' => 'inputMediaUploadedDocument',
          'file' => $pathVideo,
          'attributes' => [
            ['_' => 'documentAttributeFilename', 'file_name' => $renameFile ? $renameFile : basename($pathVideo)]
          ]
        ],
        'message' => $msg,
        'parse_mode' => 'Markdown'
      ]);
    } else {
      echo 'Need actual path!. Error';
    }

    return $this;
  }

  // Need rebuild
  public function editPhotoСhannels(string|int $group, string $photo): object
  {
    $this->telegram->channels->editPhoto(channel: $group, photo: [
      '_' => 'inputMediaUploadedPhoto',
      'file' => $photo
    ]);

    return $this;
  }

  // Need format '1147860595' 
  public function getInfo($id)
  {
    try {
      return $this->telegram->getInfo(id: $id);
    } catch (Exception $e) {
      return false;
    }
  }

  // Show all dialog & channels 
  public function getDialogs(): array
  {
    return $this->telegram->getDialogs();
  }

  // public function getFullChat(): array
  // {
  //   return $this->telegram->getDialogs();
  // }

  /* Show information by phone. Formation: 
    number[_] => contacts.resolvedPeer
    [peer] => Array
    (
        [_] => peerUser
        [user_id] => 1147860595
    )
    [chats] => Array()
    [0] => Array
    (
      [_] => user
      [flags] => 33556567
      [self] => 
      [contact] => 1
      ....
    */
  public function getInformationByNumber($phone)
  {
    return $this->telegram->contacts->resolvePhone(phone: $phone);
  }
}
