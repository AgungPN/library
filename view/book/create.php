<?php
require_once __DIR__ . "/../../app/init.php";

if (!isLoggedToAdmin()) {
  to_view("auth-login");
}

$db = new Database();
$user = $db->table('users')->where('id', '=', $_SESSION['auth_id'])->getOne();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Blank Page &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('modules/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('modules/fontawesome/css/all.min.css') ?>">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('modules/izitoast/css/iziToast.min.css') ?>">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components.css') ?>">


  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body>
<div id="app">
  <div class="main-wrapper main-wrapper-1">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
      <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a>
          </li>
        </ul>
      </form>
      <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= asset('img/avatar/avatar-1.png') ?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi,</div>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="../auth-logout.php" class="dropdown-item has-icon text-danger">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <div class="main-sidebar sidebar-style-2">
      <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
          <a href="index.html">Library</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
          <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li><a class="nav-link" href="credits.html"><i class="fas fa-solid fa-book"></i> <span>Books</span></a></li>
        </ul>
      </aside>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Books Management</h1>
        </div>

        <div class="section-body">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h4>Create New Books</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Name Book</label>
                  <input type="text" class="form-control" name="name"/>
                </div>

                <div class="form-group">
                  <label>Author Book</label>
                  <input type="text" class="form-control" name="name">
                </div>

                <div class="form-group">
                  <label>Publish At</label>
                  <input type="date" class="form-control" name="name">
                </div>

                <div class="form-group">
                  <label>Category</label>
                  <div class="selectric-wrapper selectric-form-control selectric-selectric">
                    <div class="selectric-hide-select">
                      <select class="form-control selectric" tabindex="-1">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                  <label>Publish At</label>
                  <input type="date" class="form-control" name="name">
                </div>


              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <footer class="main-footer">
      <div class="footer-left">
        Copyright &copy; 2018
        <div class="bullet"></div>
        Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
      </div>
      <div class="footer-right">

      </div>
    </footer>
  </div>
</div>

<!-- General JS Scripts -->
<script src="<?= asset('modules/jquery.min.js') ?>"></script>
<script src="<?= asset('modules/popper.js') ?>"></script>
<script src="<?= asset('modules/tooltip.js') ?>"></script>
<script src="<?= asset('modules/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
<script src="<?= asset('modules/moment.min.js') ?>"></script>
<script src="<?= asset('js/stisla.js') ?>"></script>

<!-- JS Libraies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script !src="">
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>

<!-- Template JS File -->
<script src="<?= asset('js/scripts.js') ?>"></script>
<script src="<?= asset('js/custom.js') ?>"></script>
</body>

</html>