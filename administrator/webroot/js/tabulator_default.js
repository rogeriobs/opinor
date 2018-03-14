var fn_checkInput = function (value, data, cell, row, options) { //plain text value  

    var checkbox = $('<input class="check-selectable" type="checkbox" name="__dataGrid" value="' + data.id + '">');

    checkbox.click(function (e) {

        e.stopPropagation();

        if ($(this).prop("checked")) {
            tablePU.tabulator("selectRow", data.id);
        } else {
            tablePU.tabulator("deselectRow", data.id);
        }

        if (typeof (timeSAct) !== 'undefined') {
            clearTimeout(timeSAct);
        }

        timeSAct = setTimeout(function () {
            var containerActs = tablePU.parents(".container-grid").children(".container-tools-grid");
            var total_selecionados = tablePU.tabulator("getSelectedData").length;
            if (total_selecionados > 0) {

                containerActs.find(".btn-only-selected").fadeIn(150);

                if (total_selecionados == 1) {
                    containerActs.find(".btn-only-one").fadeIn(150);
                } else {
                    containerActs.find(".btn-only-one").fadeOut(100);
                }

            } else {

                containerActs.find(".btn-only-selected").fadeOut(100);
                containerActs.find(".btn-only-one").fadeOut(100);
            }
        }, 100);

    });

    return checkbox;
};

function __load_setData() {

    var url = tablePU.data("load");

    $(".btn-only-one, .btn-only-selected").fadeOut(50);

    $.ajax({
        url: url,
        cache: false,
        global: false,
        beforeSend: function (xhr) {

            tablePU.prepend(get_loading_inner_tabulator());
        },
        success: function (data, textStatus, jqXHR) {

            tablePU.tabulator("setData", data);
        }
    });
}

$(function () {

    var area_tools = tablePU.parents(".container-grid").children(".container-tools-grid");

    area_tools.find(".select-all").click(function () {

        tablePU.tabulator("deselectRow");

        tablePU.find(".check-selectable").each(function (i, e) {
            $(e).prop("checked", false);
            $(e).trigger("click");
        });
    });

    area_tools.find(".deselect-all").click(function () {
        tablePU.find(".check-selectable").each(function (i, e) {
            $(e).prop("checked", true);
            $(e).trigger("click");
        });
    });

    area_tools.find(".remove-selected").click(function () {

        var selectedData = tablePU.tabulator("getSelectedData");
        var $this = $(this);

        var qtdSelected = selectedData.length;

        if (qtdSelected == 0) {
            return false;
        }

        $.confirm({
            theme: 'supervan',
            animationSpeed: 150,
            title: 'Confirme a exclusão',
            content: "Foram selecionados <b>" + qtdSelected + "</b> registros, deseja continuar a exclusão?",
            buttons: {
                confirmar: {
                    text: 'Excluir',
                    btnClass: 'btn-red',
                    keys: ['enter', 's'],
                    action: function () {

                        var jsonData = JSON.stringify(selectedData);
                        var url = $this.data("urldelete");

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: jsonData,
                            success: function (data, textStatus, jqXHR) {
                                __load_setData();
                                $.toast(data);
                            }
                        });

                    }
                },
                cancelar: {
                    text: 'Cancelar!',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'c'],
                    action: function () {
                        // button action.
                    }
                },
            }
        });
    });

    area_tools.find(".edit-selected").click(function (e) {

        e.preventDefault();

        var $this = $(this);
        var modal = $($this.data("modal"));
        var id = tablePU.find(".check-selectable:checked").eq(0).val();
        var url = $this.data("urledit") + "/" + id;

        if (typeof (id) == 'undefined') {
            return false;
        }

        if (modal.length == 0) {

            window.location.href = url;

            return false;
        }

        $.ajax({
            url: url,
            cache: false,
            global: false,
            beforeSend: function (xhr) {
                modal.find('.modal-content').html(get_loading_inner_modal());
            },
            success: function (data, textStatus, jqXHR) {
                modal.find('.modal-content').html(data);
            }
        });

        modal.modal("show");

    });


    //trigger download of data.csv file
    $(".download-csv").click(function () {
        tablePU.tabulator("download", "csv", "data.csv");
    });

    __load_setData();
});