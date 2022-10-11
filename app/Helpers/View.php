<?php

namespace App\Helpers;

use Amp\Http\Status;

class View
{
  private string $layout;
  private string $page;
  private array $data;

  public function __construct(string $layout, array $data, $status = 200)
  {
    $this->layout = $layout;
    $this->data = $data;
    $this->data['session'] = $_SESSION;
    $this->status = $status;
  }

  public function __destruct()
  {
    $this->render();
  }

  public function page(string $page)
  {
    $this->page = $page == '/' ? 'home' : $page;
  }

  public function render()
  {
    http_response_code($this->status);

    include_once root("resources/components/layouts/{$this->layout}.php");
  }
}
