<?php

namespace App\Helpers;

class ErrorHelper
{
  public static function writeToFileAndDie($e)
  {
    file_put_contents('ExceptionLog.log', $e, FILE_APPEND);

    print_r($e);
    die();
  }

  public static function writeToFile($e)
  {
    file_put_contents('ExceptionLog.log', $e, FILE_APPEND);
    echo $e;
  }
}

// private chat
// danog\MadelineProto\Exception Object
// (
//     [message:protected] => You have not joined this chat
//     [string:Exception:private] => 
//     [code:protected] => 0
//     [file:protected] => /home/timur/www/telegram-mailing-list/vendor/danog/madelineproto/src/danog/MadelineProto/Ipc/ExitFailure.php
//     [line:protected] => 55
//     [trace:Exception:private] => Array


// ban per flood
// print_r(explode('_', $e->getMessage())); ===== (
//     [0] => FLOOD
//     [1] => WAIT
//     [2] => 4424
// )

// danog\MadelineProto\RPCErrorException Object
// (
//     [rpc] => FLOOD_WAIT_9874
//     [fetched:danog\MadelineProto\RPCErrorException:private] => 
//     [caller:danog\MadelineProto\RPCErrorException:private] => 
//     [message:protected] => FLOOD_WAIT_9874
//     [string:Exception:private] => 
//     [code:protected] => 420
//     [file:protected] => /home/timur/www/telegram-mailing-list/vendor/danog/madelineproto/src/danog/MadelineProto/Ipc/ExitFailure.php
//     [line:protected] => 55
//     [trace:Exception:private] => Array
//         (
//             [0] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/danog/madelineproto/src/danog/MadelineProto/Ipc/ClientAbstract.php
//                     [line] => 106
//                     [function] => getException
//                     [class] => danog\MadelineProto\Ipc\ExitFailure
//                     [type] => ->
//                 )

//             [1] => Array
//                 (
//                     [function] => loopInternal
//                     [class] => danog\MadelineProto\Ipc\ClientAbstract
//                     [type] => ->
//                 )

//             [2] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/danog/madelineproto/src/danog/MadelineProto/Coroutine.php
//                     [line] => 112
//                     [function] => send
//                     [class] => Generator
//                     [type] => ->
//                 )

//             [3] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Internal/Placeholder.php
//                     [line] => 149
//                     [function] => danog\MadelineProto\{closure}
//                     [class] => danog\MadelineProto\Coroutine
//                     [type] => ->
//                 )

//             [4] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Coroutine.php
//                     [line] => 123
//                     [function] => resolve
//                     [class] => Amp\Coroutine
//                     [type] => ->
//                 )

//             [5] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Internal/Placeholder.php
//                     [line] => 149
//                     [function] => Amp\{closure}
//                     [class] => Amp\Coroutine
//                     [type] => ->
//                 )

//             [6] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Coroutine.php
//                     [line] => 123
//                     [function] => resolve
//                     [class] => Amp\Coroutine
//                     [type] => ->
//                 )

//             [7] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Internal/Placeholder.php
//                     [line] => 149
//                     [function] => Amp\{closure}
//                     [class] => Amp\Coroutine
//                     [type] => ->
//                 )

//             [8] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Deferred.php
//                     [line] => 53
//                     [function] => resolve
//                     [class] => Amp\Promise@anonymous/home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Deferred.php:22$12b
//                     [type] => ->
//                 )

//             [9] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/byte-stream/lib/ResourceInputStream.php
//                     [line] => 101
//                     [function] => resolve
//                     [class] => Amp\Deferred
//                     [type] => ->
//                 )

//             [10] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Loop/NativeDriver.php
//                     [line] => 327
//                     [function] => Amp\ByteStream\{closure}
//                     [class] => Amp\ByteStream\ResourceInputStream
//                     [type] => ::
//                 )

//             [11] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Loop/NativeDriver.php
//                     [line] => 127
//                     [function] => selectStreams
//                     [class] => Amp\Loop\NativeDriver
//                     [type] => ->
//                 )

//             [12] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Loop/Driver.php
//                     [line] => 138
//                     [function] => dispatch
//                     [class] => Amp\Loop\NativeDriver
//                     [type] => ->
//                 )

//             [13] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Loop/Driver.php
//                     [line] => 72
//                     [function] => tick
//                     [class] => Amp\Loop\Driver
//                     [type] => ->
//                 )

//             [14] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/amphp/amp/lib/Loop.php
//                     [line] => 95
//                     [function] => run
//                     [class] => Amp\Loop\Driver
//                     [type] => ->
//                 )

//             [15] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/danog/madelineproto/src/danog/MadelineProto/Tools.php
//                     [line] => 294
//                     [function] => run
//                     [class] => Amp\Loop
//                     [type] => ::
//                 )

//             [16] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/vendor/danog/madelineproto/src/danog/MadelineProto/AbstractAPIFactory.php
//                     [line] => 139
//                     [function] => wait
//                     [class] => danog\MadelineProto\Tools
//                     [type] => ::
//                 )

//             [17] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/src/app/Traits/Channels/ChannelsMethodsTelegram.php
//                     [line] => 55
//                     [function] => __call
//                     [class] => danog\MadelineProto\AbstractAPIFactory
//                     [type] => ->
//                 )

//             [18] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/src/app/Services/Executes/Execute.php
//                     [line] => 117
//                     [function] => getChannel
//                     [class] => App\Services\Authorization\Telegram
//                     [type] => ->
//                 )

//             [19] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/src/app/Services/Executes/InvitationsChannelExecute.php
//                     [line] => 82
//                     [function] => verifyChannel
//                     [class] => App\Services\Executes\Execute
//                     [type] => ->
//                 )

//             [20] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/src/app/Services/Executes/InvitationsChannelExecute.php
//                     [line] => 70
//                     [function] => joinsChannel
//                     [class] => App\Services\Executes\InvitationsChannelExecute
//                     [type] => ->
//                 )

//             [21] => Array
//                 (
//                     [file] => /home/timur/www/telegram-mailing-list/index.php
//                     [line] => 11
//                     [function] => execute
//                     [class] => App\Services\Executes\InvitationsChannelExecute
//                     [type] => ->
//                 )

//         )

//     [previous:Exception:private] => 
//     [tlTrace] => 
// Client.php(249):        __call("methodCallAsyncRead",["channels.getFullChannel",{"channel":"https:\/\/t.me\/sa12dasdas"},{"apifactory":true}])
// AbstractAPIFactory.php(195):    methodCallAsyncRead("channels.getFullChannel",{"channel":"https:\/\/t.me\/sa12dasdas"},{"apifactory":true})
// __call_async()