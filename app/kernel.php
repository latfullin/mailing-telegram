<?php

use App\Controllers\ViewController;
use App\Helpers\LangHelper;
use App\Helpers\View;

require_once __DIR__ . '/../vendor/autoload.php';
function timeLang($type)
{
  return LangHelper::init($type);
}

function view(string $page, array $data = [])
{
  return new View($page, $data);
}

include_once "{$_SERVER['DOCUMENT_ROOT']}/router/api.php";
include_once "{$_SERVER['DOCUMENT_ROOT']}/router/web.php";

view('default');

// Router::start($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

// register_shutdown_function(function () {
//   shell_exec("ps -ef | grep 'MadelineProto' | grep -v grep | awk '{print $2}' | xargs -r kill -9");
// });
