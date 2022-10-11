<?php

namespace App\Models;

use PDO;

class Model
{
  protected $connect;
  protected $table;
  protected $where = null;
  protected $or = null;
  protected $join = null;
  protected $order = null;
  protected mixed $limit = null;
  /**
   * @param column  ['column' => 'value']
   */
  protected $select = '*';
  protected $separators = ['=', '>', '<'];
  protected static $intsances = [];

  public function __construct(string $table)
  {
    $dsn = env('DB_CONNECT') . ':dbname=' . env('DOCKER_MYSQL_DATABASE') . ';host=' . env('DB_HOST');
    $user = env('DOCKER_MYSQL_USER');
    $password = env('DOCKER_MYSQL_PASSWORD');
    $this->table = $table;
    $this->connect = new PDO($dsn, $user, $password);
  }

  public function insert(array $values)
  {
    ['column' => $column, 'value' => $value] = $this->splitData($values);
    $this->connect->query("INSERT INTO {$this->table} ({$column}, `created_at`) VALUES ({$value}, now())");
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
        $update .= $length == $i ? "$key = '{$set}'," : "$key = '{$set}'";
      }
    } else {
      return false;
    }
    $this->connect->query("UPDATE {$this->table} SET {$update} WHERE {$this->where}");
  }

  public function get(): array
  {
    return $this->connect
      ->query(
        "SELECT {$this->select} FROM {$this->table}" .
          ($this->join !== null ? " {$this->join}" : '') .
          ($this->where !== null ? " WHERE {$this->where}" : '') .
          ($this->or !== null ? " OR {$this->or}" : '') .
          ($this->limit !== null ? " LIMIT {$this->limit}" : '') .
          ($this->order !== null ? " {$this->order}" : ''),
      )
      ->fetchAll(PDO::FETCH_CLASS);
  }

  public function first()
  {
    return $this->connect
      ->query(
        "SELECT {$this->select} FROM {$this->table}" .
          ($this->join !== null ? " {$this->join}" : '') .
          ($this->where !== null ? " WHERE {$this->where}" : '') .
          ($this->or !== null ? " OR {$this->or}" : '') .
          ($this->limit !== null ? " LIMIT {$this->limit}" : '') .
          ($this->order !== null ? " {$this->order}" : ''),
      )
      ->fetch(\PDO::FETCH_ASSOC);
  }

  public function last($colum = 'id')
  {
    return $this->connect
      ->query(
        "SELECT {$this->select} FROM {$this->table}" .
          ($this->join !== null ? " {$this->join}" : '') .
          ($this->where !== null ? " WHERE {$this->where}" : '') .
          ($this->or !== null ? " OR {$this->or}" : '') .
          ($this->limit !== null ? " LIMIT {$this->limit}" : '') .
          ($this->order !== null ? " {$this->order}" : " ORDER BY `{$colum}` DESC"),
      )
      ->fetch(\PDO::FETCH_ASSOC);
  }

  public function join(array $join): object
  {
    $this->join = null;
    if (is_array($join)) {
      foreach ($join as $key => $item) {
        $this->join = " JOIN {$key} ON {$item[0]} {$item[1]} {$item[2]}";
      }
    }

    return $this;
  }

  /**
   * @param limit Type int - 1,2,3,4....; Type array from - before [0, 10];
   */
  public function limit(int|array $limit)
  {
    $this->limit = '';
    if (is_int($limit)) {
      $this->limit = $limit;
    }
    if (is_array($limit)) {
      $count = count($limit) - 1;
      foreach ($limit as $key => $int) {
        $this->limit .= $key == $count ? $int : $int . ',';
      }
    }

    return $this;
  }

  public function where(array|string $where)
  {
    if (is_array($where)) {
      $this->where = $this->splitWhere($where);
      return $this;
    }
    if (is_string($where)) {
      $this->where = $where;
      return $this;
    }
    return false;
  }

  public function orWhere(array $or)
  {
    $this->or = $this->splitWhere($or);

    return $this;
  }

  protected function splitData(array $array)
  {
    $result = ['column' => '', 'value' => ''];
    $count = count($array) - 1;
    $i = 0;
    foreach ($array as $key => $item) {
      $result['column'] .= $count === $i ? "`{$key}`" : "`{$key}`,";
      $result['value'] .= $count === $i ? "'{$item}'" : "'{$item}',";
      $i++;
    }

    return $result;
  }

  protected function splitWhere(array $array)
  {
    $i = 0;
    $count = count($array) - 1;
    $result = '';
    foreach ($array as $key => $value) {
      if ($i === 0) {
        if (is_array($value)) {
          $result .=
            $count === $i
              ? "(`{$key}` = '{$value[0]}' OR `{$key}` = '{$value[1]}')"
              : "(`{$key}` = '{$value[0]}' OR `{$key}` = '{$value[1]}') ";
        } else {
          $result .= $count === $i ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}' ";
        }
      } else {
        if (is_array($value)) {
          $result .=
            $count === $i
              ? "AND (`{$key}` = '{$value[0]}' OR `{$key}` = '{$value[1]}') "
              : "AND (`{$key}` = '{$value[0]}' OR `{$key}` = '{$value[1]}') ";
        } else {
          $result .= $count === $i ? "AND `{$key}` = '{$value}'" : "AND `{$key}` = '{$value}', ";
        }
      }
      $i++;
    }

    return $result;
  }

  public function orderBy(string $colum)
  {
    $this->order = "ORDER BY `{$colum}` ASC";

    return $this;
  }

  public function orderByDesc(string $colum)
  {
    $this->order = "ORDER BY `{$colum}` DESC";

    return $this;
  }
}
