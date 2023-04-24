<?php
require_once __DIR__ . "/../app/init.php";

$penaltyService = new Penalty();
$penaltyService->toPenalty();

$auth = new Auth;

// user can't to login view if already loged
if (isLoggedToAdmin()) {
  to_view('book/index');
}
if (isLoggedToVisitor()) {
  to_view("visitor-book/index");
}

if (isset($_POST['login'])) {
  $auth->login($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport"/>
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('modules/bootstrap/css/bootstrap.min.css') ?> "/>
  <link rel="stylesheet" href="<?= asset('modules/fontawesome/css/all.min.css') ?>"/>

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('modules/bootstrap-social/bootstrap-social.css') ?>"/>
  <link rel="stylesheet" href="<?= asset('modules/izitoast/css/iziToast.min.css') ?>">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>"/>
  <link rel="stylesheet" href="<?= asset('css/components.css') ?>"/>

  <!-- JS Libraies -->
  <script src="<?= asset('modules/izitoast/js/iziToast.min.js') ?>"></script>

  <!-- Page Specific JS File -->
  <script src="<?= asset('js/page/modules-toastr.js') ?>"></script>


  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }

    gtag("js", new Date());

    gtag("config", "UA-94034622-3");
  </script>
  <!-- /END GA -->
</head>

<body>

<?php FlashMessage::getMessage(); ?>

<div id="app">
  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="login-brand">
            <img src="../public/assets/img/avatar/avatar-1.png" alt="logo" width="100" class="shadow-light rounded-circle"/>
          </div>

          <div class="card card-primary">
            <div class="card-header">
              <h4>Login</h4>
            </div>

            <div class="card-body">
              <form method="POST" action="" class="needs-validation" novalidate="">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus/>
                  <div class="invalid-feedback">Please fill in your email</div>
                </div>

                <div class="form-group">
                  <div class="d-block">
                    <label for="password" class="control-label">Password</label>
                  </div>
                  <input id="password" type="password" class="form-control" name="password" tabindex="2" required/>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" name="login">
                    Login
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div class="mt-5 text-muted text-center">
            Don't have an account?
            <a href="auth-register.php">Create One</a>
          </div>
          <div class="simple-footer">Copyright &copy; Stisla 2023</div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- General JS Scripts -->
<script src="<?= asset('modules/jquery.min.js') ?>"></script>
<script src="<?= asset('modules/popper.js') ?>"></script>
<script src="<?= asset('modules/tooltip.js') ?>"></script>
<script src="<?= asset('modules/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
<script src="<?= asset('modules/moment.min.js') ?>"></script>
<script src="<?= asset('js/stisla.js') ?>"></script>


<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="<?= asset('js/scripts.js') ?>"></script>
<script src="<?= asset('js/custom.js') ?>"></script>

</body>

</html>