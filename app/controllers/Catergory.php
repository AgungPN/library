<?php

class Catergory extends BaseController
{
  /**
   * populate data categories
   */
  public function index()
  {
    return $this->db->table('books')->getList("SELECT * FROM categories");
  }
}