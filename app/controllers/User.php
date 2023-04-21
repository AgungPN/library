<?php

class User extends BaseController
{
  public function index()
  {
    return $this->db->table('users')->getList();
  }

  private function ruleValidation(array $input, bool $isNew): array
  {
    $rules = [
      'name' => [
        'required' => true,
        'min' => 5,
        'unique' => [
          'field' => 'name',
          'table' => 'books',
          'escapeId' => $isNew ? null : $input['id']
        ],
      ],
      'description' => [
        'required' => true,
        'min' => 10
      ],
      'author' => ['required' => true],
      'category_id' => ['required' => true],
      'publish_at' => ['required' => true]
    ];

    $validate = new Validation();
    $validate->check($input, $rules);

    return $validate->notPassed() ? $validate->error() : [];
  }

  public function store(array $input)
  {
    $name = htmlspecialchars($input['name']);
    $description = htmlspecialchars($input['description']);
    $author = htmlspecialchars($input['author']);
    $category_id = htmlspecialchars($input['category_id']);
    $publish_at = htmlspecialchars($input['publish_at']);

    $errorMessages = $this->ruleValidation($input, true);

    if (!empty($errorMessages)) {
      FlashMessage::setFlashMessageArray('error', $errorMessages);
      return;
    }

    $this->db->table('books')->insert('name,description,author,publish_at,category_id', 'ssssi',
      $name, $description, $author, $publish_at, $category_id);

    FlashMessage::setFlash("success", "Success to create new book");
    to_view('book/index');
  }

  public function view($book_id)
  {
    return $this->db->table('books')->where('id', '=', $book_id)->getOne();
  }

  public function update(array $input)
  {
    $id = htmlspecialchars($input['id']);
    $name = htmlspecialchars($input['name']);
    $description = htmlspecialchars($input['description']);
    $author = htmlspecialchars($input['author']);
    $category_id = htmlspecialchars($input['category_id']);
    $publish_at = htmlspecialchars($input['publish_at']);

    $errorMessages = $this->ruleValidation($input, false);
    if (!empty($errorMessages)) {
      FlashMessage::setFlashMessageArray('error', $errorMessages);
      return;
    }

    $this->db->table('books')->update([
      'name' => $name,
      'description' => $description,
      'author' => $author,
      'publish_at' => $publish_at,
      'category_id' => $category_id
    ], 'ssssii', $id);

    FlashMessage::setFlash("success", "Success to create new book");
    to_view('book/index');
  }

  public function delete($book_id)
  {
    $this->db->table('books')->destroy($book_id);
    FlashMessage::setFlash("success", "Success to remove book");
    to_view('book/index');
  }
}