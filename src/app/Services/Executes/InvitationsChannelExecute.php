<?php

namespace App\Services\Executes;

use App\Helpers\CheckUsersHelpers;
use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class InvitationsChannelExecute extends Execute
{
  private static ?InvitationsChannelExecute $instance = null;

  /**
   * @param usedSession used phone number in instance.
   */
  protected array $usedSession = [];

  protected string $channel = '';
  protected int $idChannel;
  protected array $chunkUsers = [];
  protected array $skipUsers = [];
  protected array $notFoundUsers = [];
  protected bool $greedySession = false;
  protected array $reuseSession = [];
  protected int $countReuseSession = 0;
  protected int $sleepArterReuse = 10;
  protected bool $needCheckUsers = false;
  private bool $validateChannel = false;

  /**
   * @return InvitationsChannelExecute class instance;
   */
  public static function instance(string $channel = '', array $phone = []): InvitationsChannelExecute
  {
    if (self::$instance === null) {
      self::$instance = new self($channel, $phone, greedySession: false);
    }

    return self::$instance;
  }

  private function __construct(string $channel = '', array $phone = [], array $users = [], bool $greedySession = false)
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
    if ($greedySession) {
      $this->greedySession = $greedySession;
    }
  }

  /** 
   * @param channel required param; Need hand over params 'channel' this function or at call instance  
   */
  public function execute(string $channel = '', bool $needCheckUsers = false): object
  {
    $this->needCheckUsers = $needCheckUsers;
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
      ErrorHelper::writeToFileAndDie("$e");
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

  public function usedSession(string $session): void
  {
    if ($this->sessionList) {
      array_push($this->usedSession, array_slice($this->sessionList, array_search($session, $this->sessionList), 1)[0]);
    }
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
    $this->checkUsers();
    if ($this->sessionList) {
      for ($i = 0; $i < 10; $i++) {
        foreach ($this->sessionList as $session) {
          echo $session;
          if (!$this->chunkUsers) {
            break;
          }
          $this->usedSession($session);
          try {
            $user = array_pop($this->chunkUsers);
            Telegram::instance($session)->inviteToChannel($this->channel, $user);
            $this->success++;
          } catch (Exception $e) {
            ErrorHelper::writeToFile($e);
            $this->skipUsers[] = $user;
            $this->amountError++;
            continue;
          }
        }
        sleep($this->sleepArterReuse);
      }
    }
    if ($this->greedySession) {
      $this->callbackInvitations();
    }
  }

  private function chunkUsers()
  {
    $this->chunkUsers = array_chunk($this->usersList, 1);
  }

  private function validateUsers(): void
  {
    if ($this->usersList) {
      ['usersList' => $this->usersList, 'notFount' => $this->notFoundUsers]  = CheckUsersHelpers::checkEmptyUsers($this->usersList);
      $this->validateUsers = true;
    }
  }

  private function checkUsers(): void
  {
    if (!$this->validateUsers && $this->needCheckUsers) {
      $this->validateUsers();
    }

    if (!$this->chunkUsers) {
      $this->chunkUsers();
    }
  }

  private function callbackInvitations()
  {
    if ($this->greedySession && !$this->sessionList && $this->countReuseSession < 2) {
      shuffle($this->usedSession);
      $this->sessionList = array_splice($this->usedSession, 0, count($this->chunkUsers));
      array_push($this->reuseSession, $this->sessionList);
      $this->countReuseSession++;
    }
    if ($this->chunkUsers && $this->sessionList) {
      sleep($this->sleepArterReuse);
      $this->invitionsUsers();
    }
  }

  public function __destruct()
  {
    WorkingFileHelper::newTask($this->task,  $this->usersList, $this->channel, $this->notFoundUsers, $this->usedSession, $this->reuseSession);
    WorkingFileHelper::endTask($this->task, $this->success, $this->amountError, $this->skipUsers);
  }
}
