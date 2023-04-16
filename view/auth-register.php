<?php
require_once __DIR__ . "/../app/init.php";
$auth = new Auth;

if (isset($_POST['register'])) {
  $auth->register($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
  <title>Register &mdash; Stisla</title>


  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('modules/bootstrap/css/bootstrap.min.css') ?> " />
  <link rel="stylesheet" href="<?= asset('modules/fontawesome/css/all.min.css') ?>" />

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('modules/bootstrap-social/bootstrap-social.css') ?>" />
  <link rel="stylesheet" href="<?= asset('modules/izitoast/css/iziToast.min.css') ?>">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>" />
  <link rel="stylesheet" href="<?= asset('css/components.css') ?>" />


  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('modules/jquery-selectric/selectric.css') ?>" />

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

  <?php FlashMessage::getFlashMessageArray() ?>

  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="../public/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle" />
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="frist_name">Name</label>
                      <input id="frist_name" type="text" class="form-control" name="name" autofocus />
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">Gender</label>
                      <select name="gender" id="gender" class="form-control">
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" />
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" class="form-control" name="password-confirm" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" />
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <input id="address" type="text" class="form-control" name="address" />
                    <div class="invalid-feedback"></div>
                  </div>


                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="register">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">Copyright &copy; Stisla 2018</div>
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
  <script src="<?= asset('js/page/auth-register.js') ?>"></script>

  <!-- Template JS File -->
  <script src="<?= asset('js/scripts.js') ?>"></script>
  <script src="<?= asset('js/custom.js') ?>"></script>

  <!-- JS Libraies -->
  <script src="<?= asset('modules/jquery-pwstrength/jquery.pwstrength.min.js') ?>"></script>
  <script src="<?= asset('modules/jquery-selectric/jquery.selectric.min.js') ?>"></script>

</body>

</html>