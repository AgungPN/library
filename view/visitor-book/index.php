<?php
require_once __DIR__ . "/../../app/init.php";

if (!isLoggedToVisitor()) {
  to_view("auth-login");
}
$user = userAuth();

$bookController = new Book();
$books = $bookController->index();

if (isset($_GET['search'])) {
  $books = $bookController->index($_GET['search']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Library</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('modules/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('modules/fontawesome/css/all.min.css') ?>">

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

<body class="layout-3">

<?php FlashMessage::getMessage(); ?>

<div id="app">
  <div class="main-wrapper container">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
      <a href="#" class="navbar-brand sidebar-gone-hide">Library</a>
      <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
      <div class="nav-collapse">
        <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <ul class="navbar-nav">
          <li class="nav-item active"><a href="../visitor-book/index.php" class="nav-link">
              <i class="fas fa-book mr-1"></i>Books</a></li>
          <li class="nav-item"><a href="../visitor-collection/book-collections.php" class="nav-link">
              <i class="fas fa-list mr-1"></i>Collections</a></li>
          <li class="nav-item"><a href="../visitor-penalty/user-penalty.php" class="nav-link">
              <i class="fas fa-exclamation-circle mr-1"></i>Penalty</a></li>
        </ul>
      </div>
      <form class="form-inline ml-auto" method="get" action="">
      </form>
      <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= asset('img/avatar/avatar-1.png') ?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $user->name ?>  </div>
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

    <nav class="navbar navbar-secondary navbar-expand-lg">
      <div class="container">
        <div class="navbar-nav">
          <h1 class=" fa-2x">List Books</h1>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="row">

          <?php foreach ($books as $book): ?>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
              <article class="article article-style-b">
                <div class="article-header">
                  <div class="article-image" data-background="<?= asset('covers/' . $book->cover) ?>"
                       style="background-image: url('<?= asset('covers/' . $book->cover) ?>');">
                  </div>
                </div>
                <div class="article-details">
                  <div class="article-title">
                    <h2><a href="detail.php?id=<?= $book->id ?>"><?= $book->name ?></a></h2>
                  </div>
                  <p><?= limit_word($book->description) ?></p>
                  <div class="article-cta">
                    <a href="detail.php?id=<?= $book->id ?>">Read More <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </article>
            </div>
          <?php endforeach; ?>

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

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="<?= asset('js/scripts.js') ?>"></script>
<script src="<?= asset('js/custom.js') ?>"></script>
</body>
</html>