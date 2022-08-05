<?php

namespace App\Traits\Message;

use danog\MadelineProto\channels;

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

  // Need rebuild
  public function getInfo($id): object
  {
    $a = $this->telegram->getFullInfo($id);
    print_r($a);
    return $this;
  }


  public function getDialogs(): array
  {
    return $this->telegram->getDialogs();
  }
}
