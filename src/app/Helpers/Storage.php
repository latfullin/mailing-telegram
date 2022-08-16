<?php

namespace App\Helpers;

class Storage
{
  protected string $disk;
  private array $path = [
    'temporary' => 'storage/temporary',
    'session' => 'storage/session',
    'temporary' => 'storage/photoProfile',
    'task' => 'storage/task'
  ];

  private function __construct(string $disk)
  {
    $this->disk = "src/{$this->path[$disk]}";
  }

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
}
