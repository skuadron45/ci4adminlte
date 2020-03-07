toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    showDuration: "200",
    hideDuration: "1000",
    timeOut: "2000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
}

var HELPER = (function ($) {
    if (typeof $ === 'undefined') {
        throw new TypeError('HELPER\'s JavaScript requires jQuery !');
    }

    var helper = {};

    var Respone = (function () {
        var respone = {};
        respone.isSuccess = function (status) {
            return (status === "success");
        }
        return respone;
    })();

    var Confirm = (function () {
        var confirm = {};

        confirm.delete = function (callback) {
            Swal.fire({
                title: 'Kamu yakin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus !',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
            }).then(function (result) {
                if (result.value) {
                    callback();
                }
            });
        }

        return confirm;
    })();

    var Notify = (function () {
        var notify = {};

        function notif(type, message, callback) {

            var callbackDefault = function () {
                console.log('notify callback!');
            }
            if (!(callback === null || callback === undefined)) {
                callbackDefault = callback;
            }

            var html = message;

            var undefinedMessage = 'Error tidak diketahui!';

            if (!HELPER.isset(type)) {
                type = 'null';
                html = undefinedMessage;
            }

            var types = ['success', 'info', 'warning', 'error', 'null', 'fail'];

            if (types.indexOf(type) === -1) {
                type = 'error';
                if (!HELPER.isset(message)) {
                    html = undefinedMessage;
                }
            }

            var swal = null;

            switch (type) {
                case "info":
                    toastr.info(message, "Info");
                    break;
                case "warning":
                    toastr.warning(message, "Peringatan");
                    break;
                case "success":
                    swal = Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: html,
                        allowOutsideClick: false,
                        customClass: {
                            content: 'text-success',
                        }
                    });
                    break;
                case "error":
                    swal = Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: html,
                        allowOutsideClick: false,
                        customClass: {
                            content: 'text-danger',
                        }
                    });
                    break;
                case "fail":
                    swal = Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        html: html,
                        allowOutsideClick: false,
                        customClass: {
                            content: 'text-danger',
                        }
                    });
                    break;
                case "null":
                    swal = Swal.fire({
                        icon: 'error',
                        title: 'Error Not Found',
                        html: html,
                        allowOutsideClick: false,
                        customClass: {
                            content: 'text-danger',
                        }
                    });
                    break;
                default:
                    swal = Swal.fire({
                        icon: 'error',
                        title: type,
                        html: html,
                        allowOutsideClick: false,
                        customClass: {
                            content: 'text-danger',
                        }
                    });
            };

            if (HELPER.isset(swal)) {
                swal.then(function (result) {
                    callbackDefault();
                });
            }

            toastr.subscribe(function () {
                callbackDefault();
            });
        }

        notify.notif = notif;

        notify.success = function (message, callback) {
            notif('success', message, callback);
        }

        notify.error = function (message, callback) {
            notif('error', message, callback);
        }

        notify.warning = function (message, callback) {
            notif('error', message, callback);
        }

        notify.info = function (message, callback) {
            notif('info', message, callback);
        }

        function failJqhr(jqXHR, textStatus, errorThrown, callback) {

            var callbackDefault = function () {
            }
            if (HELPER.isset(callback)) {
                callbackDefault = callback;
            }

            if (typeof errorThrown === "object") {
                notif('', errorThrown.message, callbackDefault);
            } else {
                var json = jqXHR.responseJSON;
                if (HELPER.isset(json)) {
                    var errorMessage = json.messages.error;
                    notif('fail', errorMessage, callbackDefault);
                } else {
                    notif('fail', jqXHR.status + "-" + jqXHR.statusText, callbackDefault);
                }
            }
        }

        notify.failJqhr = failJqhr;

        notify.failJqhrReload = function (jqXHR, textStatus, errorThrown) {
            function callback() {
                location.reload();
            }
            failJqhr(jqXHR, textStatus, errorThrown, callback);
        }
        return notify;
    })();

    var Html = (function () {
        var html = {};

        html.aHref = function (link, className, title, icon) {
            return '<a href="' + link + '" class="' + className + '" title ="' + title + '">' + icon + '</a>';
        }

        html.aHref = function (link, className, title, icon) {
            return '<a href="' + link + '" class="' + className + '" title ="' + title + '">' + icon + '</a>';
        }

        html.aTag = function (onclick, className, title, icon) {
            return '<a href="javascript:void(0)" onclick="' + onclick + '" class="' + className + '" title ="' + title + '">' + icon + '</a>';
        }

        html.buttonTag = function (onclick, className, title, icon) {
            return '<button onclick="' + onclick + '" class="' + className + '" title ="' + title + '">' + icon + '</button>';
        }

        html.loading = function (state) {
            if ((state === null || state === undefined)) {
                $("#spinner-front, #spinner-back").addClass('show');
            } else {
                $("#spinner-front, #spinner-back").removeClass('show');
            }
        }

        return html;
    })();

    helper.isset = function (param) {
        return (!(param === null || param === undefined));
    }

    helper.renewCsrfForm = function (data) {
        var csrfName = data.csrfName;
        var csrfToken = data.csrfToken;
        $('input[name=' + csrfName + ']').val(csrfToken);
        console.log("renew csrf: " + csrfToken);
    }

    helper.Respone = Respone;
    helper.Notify = Notify;
    helper.Confirm = Confirm;
    helper.Html = Html;
    return helper;
})($);