<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;

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
          } catch (\Exception $e) {
            ErrorHelper::writeToFile("$e\n");
            continue;
          }
        }
      } else {
        throw new \Exception('Not found channels for entry');
      }
    } catch (\Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  private function verifyChannels(): void
  {
    try {
      if ($this->channels) {
        foreach ($this->channels as $channel) {
          try {
            $this->verifyChannel($channel);
          } catch (\Exception $e) {
            array_push($this->notFountChannel, array_splice($this->channels, array_search($channel, $this->channels), 1)[0]);
            continue;
          }
        }
        $this->verifiedChannels = true;
      } else {
        throw new \Exception('Not found channels');
      }
    } catch (\Exception $e) {
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
