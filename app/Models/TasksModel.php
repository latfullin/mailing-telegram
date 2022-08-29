<?php

namespace App\Models;

use PDO;

class TasksModel extends Model
{

  protected $table = 'tasks';

  public function __construct()
  {
    return parent::__construct($this->table);
  }

  public function getLastTask()
  {
    return $this->connect->query("SELECT * FROM {$this->table} ORDER BY `task` DESC")->fetch(PDO::FETCH_ASSOC);
  }
}
