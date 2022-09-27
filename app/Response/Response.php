<?php

namespace App\Response;

class Response
{
  public $response = null;
  public $header = 'Content-type: application/json';
  public $status = null;
  public function response(mixed $response, string $header = '', int $status = 200)
  {
    if ($header) {
      $this->header = $header;
    }
    if ($status) {
      $this->status = $status;
    }
    $this->response = $response;

    return $this;
  }

  public function header(array $header)
  {
    # code...
  }

  public function FunctionName()
  {
    return $this;
  }

  public function status(int $status)
  {
    $this->status = $status;

    return $this;
  }

  public function __destruct()
  {
    header($this->header);
    http_response_code($this->status);
    echo json_encode($this->response);
  }
}
