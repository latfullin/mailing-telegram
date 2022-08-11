<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class ParcerExecute extends Execute
{
  private static ?ParcerExecute $instance = null;

  /**
   * @param MAX_USER max length data for re
   */
  const MAX_USER = 10000;

  /**
   * @param MAX_LENGTH max length array
   */
  const MAX_LENGTH = 50000;

  const CONSONANTS_LETTERS = ['Б', 'В', 'Г', 'Д', 'Ж', 'З', 'Й', 'К', 'Л', 'М', 'Н', 'П', 'Р', 'С', 'Т', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ'];

  const MALE_END_LETTERS = ['й', 'ь', 'а', 'я'];

  /**
   * @param ALPHABETS for cycles.
   */
  const ALPHABETS = [
    ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'],
    ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'э', 'ю', 'я']
  ];

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
   * not implemented
   */
  protected bool $divideGender = false;

  /**
   * need for user id, if not found username
   */
  protected bool $needUsersId;
  protected bool $needBreakTime;

  protected array $data = [];

  /**
   * @param now time unix format
   */
  protected int $now;

  /**
   * @param lengthArrayParticipants сounting the data array. Collected users from the channel.
   */
  protected int $lengthArrayParticipants = 0;

  /**
   * counts participants in channel, which the parse.
   */
  protected int $countParticipants;

  /**
   * @param saveData save results in file 
   */
  protected bool $saveData = false;

  private function __construct(bool $needUsersId, bool $needBreakTime)
  {
    parent::__construct();
    $this->needUsersId = $needUsersId;
    $this->needBreakTime = $needBreakTime;

    if ($this->needBreakTime) {
      $this->data = [
        'oneDay' => [],
        'twoDay' => [],
        'threeDay' => [],
        'oneWeek' => [],
        'oneMonth' => [],
        'moreOneMonth' => [],
        'notTime' => [],
      ];
    }
  }

  public static function instance(bool $needUsersId = true,  bool $needBreakTime = true): ParcerExecute
  {
    if (self::$instance === null) {
      self::$instance = new self($needUsersId, $needBreakTime);
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
    $this->countParticipants = $this->channelInformation['full_chat']['participants_count'];

    return $this;
  }

  public function executes(): bool
  {
    $this->checkChannelInformation();
    // if ($this->countParticipants < self::MAX_USER) {
    //   $this->collectParticipants($this->countParticipants);
    //   $this->usersProcessing();
    // } else {
    //   $this->bigChannel();
    // }
    $this->bigChannel();

    return true;
  }

  public function bigChannel()
  {
    $resetArray = 0;
    foreach (self::ALPHABETS as $alphabets) {
      if ($this->lengthArrayParticipants > $this->countParticipants * 0.98) {
        continue;
      }
      foreach ($alphabets as $alphabet) {
        $countsParticipants = min(Telegram::instance('79874018497')
          ->getParticipants($this->channel, 0, 1, q: $alphabet)['count'], self::MAX_USER);

        $this->collectParticipants($countsParticipants, $alphabet);

        if ($this->lengthArrayParticipants > self::MAX_LENGTH) {
          $this->writeTemporaryFile();
          $resetArray++;
        }
      }
    }

    if ($resetArray !== 0) {
      $this->writeTemporaryFile();
    }
  }

  public function collectParticipants(int $countUsers, $q = ''): bool
  {
    $result = [];
    $this->countAmountInteration($countUsers);

    for ($i = 0; $i < $this->countCycles; $i++) {
      $result[] = Telegram::instance('79874018497')
        ->getParticipants($this->channel, $i * self::OFFSET_LIMIT, q: $q)['users'];
    }

    for ($r = 0; $r < count($result); $r++) {
      for ($s = 0; $s < count($result[$r]); $s++) {
        if ($result[$r][$s]['username'] ?? false || $this->needUsersId) {
          $this->participants[$result[$r][$s]['id']] = $result[$r][$s];
        }
      }
    }

    $this->lengthArrayParticipants = count($this->participants);

    return true;
  }

  public function usersProcessing(): void
  {
    $this->now = time();

    foreach ($this->participants as $participant) {
      $time = $participant['status']['was_online'] ?? false;
      $userNameOrId = '';
      if ($participant['username'] ?? false) {
        $userNameOrId = '@' . $participant['username'];
      } else {
        if (!$this->needUsersId) {
          continue;
        }
        $userNameOrId = $participant['id'];
      }

      if ($this->needBreakTime) {
        $this->switchVariablesTime($userNameOrId, $time);
        continue;
      }

      $this->data[] = $userNameOrId;
    }
  }

  private function switchVariablesTime($userNameOrId, $time): void
  {
    if ($time === false) {
      $this->data['notTime'][] = $userNameOrId;
      return;
    }
    $validTime = $this->now - $time;
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

  public function writeTemporaryFile()
  {
    $handle = fopen("src/storage/temporary/{$this->task}-temporary.txt", 'a');
    foreach ($this->participants as $participant) {
      $id = '';
      if ($participant['username'] ?? false) {
        $id = $participant['username'];
      } else {
        $id = $participant['id'];
      }
      $time = $participant['status']['was_online'] ?? 'false';
      $name = $participant['first_name'];
      fwrite($handle, "{$id};{$time};{$name}\n");
    }
    $this->resetData();
    $this->lengthArrayParticipants = 0;

    fclose($handle);
  }

  public function extractData()
  {
    $handle = fopen("src/storage/temporary/385-temporary.txt", 'r');
    while (true) {
      $str = fgets($handle);
      if ($str) {
        $array = explode(';',  $str);
      }
    }
  }

  private function countAmountInteration(int $informationChannel): void
  {
    $this->countCycles = ceil($informationChannel / self::OFFSET_LIMIT);
  }

  private function saveToFile(): void
  {
    WorkingFileHelper::saveForFileTask($this->task, "Группа {$this->channel}\n\n");
    foreach ($this->data as $key => $items) {
      if (is_array($items)) {
        $lang = timeLang($key);
        WorkingFileHelper::saveForFileTask($this->task, "\n{$lang}\n\n");
        foreach ($items as $item) {
          WorkingFileHelper::saveForFileTask($this->task, "$item\n");
        }
        continue;
      }

      WorkingFileHelper::saveForFileTask($this->task, "$items\n");
    }
  }

  private function resetData(): void
  {
    $this->participants = [];
  }

  public function save(): bool
  {
    if ($this->data) {
      $this->saveToFile();
      $this->saveData = true;
    }

    return true;
  }

  public function __destruct()
  {
    if (!$this->saveData) {
      $this->saveToFile();
    }
  }

  public function setNeedUserId(bool $bool): ParcerExecute
  {
    $this->needUsersId = $bool;

    return $this;
  }

  private function checkChannelInformation()
  {
    try {
      if (!$this->channelInformation) {
        throw new Exception('Not information for channel');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie($e);
    }
  }
}
