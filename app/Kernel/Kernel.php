<?php

namespace App\Kernel;

use App\kernel as AppKernel;
use App\Providers\Providers;
use App\Routers\Router;

class Kernel extends AppKernel
{
  public function __construct()
  {
  }

  public function app()
  {
    include_once "{$_SERVER['DOCUMENT_ROOT']}/router/api.php";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/router/web.php";

    Router::start($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
  }

  public function callServices()
  {
    foreach ($this->services as $service) {
      if (is_string($service)) {
        $this->handle($service, 'handle');
      }
    }
  }

  private function handle(string $class, string $function, array $data = [])
  {
    Providers::call($class, $function, $data);
  }
}
