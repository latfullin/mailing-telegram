<?php

namespace App\Models;

class CheckItPhonesModel extends Model
{
  protected $table = 'check_it_phones';

  public function __construct()
  {
    parent::__construct($this->table);
  }
}
