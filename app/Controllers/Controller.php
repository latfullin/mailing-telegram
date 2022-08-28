<?php

namespace App\Controllers;

use ReflectionMethod;

class Controller {
  public function __construct($controller, string $funciton, $argumets = [])
  {
    $arg = [];

    if($argumets) {
      foreach($argumets as $key => $argumet) {
        $this->__set($key, $argumet);
      }
      $arg[] = $this;
    }

    $reflection = new ReflectionMethod($controller, $funciton);
    foreach($reflection->getParameters() as $param) {
      if($param->getType()?->getName() ?? false) {
        $nameClass = $param->getType()->getName();

        $arg[] = new $nameClass;
      }
    }

    $reflection->invokeArgs(new $controller, $arg);
  }


  public function __set($name, $value)
  {
    $this->{$name} = $value;
  }
}