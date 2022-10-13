<?php

namespace App\Helpers;

class Cache
{
  private static string $path = './../storage/cache';
  private static ?Cache $cache = null;

  protected function __construct()
  {
    self::$path = root('storage/cache');
  }

  public static function __callStatic($name, $arguments)
  {
    if (self::$cache == null) {
      self::$cache = new self();
    }
    if (in_array($name, \get_class_methods(__CLASS__))) {
      self::{$name}(...$arguments);
    }
  }

  protected static function remove(string $file): void
  {
    unlink(self::$path . "/$file.cache.txt");
  }

  protected static function save(string $file, $data): void
  {
    file_put_contents(self::$path . "/{$file}.cache.txt", $data);
  }

  protected static function unserialize(string $file): mixed
  {
    return unserialize(file_get_contents(self::$path . "/{$file}.cache.txt"));
  }

  protected static function issetCache(string $file): bool
  {
    return is_file(self::$path . "/{$file}.cache.txt");
  }

  protected static function serialize($file, $contents): void
  {
    if (is_object($contents)) {
      file_put_contents(self::$path . "/{$file}.cache.txt", serialize(get_object_vars($contents)));
    } else {
      file_put_contents(self::$path . "/{$file}.cache.txt", serialize($contents));
    }
  }
}
