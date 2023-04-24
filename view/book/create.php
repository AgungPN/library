<?php
require_once __DIR__ . "/../../app/init.php";
if (!isLoggedToAdmin()) {
  to_view("auth-login");
}
$user = userAuth();

$categoryController = new Catergory();
$categories = $categoryController->index();

if (isset($_POST['store-book'])) {
  $bookController = new Book();
  $bookController->store($_POST);
}
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

  <!-- toast popup message -->
  <link rel="stylesheet" href="<?= asset('modules/izitoast/css/iziToast.min.css') ?>">
  <script src="<?= asset('modules/izitoast/js/iziToast.min.js') ?>"></script>

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

<?php FlashMessage::getFlashMessageArray(); ?>
<?php FlashMessage::getMessage(); ?>

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
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $user->name ?></div>
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
          <a href="">Library</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
          <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li><a class="nav-link" href="../book/index.php"><i class="fas fa-solid fa-book"></i> <span>Books</span></a></li>
          <li><a class="nav-link" href="../user/index.php"><i class="fas fa-solid fa-users"></i> <span>Users</span></a></li>
          <li><a class="nav-link" href="../penalty/index.php"><i class="fas fa-solid fa-exclamation-circle"></i> <span>Penalty</span></a></li>
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
            <div class="card card-primary">
              <div class="card-header">
                <h4 class=" w-100 text-center text-primary">Create New Books</h4>
              </div>
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  
                  <div class="form-group">
                    <label>Name Book</label>
                    <input type="text" class="form-control" name="name"/>
                  </div>

                  <div class="form-group">
                    <label>Author Book</label>
                    <input type="text" class="form-control" name="author">
                  </div>

                  <div class="form-group">
                    <label>Category</label>
                    <div class="selectric-wrapper selectric-form-control selectric-selectric">
                      <div class="selectric-hide-select">
                        <select class="form-control selectric" tabindex="-1" name="category_id">
                          <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"><?= $category->category ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Publish At</label>
                    <input type="date" class="form-control" name="publish_at"/>
                  </div>

                  <div class="form-group">
                    <label>File PDF E-Book</label>
                    <input type="file" class="form-control" name="file" accept="application/pdf">
                  </div>

                  <div class="form-group">
                    <label>Cover</label>
                    <input type="file" class="form-control" name="cover" accept="image/*">
                  </div>

                  <div class="form-group mb-0">
                    <label>Description</label>
                    <textarea class="form-control" required="" name="description"></textarea>
                  </div>

                  <div class="card-footer text-right">
                    <button class="btn btn-primary" name="store-book">Submit</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
      </section>
    </div>
    <footer class="main-footer">
      <div class="footer-left">
        Copyright &copy; 2023
        <div class="bullet"></div>
        Design By <a href="">Kelompok Library</a>
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