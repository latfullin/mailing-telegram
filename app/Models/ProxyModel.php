<?php

namespace App\Models;

class ProxyModel extends Model
{
  protected $table = "proxies";

  public function __construct()
  {
    return parent::__construct($this->table);
  }
}
