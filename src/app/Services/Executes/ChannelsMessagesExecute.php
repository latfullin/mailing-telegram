<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class ChannelsExecute extends Execute
{
  private static ?ChannelsExecute $instance = null;
  private array $channels = [];
  private array $notFountChannel = [];
  protected bool $verifiedChannels = false;

  public static function instance(array $channels = []): ChannelsExecute
  {
    if (self::$instance === null) {
      self::$instance = new self($channels);
    }

    return self::$instance;
  }

  private function __construct(array $channels = [])
  {
    parent::__construct();
    if ($channels) {
      $this->channels = $channels;
      $this->verifyChannels();
    }
  }

  public function setChannels(array $channels): ChannelsExecute
  {
    $this->channels = $channels;
    $this->verifyChannels();
    return $this;
  }

  public function verifyChannel($link): bool
  {
    try {
      if ($link) {
        Telegram::instance($this->sessionList[rand(0, count($this->sessionList) - 1)], false)->getChannel($link);
        return true;
      }
    } catch (Exception $e) {
      return false;
    }

    return false;
  }

  public function joinChannels(): object
  {
    $this->telegramExecute('joinChannel');
    return $this;
  }

  public function leaveChannel(): object
  {
    $this->telegramExecute('leaveChannel');
    return $this;
  }

  private function telegramExecute(string $method): void
  {
    if (!$this->channels) {
      $this->getChannels();
    }
    try {
      if ($this->channels && $this->verifiedChannels) {
        foreach ($this->sessionList as $session) {
          try {
            foreach ($this->channels as $channel) {
              $this->methodsWithChallen($session, $method, $channel);
            }
          } catch (Exception $e) {
            ErrorHelper::writeToFile("$e\n");
            continue;
          }
        }
      } else {
        throw new ('Not found channels for entry');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  private function methodsWithChallen(string $session, string $method, string $link): void
  {
    try {
      if ($method === 'leaveChannel' || $method === 'joinChannel') {
        Telegram::instance($session)->{$method}($link);
      } else {
        throw new ('Not found methods');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  private function verifyChannels(): void
  {
    try {
      if ($this->channels) {
        foreach ($this->channels as $channel) {
          try {
            Telegram::instance($this->sessionList[rand(0, count($this->sessionList) - 1)], false)->getChannel($channel);
          } catch (Exception $e) {
            array_push($this->notFountChannel, array_splice($this->channels, array_search($channel, $this->channels), 1)[0]);
            continue;
          }
        }
        $this->verifiedChannels = true;
      } else {
        throw new ('Not found channels');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFile("$e\n");
    }
  }

  private function getChannels(): void
  {
    if (!$this->channels) {
      $this->channels = WorkingFileHelper::initChannelsList();
      if ($this->channels) {
        $this->verifyChannels();
      }
    }
  }
}
