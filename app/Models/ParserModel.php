<?php

namespace App\Models;

class ParserModel extends Model
{
  protected $table = "parser_group";

  public function __construct()
  {
    parent::__construct($this->table);
  }
}
