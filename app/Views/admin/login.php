<?php
$appName = $appName ?? '';
$status = isset($status) ? $status : null;
$message = isset($message) ? $message : null;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $appName ?></title>
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

    <script>
        paceOptions = {
            restartOnPushState: false,
            restartOnRequestAfter: false
        }
    </script>

    <!-- App JS -->
    <?php print_script_resource("assets/admin/js/app.js"); ?>
</head>

<body class="hold-transition layout-top-nav">
    <div id="spinner-front">
        <img src="<?= base_url('assets/admin/dist/img/loader.gif') ?>" /><br>
        Verifying !
    </div>
    <div id="spinner-back"></div>

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?php print_site_url() ?>" class="navbar-brand">
                    <span class="brand-text font-weight-light"><?= $appName ?></span>
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
                            $attributes = array(
                                'id' => 'login-form'
                            );
                            print_var(form_open($link_form, $attributes));
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
                                    <button id="btn-submit" onclick="submitPost(); return false;" type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                            <?php
                            print_var(form_close());
                            ?>
                            <p class="mb-1">
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

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script>
        function disableForm(state) {
            var defaultState = true;
            if (HELPER.isset(state)) {
                defaultState = state === true ? true : false;
            }
            $("#login-form input").attr("disabled", defaultState);
            $("#btn-submit").attr('disabled', defaultState);
        }

        function submitPost() {
            var actionUrl = <?php print_var(json_encode($link_form)) ?>;

            var formDatas = $("#login-form").serializeArray();
            var params = {};
            for (var index = 0; index < formDatas.length; index++) {
                var formData = formDatas[index];
                params[formData.name] = formData.value;
            }

            disableForm(true);
            HELPER.Html.loading();
            SERVER.post(actionUrl, params, "json", function(data, textStatus, jqXHR) {
                var status = data.status;

                HELPER.Html.loading(false);
                HELPER.Notify.notif(status, data.message, function() {
                    if (HELPER.Respone.isSuccess(status)) {
                        location.reload();
                    } else {
                        $("#login-form").get(0).reset();
                        disableForm(false);
                    }
                });
            }, function(jqXHR, textStatus, errorThrown) {
                HELPER.Html.loading(false);
                HELPER.Notify.failJqhrReload(jqXHR, textStatus, errorThrown);
            });
        }
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