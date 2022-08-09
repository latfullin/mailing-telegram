<?php

namespace App\Services\Executes;

use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;

class ParcerExecute extends Execute
{
  private static ?ParcerExecute $instance = null;
  const CONSONANTS_LETTERS = ['Б', 'В', 'Г', 'Д', 'Ж', 'З', 'Й', 'К', 'Л', 'М', 'Н', 'П', 'Р', 'С', 'Т', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ'];
  const MALE_END_LETTERS = ['й', 'ь', 'а', 'я'];

  /**
   * limit count, on the get users in request
   */
  const OFFSET_LIMIT = 200;

  /**
   * 1 day
   */
  const ONE_DAY = 86400;

  /**
   * 2 day
   */
  const TWO_DAY = 172800;

  /**
   * 3 day
   */
  const THREE_DAY = 259200;

  /**
   * 7day - one week
   */
  const ONE_WEEK = 604800;

  /**
   * 30.44 day - one month
   */
  const ONE_MONTH = 2629743;

  /**
   * channel for parser
   */
  protected string $channel;

  /**
   * array information group 
   * todo. Need do dir for example received informations.
   */
  protected array $channelInformation;

  /**
   * count cycles for array 
   */
  protected int $countCycles;

  /**
   * information about user 
   */
  protected array $participants = [];

  /**
   * divite participant for gender
   */
  protected bool $divideGender = false;

  /**
   * need for user id, if not found username
   */
  protected bool $needUsersId = true;

  protected array $data = [
    'oneDay' => [],
    'twoDay' => [],
    'threeDay' => [],
    'oneWeek' => [],
    'oneMonth' => [],
    'moreOneMonth' => [],
    'notTime' => [],
  ];

  protected int $countUsers = 0;

  private function __construct(bool $needUsersId)
  {
    parent::__construct();
    $this->needUsersId = $needUsersId;
  }

  public static function instance(bool $needUsersId = true): ParcerExecute
  {
    if (self::$instance === null) {
      self::$instance = new self($needUsersId);
    }
    return self::$instance;
  }

  public function channel(string $channel): ParcerExecute
  {
    if ($this->participants) {
      $this->resetData();
    }

    $this->channel = $channel;
    $this->channelInformation = $this->verifyChannel($channel);
    $this->countAmountInteration($this->channelInformation['full_chat']['participants_count']);

    return $this;
  }

  public function collectParticipants(): ParcerExecute
  {
    $offset = 0;
    // $result = [];
    for ($i = 0; $i < $this->countCycles; $i++) {
      echo $i;
      $result = Telegram::instance('79776782207')->getParticipants($this->channel, $offset)['users'];
      for ($r = 0; $r < count($result); $r++) {
        $this->participants[$result[$r]['id']] = $result[$r];
      }
      $offset += SELF::OFFSET_LIMIT;
    }

    $this->countUsers = count($this->participants);

    return $this;
  }

  public function breakInfoTime(): void
  {
    $now = time();

    foreach ($this->participants as $participant) {
      $time = $participant['status']['was_online'] ?? false;
      $userNameOrId = 'empty';
      if ($participant['username'] ?? false) {
        $userNameOrId = '@' . $participant['username'];
      } else {
        if (!$this->needUsersId) {
          continue;
        }
        $userNameOrId = $participant['id'];
      }

      if ($time === false) {
        $this->data['notTime'][] = $userNameOrId;
        continue;
      }

      $validTime = $now - $time;

      switch ($validTime) {
        case self::ONE_DAY > $validTime:
          $this->data['oneDay'][] = $userNameOrId;
          break;
        case self::ONE_DAY < $validTime &&  self::TWO_DAY > $validTime:
          $this->data['twoDay'][] = $userNameOrId;
          break;
        case self::TWO_DAY < $validTime && self::THREE_DAY > $validTime:
          $this->data['threeDay'][] = $userNameOrId;
          break;
        case self::THREE_DAY < $validTime && self::ONE_WEEK > $validTime:
          $this->data['oneWeek'][] = $userNameOrId;
          break;
        case self::ONE_WEEK < $validTime && self::ONE_MONTH > $validTime:
          $this->data['oneMonth'][] = $userNameOrId;
          break;
        default:
          $this->data['moreOneMonth'][] = $userNameOrId;
      }
    }
  }

  private function countAmountInteration(int $informationChannel): void
  {
    $this->countCycles = ceil($informationChannel / self::OFFSET_LIMIT);
  }

  private function resetData(): void
  {
    $this->participants = [];
  }

  private function saveToFile()
  {
    WorkingFileHelper::saveForFileTask($this->task, "Группа {$this->channel}\n\n");
    WorkingFileHelper::saveForFileTask($this->task, "Количество пользователей в группе: {$this->countUsers}\n\n");
    foreach ($this->data as $key => $days) {
      $lang = timeLang($key);
      WorkingFileHelper::saveForFileTask($this->task, "\n{$lang}\n\n");
      foreach ($days as $item) {
        WorkingFileHelper::saveForFileTask($this->task, "$item\n");
      }
    }
  }

  public function __destruct()
  {
    $this->saveToFile();
  }
}
