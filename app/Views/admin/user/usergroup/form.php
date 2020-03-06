<?php

/**
 * @var \CodeIgniter\view\View $this
 */
$this->extend('admin/layouts/index');
?>

<?php $this->section('main-content'); ?>
<section class="content">

  <div class="card card-info">
    <div class="card-header">

      <h3 class="card-title"><?= print_var($contentTitle); ?></h3>
      <div class="card-tools">
        <button type="submit" form="content-form" onclick="submitPost(); return false;" class="btn btn-success btn-sm" title="Simpan"><i class="fa fa-save"></i></button>
        <a href="<?= print_var($backWardUrl) ?>" class="btn btn-secondary btn-sm" title="Batal"><i class="fa fa-reply"></i></a>
      </div>
    </div>
    <div class="card-body">

      <?php
      $modules = isset($modules) ? $modules : [];

      $userGroup = isset($userGroup) ? $userGroup : null;
      $group = getArrayString($userGroup, 'group_name');

      $attributes = array(
        'id' => 'content-form'
      );
      print_var(form_open($actionUrl, $attributes));
      ?>
      <div class="card-body">
        <div class="form-group row required">
          <label class="col-sm-2 col-form-label">Nama Grup</label>
          <div class="col-sm-10">
            <input type="text" name="group" class="form-control" placeholder="Nama Grup" value="<?php print_var($group) ?>">
          </div>
        </div>
        <div class="form-group row required">
          <label class="col-sm-12 col-form-label">Privileges:</label>
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="table-privileges" class="table  table-bordered">
                <thead>
                  <tr class="table-active">
                    <th style="width: 40px" class="text-center">#</th>
                    <th colspan="2">Module</th>
                    <th class="text-center" style="width: 65px">
                      <span class="d-block">View</span>
                      <span>
                        <input title="Check all vertical" type="checkbox" id="is_view">
                      </span>
                    </th>
                    <th class="text-center" style="width: 65px">
                      <span class="d-block">Add</span>
                      <span>
                        <input title="Check all vertical" type="checkbox" id="is_add">
                      </span>
                    </th>
                    <th class="text-center" style="width: 65px">
                      <span class="d-block">Edit</span>
                      <span>
                        <input title="Check all vertical" type="checkbox" id="is_edit">
                      </span>
                    </th>
                    <th class="text-center" style="width: 65px">
                      <span class="d-block">Delete</span>
                      <span>
                        <input title="Check all vertical" type="checkbox" id="is_delete">
                      </span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $moduleHtml  =  showModules($modules);
                  print_var($moduleHtml);

                  function showModules($modules)
                  {
                    $content = '';
                    $index = 1;
                    foreach ($modules as $module) {
                      $moduleId = $module['id'];
                      $moduleName = $module['module_name_path'];
                      $moduleDesc = $module['module_description'];

                      $needView = $module['need_view'];
                      $needEdit = $module['need_edit'];
                      $needDelete = $module['need_delete'];
                      $needAdd = $module['need_add'];

                      $moduleLabel = $moduleName;
                      if (ENVIRONMENT != 'production') {
                        $moduleLabel = $moduleId . "-" . $moduleName;
                      }

                      $isView = "privileges[" . $moduleId . "][is_view]";
                      $isAdd = "privileges[" . $moduleId . "][is_add]";
                      $isEdit = "privileges[" . $moduleId . "][is_edit]";
                      $isDelete = "privileges[" . $moduleId . "][is_delete]";

                      $content .= '<tr class="align-middle">';
                      $content .= " <td class='text-center'><a id='" . $moduleId . "' href='#' class='text-primary expand-icon'><i class='fas fa-angle-right'></i></a></td>";
                      $content .= ' <td class="text-bold" style="min-width: 300px">' . $moduleLabel . '</td>';

                      if (!($needView || $needAdd || $needDelete || $needEdit)) {

                        $content .= ' <td style="width: 65px" class="align-middle text-center"></td>';
                        $content .= ' <td colspan="4" class="align-middle text-center"></td>';
                      } else {

                        $content .= ' <td style="width: 65px" class="align-middle text-center"><input class="select_horizontal" type="checkbox"></td>';
                        if ($needView) {
                          $content .= ' <td class="align-middle text-center table-primary"><input class="is_view" type="checkbox" name="' . $isView . '" value="1"></td>';
                        } else {
                          $content .= ' <td class="align-middle text-center"></td>';
                        }
                        if ($needAdd) {
                          $content .= ' <td class="align-middle text-center table-success"><input class="is_add" type="checkbox" name="' . $isAdd . '" value="1"></td>';
                        } else {
                          $content .= ' <td class="align-middle text-center"></td>';
                        }
                        if ($needEdit) {
                          $content .= ' <td class="align-middle text-center table-warning"><input class="is_edit" type="checkbox" name="' . $isEdit . '" value="1"></td>';
                        } else {
                          $content .= ' <td class="align-middle text-center"></td>';
                        }
                        if ($needDelete) {
                          $content .= ' <td class="align-middle text-center table-danger"><input class="is_delete" type="checkbox" name="' . $isDelete . '" value="1"></td>';
                        } else {
                          $content .= ' <td class="align-middle text-center"></td>';
                        }
                      }

                      $content .= '</tr>';
                      $content .= '<tr class="module-detail" id="detail-' . $moduleId . '" class="align-middle">';
                      $content .= ' <td style="width: 40px" class="text-center">-</td>';
                      $content .= ' <td colspan="6">' . $moduleDesc . '</td>';
                      $content .= '</tr>';

                      $index++;
                    }

                    return $content;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</section>
<?php $this->endSection(); ?>

<?php $this->section('main-script'); ?>
<script>
  $("#table-privileges").find("thead th").addClass("align-middle py-1");
  $("#table-privileges .module-detail").hide();

  $("#table-privileges").find("tbody td a.expand-icon").click(function() {
    $(this).toggleClass(function() {
      var id = $(this).attr('id');
      $('#detail-' + id).toggle();
      return "expanded";
    });
    return false;
  });

  $(function() {
    function veriyIsView(element) {
      var parent = $(element).parents('tr');

      var isChecked = parent.find(".is_delete, .is_edit, .is_add").is(':checked');
      if (isChecked == true) {
        parent.find(".is_view").prop("checked", isChecked);
      }
      parent.find(".is_view").attr('disabled', isChecked);

      var isControlChecked = $("#is_add, #is_edit, #is_delete").is(':checked');

      if (isControlChecked == true) {
        $("#is_view").prop("checked", isControlChecked);
      }
      //$("#is_view").attr('disabled', isControlChecked);
    }

    $("#is_view").change(function() {
      var is_ch = $(this).prop('checked');

      $(".is_view").each(function() {
        $(this).prop("checked", is_ch);
        veriyIsView(this);
      });
    })

    $("#is_add").change(function() {
      var is_ch = $(this).prop('checked');
      $(".is_add").prop("checked", is_ch).trigger('change');
      //veriyIsView(this);
    })
    $("#is_edit").change(function() {
      var is_ch = $(this).is(':checked');
      $(".is_edit").prop("checked", is_ch).trigger('change');
      //veriyIsView(this);
    })

    $("#is_delete").change(function() {
      var is_ch = $(this).is(':checked');
      $(".is_delete").prop("checked", is_ch).trigger('change');
      //veriyIsView(this);
    })


    $(".is_view").change(function() {
      var is_ch = $(this).is(':checked');
    })

    $(".is_delete, .is_edit, .is_add").change(function() {
      var is_ch = $(this).is(':checked');
      veriyIsView(this);
    })

    $(".select_horizontal").change(function() {
      var p = $(this).parents('tr');
      var is_ch = $(this).is(':checked');
      p.find("input[type=checkbox]").prop("checked", is_ch);
      veriyIsView(this);
    })

    <?php
    $userPrivileges = isset($userPrivileges) ? $userPrivileges : [];
    ?>var privileges = <?php print_var(json_encode($userPrivileges)) ?>;
    for (let index = 0; index < privileges.length; index++) {
      var privilege = privileges[index];
      var module = privilege.module;

      var isView = 'input[name="privileges[' + module + '][is_view]"]';
      $(isView).prop("checked", true);

      if (privilege.is_add == 1) {
        var isAdd = 'input[name="privileges[' + module + '][is_add]"]';
        $(isAdd).prop("checked", true).trigger('change');
      }
      if (privilege.is_edit == 1) {
        var isEdit = 'input[name="privileges[' + module + '][is_edit]"]';
        $(isEdit).prop("checked", true).trigger('change');
      }
      if (privilege.is_delete == 1) {
        var isDelete = 'input[name="privileges[' + module + '][is_delete]"]';
        $(isDelete).prop("checked", true).trigger('change');
      }

    }

  });

  function submitPost() {
    var backWardUrl = <?php print_var($backWardUrlJson); ?>;
    var actionUrl = <?php print_var($actionUrlJson); ?>;

    var formDatas = $("#content-form").serializeArray();
    var params = {};
    for (var index = 0; index < formDatas.length; index++) {
      var formData = formDatas[index];
      params[formData.name] = formData.value;
    }

    HELPER.Html.loading();
    SERVER.post(actionUrl, params, "json", function(data, textStatus, jqXHR) {
      var status = data.status;
      HELPER.Html.loading(false);
      HELPER.Notify.notif(status, data.message, function() {
        if (HELPER.Respone.isSuccess(status)) {
          window.location = backWardUrl;
        }
      });
    }, function(jqXHR, textStatus, errorThrown) {
      HELPER.Html.loading(false);
      HELPER.Notify.failJqhr(jqXHR, textStatus, errorThrown, function() {
        window.location = backWardUrl;
      });
    });
  };
</script>
<?php $this->endSection(); ?>