<?php

use App\Helpers\LangHelper;
use App\Helpers\View;
use App\Middleware\Middleware;
use App\Response\Response;
use App\Routers\Router;

function timeLang($type)
{
  return LangHelper::init($type);
}

function view(string $page, array $data = [], $status = 200)
{
  return new View($page, $data, $status);
}

function response(mixed $data, array $header = [], int $status = 200)
{
  $response = new Response();
  $response->response($data, $header, $status);
  return $response;
}