var SERVER = (function ($) {
    if (typeof $ === 'undefined') {
        throw new TypeError('SERVER\'s JavaScript requires jQuery!');
    }

    var server = {};

    var ajax = function (method, url, params, dataType, doneCb, failCb) {

        console.log(params);

        var defaultDataType = "json";

        if (HELPER.isset(dataType)) {
            defaultDataType = dataType;
        }

        var jqHr = $.ajax({
            url: url,
            type: method,
            data: params,
            dataType: defaultDataType
        });
        jqHr.done(doneCb);
        jqHr.fail(failCb);

    }

    server.post = function (url, params, dataType, doneCb, failCb) {

        var csrfToken = Cookies.get(_CSRF_COOKIE);
        if (!HELPER.isset(csrfToken)) {
            csrfToken = $('input[name=' + _CSRF_NAME + ']').val();
        }
        params[_CSRF_NAME] = csrfToken;

        var defaultDone = function (data, textStatus, jqXHR) {
            HELPER.renewCsrfForm(data);
            if (HELPER.isset(doneCb)) {
                doneCb(data, textStatus, jqXHR);
            } else {
                HELPER.Notify.notif(data.status, data.message);
            }
        }

        var defaultFail = function (jqXHR, textStatus, errorThrown) {
            if (HELPER.isset(failCb)) {
                failCb(jqXHR, textStatus, errorThrown);
            } else {
                HELPER.Html.loading(false);
                HELPER.Notify.failJqhrReload(jqXHR, textStatus, errorThrown);
            }
        }
        ajax("POST", url, params, dataType, defaultDone, defaultFail);
    };

    server.get = function (url, params, dataType, doneCb, failCb) {

        var defaultDone = function (data, textStatus, jqXHR) {
            if (HELPER.isset(doneCb)) {
                doneCb(data, textStatus, jqXHR);
            } else {
                HELPER.Notify.notif(data.status, data.message);
            }
        }

        var defaultFail = function (jqXHR, textStatus, errorThrown) {
            if (HELPER.isset(failCb)) {
                failCb(jqXHR, textStatus, errorThrown);
            } else {
                HELPER.Notify.failJqhr(jqXHR, textStatus, errorThrown);
            }
        }

        ajax("GET", url, params, dataType, defaultDone, defaultFail);
    };

    return server;
})($);