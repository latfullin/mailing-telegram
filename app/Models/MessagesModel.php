<?php

namespace App\Models;

class MessagesModel extends Model
{
  protected $table = "messages";

  public function __construct()
  {
    return parent::__construct($this->table);
  }
}
