<?php

class Collection extends BaseController
{

  public function addCollection($userId, $bookId)
  {

    $isExists = $this->db->getOne("SELECT * FROM collections WHERE user_id = $userId AND book_id = $bookId");
    if (!empty($isExists)) {
      FlashMessage::setFlash('error', "Telah ditambahkan pada collection");
      return;
    }

    $sevenDayLetter = date('Y-m-d', strtotime('+7 days'));

    $this->db->table('collections')->
    insert("user_id,book_id,expired_at", 'iis', $userId, $bookId, $sevenDayLetter);
    FlashMessage::setFlash("success", "Success to add book to collection");

    to_view('visitor-book/index');
  }

  public function visitorCollection($userId)
  {
    $sql = "
SELECT *, collections.expired_at, categories.category, books.id AS id
FROM books
         INNER JOIN categories ON categories.id = books.category_id
         INNER JOIN collections on books.id = collections.book_id
    ";

    $now = date("Y-m-d");
    return $this->db->getList($sql . " WHERE collections.user_id = $userId AND collections.expired_at >= '$now'");
  }

}