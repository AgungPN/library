<?php

class Validation
{
  private array $errors = [];
  private bool $passed = false;
  private Database $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function check($source, array $items)
  {
    foreach ($items as $item => $rules) {
      foreach ($rules as $rule => $ruleValue) {
        $value = $source["$item"];
        switch ($rule) {

          // to check if field required to set or not
          case 'required':
            if ($ruleValue && (is_null($value) || trim($value) == "")) $this->setError("$item must have value!");
            break;

          // to check min character in field (min length) {string < length}
          case 'min':
            if (strlen($value) < $ruleValue) $this->setError("$item must more then $ruleValue character");
            break;

          // to check max character in field (max length) {string > length}
          case 'max':
            if (strlen($value) > $ruleValue) $this->setError("$item must less then $ruleValue character");
            break;

          // to check fix character in field (means length string must equals with value) {string == length}
          case 'length':
            if (strlen($value) != $ruleValue) $this->setError("$item must $ruleValue character");
            break;

          // to check value must same with key source
          case 'same':
            if ($value != $source[$ruleValue]) $this->setError("$item tidak sama dengan $ruleValue");
            break;

          // to check is data unique in database
          case 'unique':
            // example $sql = SELECT name,id FROM books WHERE name = 'Harry Potter'
            $sql = "SELECT " . $ruleValue['field'] . ",id FROM " . $ruleValue['table'] . " WHERE " . $ruleValue['field'] . " = " . "'$value'";
            // example sql + escapeId =  SELECT name,id FROM books WHERE name = 'Harry Potter' AND id != 2;
            $data = $this->db->table('users')->getOne($sql . (isset($ruleValue['escapeId']) ? " AND id != " . $ruleValue['escapeId'] : ""));
            // set message if found data
            if (!is_null($data)) $this->setError("$item value is already used");
            break;

        }
      }
    }

    // set passed to true if not found error message
    if (empty($this->error())) return $this->passed = true;
    return $this;
  }

  /** add error message to array errors */
  private function setError($error): void
  {
    $this->errors[] = $error;
  }

  // get error message
  public function error(): array
  {
    return $this->errors;
  }

  /** is passed validation */
  public function passed(): bool
  {
    return $this->passed;
  }

  /** is not passed validation */
  public function notPassed(): bool
  {
    return $this->passed === false;
  }
}
