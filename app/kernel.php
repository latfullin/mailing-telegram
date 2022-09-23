<?php

use App\Helpers\LangHelper;
use App\Routers\Router;

require_once __DIR__ . "/../vendor/autoload.php";
function timeLang($type)
{
  return LangHelper::init($type);
}
include_once "{$_SERVER["DOCUMENT_ROOT"]}/router/api.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/router/web.php";

Router::start($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);

// register_shutdown_function(function () {
//   shell_exec("ps -ef | grep 'MadelineProto' | grep -v grep | awk '{print $2}' | xargs -r kill -9");
// });
