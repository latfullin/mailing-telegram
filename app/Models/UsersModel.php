<?php

namespace App\Models;

class UsersModel extends Model
{
  protected $table = 'users';

  public function __construct()
  {
    return parent::__construct($this->table);
  }
}
