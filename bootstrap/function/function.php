<?php

use App\Helpers\Env;
use App\Helpers\LangHelper;
use App\Helpers\Sessions\Session;
use App\Helpers\View;
use App\Response\Response;
use Symfony\Component\Dotenv\Dotenv;

function env($key)
{
  return Env::get($key);
}

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

function session()
{
  return Session::intance();
}

function root($path = ''): string
{
  return $path ? "{$_SERVER['DOCUMENT_ROOT']}/$path" : $_SERVER['DOCUMENT_ROOT'];
}
