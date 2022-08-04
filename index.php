<?php
require_once 'vendor/autoload.php';

use App\Controllers\MailingMessagesController;

MailingMessagesController::instance()->mailingMessagesUsers('hello');
