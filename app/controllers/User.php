<?php

class User extends BaseController
{
  public function index()
  {
    return $this->db->table('users')->getList();
  }

  public function view($userId)
  {
    return $this->db->table('users')->where('id', '=', $userId)->getOne();
  }

  public function update(array $input)
  {
    $validation = new Validation();
    $validation->check($input, [
      'name' => [
        'required' => true,
        'min' => 10,
        'max' => 80,
      ],
      'email' => [
        'required' => true,
        'min' => 10,
        'max' => 80,
        'unique' => ['table' => 'users', 'field' => 'email', 'escapeId' => $input['id']]
      ],
      'address' => [
        'required' => true,
        'min' => 10,
        'max' => 80,
      ],
      'gender' => [
        'required' => true,
      ],
    ]);

    if ($validation->notPassed()) {
      $errors = $validation->error();
      FlashMessage::setFlashMessageArray("error", $errors);
      return;
    }

    $username = htmlspecialchars($input['name']);
    $email = htmlspecialchars($input['email']);
    $address = htmlspecialchars($input['address']);
    $gender = htmlspecialchars($input['gender']);
    $isAdmin = htmlspecialchars($input['is_admin']);

    $this->db->table('users')->update([
      'name' => $username,
      'email' => $email,
      'address' => $address,
      'gender' => $gender,
      'is_admin' => $isAdmin
    ], 'ssssii', $input['id']);

    FlashMessage::setFlash("success", "Success update data user");
    to_view("user/index");
  }

  public function delete($book_id)
  {
    $this->db->table('users')->destroy($book_id);
    FlashMessage::setFlash("success", "Success to remove user");
    to_view('user/index');
  }
}