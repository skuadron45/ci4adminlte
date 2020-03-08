<?php

/**
 * @var \CodeIgniter\view\View $this
 */
$this->extend('admin/layouts/index');
?>
<?php $this->section('main-content'); ?>
<section class="content">
  <?php
  echo $this->include('admin/layouts/gridmodal');
  ?>
</section>
<?php $this->endSection(); ?>

<?php $this->section('main-script'); ?>
<?php
$userGroupsDs = isset($userGroupsDs) ? $userGroupsDs : json_encode([]);
?>
<script>
  var userGroupsDs = <?php print_var($userGroupsDs) ?>;
  var grid = "USER";
  var fields = [{
    header: 'No',
    width: "50px",
    className: 'text-center',
  }, {
    header: 'Username',
    orderable: true,
    searchable: true
  }, {
    header: 'Nama',
    orderable: true,
    searchable: true
  }, {
    header: 'Email',
    orderable: true,
    searchable: true
  }];

  var urlController = _CURRENT_URL;
  var actionsField = {
    header: 'Aksi',
    width: "100px",
    className: 'text-center',
    render: function(data, type, row, meta) {
      var html = DTHELPER.editButton(data, form);
      html += DTHELPER.deleteButton(data, grid);
      return html;
    }
  };

  fields.push(actionsField);

  var dtUrl = urlController + '/getdata';
  var deleteUrl = urlController + '/delete/';
  var config = {
    id: 'main-table',
    url: dtUrl,
    deleteUrl: deleteUrl,
    fields: fields,
    addModal: true
  }
  new DtBuilder(grid, config);

  var form = grid + "_FORM";
  var formFields = [{
    label: 'Username',
    name: 'username',
    required: true
  }, {
    label: 'Nama Lengkap',
    name: 'fullname',
    required: true
  }, {
    label: 'Password',
    name: 'password',
    type: 'password',
    required: true
  }, {
    label: 'Grup Pengguna',
    name: 'user_group',
    type: 'select',
    required: true,
    dataSource: userGroupsDs
  }];

  var formConfig = {
    table: grid,
    fields: formFields,
    findUrl: _CURRENT_URL + "/find",
    saveUrl: _CURRENT_URL + "/store"
  };
  new ModalFormBuilder(form, formConfig);
</script>
<?php $this->endSection(); ?>