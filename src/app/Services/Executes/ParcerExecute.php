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
  protected array $channelInformation;
  protected int $countCycles;
  protected int $participantsCount;
  protected array $participants = [];
  protected bool $divideGender = false;
  protected bool $needUsersId = true;
  protected int $countUsers = 0;

  private function __construct(string $channel, bool $needUsersId)
  {
    parent::__construct();
    $this->channel = $channel;
    $this->needUsersId = $needUsersId;
    $this->channelInformation = $this->verifyChannel($channel);
    $this->participantsCount = $this->channelInformation['full_chat']['participants_count'];
    $this->countAmountInteration($this->participantsCount);
  }

  public static function instance(string $channel = '', bool $needUsersId = true)
  {
    if (self::$instance === null) {
      self::$instance = new self($channel, $needUsersId);
    }

    return self::$instance;
  }

  public function start()
  {
    $offset = 0;
    for ($i = 0; $i < $this->countCycles; $i++) {
      $data = Telegram::instance('79776782207')->getParticipants($this->channel, $offset)['users'];
      for ($d = 0; $d < count($data); $d++) {
        array_push($this->participants, $data[$d]);
      }
      $offset += SELF::OFFSET_LIMIT;
    }
    $this->countUsers = count($this->participants);

    return $this;
  }

  public function breakInfoTime()
  {
    $data = [
      'oneDay' => [],
      'twoDay' => [],
      'threeDay' => [],
      'oneWeek' => [],
      'oneMonth' => [],
      'moreOneMonth' => [],
      'notTime' => [],
    ];
    $now = time();

    foreach ($this->participants as $key => $participant) {
      $time = $participant['status']['was_online'] ?? false;
      $userNameOrId = $participant['username'] ?? $participant['id'];

      if ($time === false) {
        $data['notTime'][] = $userNameOrId;
        continue;
      }

      $validTime = $now - $time;

      switch ($validTime) {
        case self::ONE_DAY > $validTime:
          $data['oneDay'][] = $userNameOrId;
          break;
        case self::ONE_DAY < $validTime &&  self::TWO_DAY > $validTime:
          $data['twoDay'][] = $userNameOrId;
          break;
        case self::TWO_DAY < $validTime && self::THREE_DAY > $validTime:
          $data['threeDay'][] = $userNameOrId;
          break;
        case self::THREE_DAY < $validTime && self::ONE_WEEK > $validTime:
          $data['oneWeek'][] = $userNameOrId;
          break;
        case self::ONE_WEEK < $validTime && self::ONE_MONTH > $validTime:
          $data['oneMonth'][] = $userNameOrId;
          break;
        default:
          $data['moreOneMonth'][] = $userNameOrId;
      }
    }
    WorkingFileHelper::writeToFile($this->task, "Группа {$this->channel}\n\n");
    WorkingFileHelper::writeToFile($this->task, "Количество пользователей: {$this->countUsers}\n\n");
    foreach ($data as $key => $days) {
      WorkingFileHelper::writeToFile($this->task, "\n$key\n\n");
      foreach ($days as $item) {
        WorkingFileHelper::writeToFile($this->task, "$item\n");
      }
    }
  }

  private function solidSheet($item)
  {
    return array_search($item, $this->participants);
  }

  private function countAmountInteration(int $informationChannel)
  {
    $this->countCycles = ceil($informationChannel / self::OFFSET_LIMIT);
  }
}
