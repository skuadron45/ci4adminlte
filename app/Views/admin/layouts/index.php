<?php

/**
 * @var \CodeIgniter\view\View $this
 */

$appName = isset($appName) ? $appName : 'CP OSHOP';
$authFullname = isset($authFullname) ? $authFullname : 'No User';
$pageTitle = isset($pageTitle) ? $pageTitle : '';
$sidebar['modules'] = isset($sidebar['modules']) ? $sidebar['modules'] : '';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Blank Page</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- App CSS -->
  <?php print_link_resource("assets/admin/css/app.css"); ?>

  <script type="text/javascript">
    const _BASE_URL = '<?= base_url(); ?>';
    const _SITE_URL = '<?= site_url(); ?>';
    const _CURRENT_URL = '<?= current_url(); ?>';
    const _ADMIN_SITE_URL = '<?= admin_site_url(); ?>';
    const _CSRF_COOKIE = '<?= csrf_cookie(); ?>';
    const _CSRF_NAME = '<?= csrf_token(); ?>';
  </script>

</head>

<body class="sidebar-mini layout-fixed text-sm">
  <div id="spinner-front">
    <img src="<?= base_url('assets/admin/dist/img/loader.gif') ?>" /><br>
    Loading !
  </div>
  <div id="spinner-back"></div>

  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-lightblue">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fa fa-rocket"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print_admin_site_url('logout') ?>">
            <i class="fa fa-power-off"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-lightblue elevation-4">
      <!-- Brand Logo -->
      <a href="<?php print_site_url(); ?>" class="brand-link">
        <!-- <img src="<?php print_base_url("assets/admin/"); ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->

        <span class="brand-image"><i class="fa fa-cogs" style="font-size: 24px;line-height: 32px;"></i></span>
        <span class="brand-text font-weight-light"><?php print_var($appName) ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php print_base_url("assets/admin/dist/img/user2-160x160.jpg"); ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php print_var($authFullname) ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
            <?php
            print_var($sidebar['modules']);
            ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?php print_var($pageTitle) ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content-header -->

      <?php
      $this->renderSection('main-content');
      ?>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <strong>Copyright &copy; 2020 <a href="http://adminlte.io"><?= $appName; ?></a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>

  </div>

  <!-- ./wrapper -->
  <script>
    paceOptions = {
      elements: false,
      restartOnPushState: false,
      restartOnRequestAfter: false
    }
  </script>

  <!-- App JS -->
  <?php print_script_resource("assets/admin/js/app.js"); ?>

  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>

  <?php
  $this->renderSection('main-script');
  ?>

  <?php
  if (isset($status)) {
  ?>
    <script>
      var status = <?php print_var($status) ?>;
      var message = <?php print_var($message) ?>;
      HELPER.Notify.notif(status, message);
    </script>
  <?php
  }
  ?>
</body>

</html>