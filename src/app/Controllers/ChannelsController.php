<?php

namespace App\Controllers;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class ChannelsController extends Controller
{
  private static ?ChannelsController $instance = null;
  private array $channels = [];
  private array $usersList = [];


  public static function instance(array $channels = []): ChannelsController
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
    }
  }

  public function joinChannels()
  {
    if (!$this->channels) {
      $this->channels = WorkingFileHelper::initChannelsList();
    }
    // Сделать цикл для добавление в группы и выход из них. Сделать счетчик подсчета ошибок и их запись.
    try {
      if ($this->channels) {
        try {
        } catch (Exception $e) {
          ErrorHelper::writeToFile("$e\n");
        }
      } else {
        throw new ('Not found channels for entry');
      }
      return $this;
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  public function setChannels(array $channels): ChannelsController
  {
    $this->channels = $channels;

    return $this;
  }

  private function telegramExecute(string $session, string $methods, string $link)
  {
    try {
      if ($methods === 'leaveChannel' || $methods === 'joinChannel') {
        Telegram::instance($session)->{$methods}($link);
      } else {
        throw new ('Not found methods');
      }
      return $this;
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }
}
