<?php

/**
 * Authentications Feature
 */
class Auth extends BaseController
{
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

    if ($validation->notPassed()) {
      $errors = $validation->error();
      FlashMessage::setFlashMessageArray("error", $errors);
      return;
    }

    $username = htmlspecialchars($input['name']);
    $password = password_hash(htmlspecialchars($input['password']), PASSWORD_DEFAULT);
    $email = htmlspecialchars($input['email']);
    $address = htmlspecialchars($input['address']);
    $gender = htmlspecialchars($input['gender']);

    $this->db->table('users')->insert('name,password,email,address,gender', 'sssss', $username, $password, $email, $address, $gender);

    FlashMessage::setFlash("success", "Success register new user");
    to_view("auth-login");
  }

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
        if (true) {
          to_view("book/index");
        }
        return;
      }
    }
    FlashMessage::setFlash("error", "Username or password wrong");
  }

  public function logout()
  {
    session_destroy();
    unset($_SESSION['auth_id']);
    unset($_SESSION['is_admin']);

    to_view("auth-login");
  }
}
