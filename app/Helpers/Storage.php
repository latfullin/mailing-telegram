<?php

namespace App\Helpers;


class Storage
{
  protected string $disk;
  private array $path = [
    'temporary' => 'storage/temporary',
    'session' => 'storage/session',
    'photo' => 'storage/photoProfile',
    'task' => 'storage/task'
  ];

  private function __construct(string $disk)
  {
    $this->disk = "{$this->path[$disk]}";
  }

  /**
   * @param disk string - [task, session, temporary, photo].
   */
  public static function disk($disk)
  {
    return new self($disk);
  }

  /**
   * need formart file file.txt, file.csv..
   */
  public function isFile(string $file): bool
  {
    return is_file("{$this->disk}/{$file}");
  }

  /**
   * need fullname file file.txt
   */
  public function put(string $file, string|array $contents): void
  {
    if (is_array($contents)) {
      foreach ($contents as $content) {
        if (is_array($content)) {
          $this->put($file, $content);
        } else {
          file_put_contents("{$this->disk}/$file", "$content\n", FILE_APPEND);
        }
      }
    } else {
      file_put_contents("{$this->disk}/$file", "$contents\n", FILE_APPEND);
    }
    return;
  }

  public function getPath(string $file): string
  {
    if ($this->isFile($file)) {
      return "{$this->disk}/$file";
    }

    throw new \Exception('Not found file.');
  }
}
