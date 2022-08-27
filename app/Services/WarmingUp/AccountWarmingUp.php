<?php

namespace App\Services\WarmingUp;

use App\Services\Authorization\Telegram;

class AccountWarmingUp
{
  protected array $collections = [];

  public function __construct(array $phones)
  {
    $this->phones = $phones;
    $this->collections['photo'] = $this->getInformationFile(fopen('photoList', 'r'));
    $this->collections['name'] = $this->getInformationFile(fopen('nameList', 'r'));
    $this->getIdChannel($this->getInformationFile(fopen('channels', 'r')));
  }

  public function warmingUpAccount()
  {
    foreach ($this->phones as $phone) {
      $this->collections[$phone]['self']  = Telegram::instance($phone)->getSelf();
      $this->collections[$phone]['dialogs'] = Telegram::instance($phone)->getDialogs();
      $this->setInformationProfile($phone);
      $this->joinChannelForWarmingUp($phone);
      sleep(15);
    }
  }

  private function setInformationProfile(string $phone): void
  {
    $mePhoto = $this->collections[$phone]['self']['photo'] ?? false;
    if (!$mePhoto) {
      $name = $this->collections['name'][rand(0, (count($this->collections['name']) - 1))];
      Telegram::instance($phone)->updateNameProfile($name, about: "Меня зовут {$name}. Живу в Спб :)");
      Telegram::instance($phone)->updatePhotoProfile($this->collections['photo'][rand(0, (count($this->collections['photo']) - 1))]);
      Telegram::instance($phone)->sendMessage('@hitThat', "{$name} - set new informations");
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

  private function getIdChannel(array $array): void
  {
    $channelsId = Telegram::instance('79874018497')->getChannels($array);
    foreach ($channelsId['chats'] as $channel) {
      if ($channel['_'] === 'channel') {
        $this->collections['channels'][$channel['id']] = ['id' => $channel['id'], 'username' => $channel['username']];
      }
    }
  }

  private function joinChannelForWarmingUp($phone): bool
  {
    if ($this->collections[$phone] ?? false) {
      foreach ($this->collections['channels'] as $channel) {
        array_walk($this->collections[$phone]['dialogs'], function ($i) use ($channel, $phone) {
          if ($i['_'] == 'peerChat') {
            if ($i['chat_id'] !== $channel['id']) {
              Telegram::instance($phone)->joinchannel("https://t.me/{$channel['username']}");
            }
          }
        });
      }
    }

    return true;
  }
}
