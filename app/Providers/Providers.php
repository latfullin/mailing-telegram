<?php

namespace App\Providers;

use App\Routers\Router;

class Providers
{
  protected array $type = ['string', 'int', 'bool', 'array'];

  private function __construct($controller, string $function, $argumets = [])
  {
    try {
      $class = [];
      $reflection = new \ReflectionMethod($controller, $function);
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
    } catch (\Exception $e) {
      Router::notFound();
      die();
    }
  }

  private function getAddicted($class)
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

  private function chunkParams($argumets)
  {
    $data = [];
    foreach ($argumets as $key => $argumet) {
      if ($argumet) {
        if (is_array($argumet)) {
          foreach ($argumet as $key => $item) {
            $data[$key] = $item;
          }
        } else {
          $data[$key] = $argumet;
        }
      }
    }

    return $data;
  }

  public static function call($controller, string $function, $argumets = [])
  {
    new self($controller, $function, $argumets);
  }
}
