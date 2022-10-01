<?php

namespace App\Kernel;

use App\kernel as AppKernel;
use App\Providers\Providers;
use App\Routers\Router;

class Kernel extends AppKernel
{
  private array $router = ['/router/api.php', '/router/web.php'];
  public function __construct()
  {
  }

  public function app()
  {
    $this->include();
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

  public function include()
  {
    foreach ($this->router as $router) {
      include_once "{$_SERVER['DOCUMENT_ROOT']}{$router}";
    }
  }
}
