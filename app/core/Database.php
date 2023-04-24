<?php

require_once __DIR__ . "/../../env.php";

class Database
{
  /** data connection variable */
  private $host = DB_HOST, $username = DB_USERNAME, $password = DB_PASSWORD, $database = DB_NAME;
  private $table, $where = '';
  private array $query = [];
  /** instance mysql  */
  public $mysql;
  /** affected result query */
  public $affected_rows;

  /** connect to database */
  public function __construct()
  {
    $this->mysql = new \mysqli($this->host, $this->username, $this->password, $this->database);
  }

  /**
   * setter table
   *
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
   *
   * @param string $sql syntax sql
   * @param ?string $bind bind prepare
   * @param array ...$args spread operator argument
   */
  public function query($sql, $bind = null, ...$args)
  {
    // if not set arguments
    if (is_null($args) || count($args) == 0) {
      // then run directly sql
      return $this->mysql->query($sql);
    }

    // prepare SQL query
    $stmp = $this->mysql->prepare($sql);

    if (!is_null($bind) && !is_null($args)) {
      // bind param
      $stmp->bind_param($bind, ...$args);
    }
    // execute query
    $stmp->execute();
    // get result
    $result = $stmp->get_result();
    // and set field affected_rows with result query
    $this->affected_rows = $stmp->affected_rows;
    // close prepare SQL
    $stmp->close();
    return $result;
  }

  /**
   * count record data database
   * @return ?int count
   * @TODO: intended of num_rows use COUNT by database
   */
  public function num_rows(): ?int
  {
    $sql = "SELECT * FROM {$this->table} {$this->where}";
    // count data in sql
    return $this->query($sql)->num_rows;
  }

  /**
   * where for syntax sql
   *
   * @param string $field field where
   * @param string $operator operator
   * @param mixed $value value
   */
  public function where($field, $operator, $value)
  {
    // set where syntax
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
  public function getList(?string $sql = null): ?object
  {
    /** if not set directly SQL then use class data */
    if (is_null($sql)) {
      // limit populate data
      $limit = isset($this->query['limit']) ? $this->query['limit'] : '';
      // set OFFSET start get data
      $offset = isset($this->query['offset']) ? $this->query['offset'] : '';
      // template SQL query to get data
      $sql = "SELECT * FROM {$this->table} {$this->where} {$limit} {$offset}";
    }
    // run query SQL
    $query = $this->query($sql);
    $rows = [];
    // fetch data with object types
    while ($row = $query->fetch_object())
      $rows[] = $row;
    // convert array to object
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
    // fetch only one data
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

    // example goal $var is:  ?,?,?,?
    $val = '';
    for ($i = 1; $i <= $len; $i++) {
      $val .= '?,';
    }
    // remove last ',' example "?,?,?,?," to "?,?,?,?"
    $val = rtrim($val, ',');

    $sql = "INSERT INTO {$this->table} ({$field}) VALUES ({$val})";
    try {
      $this->query($sql, $bind, ...$args);
    } catch (\Throwable $th) {
      // if found error print and stop app
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

    // example goal $set = "name = ?, email = ?, password = ?"
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
      // call query method with bind and value
      $this->query($sql, $bind, ...$val);
    } catch (\Throwable $th) {
      var_dump($th->getMessage());
      die;
    }
    return $this->affected_rows;
  }

  /** delete from database */
  public function destroy($id)
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
