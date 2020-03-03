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
<script>
  var grid = "USERGROUP";
  var fields = [{
    header: 'No',
    width: "50px",
    className: 'text-center',
  }, {
    header: 'Group',
    orderable: true,
    searchable: true
  }];

  var urlController = _CURRENT_URL;
  var editUrl = urlController + '/edit/';
  var actionsField = {
    header: 'Aksi',
    width: "100px",
    className: 'text-center',
    render: function(data, type, row, meta) {
      var html = HELPER.Html.aHref(editUrl + data, "btn btn-xs text-info", "Edit", '<i class="fa fa-pencil-alt"></i>');
      html += DTHELPER.deleteButton(data, grid);
      return html;
    }
  };

  fields.push(actionsField);

  var dtUrl = urlController + '/getdata';
  var addLink = urlController + '/create';
  var deleteUrl = urlController + '/delete';

  var extraButtons = HELPER.Html.aHref(addLink, "btn btn-success btn-sm", "Add", '<i class="fas fa-plus-circle"></i>');
  var config = {
    id: 'main-table',
    url: dtUrl,
    deleteUrl: deleteUrl,
    fields: fields,
    addModal: false,
    extraButtons: extraButtons
  }
  new DtBuilder(grid, config);
</script>

<?php $this->endSection(); ?>