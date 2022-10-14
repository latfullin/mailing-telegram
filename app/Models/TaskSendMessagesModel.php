<?php

namespace App\Models;

class TaskSendMessagesModel extends Model
{
  protected $table = 'task_send_messages';

  public function __construct()
  {
    parent::__construct($this->table);
  }
}
