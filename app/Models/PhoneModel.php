<?php

namespace App\Models;

class PhoneModel extends Model
{
  protected $table = "sessions";

  public function __construct()
  {
    return parent::__construct($this->table);
  }

  public function increment(string $phone, string $column)
  {
    return $this->connect->query(
      "UPDATE {$this->table} SET {$column} = {$column} + 1 WHERE phone = {$phone}"
    );
  }

  public function sessionList($column = "count_action", int $limit = 10)
  {
    return $this->connect
      ->query(
        "SELECT * FROM {$this->table}  WHERE ban = 0 AND '{$column}' < {$limit} ORDER BY '{$column}'" .
          ($this->limit !== null ? "LIMIT {$this->limit}" : "")
      )
      ->fetchAll(\PDO::FETCH_CLASS);
  }

  public function getAll()
  {
    return $this->connect
      ->query("SELECT * FROM {$this->table}  WHERE ban = 0")
      ->fetchAll(\PDO::FETCH_CLASS);
  }
}
