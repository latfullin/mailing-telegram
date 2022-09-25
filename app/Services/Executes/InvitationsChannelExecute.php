<?php

namespace App\Services\Executes;

use App\Helpers\CheckUsersHelpers;
use App\Helpers\ErrorHelper;
use App\Helpers\Storage;
use App\Models\InvitationsModel;
use App\Services\Authorization\Telegram;

class InvitationsChannelExecute extends Execute
{
  const LIMIT_ACTIONS = 45;
  const ACTION_FIELD = 'count_action';
  const TASK_NAME = 'invitations_channel';
  protected bool $saved = false;
  protected string $channel = '';
  protected int $idChannel;
  protected array $chunkUsers = [];
  protected array $notFoundUsers = [];
  protected bool $greedySession = false;
  protected int $countReuseSession = 0;
  protected int $sleepArterReuse = 30;
  protected bool $needCheckUsers = false;
  private bool $validateChannel = false;
  protected ?InvitationsModel $invitationsModel = null;

  public function __construct(InvitationsModel $model)
  {
    parent::__construct(self::ACTION_FIELD, self::TASK_NAME, self::LIMIT_ACTIONS);
    $this->invitationsModel = $model;
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
        $this->invitionsUsers($session->phone);
        $this->leaveChannel($session->phone);
      }
      if ($this->greedySession && $this->chunkUsers) {
        $this->countReuseSession++;
        $this->callbackInvitations();
      }

      return $this;
    }

    return false;
  }

  private function callbackInvitations(): void
  {
    if ($this->greedySession && !$this->sessionList && $this->countReuseSession < 2) {
      $this->getSessionList();
    }
    if ($this->chunkUsers && $this->sessionList) {
      sleep($this->sleepArterReuse);
      $this->execute();
    }
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

  // Создание задания для продолжения
  public function setChannel(string $channel): object
  {
    $this->channel = $channel;
    if (!$this->validateChannel) {
      $result = $this->verifyChannel($this->channel);
      $this->idChannel = $result['full_chat']['id'];
      $this->validateChannel = true;
    }
    $information = json_encode(['channel' => $this->channel, 'idChannel' => $this->idChannel]);
    $this->modelTask->where(['task' => $this->task])->update([]);
    return $this;
  }

  public function leaveChannel($session)
  {
    $this->methodsWithChallen($session, 'leaveChannel', $this->channel);
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

  private function invitionsUsers($session)
  {
    for ($i = 0; $i < 10; $i++) {
      if (!$this->chunkUsers) {
        break;
      }
      $this->sessionConnect->increment($session, 'count_action');
      try {
        $user = array_pop($this->chunkUsers);
        Telegram::instance($session)->inviteToChannel($this->channel, $user);
        $this->invitationsModel->where(['task' => $this->task, 'user' => $user[0]])->update(['status' => 2]);
      } catch (\Exception $e) {
        $this->invitationsModel
          ->where(['task' => $this->task, 'user' => $user[0]])
          ->update(['error_log' => $e->getMessage(), 'status' => 3]);
        continue;
      }
    }

    sleep($this->sleepArterReuse);
  }

  private function chunkUsers()
  {
    $this->chunkUsers = array_chunk($this->usersList, 1);
  }

  private function validateUsers(): void
  {
    if ($this->usersList) {
      [
        'usersList' => $this->usersList,
        'notFount' => $this->notFoundUsers,
      ] = CheckUsersHelpers::checkEmptyUsers($this->usersList);
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

  public function save()
  {
    $this->saved = true;
    $results = [['Список пользователей', $this->usersList], ['Группа:', $this->channel]];
    $disk = Storage::disk('task');
    foreach ($results as $result) {
      $disk->put("{$this->task}", $result);
    }

    return $disk->getPath("{$this->task}");
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
    foreach ($users as $user) {
      $this->invitationsModel->insert([
        'task' => $this->task,
        'user' => $user,
        'status' => 0,
      ]);
    }

    return $this;
  }

  public function setNeedCheckUser(bool $bool): object
  {
    $this->needCheckUsers = $bool;

    return $this;
  }
}
