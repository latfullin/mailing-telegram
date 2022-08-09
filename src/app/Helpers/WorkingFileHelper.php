<?php

namespace App\Helpers;

use Exception;

class WorkingFileHelper
{
  private static $pathTask = 'src/storage/task/';
  private static $pathSession;

  public static function initSessionList()
  {
    try {
      if (is_file('phone')) {
        return self::readFile('phone');
      } else {
        throw new Exception("Not fount file - phone!");
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFile("$e\n");
    }
  }

  public static function initcheckSession()
  {
    try {
      if (is_file('phone')) {
        return self::readFile('phoneForCheck');
      } else {
        throw new Exception("Not fount file - phoneForCheck!");
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFile("$e\n");
    }
  }

  public static function initUsersList()
  {
    try {
      if (is_file('users')) {
        return self::readFile('users');
      } else {
        throw new Exception("Not fount file - users!");
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFile("$e\n");
    }
  }

  public static function initChannelsList()
  {
    try {
      if (is_file('channels')) {
        return self::readFile('channels');
      } else {
        throw new Exception("Not fount file - channels!");
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFile("$e\n");
    }
  }

  public static function readFile($fileName): array
  {
    $data =  explode("\n", file_get_contents($fileName));
    return array_filter($data, function ($line) {
      return !empty($line);
    });
  }

  public static function lastTask(): int
  {
    $files = scandir(self::$pathTask);
    asort($files, SORT_NUMERIC);
    $file = array_pop($files);
    if ($file > 0) {
      return $file + 1;
    } else {
      return 1;
    }
  }

  public static function newTask(int $task, ...$params): void
  {
    foreach ($params as $item) {
      if (is_array($item)) {
        foreach ($item as $text) {
          self::writeToFile(self::$pathTask . $task, "$text\n");
        }
      } else {
        self::writeToFile(self::$pathTask . $task, "$item\n");
      }
      self::writeToFile(self::$pathTask . $task, "\n");
    }
  }

  public static function endTask(int $task, int $success, int $error, array $users): void
  {
    self::writeToFile(self::$pathTask . $task, "\nENDTASK\n");
    self::writeToFile(self::$pathTask . $task, "Success: {$success}\n");
    self::writeToFile(self::$pathTask . $task, "AmoutErrors: {$error}\n");
    if (count($users) > 0) {
      self::writeToFile(self::$pathTask . $task, "\nSkipUsers:\n");
      foreach ($users as $user) {
        self::writeToFile(self::$pathTask . $task, "$user\n");
      }
    }
  }

  public static function saveForFileTask(int $task, string $text): void
  {
    self::writeToFile(self::$pathTask . "{$task}.txt", $text);
  }

  private static function writeToFile(string $filePath, string $text): void
  {
    file_put_contents($filePath, $text, FILE_APPEND);

    return;
  }
}
