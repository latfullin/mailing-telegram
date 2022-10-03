<?php

namespace App\Models;

class MenuModel extends Model
{
  protected $table = 'menu';

  public function __construct()
  {
    return parent::__construct($this->table);
  }
}
