<?php

class Collection extends BaseController
{

  /** add book to collections */
  public function addCollection($userId, $bookId)
  {

    $isExists = $this->db->getOne("SELECT * FROM collections WHERE user_id = $userId AND book_id = $bookId");
    // if user already borrowed this book 
    if (!empty($isExists)) {
      // then send error message and stop process
      FlashMessage::setFlash('error', "Telah ditambahkan pada collection");
      return;
    }

    // count how many user have collectios books
    $countCollection = $this->db->table('collections')->where('user_id', '=', $userId)->num_rows();
    // max collections is 5
    if ($countCollection >= 5) {
      FlashMessage::setFlash('error', "User telah mencapai jumlah maximum peminjaman buku");
      return;
    }

    // get 7 days letter from now
    $sevenDayLetter = date('Y-m-d', strtotime('+7 days'));

    $this->db->table('collections')->
    insert("user_id,book_id,expired_at", 'iis', $userId, $bookId, $sevenDayLetter);

    FlashMessage::setFlash("success", "Success to add book to collection");
    to_view('visitor-book/index');
  }

  /** populate visitor collections */
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

  /** visitor return books */
  public function returnBook($userId, $bookId)
  {
    $this->db->query("DELETE FROM collections WHERE user_id = $userId AND book_id = $bookId");
    
    FlashMessage::setFlash("success", "Success to return book");
    to_view('visitor-collection/book-collections');
  }

}