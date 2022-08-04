<?php

namespace App\Helpers;

use Exception;

class WorkingFileHelper
{
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
      if (is_file('usechannelsrs')) {
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
    $files = scandir('src/storage/task/');
    asort($files, SORT_NUMERIC);
    $file = array_pop($files);
    if ($file > 0) {

      return $file + 1;
    } else {

      return 1;
    }
  }

  public static function newTask(...$params): int
  {
    $lastTask = self::lastTask();
    foreach ($params as $item) {
      if (is_array($item)) {
        foreach ($item as $text) {
          self::writeToFile("src/storage/task/{$lastTask}", "$text\n");
        }
      } else {
        self::writeToFile("src/storage/task/{$lastTask}", "$item\n");
      }
      self::writeToFile("src/storage/task/{$lastTask}", "\n");
    }
    return $lastTask;
  }

  public static function endTask(int $task, int $success, int $error, array $users)
  {
    self::writeToFile("src/storage/task/{$task}", "\nENDTASK\n");
    self::writeToFile("src/storage/task/{$task}", "Success: {$success}\n");
    self::writeToFile("src/storage/task/{$task}", "AmoutErrors: {$error}\n");
    if (count($users) > 0) {
      self::writeToFile("src/storage/task/{$task}", "\nSkipUsers:\n");
      foreach ($users as $user) {
        self::writeToFile("src/storage/task/{$task}", "$user\n");
      }
    }
  }

  private static function writeToFile(string $filePath, string $text): void
  {
    file_put_contents($filePath, $text, FILE_APPEND);

    return;
  }
}
