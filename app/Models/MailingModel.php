<?php

namespace App\Models;

class MailingModel extends Model
{
  protected $table = "send_message_users";

  public function __construct()
  {
    parent::__construct($this->table);
  }
}
