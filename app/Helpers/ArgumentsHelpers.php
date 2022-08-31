<?php

namespace App\Helpers;

class ArgumentsHelpers
{
  public function __construct(array $arguments = [])
  {
    if ($arguments) {
      foreach ($arguments as $key => $argumet) {
        $this->__set($key, $argumet);
      }
    }
  }

  public function __set($name, $value)
  {
    $this->{$name} = $value;
  }
}
