<?php

namespace App\Helpers;

class Cache
{
  private static string $path = 'storage/cache';
  private static ?Cache $cache = null;

  private static function __consruct()
  {
    echo 'ds';
  }

  public static function remove(string $file): void
  {
    unlink(self::$path . "/$file.cache.txt");
  }

  public static function save(string $file, $data): void
  {
    file_put_contents(self::$path . "/{$file}.cache.txt", $data);
  }

  public static function unserialize(string $file): mixed
  {
    return unserialize(file_get_contents(self::$path . "/{$file}.cache.txt"));
  }

  public static function issetCache(string $file): bool
  {
    return is_file(self::$path . "/{$file}.cache.txt");
  }

  public static function serialize($file, $contents): void
  {
    if (is_object($contents)) {
      file_put_contents(self::$path . "/{$file}.cache.txt", serialize(get_object_vars($contents)));
    } else {
      file_put_contents(self::$path . "/{$file}.cache.txt", serialize($contents));
    }
  }
}
