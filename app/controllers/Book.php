<?php

class Book extends BaseController
{
  /** Populate data books */
  public function index($search = null)
  {
    // string SQL to get data books with field category form table categories. (use LEFT JOIN)
    $sql = "SELECT *,categories.category,books.id AS id FROM books INNER JOIN categories ON categories.id = books.category_id ORDER BY books.created_at DESC";
    if (!is_null($search)) {
      // concat string SQL with where condition to search by name books
      $sql .= " WHERE books.name LIKE '%$search%'";
    }
    return $this->db->getList($sql);
  }

  /** create new data book */
  public function store(array $input)
  {
    // XSS protection
    $name = htmlspecialchars($input['name']);
    $description = htmlspecialchars($input['description']);
    $author = htmlspecialchars($input['author']);
    $category_id = htmlspecialchars($input['category_id']);
    $publish_at = htmlspecialchars($input['publish_at']);

    // call method ruleValidation to validate input and return error message if exists
    $errorMessages = $this->ruleValidation($input, true);

    // if you have error message
    if (!empty($errorMessages)) {
      // then stop process and send array message
      FlashMessage::setFlashMessageArray('error', $errorMessages);
      return;
    }

    try {
      // store cover and pdf file 
      $cover = Storage::putFileAs('covers', 'cover');
      // ['pdf'] only can save pdf file
      $filePdf = Storage::putFileAs('book-pdf', 'file', ['pdf']);

      $this->db->table('books')->insert('name,description,author,publish_at,category_id,cover,file', 'ssssiss',
        $name, $description, $author, $publish_at, $category_id, $cover, $filePdf);

      // send success message
      FlashMessage::setFlash("success", "Success to create new book");
      to_view('book/index');
    } catch (Exception $e) {
      // if found error like storage error
      FlashMessage::setFlash("error", $e->getMessage());
    }

  }

  /** get detail data book */
  public function view($book_id)
  {
    $sql = "SELECT *,categories.category,books.id AS id FROM books INNER JOIN categories ON categories.id = books.category_id";
    return $this->db->getOne($sql . " WHERE books.id = $book_id");
  }

  /** update data book */
  public function update(array $input)
  {
    // XSS protection
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
    // save old cover and pdf data
    $cover = $book->cover;
    $pdfFile = $book->file;

    try {
      if (!empty($_FILES['cover']['name'])) {
        Storage::delete('covers', $cover); // remove old file from storage
        $cover = Storage::putFileAs('covers', 'cover'); // save new file
      }
      if (!empty($_FILES['file']['name'])) {
        Storage::delete('book-pdf', $cover); // remove old file from storage
        $pdfFile = Storage::putFileAs('book-pdf', 'file', ['pdf']);
      }

      // update book
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
    } catch (Exception $e) {
      FlashMessage::setFlash("error", $e->getMessage());
    }

  }

  /** remove data book */
  public function delete($book_id)
  {
    $book = $this->db->table('books')->where('id', '=', $book_id)->getOne();
    // remove files
    Storage::delete('book-pdf', $book->file);
    Storage::delete('covers', $book->cover);

    $this->db->table('books')->destroy($book_id);
    FlashMessage::setFlash("success", "Success to remove book");
    to_view('book/index');
  }

  /** rule validation book */
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

    // send error message 
    return $validate->error();
  }
}