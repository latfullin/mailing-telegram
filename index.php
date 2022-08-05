<?php
require_once 'vendor/autoload.php';

use App\Controllers\ChannelsController;
use App\Controllers\MailingMessagesController;

$a = MailingMessagesController::instance()->mailingMessagesUsers('Hello');
