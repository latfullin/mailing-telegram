<?php

use App\Helpers\LangHelper;

require_once 'vendor/autoload.php';


function timeLang($type)
{
  return LangHelper::init($type);
}

register_shutdown_function(function () {
  shell_exec("ps -ef | grep 'MadelineProto' | grep -v grep | awk '{print $2}' | xargs -r kill -9");
});
