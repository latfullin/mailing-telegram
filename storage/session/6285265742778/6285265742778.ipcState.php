<?php __HALT_COMPILER();O:32:"danog\MadelineProto\Ipc\IpcState":3:{s:45:" danog\MadelineProto\Ipc\IpcState startupTime";d:1665830945.398755;s:43:" danog\MadelineProto\Ipc\IpcState startupId";i:942931490;s:43:" danog\MadelineProto\Ipc\IpcState exception";O:35:"danog\MadelineProto\Ipc\ExitFailure":7:{s:41:" danog\MadelineProto\Ipc\ExitFailure type";s:37:"danog\MadelineProto\RPCErrorException";s:44:" danog\MadelineProto\Ipc\ExitFailure message";s:20:"USER_DEACTIVATED_BAN";s:41:" danog\MadelineProto\Ipc\ExitFailure code";i:401;s:42:" danog\MadelineProto\Ipc\ExitFailure trace";a:9:{i:0;a:6:{s:4:"file";s:99:"/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/MTProtoSession/ResponseHandler.php";s:4:"line";i:194;s:8:"function";s:14:"handleRpcError";s:5:"class";s:30:"danog\MadelineProto\Connection";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:51:"Object(danog\MadelineProto\MTProto\OutgoingMessage)";i:1;s:49:"Array(["rpc_error", 401, "USER_DEACTIVATED_BAN"])";}}i:1;a:6:{s:4:"file";s:99:"/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/MTProtoSession/ResponseHandler.php";s:4:"line";i:73;s:8:"function";s:14:"handleResponse";s:5:"class";s:30:"danog\MadelineProto\Connection";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:51:"Object(danog\MadelineProto\MTProto\IncomingMessage)";}}i:2;a:6:{s:4:"file";s:50:"/var/www/html/vendor/amphp/amp/lib/Loop/Driver.php";s:4:"line";i:119;s:8:"function";s:14:"handleMessages";s:5:"class";s:30:"danog\MadelineProto\Connection";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:4:""or"";i:1;s:4:"null";}}i:3;a:6:{s:4:"file";s:50:"/var/www/html/vendor/amphp/amp/lib/Loop/Driver.php";s:4:"line";i:72;s:8:"function";s:4:"tick";s:5:"class";s:15:"Amp\Loop\Driver";s:4:"type";s:2:"->";s:4:"args";a:0:{}}i:4;a:6:{s:4:"file";s:43:"/var/www/html/vendor/amphp/amp/lib/Loop.php";s:4:"line";i:95;s:8:"function";s:3:"run";s:5:"class";s:15:"Amp\Loop\Driver";s:4:"type";s:2:"->";s:4:"args";a:0:{}}i:5;a:6:{s:4:"file";s:74:"/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/Tools.php";s:4:"line";i:345;s:8:"function";s:3:"run";s:5:"class";s:8:"Amp\Loop";s:4:"type";s:2:"::";s:4:"args";a:1:{i:0;s:87:"Closure(/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/Tools.php:334)";}}i:6;a:6:{s:4:"file";s:89:"/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/Async/AsyncConstruct.php";s:4:"line";i:48;s:8:"function";s:4:"wait";s:5:"class";s:25:"danog\MadelineProto\Tools";s:4:"type";s:2:"::";s:4:"args";a:1:{i:0;s:37:"Object(danog\MadelineProto\Coroutine)";}}i:7;a:6:{s:4:"file";s:85:"/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/Ipc/Runner/entry.php";s:4:"line";i:105;s:8:"function";s:4:"init";s:5:"class";s:40:"danog\MadelineProto\Async\AsyncConstruct";s:4:"type";s:2:"->";s:4:"args";a:0:{}}i:8;a:4:{s:4:"file";s:85:"/var/www/html/vendor/danog/madelineproto/src/danog/MadelineProto/Ipc/Runner/entry.php";s:4:"line";i:134;s:8:"function";s:9:"{closure}";s:4:"args";a:0:{}}}s:44:" danog\MadelineProto\Ipc\ExitFailure tlTrace";s:985:"['updates.getDifference']
CallHandler.php(61):	methodCallAsyncRead("updates.getDifference",{"pts":74,"date":1665830925,"qts":-1},{"datacenter":5})
UpdateLoop.php(163):	methodCallAsyncRead("updates.getDifference",{"pts":74,"date":1665830925,"qts":-1},{"datacenter":5})
LoggerLoop.php(59): 	loop()
danog\MadelineProto\Loop\{closure}()
danog\MadelineProto\Loop\{closure}()

Previous TL trace:
['updates.getDifference']
ResponseHandler.php(194):	handleRpcError({},{"_":"rpc_error","error_code":401,"error_message":"USER_DEACTIVATED_BAN"})
ResponseHandler.php(73):	handleResponse({})
Driver.php(119):    	handleMessages("or",null)
Driver.php(72):     	tick()
Loop.php(95):       	run()
Tools.php(345):     	run({})
AsyncConstruct.php(48):	wait("To obtain a result from a Coroutine object, yield the result or disable async (not recommended). See https:\/\/docs.madelineproto.xyz\/docs\/ASYNC.html for more information on async.")
entry.php(105):     	init()
entry.php(134):     	{closure}()";s:45:" danog\MadelineProto\Ipc\ExitFailure previous";N;s:46:" danog\MadelineProto\Ipc\ExitFailure localized";s:20:"USER_DEACTIVATED_BAN";}}