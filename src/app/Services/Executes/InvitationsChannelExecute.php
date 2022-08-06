<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class InvitationsChannelExecute extends Execute
{
  private static ?InvitationsChannelExecute $instance = null;
  const LENGTH_USERS_FOR_INVITIONS = 10;
  protected string $channel = '';
  protected int $idChannel;
  protected array $chunkUsers = [];
  protected array $skipUsers = [];
  private bool $validateChannel = false;

  /**
   * @return InvitationsChannelExecute class instance;
   */
  public static function instance(string $channel = '', array $phone = []): InvitationsChannelExecute
  {
    if (self::$instance === null) {
      self::$instance = new self($channel, $phone);
    }

    return self::$instance;
  }

  private function __construct(string $channel = '', array $phone = [], array $users = [])
  {
    if ($phone) {
      parent::__construct($phone);
    } else {
      parent::__construct();
    }
    if ($channel) {
      $this->channel = $channel;
    }
    if ($users) {
      $this->usersList = $users;
    }
  }

  /** 
   * @param channel required param; Need hand over params 'channel' this function or at call instance  
   */
  public function execute(string $channel = ''): object
  {
    if ($channel) {
      $this->channel = $channel;
    }
    if (!$this->usersList) {
      $this->initUsersInFile();
    }

    if ($this->channel && $this->usersList) {
      $this->joinsChannel();
      $this->invitionsUsers();
    }

    return $this;
  }

  /**
   *  @return object this class;
   */
  private function joinsChannel(): object
  {
    if (!$this->validateChannel) {
      $result = $this->verifyChannel($this->channel);
      $this->idChannel = $result['full_chat']['id'];
      $this->validateChannel = true;
    }
    try {
      if ($this->channel && $this->idChannel) {
        foreach ($this->sessionList as $session) {
          if (!$this->checkAccountGroups($session)) {
            Telegram::instance($session)->joinChannel($this->channel);
          }
        }
      } else {
        throw new Exception('Not found channel to invite!');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    return $this;
  }

  /**
   * @return object this class;
   */
  public function setChannel(string $channel): object
  {
    $this->channel = $channel;
    $this->validateChannel = false;
    return $this;
  }

  public function leaveChannel(): object
  {
    sleep(10);
    if ($this->usedSession) {
      foreach ($this->usedSession as $session) {
        $this->methodsWithChallen($session, 'leaveChannel', $this->channel);
      }
    }

    return $this;
  }

  private function checkAccountGroups(string $session)
  {
    $data = Telegram::instance($session)->getDialogs();
    return array_filter($data, function ($group) {
      if ($group['channel_id'] ?? false) {
        return $group['channel_id'] === $this->idChannel;
      }
    });
  }

  /**
   * 
   */
  private function invitionsUsers()
  {
    if (!$this->valiteUsers) {
      $this->validateUsers();
    }
    $this->chunkUsers();

    foreach ($this->sessionList as $session) {
      $this->usedSession($session);
      try {
        $users = array_pop($this->chunkUsers);
        Telegram::instance($session, false)->inviteToChannel($this->channel, $users);
      } catch (Exception $e) {
        ErrorHelper::writeToFile($e);
        array_push($this->skipUsers, $users);
        continue;
      }
    }
  }

  private function chunkUsers()
  {
    $this->chunkUsers = array_chunk($this->usersList, self::LENGTH_USERS_FOR_INVITIONS);
    print_r($this->chunkUsers);
  }

  private function validateUsers(): void
  {
    if ($this->usersList) {
      $session = Telegram::instance($this->sessionList[0]);
      foreach ($this->usersList as $user) {
        try {
          $a = $session->getInfo($user);
          print_r($a);
        } catch (Exception $e) {
          array_push($this->skipUsers, array_splice($this->usersList, array_search($user, $this->usersList))[0]);
          continue;
        }
      }
      print_r($this->skipUsers);
    }
  }

  private function spliceUsers($user)
  {
  }

  public function __desctruct()
  {
    WorkingFileHelper::newTask($this->task, $this->userList, $this->usedSession, $this->skipUsers);
  }
}
