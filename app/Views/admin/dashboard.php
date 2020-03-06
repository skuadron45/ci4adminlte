<?php

/**
 * @var \CodeIgniter\view\View $this
 */
$this->extend('admin/layouts/index');
?>
<?php $this->section('main-content'); ?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Dashboard</h3>
        <div class="card-tools">
        </div>
      </div>
      <div class="card-body">
        <?php
        if (ENVIRONMENT != 'production') {
          var_dump($this->getData()['debugs']);
        }
        ?>
      </div>
    </div>

  </div> <!-- /.container-fluid -->
</section>
<!-- /.content -->
<?php $this->endSection(); ?>