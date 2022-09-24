<?php

namespace App\Helpers;

class View
{
  private string $layout;
  private string $page;
  private array $data;
  public function __construct(string $layout, array $data)
  {
    $this->layout = $layout;
    $this->data = $data;
  }

  public function __destruct()
  {
    $this->render();
  }

  public function page(string $page)
  {
    $this->page = $page;
  }

  public function render()
  {
    include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/layouts/{$this->layout}.php";
  }
}
