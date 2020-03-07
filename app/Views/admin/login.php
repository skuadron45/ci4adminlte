<?php
$status = isset($status) ? $status : null;
$message = isset($message) ? $message : null;
$appName = isset($appName) ? $appName : '';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{appName}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Login style -->
    <?php print_link_resource("assets/admin/login.css"); ?>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?php print_site_url() ?>" class="navbar-brand">
                    <span class="brand-text font-weight-light">{appName}</span>
                </a>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php print_site_url() ?>" target="_blank">
                            <i class="fa fa-rocket"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="login-box">
                    <div class="login-logo">
                        <a href="#"><b>Administrator Panel</b></a>
                    </div>
                    <!-- /.login-logo -->
                    <div class="card">
                        <div class="card-body login-card-body">
                            <p class="login-box-msg">Sign in to start your session</p>

                            <?php
                            print_var(form_open($link_form));
                            ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Username" name="username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if (isset($captcha)) {
                            ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php print_var($captcha); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="row">
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>


                            <?php
                            print_var(form_close());
                            ?>
                            <p class="mb-1">
                                <a href="#">I forgot my password</a>
                            </p>
                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
                <!-- /.login-box -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="#"><?= $appName; ?></a>.</strong> All rights reserved.
        </footer>
    </div>

    <?php print_script_resource("assets/admin/login.js"); ?>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <?php
    if (isset($status)) {
    ?>
        <script>
            $(function() {
                var status = <?php print_var($status) ?>;
                var message = <?php print_var($message) ?>;
                HELPER.Notify.notif(status, message);
            });
        </script>
    <?php
    }
    ?>
</body>

</html>