const mix = require('laravel-mix');

let appJsFiles = [];
appJsFiles.push('resources/admin/plugins/js-cookie/js.cookie.js');
appJsFiles.push('resources/admin/plugins/jquery/jquery.min.js');
appJsFiles.push('resources/admin/plugins/jquery-ui/jquery-ui.min.js');
appJsFiles.push('resources/admin/plugins/bootstrap/js/bootstrap.bundle.min.js');
appJsFiles.push('resources/admin/plugins/sweetalert2/sweetalert2.js');

appJsFiles.push('resources/admin/plugins/toastr/toastr.min.js');
appJsFiles.push('resources/admin/dist/js/adminlte.js');
appJsFiles.push('resources/admin/plugins/sweetalert2/sweetalert2.js');
appJsFiles.push('resources/admin/custom/js/*.js');

mix.combine(appJsFiles, 'public/assets/admin/login.js');

appJsFiles = [];
appJsFiles.push('resources/admin/plugins/js-cookie/js.cookie.js');
appJsFiles.push('resources/admin/plugins/jquery/jquery.min.js');
appJsFiles.push('resources/admin/plugins/jquery-ui/jquery-ui.min.js');
appJsFiles.push('resources/admin/plugins/bootstrap/js/bootstrap.bundle.min.js');
appJsFiles.push('resources/admin/plugins/select2/js/select2.full.min.js');
appJsFiles.push('resources/admin/plugins/sweetalert2/sweetalert2.js');
appJsFiles.push('resources/admin/plugins/toastr/toastr.min.js');
appJsFiles.push('resources/admin/plugins/chart.js/Chart.min.js');
appJsFiles.push('resources/admin/plugins/sparklines/sparkline.js');
appJsFiles.push('resources/admin/plugins/jqvmap/jquery.vmap.min.js');
appJsFiles.push('resources/admin/plugins/jqvmap/maps/jquery.vmap.usa.js');
appJsFiles.push('resources/admin/plugins/jquery-knob/jquery.knob.min.js');
appJsFiles.push('resources/admin/plugins/moment/moment.min.js');
appJsFiles.push('resources/admin/plugins/daterangepicker/daterangepicker.js');
appJsFiles.push('resources/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js');
appJsFiles.push('resources/admin/plugins/summernote/summernote-bs4.min.js');
appJsFiles.push('resources/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');
appJsFiles.push('resources/admin/plugins/datatables/jquery.dataTables.js');
appJsFiles.push('resources/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js');
appJsFiles.push('resources/admin/plugins/datatables-scroller/js/dataTables.scroller.js');
appJsFiles.push('resources/admin/plugins/jstree/jstree.js');
appJsFiles.push('resources/admin/plugins/jstree/misc.js');
appJsFiles.push('resources/admin/plugins/pace-progress/pace.js');
appJsFiles.push('resources/admin/dist/js/adminlte.js');
appJsFiles.push('resources/admin/custom/js/*.js');

mix.combine(appJsFiles, 'public/assets/admin/admin.js');

mix.copy('resources/admin/plugins/fontawesome-free/webfonts/*', 'public/assets/webfonts/');

let appCssFiles = [];
appCssFiles.push('resources/admin/plugins/fontawesome-free/css/all.min.css');
appCssFiles.push('resources/admin/plugins/ionicons/css/ionicons.min.css');
appCssFiles.push('resources/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
appCssFiles.push('resources/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
appCssFiles.push('resources/admin/plugins/toastr/toastr.min.css');
appCssFiles.push('resources/admin/plugins/sweetalert2/sweetalert2.css');
appCssFiles.push('resources/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css');
appCssFiles.push('resources/admin/dist/css/adminlte.min.css');
appCssFiles.push('resources/admin/custom/css/custom.css');

mix.combine(appCssFiles, 'public/assets/admin/login.css');

appCssFiles = [];
appCssFiles.push('resources/admin/plugins/fontawesome-free/css/all.min.css');
appCssFiles.push('resources/admin/plugins/ionicons/css/ionicons.min.css');
appCssFiles.push('resources/admin/plugins/pace-progress/themes/blue/pace-theme-loading-bar.css');
appCssFiles.push('resources/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
appCssFiles.push('resources/admin/plugins/select2/css/select2.min.css');
appCssFiles.push('resources/admin/plugins/select2-bootstrap-theme/select2-bootstrap.min.css');
appCssFiles.push('resources/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
appCssFiles.push('resources/admin/plugins/toastr/toastr.min.css');
appCssFiles.push('resources/admin/plugins/sweetalert2/sweetalert2.css');
appCssFiles.push('resources/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css');
appCssFiles.push('resources/admin/plugins/bootstrap/css/bootstrap.css');
appCssFiles.push('resources/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css');
appCssFiles.push('resources/admin/plugins/datatables-scroller/css/scroller.bootstrap4.css');
appCssFiles.push('resources/admin/plugins/jstree/themes/default/style.css');
appCssFiles.push('resources/admin/dist/css/adminlte.min.css');
appCssFiles.push('resources/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css');
appCssFiles.push('resources/admin/plugins/daterangepicker/daterangepicker.css');
appCssFiles.push('resources/admin/plugins/summernote/summernote-bs4.css');
appCssFiles.push('resources/admin/custom/css/custom.css');

mix.combine(appCssFiles, 'public/assets/admin/admin.css');


