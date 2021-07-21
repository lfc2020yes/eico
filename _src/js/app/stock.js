$(function () {


//нажатие на кнопку добавить наименование на склад
    $('body').on("change keyup input click",'.js-add-stock', add_invoice1);
    $('body').on("change keyup input click",'.js-print-stock',PrintStock_);
});

//добавить наименование на склад
function add_invoice1()
{


    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_add_stock.php',
        beforeOpen: function (data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function (data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function (data, el) { // после закрытия окна ArcticModal
            if (typeof timerId !== "undefined") {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });

}


//открыть форму сформировать отчет
function PrintStock_()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_print_stock.php?id='+$('#sort_stock4').val(),
        beforeOpen: function (data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function (data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function (data, el) { // после закрытия окна ArcticModal
            if (typeof timerId !== "undefined") {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });
}

