<?php

namespace App\Models;

use PDO;
use Carbon\Carbon;

class Model
{
  protected $connect;
  protected $table;
  protected mixed $where;
  protected $column = '*';
  protected static $intsances = [];

  public function __construct($table)
  {
    $dsn = 'mysql:dbname=telegram-bot;host=mysql';
    $user = 'kilkenny';
    $password = 'password';
    $this->table = $table;
    $this->connect = new PDO($dsn, $user, $password);
  }

  /**
   * @param column ['column' => 'value']
   */
  public function insert(array $values)
  {
    ['column' => $column, 'value' => $value] = $this->splitData($values);
    $this->connect->query("INSERT INTO {$this->table} ($column) VALUE ($value)");
  }

  public function delete(string $column, string $separator, string $value)
  {
    $separator = $separator == '' ? '=' : $separator;
    $this->connect->query("DELETE FROM {$this->table} WHERE {$column} {$separator} {$value}");
  }

  /**
   * @param update [colum => value]
   */
  public function update(string|array $sets)
  {
    $update = is_string($sets) ? $sets : '';
    if (is_array($sets)) {
      $length = count($sets);
      $i = 0;
      foreach ($sets as $key => $set) {
        $update .= $length == $i ? "$key = $set," : "$key = $set";
      }
    } else {
      return false;
    }

    $this->connect->query("UPDATE {$this->table} SET {$update} WHERE {$this->where}");
  }

  public function get(): array
  {
    return $this->connect->query("SELECT {$this->column} FROM {$this->table} WHERE {$this->where}")->fetchAll(PDO::FETCH_CLASS);
  }

  public function first()
  {
    return $this->connect->query("SELECT {$this->column} FROM {$this->table} WHERE {$this->where}")->fetch(PDO::FETCH_ASSOC);
  }

  public function where(array|string $where)
  {
    if (is_array($where)) {
      $this->where = '';
      foreach ($where as $key => $value) {
        $this->where .= "{$key} = {$value}";
      }
      return $this;
    }
    if (is_string($where)) {
      $this->where = $where;
      return $this;
    }

    return false;
  }

  protected function splitData(array $array)
  {
    $result = ['column' => '', 'value' => ''];
    $count = count($array) - 1;
    $i = 0;
    foreach ($array as $key => $item) {
      $result['value'] .= $count === $i ?  "$item" : "$item,";
      $result['column'] .= $count === $i ?  "$key" : "$key,";
      $i++;
    }

    return $result;
  }
}
