<?php

namespace App\Services\Executes;

use App\Helpers\CheckUsersHelpers;
use App\Helpers\ErrorHelper;
use App\Helpers\Storage;
use App\Helpers\WorkingFileHelper;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;

class InvitationsChannelExecute extends Execute
{
  private static ?InvitationsChannelExecute $instance = null;

  /**
   * @param usedSession used phone number in instance.
   */
  protected array $usedSession = [];

  /**
   * channel for invitations 
   */
  protected int $limitActions = 45;
  protected bool $saved = false;
  protected string $channel = '';
  protected int $idChannel;
  protected array $chunkUsers = [];
  protected array $notFoundUsers = [];
  protected bool $greedySession = false;
  protected array $reuseSession = [];
  protected int $countReuseSession = 0;
  protected int $sleepArterReuse = 10;
  protected bool $needCheckUsers = false;
  private bool $validateChannel = false;
  private ?PhoneModel $connect = null;
  /**
   * @return InvitationsChannelExecute class instance;
   */
  // public static function instance(string $channel = '', array $usersList, bool $needCheckUsers = false): InvitationsChannelExecute
  // {
  //   if (self::$instance === null) {
  //     self::$instance = new self($channel, $usersList, greedySession: false, needCheckUsers: $needCheckUsers);
  //   }

  //   return self::$instance;
  // }

  public function __construct()
  {
    parent::__construct('count_actions', $this->limitActions);
  }

  /** 
   * @param channel required param; Need hand over params 'channel' this function or at call instance  
   */
  public function execute(): object
  {
    if ($this->channel && $this->usersList) {
      $this->checkUsers();
      foreach ($this->sessionList as $session) {
        if (!$this->chunkUsers) {
          break;
        }
        $this->joinsChannel($session->phone);
        $this->connect = new PhoneModel();
        $this->invitionsUsers($session->phone);
        $this->leaveChannel($session->phone);
      }
      return $this;
    }

    return false;
  }

  /**
   *  @return object this class;
   */
  private function joinsChannel($session)
  {
    try {
      if ($this->channel && $this->idChannel) {
        if (!$this->checkAccountGroups($session)) {
          Telegram::instance($session)->joinChannel($this->channel);
        }
      } else {
        throw new \Exception('Not found channel to invite!');
      }
    } catch (\Exception $e) {
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
    if (!$this->validateChannel) {
      $result = $this->verifyChannel($this->channel);
      $this->idChannel = $result['full_chat']['id'];
      $this->validateChannel = true;
    }

    return $this;
  }

  public function leaveChannel($session)
  {
    $this->methodsWithChallen($session, 'leaveChannel', $this->channel);
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
  private function invitionsUsers($session)
  {
    for ($i = 0; $i < 10; $i++) {
      if (!$this->chunkUsers) {
        break;
      }
      try {
        $user = array_pop($this->chunkUsers);
        Telegram::instance($session)->inviteToChannel($this->channel, $user);
        $this->success++;
      } catch (\Exception $e) {
        ErrorHelper::writeToFile($e);
        $this->notFoundUsers[] = $user;
        $this->amountError++;
        continue;
      }
      $this->connect->increment($session, 'count_action');
    }
    sleep($this->sleepArterReuse);
    // }
    // if ($this->greedySession) {
    //   $this->callbackInvitations();
    // }
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

  // private function callbackInvitations()
  // {
  //   if ($this->greedySession && !$this->sessionList && $this->countReuseSession < 2) {
  //     shuffle($this->usedSession);
  //     $this->sessionList = array_splice($this->usedSession, 0, count($this->chunkUsers));
  //     array_push($this->reuseSession, $this->sessionList);
  //     $this->countReuseSession++;
  //   }
  //   if ($this->chunkUsers && $this->sessionList) {
  //     sleep($this->sleepArterReuse);
  //     $this->invitionsUsers();
  //   }
  // }

  public function save()
  {
    $this->saved = true;
    $results = [
      ['Список пользователей', $this->usersList],
      ['Группа:', $this->channel],
      ['Не найденные пользователи', $this->notFoundUsers],
      ['Использованные сессии:', $this->usedSession],
      ['Переиспользованные сессии:', $this->reuseSession],
      ['Успешный итераций:', $this->success],
      ['Количество ошибок:', $this->amountError]
    ];
    $disk = Storage::disk('task');
    foreach ($results as $result) {
      $disk->put("{$this->task}.txt", $result);
    }

    return $disk->getPath("{$this->task}.txt");
  }

  public function __destruct()
  {
    if (!$this->saved) {
      throw new \Exception('Результат не сохранен');
    }
  }

  public function setGreedySession(bool $bool): object
  {
    $this->greedySession = $bool;

    return $this;
  }

  public function setUsersList(array $users): object
  {
    $this->usersList = $users;

    return $this;
  }

  public function setNeedCheckUser(bool $bool): object
  {
    $this->needCheckUsers = $bool;

    return $this;
  }
}
