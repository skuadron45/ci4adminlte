<?php
$authFullname = isset($authFullname) ? $authFullname : 'No User';
$sidebar['modules'] = isset($sidebar['modules']) ? $sidebar['modules'] : '';
?>
<aside class="main-sidebar sidebar-dark-lightblue elevation-4">
    <!-- Brand Logo -->
    <a href="<?php print_site_url(); ?>" class="brand-link">
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