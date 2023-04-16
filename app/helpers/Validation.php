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
          case 'required':
            if ($ruleValue && (is_null($value) || trim($value) == "")) $this->setError("$item must have value!");
            break;
          case 'min':
            if (strlen($value) < $ruleValue) $this->setError("$item must more then $ruleValue character");
            break;
          case 'max':
            if (strlen($value) > $ruleValue) $this->setError("$item must less then $ruleValue character");
            break;
          case 'length':
            if (strlen($value) != $ruleValue) $this->setError("$item must $ruleValue character");
            break;
          case 'same':
            if ($value != $source[$ruleValue]) $this->setError("$item tidak sama dengan $ruleValue");
            break;
          case 'unique':
            $data = $this->db->getOne("SELECT " . $ruleValue['field'] . ",id FROM " . $ruleValue['table'] . " WHERE " . $ruleValue['field'] . " = " . ":$item");

            if ($data && $data->id != $ruleValue['escapeId']) $this->setError("$item value is already used");
            break;
        }
      }
    }

    if (empty($this->error())) return $this->passed = true;
    return $this;
  }

  private function setError($error): void
  {
    $this->errors[] = $error;
  }

  public function error(): array
  {
    $errors = $this->errors;
    return $errors;
  }

  public function passed(): bool
  {
    return $this->passed;
  }

  public function notPassed(): bool
  {
    return $this->passed === false;
  }
}
