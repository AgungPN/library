<?php
require_once __DIR__ . "/../../app/init.php";

if (!isLoggedToAdmin()) {
  to_view("auth-login");
}
$user = userAuth();

$penaltyService = new Penalty();
$penalties = $penaltyService->allPenalties();

if (isset($_POST['change-status'])) {
  $penaltyService->updateStatus($_POST['penalty_id'], $_POST['status']);
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

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('modules/izitoast/css/iziToast.min.css') ?>">

  <style>
    .custom-section {
      position: static !important;
    }
  </style>

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components.css') ?>">

  <!-- toast popup message -->
  <link rel="stylesheet" href="<?= asset('modules/izitoast/css/iziToast.min.css') ?>">
  <script src="<?= asset('modules/izitoast/js/iziToast.min.js') ?>"></script>

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
      <section class="section custom-section">
        <div class="section-header">
          <h1>Penalty Management</h1>
        </div>

        <div class="section-body">
          <table id="myTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
              <th>No</th>
              <th>User Name</th>
              <th>Book Name</th>
              <th>Expired Days</th>
              <th>Penalty Price</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($penalties as $penalty): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $penalty->username ?></td>
                <td><?= $penalty->name ?></td>
                <td><strong class="text-danger"><?= $penalty->count_days ?> Days</strong></td>
                <td><strong class="text-primary"><?= 'Rp.' . $penalty->count_days * PENALTY_PRICE ?></strong></td>
                <td>
                  <?php
                  if ($penalty->status === 'Paid') {
                    echo " <span class='badge badge-success'>{$penalty->status}</span> ";
                  } elseif ($penalty->status === 'Unpaid') {
                    echo " <span class='badge badge-danger'>{$penalty->status}</span> ";
                  } else {
                    echo " <span class='badge badge-warning'>{$penalty->status}</span> ";
                  }
                  ?>
                </td>
                <td>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#proof<?= $penalty->id ?>">
                    View Penalty
                  </button>

                  <button class="btn btn-warning" data-toggle="modal" data-target="#change-status<?= $penalty->id ?>">
                    Change Status
                  </button>
                </td>
              </tr>

              <!--    Modal Proof        -->
              <div class="modal fade" tabindex="-1" role="dialog" id="proof<?= $penalty->id ?>"
                   aria-hidden="true"
                   style="display: none;">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Proof Payment Penalty</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <img src="<?= asset('proof-penalties/' . ($penalty->proof ?? '')) ?>" alt="Noting Proof payment"
                           width="100%" height="500">
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <!--                      <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                  </div>
                </div>
              </div>

              <!--    Modal Change Status        -->
              <div class="modal fade" tabindex="-1" role="dialog" id="change-status<?= $penalty->id ?>"
                   aria-hidden="true"
                   style="display: none;">
                <div class="modal-dialog" role="document">
                  <form action="" method="post">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Change Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="penalty_id" value="<?= $penalty->id ?>">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status">
                            <option value="Unconfirmed">Unconfirmed</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="change-status" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>


            <?php endforeach; ?>
            </tbody>
          </table>
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