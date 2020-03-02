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

  <!-- Font Awesome -->
  <?php print_link_resource("assets/admin/plugins/fontawesome-free/css/all.min.css"); ?>

  <!-- Ionicons -->
  <?php print_link_resource("assets/admin/plugins/ionicons/css/ionicons.min.css"); ?>

  <!-- pace-progress -->
  <?php print_link_resource("assets/admin/plugins/pace-progress/themes/blue/pace-theme-loading-bar.css"); ?>

  <!-- Tempusdominus Bbootstrap 4 -->
  <?php print_link_resource("assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"); ?>

  <!-- Select2 -->
  <?php print_link_resource("assets/admin/plugins/select2/css/select2.min.css"); ?>
  <?php print_link_resource("assets/admin/plugins/select2-bootstrap-theme/select2-bootstrap.min.css"); ?>
  <!-- <?php print_link_resource("assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"); ?> -->

  <!-- iCheck -->
  <?php print_link_resource("assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>

  <!-- Toastr -->
  <?php print_link_resource("assets/admin/plugins/toastr/toastr.min.css"); ?>

  <!-- SweetAlert2 -->
  <?php print_link_resource("assets/admin/plugins/sweetalert2/sweetalert2.css"); ?>
  <?php print_link_resource("assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"); ?>

  <!-- DataTables -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
  <?php print_link_resource("assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css"); ?>
  <?php print_link_resource("assets/admin/plugins/datatables-scroller/css/scroller.bootstrap4.css"); ?>

  <!-- Jstree -->
  <?php print_link_resource("assets/admin/plugins/jstree/themes/default/style.css"); ?>

  <!-- Theme style -->
  <?php print_link_resource("assets/admin/dist/css/adminlte.min.css"); ?>

  <!-- overlayScrollbars -->
  <?php print_link_resource("assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"); ?>

  <!-- Daterange picker -->
  <?php print_link_resource("assets/admin/plugins/daterangepicker/daterangepicker.css"); ?>

  <!-- summernote -->
  <?php print_link_resource("assets/admin/plugins/summernote/summernote-bs4.css"); ?>

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Custom style -->
  <?php print_link_resource("assets/admin/custom/custom.css"); ?>

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

  <!-- JS Cookie -->
  <?php print_script_resource("assets/admin/plugins/js-cookie/js.cookie.js"); ?>
  <!-- jQuery -->
  <?php print_script_resource("assets/admin/plugins/jquery/jquery.min.js"); ?>
  <!-- jQuery UI 1.11.4 -->
  <?php print_script_resource("assets/admin/plugins/jquery-ui/jquery-ui.min.js"); ?>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <?php print_script_resource("assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>

  <!-- Select2 -->
  <?php print_script_resource("assets/admin/plugins/select2/js/select2.full.min.js"); ?>
  <!-- SweetAlert2 -->
  <?php print_script_resource("assets/admin/plugins/sweetalert2/sweetalert2.js"); ?>
  <!-- Toastr -->
  <?php print_script_resource("assets/admin/plugins/toastr/toastr.min.js"); ?>
  <!-- ChartJS -->
  <?php print_script_resource("assets/admin/plugins/chart.js/Chart.min.js"); ?>
  <!-- Sparkline -->
  <?php print_script_resource("assets/admin/plugins/sparklines/sparkline.js"); ?>
  <!-- JQVMap -->
  <?php print_script_resource("assets/admin/plugins/jqvmap/jquery.vmap.min.js"); ?>
  <?php print_script_resource("assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"); ?>
  <!-- jQuery Knob Chart -->
  <?php print_script_resource("assets/admin/plugins/jquery-knob/jquery.knob.min.js"); ?>
  <!-- daterangepicker -->
  <?php print_script_resource("assets/admin/plugins/moment/moment.min.js"); ?>
  <?php print_script_resource("assets/admin/plugins/daterangepicker/daterangepicker.js"); ?>
  <!-- Tempusdominus Bootstrap 4 -->
  <?php print_script_resource("assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>
  <!-- Summernote -->
  <?php print_script_resource("assets/admin/plugins/summernote/summernote-bs4.min.js"); ?>
  <!-- overlayScrollbars -->
  <?php print_script_resource("assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>
  <!-- DataTables -->
  <?php print_script_resource("assets/admin/plugins/datatables/jquery.dataTables.js"); ?>
  <?php print_script_resource("assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"); ?>
  <?php print_script_resource("assets/admin/plugins/datatables-scroller/js/dataTables.scroller.js"); ?>
  <!-- Jstree -->
  <?php print_script_resource("assets/admin/plugins/jstree/jstree.js"); ?>
  <?php print_script_resource("assets/admin/plugins/jstree/misc.js"); ?>
  <!-- pace-progress -->
  <?php print_script_resource("assets/admin/plugins/pace-progress/pace.js"); ?>
  <!-- AdminLTE App -->
  <?php print_script_resource("assets/admin/dist/js/adminlte.js"); ?>
  <!-- Custom JS -->
  <?php print_script_resource("assets/admin/custom/custom.js"); ?>
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