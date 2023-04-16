<?php

class Database
{
  private $host = "localhost", $username = "root", $password = "", $database = "library";
  private ?string $table, $where = '';
  private array $query = [];
  public $mysql, $affected_rows;

  /** connect to database */
  public function __construct()
  {
    // show error sql
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $this->mysql = new \mysqli($this->host, $this->username, $this->password, $this->database);
  }

  /**
   * setter table
   * @param string $table name table
   * @return Database this object
   */
  public function table(string $table): self
  {
    $this->table = $table;
    return $this;
  }


  /**
   * to run query
   * @param string $sql syntax sql
   * @param ?string $bind bind prepare
   * @param array ...$args spread operator argument
   */
  public function query($sql, $bind = null, ...$args)
  {
    // without bind
    if (is_null($args) || count($args) == 0) {
      return $this->mysql->query($sql);
    }

    $stmp = $this->mysql->prepare($sql);
    if (!is_null($bind) && !is_null($args)) {
      $stmp->bind_param($bind, ...$args);
    }
    $stmp->execute();
    $result = $stmp->get_result();
    $this->affected_rows = $stmp->affected_rows;
    $stmp->close();
    return $result;
  }

  /**
   * count record data database
   * @return ?int count recourd
   */
  public function num_rows(): ?int
  {
    $sql = "SELECT * FROM {$this->table} {$this->where}";
    return $this->query($sql)->num_rows;
  }

  /**
   * where for syntax sql
   * @param string $field field where
   * @param string $operator operator
   * @param mixed $value value
   */
  public function where($field, $operator, $value)
  {
    if (is_string($value))
      $val = (string)"$value";
    else
      $val = $value;
    $where = "WHERE {$field} {$operator} ";
    $where .= is_string($value) ? "'$value'" : $value;
    $this->where = $where;
    return $this;
  }

  /**
   * limit select data from database
   * @param int $limit lenght limit
   */
  public function limit(int $limit)
  {
    $this->query['limit'] = "LIMIT $limit";
    return $this;
  }

  /**
   * offset for start select data
   * @param int $offset start from
   */
  public function offset(int $offset)
  {
    $this->query['offset'] = "OFFSET $offset";
    return $this;
  }

  /** get list data */
  public function getList(?string $sql): ?object
  {
    if (is_null($sql)) {
      $limit = isset($this->query['limit']) ? $this->query['limit'] : '';
      $offset = isset($this->query['offset']) ? $this->query['offset'] : '';
      $rows = [];
      $sql = "SELECT * FROM {$this->table} {$this->where} {$limit} {$offset}";
    }
    $query = $this->query($sql);
    while ($row = $query->fetch_object())
      $rows[] = $row;
    return (object)$rows;
  }

  /** get one data */
  public function getOne($sql = null): ?object
  {
    if (!is_null($sql)) {
      return $this->query($sql)->fetch_object();
    }
    $sql = "SELECT * FROM {$this->table} {$this->where}";
    $result = $this->query($sql);
    return $result->fetch_object();
  }

  /**
   * insert into database
   *
   * @param string $field fields
   * @param ?string $bind bind
   * @param mixed ...$args arguments
   */
  public function insert(string $field, ?string $bind = null, ...$args)
  {
    $len = strlen($bind);
    $val = '';
    for ($i = 1; $i <= $len; $i++) {
      $val .= '?';
      if ($i != $len)
        $val .= ',';
    }
    $sql = "INSERT INTO {$this->table} ({$field}) VALUES ({$val})";
    try {
      $this->query($sql, $bind, ...$args);
    } catch (\Throwable $th) {
      var_dump($th->getMessage());
      die;
    }
    return $this->affected_rows;
  }

  /**
   * update data database
   *
   * @param array $field data
   * @param ?string $bind bind
   * @param ?int $id id
   */
  public function update(array $field, ?string $bind = null, ?int $id = null)
  {
    $set = "";
    $val = [];
    $len = sizeof($field);
    $i = 1;
    foreach ($field as $key => $value) {
      $val[$i - 1] = $value;
      $set .= "$key = ?";
      if ($len != $i++)
        $set .= ',';
    }
    $val[$len] = $id;
    $where = is_null($id) ? '' : 'WHERE id = ?';
    $sql = "UPDATE {$this->table} SET {$set} {$where}";
    try {
      $this->query($sql, $bind, ...$val);
    } catch (\Throwable $th) {
      var_dump($th->getMessage());
      die;
    }
    return $this->affected_rows;
  }

  /**
   * delete from database
   *
   * @param int $id id
   */
  public function destroy(int $id)
  {
    $sql = "DELETE FROM {$this->table} WHERE id = ?";
    try {
      $this->query($sql, 'i', $id);
    } catch (\Throwable $th) {
      var_dump($th->getMessage());
      die;
    }
    return $this->affected_rows;
  }
}
