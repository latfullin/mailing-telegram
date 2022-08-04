<?php
require_once 'vendor/autoload.php';

use App\Controllers\MailingMessagesController;

MailingMessagesController::init()->mailingMessagesUsers('hello');
