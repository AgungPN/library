<?php 

class BaseController  
{
  /** instance Database class */
  protected Database $db;

  public function __construct() {
    // set db field to Database class
    $this->db = new Database();
  }
}
