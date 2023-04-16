<?php

class Book extends BaseController
{
  public function index()
  {
    return $this->db->table('books')->getList();
  }
}