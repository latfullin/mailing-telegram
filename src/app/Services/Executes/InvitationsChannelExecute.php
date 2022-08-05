<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Services\Authorization\Telegram;
use Exception;

class InvitationsChannelExecute extends Execute
{
  private static ?InvitationsChannelExecute $instance = null;
  protected string $channel = '';
  private bool $validateChannel = false;

  public static function instance(string $channel = '', array $phone = []): InvitationsChannelExecute
  {
    if (self::$instance === null) {
      self::$instance = new self($channel, $phone);
    }

    return self::$instance;
  }

  private function __construct(string $channel = '', array $phone = [])
  {
    if ($phone) {
      parent::__construct($phone);
    } else {
      parent::__construct();
    }
    if ($channel) {
      $this->channel = $channel;
    }
  }

  public function joinChannel(): object
  {
    if ($this->validateChannel) {
      $this->varifyChannel();
    }
    try {
      if ($this->channel) {
        foreach ($this->sessionList as $session) {
          Telegram::instance($session)->joinChannel($this->channel);
        }
      } else {
        throw new Exception('Not found channel to invite!');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    return $this;
  }

  public function setChannel(string $channel): object
  {
    $this->channel = $channel;
    $this->validateChannel = false;
    return $this;
  }

  private function varifyChannel(): void
  {
    try {
      if ($this->channel) {
        Telegram::instance($this->sessionList[rand(0, count($this->sessionList) - 1)], false)->getChannel($this->channel);
        $this->validateChannel = true;
      } else {
        throw new Exception('Not found channel to invite!');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }
}
