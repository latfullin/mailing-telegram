<?php

namespace App\Helpers;
use Symfony\Component\Dotenv\Dotenv;

class Env
{
  private static ?Dotenv $dotenv = null;

  public function __construct()
  {
  }

  public function handle()
  {
    (new Dotenv())->load(root('.env'));
  }

  public static function get($key)
  {
    if (isset($_ENV[$key])) {
      return $_ENV[$key];
    }
    return null;
  }
}
