<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\Storage;
use App\Services\Authorization\Telegram;

class ParserExecute extends Execute
{
  private static ?ParserExecute $instance = null;

  /**
   * @param MAX_USER max length data for re
   */
  const MAX_USER = 10000;

  /**
   * @param MAX_LENGTH max length array
   */
  const MAX_LENGTH = 80000;

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

  public function __construct(bool $needUsersId = false, bool $needBreakTime = true)
  {
    parent::__construct();
    $this->needUsersId = $needUsersId;
    $this->needBreakTime = $needBreakTime;
    $this->now = time();

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

  // public static function instance(bool $needUsersId = true,  bool $needBreakTime = true): ParserExecute
  // {
  //   if (self::$instance === null) {
  //     self::$instance = new self($needUsersId, $needBreakTime);
  //   }
  //   return self::$instance;
  // }

  public function channel(string $channel): ParserExecute
  {
    if ($this->participants) {
      $this->resetData();
    }
    $this->channel = $channel;
    $this->channelInformation = $this->verifyChannel($channel);
    $this->countParticipants = $this->channelInformation['full_chat']['participants_count'];
    return $this;
  }

  public function executes(): object
  {
    $this->checkChannelInformation();
    if ($this->countParticipants < self::MAX_USER) {
      $this->collectParticipants($this->countParticipants);
    } else {
      $this->bigChannel();
    }

    if (is_file("storage/temporary/{$this->task}-temporary.txt")) {
      $this->extractData();
    }
    if ($this->participants) {
      $this->usersProcessing();
    }

    return $this;
  }

  private function bigChannel()
  {
    $resetArray = 0;
    foreach (self::ALPHABETS as $alphabets) {
      if ($this->lengthArrayParticipants > $this->countParticipants * 0.98) {
        break;
      }
      foreach ($alphabets as $alphabet) {
        echo $alphabet;
        $countsParticipants = min(Telegram::instance('79274271401')
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

  public function collectParticipants(int $countUsers, string $q = ''): bool
  {
    $result = [];
    $this->countAmountInteration($countUsers);

    for ($i = 0; $i < $this->countCycles; $i++) {
      $result[] = Telegram::instance('79274271401')
        ->getParticipants($this->channel, $i * self::OFFSET_LIMIT, q: $q)['users'];
    }

    $this->treatmentResult($result);
    $this->lengthArrayParticipants = count($this->participants);

    return true;
  }

  public function treatmentResult(array $result)
  {
    for ($r = 0; $r < count($result); $r++) {
      for ($s = 0; $s < count($result[$r]); $s++) {
        $user['id'] = $result[$r][$s]['id'];

        if ($result[$r][$s]['status']['userStatusOnline'] ?? false) {
          $user['time'] = $this->now;
        } else {
          $user['time'] = $result[$r][$s]['status']['was_online'] ?? false;
        }

        if ($result[$r][$s]['username'] ?? false) {
          $user['username'] = '@' . $result[$r][$s]['username'];
          [
            'id' => $this->participants[$result[$r][$s]['id']]['id'],
            'time' => $this->participants[$result[$r][$s]['id']]['time'],
            'username' => $this->participants[$result[$r][$s]['id']]['username'],
          ] = $user;

          continue;
        }

        if ($this->needUsersId) {
          $user['username'] = $result[$r][$s]['id'];
          [
            'id' => $this->participants[$result[$r][$s]['id']]['id'],
            'time' => $this->participants[$result[$r][$s]['id']]['time'],
            'username' => $this->participants[$result[$r][$s]['id']]['username'],
          ] = $user;
        }
      }
    }
  }

  public function usersProcessing(): object
  {
    foreach ($this->participants as $participant) {
      if ($this->needBreakTime) {
        $this->switchVariablesTime($participant['id'], $participant['time'], $participant['username']);
        continue;
      }

      $this->data[] = $participant['username'];
    }

    return $this;
  }

  public function switchVariablesTime(mixed $userNameOrId, int|bool $time, mixed $username): void
  {
    if ($time == false) {
      $this->data['notTime'][$userNameOrId] = $username;
      return;
    }
    $validTime = $this->now - $time;

    switch ($validTime) {
      case self::ONE_DAY > $validTime:
        $this->data['oneDay'][$userNameOrId] = $username;
        break;
      case self::ONE_DAY < $validTime &&  self::TWO_DAY > $validTime:
        $this->data['twoDay'][$userNameOrId] = $username;
        break;
      case self::TWO_DAY < $validTime && self::THREE_DAY > $validTime:
        $this->data['threeDay'][$userNameOrId] = $username;
        break;
      case self::THREE_DAY < $validTime && self::ONE_WEEK > $validTime:
        $this->data['oneWeek'][$userNameOrId] = $username;
        break;
      case self::ONE_WEEK < $validTime && self::ONE_MONTH > $validTime:
        $this->data['oneMonth'][$userNameOrId] = $username;
        break;
      default:
        $this->data['moreOneMonth'][$userNameOrId] = $username;
    }
  }

  private function writeTemporaryFile()
  {
    $handle = fopen("storage/temporary/{$this->task}-temporary.txt", 'a');
    foreach ($this->participants as $participant) {
      $id = $participant['id'];
      $username = $participant['username'] ?? '';
      $time = $participant['time'] ?? '';
      $name = $participant['first_name'] ?? '';

      fwrite($handle, "{$id};{$username};{$time};{$name}\n");
    }
    $this->resetData();
    $this->lengthArrayParticipants = 0;

    fclose($handle);
  }

  private function extractData()
  {
    $handle = fopen("storage/temporary/{$this->task}-temporary.txt", 'r');
    while ($str = fgets($handle)) {
      $array = explode(';',  $str);
      if ($this->needBreakTime) {
        $time = $array[2] == '' ? false : $array[2];
        $username = $array[1] == '' ? $array[0] : $array[1];
        $this->switchVariablesTime($array[0], $time, $username);
        continue;
      }
      $this->data[$array[0]] = $array[1] === '' ? $array[0] : $array[1];
    }

    fclose($handle);
  }

  private function countAmountInteration(int $informationChannel): void
  {
    $this->countCycles = ceil($informationChannel / self::OFFSET_LIMIT);
  }

  /**
   * @return string path before file
   */
  public function save(): string
  {
    $disk = Storage::disk('task');
    if ($this->channel ?? false) {
      $disk->put($this->task, "Группа {$this->channel}\n\n");
    }
    foreach ($this->data as $key => $items) {
      if (is_array($items)) {
        $lang = timeLang($key);
        $disk->put($this->task, "\n{$lang}\n");
        foreach ($items as $item) {
          $disk->put($this->task, "$item");
        }
        continue;
      }
      $disk->put($this->task, "$items");
    }

    return  $disk->getPath("{$this->task}");
  }

  public function resetData(): void
  {
    $this->participants = [];
  }

  public function setNeedUserId(bool $bool): ParserExecute
  {
    $this->needUsersId = $bool;

    return $this;
  }

  private function checkChannelInformation()
  {
    try {
      if (!$this->channelInformation) {
        throw new \Exception('Not information for channel');
      }
    } catch (\Exception $e) {
      ErrorHelper::writeToFileAndDie($e);
    }
  }
}
