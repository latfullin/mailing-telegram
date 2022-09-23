<?php

namespace App\Providers;

use ReflectionMethod;

class Providers
{
  protected array $type = ['string', 'int', 'bool', 'array'];

  public function __construct($controller, string $function, $argumets = [])
  {
    $class = [];
    $reflection = new ReflectionMethod($controller, $function);
    foreach ($reflection->getParameters() as $param) {
      $nameClass = $param->getType()->getName();
      if ($nameClass == 'App\Helpers\ArgumentsHelpers') {
        $argumets = $argumets ? $this->chunkParams($argumets) : [];
        $class[] = new $nameClass($argumets ?? []);
      } else {
        $class[] = $this->getAddicted($nameClass);
      }
    }

    $reflection->invokeArgs(new $controller(), $class);
  }

  public function getAddicted($class)
  {
    $argumets = [];
    $reflection = new \ReflectionClass($class);
    $construct = $reflection->getConstructor();
    foreach ($construct->getParameters() as $key => $param) {
      $className = $param->getType()?->getName() ?? false;
      if (!$param->isDefaultValueAvailable()) {
        $argumets[] = new $className();
      }
    }
    return $reflection->newInstanceArgs($argumets);
  }

  public function chunkParams($argumets)
  {
    $data = [];
    foreach ($argumets as $argumet) {
      if ($argumet) {
        foreach ($argumet as $key => $item) {
          $data[$key] = $item;
        }
      }
    }

    return $data;
  }
}
