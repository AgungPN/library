<?php

/**
 * Authentications Feature
 */
class Auth extends BaseController
{
  /** register new user with visitor/reader role */
  public function register(array $input)
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
        'unique' => ['table' => 'users', 'field' => 'email']
      ],
      'address' => [
        'required' => true,
        'min' => 10,
        'max' => 80,
      ],
      'password' => [
        'required' => true,
        'min' => 6,
        'same' => 'password-confirm'
      ],
      'gender' => [
        'required' => true,
      ],
    ]);

    // if not passed check
    if ($validation->notPassed()) {
      // then set error end stop process register
      $errors = $validation->error();
      FlashMessage::setFlashMessageArray("error", $errors);
      return;
    }

    // XSS protection
    $username = htmlspecialchars($input['name']);
    $password = password_hash(htmlspecialchars($input['password']), PASSWORD_DEFAULT);
    $email = htmlspecialchars($input['email']);
    $address = htmlspecialchars($input['address']);
    $gender = htmlspecialchars($input['gender']);

    // insert data into users
    $this->db->table('users')->insert('name,password,email,address,gender', 'sssss', $username, $password, $email, $address, $gender);

    // set message and to view auth-login
    FlashMessage::setFlash("success", "Success register new user");
    to_view("auth-login");
  }

  /** login feature to admin or visitor by 'is_admin' field */
  public function login(array $input): void
  {
    $validation = new Validation();
    // validation
    $validation->check($input, [
      'email' => ['required' => true],
      'password' => ['required' => true],
    ]);

    // if you get any error
    if ($validation->notPassed()) {
      // then stop process and set message
      $errors = $validation->error();
      FlashMessage::setFlashMessageArray("error", $errors);
      return;
    }

    // get email from database
    $user = $this->db->table('users')->where('email', '=', $input['email'])->getOne();

    // if found data user by id
    if (!is_null($user)) {
      // then verify password
      if (password_verify($input['password'], $user->password)) {
        $_SESSION['auth_id'] = $user->id;
        $isAdmin = $user->is_admin == 1;
        $_SESSION['is_admin'] = $isAdmin; // 1 means admin, 0 means user (reader)
        if ($isAdmin) {
          to_view("book/index"); // to admin page
        } else {
          to_view("visitor-book/index"); // to visitor/reader page
        }
        return;
      }
    }
    FlashMessage::setFlash("error", "Username or password wrong");
  }

  /** logout feature */
  public function logout()
  {
    // remove session then back to auth-login page
    session_destroy();
    unset($_SESSION['auth_id']);
    unset($_SESSION['is_admin']);

    to_view("auth-login");
  }
}
