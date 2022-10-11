<?php

namespace App\Kernel;

use App\kernel as HttpKernel;
use App\Providers\Providers;
use App\Routers\Router;
use App\Services\Bot\TelegramBot;

class Kernel extends HttpKernel
{
  private array $router = ['router/api.php', 'router/web.php'];
  private ?string $type = null;
  private bool $notFound = false;

  public function __construct()
  {
    $this->basicService();
    $this->include();
  }

  public function app()
  {
    if (!$this->notFound) {
      Router::start($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    } else {
      $this->sendErrors();
    }
  }

  public function callServices()
  {
    $this->type = $this->getrequestMethod(strtok($_SERVER['REQUEST_URI'], '?'));
    if ($this->type === null) {
      foreach ([\App\Helpers\Sessions\Session::class, \App\Helpers\Sessions\Cookie::class] as $service) {
        $this->handle($service, 'handle');
      }
      $this->notFound = true;
      Router::notFound();
    } else {
      foreach ($this->services[$this->type] as $service) {
        if (is_string($service)) {
          $this->handle($service, 'handle');
        }
      }
    }
  }

  private function handle(string $class, string $function, array $data = []): void
  {
    Providers::call($class, $function, $data);
  }

  public function include(): void
  {
    foreach ($this->router as $router) {
      include_once root($router);
    }
  }

  private function getrequestMethod(string $url): ?string
  {
    return Router::getrequestMethod($url);
  }

  private function sendErrors()
  {
    $data = json_encode(debug_backtrace());
    $method = $_SERVER['REQUEST_METHOD'] ?? 'NO DATA';
    $path = $_SERVER['REQUEST_URI'] ?? 'NO PATH';
    TelegramBot::exceptionError("Error 404. Page: {$path}. Methods: {$method}. \nInformation: {$data}.");
  }

  private function basicService()
  {
    foreach ($this->basicServices as $service) {
      $this->handle($service, 'handle');
    }
  }
}
