<?php

namespace App\Response;

class Response
{
  public $response = null;
  public $headers = ['Content-type: application/json'];
  public $status = null;
  public function response(mixed $response, array $header = [], int $status = 200)
  {
    if ($header) {
      $this->headers[] = $header;
    }
    if ($status) {
      $this->status = $status;
    }
    $this->response = $response;

    return $this;
  }

  public function header($header)
  {
    $this->headers[] = $header;

    return $this;
  }

  public function redirect(string $path): Response
  {
    $this->headers[] = "Location: $path";

    return $this;
  }

  public function status(int $status)
  {
    $this->status = $status;

    return $this;
  }

  public function __destruct()
  {
    foreach ($this->headers as $header) {
      header($header);
    }
    http_response_code($this->status);
    echo json_encode($this->response);
  }
}
