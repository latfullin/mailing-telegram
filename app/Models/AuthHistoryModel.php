<?php

namespace App\Models;

class AuthHistoryModel extends Model
{
  protected $table = 'auth_history';

  public function __construct()
  {
    return parent::__construct($this->table);
  }
}
