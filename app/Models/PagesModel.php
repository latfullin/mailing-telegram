<?php

namespace App\Models;

class PagesModel extends Model
{
  protected $table = "pages";

  public function __construct()
  {
    parent::__construct($this->table);
  }
}
