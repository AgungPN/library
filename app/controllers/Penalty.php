<?php

class Penalty extends BaseController
{

  /**
   * SQL to get data books with some data by relation between books, categories, penalties, and users table
   */
  private $sql = "
SELECT *, categories.category, penalties.id AS id, users.name as username, books.name AS name
FROM books
         INNER JOIN categories ON categories.id = books.category_id
         INNER JOIN penalties on books.id = penalties.book_id
         INNER JOIN users on penalties.user_id = users.id 
  ";

  /** populate data penalties by user id */
  public function userPenalties($userId)
  {
    return $this->db->getList($this->sql . " WHERE penalties.user_id = $userId");
  }

  /** populate all data penalties */
  public function allPenalties()
  {
    return $this->db->getList($this->sql);
  }

  /** get one data penalties by id penalties */
  public function detailPenalty($idPenalty)
  {
    return $this->db->getOne($this->sql . " WHERE penalties.id = $idPenalty");
  }

  /** send proof payment penalty */
  public function payment($id)
  {
    try {
      // save proof image file
      $proof = Storage::putFileAs('proof-penalties', 'proof');

      /** update status and set proof field */
      $this->db->table('penalties')->update([
        'proof' => $proof,
        'status' => 'Unconfirmed'
      ], 'ssi', $id);

      // set message
      FlashMessage::setFlash("success", "Success send proof");
      to_view('visitor-penalty/user-penalty');

    } catch (Exception $e) {
      // if any error, then send error message
      FlashMessage::setFlash("error", $e->getMessage());
    }
  }

  /** update status by admin */
  public function updateStatus($penalty_id, $status)
  {
    $this->db->table('penalties')->update([
      'status' => $status
    ], 'si', $penalty_id);

    to_view('penalty/index');
  }

  /** check collections already expired or not, if it is expired move to penalties table */
  public function toPenalty()
  {
    // get yesterday date
    $yesterday = date('Y-m-d', strtotime('-1 days'));
    // string to collect collections id 
    $ids = '';

    // get data collections already expired (expired_at < yesterday)
    $collections = $this->db->table('collections')->where('expired_at', '<=', "$yesterday")->getList();

    foreach ($collections as $collectoin) {
      // create data penalties by collections
      $this->db->table('penalties')->insert('user_id,book_id,status,expired_at', 'iiss',
        $collectoin->user_id, $collectoin->book_id, 'Unpaid', $yesterday);

      // concat $ids with id collections (example: 1,2,3,4,)
      $ids .= $collectoin->id . ',';
    }

    // remove last ,
    $ids = rtrim($ids, ',');
    // if not empy ids
    if (!empty($ids))
      // remove collection IN $ids
      $this->db->query("DELETE FROM collections WHERE id IN ($ids)");
  }
}