function get_loading_inner_tabulator() {
    return "<div id='loading-inner-tabulator'><div class='cssload-container'><div class='cssload-zenith'></div></div></div>";
}
function hide_loading_inner_tabulator() {
    $("#loading-inner-tabulator").fadeOut(150, function () {
        $(this).remove();
    });
}

function get_loading_inner_modal() {
    return "<div id='loading-inner-modal'><div class='cssload-container'><div class='cssload-zenith'></div></div></div>";
}

function hide_loading_inner_modal() {
    $("#loading-inner-modal").fadeOut(150, function () {
        $(this).remove();
    });
}

function get_loading_inner_html() {
    return '<div id="loading-inner-html"><div class="cssload-loading"><div class="cssload-finger cssload-finger-1"><div class="cssload-finger-item"><span></span><i></i></div></div><div class="cssload-finger cssload-finger-2"><div class="cssload-finger-item"><span></span><i></i></div></div><div class="cssload-finger cssload-finger-3"><div class="cssload-finger-item"><span></span><i></i></div></div><div class="cssload-finger cssload-finger-4"><div class="cssload-finger-item"><span></span><i></i></div></div><div class="cssload-last-finger"><div class="cssload-last-finger-item"><i></i></div></div></div></div>';
}
function hide_loading_inner_html() {
    $("#loading-inner-html").fadeOut(150, function () {
        $(this).remove();
    });
}

$(function () {
    $.ajaxSetup({
        cache: false,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            alert(errorThrown + " - " + textStatus);
        }
    });

    $(document).ajaxStart(function () {
        console.log("ajaxStart");
        //showLoading();
    });

    $(document).ajaxComplete(function (event, xhr, settings) {
        console.log("ajaxComplete");
    });

    $(document).ajaxStop(function () {
        console.log("ajaxStop");
    });

    $(document).on("submit", ".form-async-modal", function (event) {

        event.preventDefault();

        var data = $(this).serialize();
        var action = $(this).prop("action");
        var method = $(this).prop("method");
        var modal = $("#" + $(this).data("modal"));

        if (typeof (reqSub) == 'object') {
            if (reqSub.readyState != 4) {
                return false;
            }
        }

        reqSub = $.ajax({
            url: action,
            type: method,
            data: data,
            global: false,
            beforeSend: function (xhr) {
                modal.find('.modal-content').html(get_loading_inner_modal());
            },
            success: function (data, textStatus, jqXHR) {

                modal.find('.modal-content').html(data);

                //por default
                console.log(typeof (__load_setData));
                if (typeof (__load_setData) == 'function') {
                    __load_setData();
                }
            }
        });

    });

    $(document).on("click", ".get-async-modal", function (e) {

        e.preventDefault();

        var $this = $(this);
        var modal = $($(this).data("modal"));

        if (modal.length === 0)
            return false;

        $.ajax({
            url: $this.prop("href"),
            cache: false,
            global: false,
            beforeSend: function (xhr) {
                modal.find('.modal-content').html(get_loading_inner_modal());
            },
            success: function (data, textStatus, jqXHR) {
                modal.find('.modal-content').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                switch (jqXHR.status) {
                    case 403:
                        window.location.reload();
                        break;
                    case 404:
                    case 500:
                        modal.find('.modal-content').html(jqXHR.responseText);
                        break;
                }
            }
        });

        modal.modal("show");
    });

    $("#scoop").fadeIn(200);
});