<?php

namespace App\Models;

class PhoneModel extends Model {

  protected $table = 'sessions';

  public function __construct()
  {
    return parent::__construct($this->table);
  }
}