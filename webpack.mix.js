let mix = require('laravel-mix');

const publicAssetsAdminPath = 'public/assets/admin/';

mix.setPublicPath('public');
mix.sass('resources/admin/sass/app.scss', 'public/assets/admin/css');

let appCssFiles = [];
appCssFiles.push('resources/general/plugins/pace-progress/themes/blue/pace-theme-loading-bar.css');
appCssFiles.push('public/assets/admin/css/app.css');
appCssFiles.push('node_modules/select2-bootstrap-theme/dist/select2-bootstrap.css');

appCssFiles.push('resources/admin/custom/css/custom.css');
mix.combine(appCssFiles, publicAssetsAdminPath + 'css/app.css');

const resourceRootPath = 'node_modules/';
let appJsFiles = [];
appJsFiles.push(resourceRootPath + 'js-cookie/src/js.cookie.js');
appJsFiles.push(resourceRootPath + 'jquery/dist/jquery.js');
appJsFiles.push(resourceRootPath + 'jquery-ui-dist/jquery-ui.js');
appJsFiles.push(resourceRootPath + 'bootstrap/dist/js/bootstrap.js');
appJsFiles.push(resourceRootPath + 'sweetalert2/dist/sweetalert2.js');
appJsFiles.push(resourceRootPath + 'toastr/toastr.js');

appJsFiles.push(resourceRootPath + 'select2/dist/js/select2.full.js');
appJsFiles.push(resourceRootPath + 'chart.js/dist/Chart.js');
appJsFiles.push(resourceRootPath + 'moment/moment.js');
appJsFiles.push(resourceRootPath + 'daterangepicker/daterangepicker.js');
appJsFiles.push(resourceRootPath + 'tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.js');
appJsFiles.push(resourceRootPath + 'summernote/dist/summernote-bs4.js');
appJsFiles.push(resourceRootPath + 'overlayscrollbars/js/jquery.overlayScrollbars.js');
appJsFiles.push(resourceRootPath + 'datatables.net/js/jquery.dataTables.js');
appJsFiles.push(resourceRootPath + 'datatables.net-bs4/js/dataTables.bootstrap4.js');
appJsFiles.push(resourceRootPath + 'datatables.net-scroller/js/dataTables.scroller.js');
appJsFiles.push(resourceRootPath + 'jstree/dist/jstree.js');
appJsFiles.push(resourceRootPath + 'jstree/src/misc.js');
appJsFiles.push('resources/general/plugins/pace-progress/pace.js');

appJsFiles.push(resourceRootPath + 'admin-lte/dist/js/adminlte.js');
appJsFiles.push('resources/admin/custom/js/*.js');
mix.combine(appJsFiles, publicAssetsAdminPath + 'js/app.js');

mix.copy(resourceRootPath + 'admin-lte/dist/img/', publicAssetsAdminPath + 'dist/img/');
mix.copy('resources/admin/img/', publicAssetsAdminPath + 'dist/img/');