<?php 

class BaseController  
{
  protected Database $db;

  public function __construct() {
    $this->db = new Database();
  }
}
