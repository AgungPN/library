<?php

class Book extends BaseController
{
  public function index()
  {
    return $this->db->getList("SELECT *,categories.category,books.id AS id FROM books LEFT JOIN categories ON categories.id = books.category_id");
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

    try {
      $cover = Storage::putFileAs('covers', 'cover');
      $filePdf = Storage::putFileAs('book-pdf', 'file', ['pdf']);

      $this->db->table('books')->insert('name,description,author,publish_at,category_id,cover,file', 'ssssiss',
        $name, $description, $author, $publish_at, $category_id, $cover, $filePdf);

      FlashMessage::setFlash("success", "Success to create new book");
      to_view('book/index');
    } catch (Exception $e) {
      FlashMessage::setFlash("error", $e->getMessage());
    }

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

    $book = $this->db->table('books')->where('id', '=', $id)->getOne();
    $cover = $book->cover;
    $pdfFile = $book->file;

    try {
      if (!empty($_FILES['cover']['name'])) {
        $cover = Storage::putFileAs('covers', 'cover');
      }
      if (!empty($_FILES['file']['name'])) {
        $pdfFile = Storage::putFileAs('book-pdf', 'file', ['pdf']);
      }

      $this->db->table('books')->update([
        'name' => $name,
        'description' => $description,
        'author' => $author,
        'publish_at' => $publish_at,
        'cover' => $cover,
        'file' => $pdfFile,
        'category_id' => $category_id
      ], 'ssssssii', $id);

      FlashMessage::setFlash("success", "Success to create new book");
      to_view('book/index');
    }catch (Exception $e){
      FlashMessage::setFlash("error", $e->getMessage());
    }

  }

  public function delete($book_id)
  {
    $book = $this->db->table('books')->where('id', '=', $book_id)->getOne();
    Storage::delete('book-pdf', $book->file);
    Storage::delete('covers', $book->cover);

    $this->db->table('books')->destroy($book_id);
    FlashMessage::setFlash("success", "Success to remove book");
    to_view('book/index');
  }
}