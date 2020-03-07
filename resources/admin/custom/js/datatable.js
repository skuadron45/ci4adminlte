var DTHELPER = (function ($) {
    if (typeof $ === 'undefined') {
        throw new TypeError('DTHELPER\'s JavaScript requires jQuery!');
    }
    var dtHelper = {};

    dtHelper.deleteButton = function (idParam, tableName) {

        return HELPER.Html.buttonTag(tableName + ".onDelete('" + idParam + "')", "btn btn-xs text-danger", "Delete", "<i class=\"fas fa-times-circle\"></i>");
    }

    dtHelper.editButton = function (idParam, tableName) {
        return HELPER.Html.buttonTag(tableName + ".onEdit('" + idParam + "')", "btn btn-xs text-info", "Edit", "<i class=\"fa fa-pencil-alt\"></i>");
    }

    dtHelper.getActionHref = function (editLink, deleteLink) {
        return {
            header: 'Aksi',
            width: "100px",
            className: 'text-center',
            render: function (data, type, row, meta) {
                var html = HELPER.Html.aHref(editLink + data, "btn btn-xs text-info", "Edit", '<i class="fa fa-pencil-alt"></i>');
                html += HELPER.Html.aHref(deleteLink + data, "btn btn-xs text-danger", "Delete", '<i class="fas fa-times-circle"></i>');
                return html;
            }
        }
    }
    return dtHelper;
})($);

function DtBuilder(name, options) {
    var self = this;
    self.instance = null;
    window[name] = self;

    var defaultOption = {
        method: "GET",
        addModal: false,
        extraButtons: "",
        deleteUrl: ''
    }

    self.name = name;
    self.options = $.extend(defaultOption, options);

    $(function () {
        self._init();
    });
}
(function () {
    this.th = function (text) {
        return '<th>' + text + '</th>';
    };
    this.tr = function (html) {
        return '<tr>' + html + '</tr>';
    };

    this._init = function () {
        this.buildButtons();
        this.buildTableHeader();
        this.buildDataTable();
    };

    this.buildButtons = function () {
        var name = this.name;
        var options = this.options;

        var buttons = '';
        options.extraButtons && (buttons += options.extraButtons);
        options.addModal && (buttons += ' <button type="button" onclick="' + name + '_FORM.onShow()" class="btn btn-success btn-sm" title="Add"><i class="fas fa-plus-circle"></i></button>');

        $("#main-table-buttons").html(buttons);
    }

    this.buildTableHeader = function () {
        var tds = '';
        var id = this.options.id;
        var fields = this.options.fields;
        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];
            tds += this.th(field.header);
        }
        var thead = $('#' + id).find('thead')[0];
        $(thead).html(this.tr(tds));
    }

    this.onDelete = function (id) {
        var self = this;

        HELPER.Confirm.delete(function () {
            var deleteUrl = self.options.deleteUrl;
            var params = {};
            params.id = id;

            HELPER.Html.loading();
            SERVER.get(deleteUrl, params, "json", function (data) {
                HELPER.Html.loading(false);

                var status = data.status;
                HELPER.Notify.notif(data.status, data.message);
                if (HELPER.Respone.isSuccess(status)) {
                    self.refresh();
                }
            }, function (jqXHR, textStatus, errorThrown) {

                HELPER.Html.loading(false);
                HELPER.Notify.failJqhrReload(jqXHR, textStatus, errorThrown);
            });
        });
    }

    this.refresh = function () {
        self.instance.draw();
    }

    this.buildDataTable = function () {

        var id = this.options.id;
        var url = this.options.url;
        var method = this.options.method;

        var fields = this.options.fields;
        var searchable = false;
        var columnDefs = [];
        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];
            var fieldDefault = {
                className: '',
                searchable: false,
                name: '',
                orderable: false,
                width: null,
                render: function (data, type, row, meta) {
                    return data;
                }
            };
            field = $.extend(fieldDefault, field);

            if (field.searchable === true) {
                searchable = true;
            }

            var columnDef = {};
            columnDef.className = field.className;
            columnDef.searchable = field.searchable;
            columnDef.orderable = field.orderable;
            columnDef.width = field.width;
            columnDef.name = field.name;
            columnDef.render = field.render;
            columnDef.targets = index;
            columnDefs.push(columnDef);
        }

        var general = {
            ajax: {
                url: url,
                type: method,
            },
            serverSide: true,
            processing: true,
            searching: searchable,
            order: [],
            columnDefs: columnDefs
        }
        self.instance = $('#' + id).DataTable(general);
    }


}).call(DtBuilder.prototype);


function ModalFormBuilder(name, options) {
    var self = this;
    self.name = name;
    window[name] = self;

    var defaultIdValue = 0;
    var defaultOption = {
        idValue: defaultIdValue,
        name: name,
        findUrl: '',
        saveUrl: '',
        fields: [],
        className: ''
    }
    self.defaultIdValue = defaultIdValue;
    self.options = $.extend(defaultOption, options);
}
(function () {

    this.renderField = function (field) {
        var type = field.type;

        var fieldId = field.name;
        var fieldName = field.name;
        var placeholder = (field.placeholder ? field.placeholder : "");
        var dataSource = (field.dataSource ? field.dataSource : {});

        var html = '<div class="form-group ' + (field.required ? "required" : "") + '">';
        html += '<label for="' + field.name + '">' + field.label + "</label>";
        switch (type) {
            case "password":
                //html += '<input type="password" class="form-control form-control-sm" id="' + fieldId + '" name="' + fieldName + '" placeholder="' + placeholder + '">';
                html += '<div class="input-group input-group-sm">';
                html += '<input type="password" class="form-control" id="' + fieldId + '" name="' + fieldName + '" placeholder="' + placeholder + '">';
                html += '<div class="input-group-append">';
                html += '<span class="input-group-text"><i class="fa fa-key"></i></span>';
                html += '</div>';
                html += '</div>';

                break;
            case "textarea":
                html += '<textarea rows="5" class="form-control form-control-sm" id="' + fieldId + '" name="' + fieldName + '" placeholder="' + placeholder + '"></textarea>';
                break;
            case "select":
                html += '<select class="form-control input-sm select2" id="' + fieldId + '" name="' + fieldName + '" data-placeholder="' + placeholder + '">'
                for (var key in dataSource) {
                    if (dataSource.hasOwnProperty(key)) {
                        var value = dataSource[key];
                        html += '<option value="' + key + '">' + value + '</option>';
                    }
                }
                html += '</select>';
                break;
            default:
                html += '<input type="text" class="form-control form-control-sm" id="' + fieldId + '" name="' + fieldName + '" placeholder="' + placeholder + '">'
        }
        html += "</div>";
        return html;
    }

    this.populateValue = function (record) {

        var options = this.options;
        var fields = options.fields;

        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];
            var fieldName = field.name;
            var type = field.type;
            var value = (record[fieldName] ? record[fieldName] : '');
            switch (type) {
                case "select":
                    $('#' + fieldName).val(value).trigger('change');
                    break;
                default:
                    $('#' + fieldName).val(value);
            }
        }

    }

    this.renderForm = function () {
        var options = this.options;
        var className = options.className;
        var fields = options.fields;
        var html = "";
        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];
            html += this.renderField(field);
        }
        $("#modal-form-fields").html(html);

        $(document).find(".select2:enabled").select2({
            theme: 'bootstrap'
        });

        $("#main-modal").modal({
            backdrop: 'static'
        });
        $(".modal-dialog").addClass(className);
        $("#main-modal-submit-button").attr("onclick", this.name + ".submit(event)");
    }

    this.onShow = function () {
        var options = this.options;
        options.idValue = this.defaultIdValue;
        this.renderForm();
        $("#main-modal-submit-button").html('<i class="fa fa-save"></i> Simpan');
    }

    this.onEdit = function (id) {
        var self = this;
        var options = this.options;
        options.idValue = id;
        var params = {};
        params.id = id;
        var findUrl = options.findUrl;


        HELPER.Html.loading();
        SERVER.get(findUrl, params, "json", function (data) {
            HELPER.Html.loading(false);

            var status = data.status;
            if (HELPER.Respone.isSuccess(status)) {

                self.renderForm();
                $("#main-modal-submit-button").html('<i class="fa fa-save"></i> Ubah');
                self.populateValue(data.record);

            } else {
                HELPER.Notify.notif(data.status, data.message);
            }
        }, function (jqXHR, textStatus, errorThrown) {
            HELPER.Html.loading(false);
            HELPER.Notify.failJqhr(jqXHR, textStatus, errorThrown);
        });
    }

    this.submit = function (e) {
        var options = this.options;
        var idValue = options.idValue;
        var params = {};
        params.id = idValue;

        var formDatas = $("#modal-form").serializeArray();
        for (var index = 0; index < formDatas.length; index++) {
            var formData = formDatas[index];
            params[formData.name] = formData.value;
        }
        var saveUrl = options.saveUrl;

        HELPER.Html.loading();
        SERVER.post(saveUrl, params, "json", function (data, textStatus, jqXHR) {

            HELPER.Html.loading(false);
            var status = data.status;
            HELPER.Notify.notif(data.status, data.message);
            if (HELPER.Respone.isSuccess(status)) {
                var table = options.table;
                (window[table]) ? window[table].refresh() : '';
                $("#main-modal").modal("hide");
            }
        }, function (jqXHR, textStatus, errorThrown) {
            HELPER.Html.loading(false);
            HELPER.Notify.failJqhrReload(jqXHR, textStatus, errorThrown);
        });
    }

}).call(ModalFormBuilder.prototype);