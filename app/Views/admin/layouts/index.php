<?php

/**
 * @var \CodeIgniter\view\View $this
 */
$appName = $appName ?? '';
$status = isset($status) ? $status : null;
$message = isset($message) ? $message : null;
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.::Modul Admin::.</title>

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
    <?php
    echo $this->include('admin/layouts/navbar');
    ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php
    echo $this->include('admin/layouts/sidebar');
    ?>
    <!-- /Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <?php
      echo $this->include('admin/layouts/contentheader');
      ?>
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