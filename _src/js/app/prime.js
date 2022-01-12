$(function () {


//добавить раздел
    $(".add__razdel").bind('change keyup input click', add_button_block);

    $('.material-prime-v2').on("click",'.history_icon',HistoryN1);


    $('body').on("click",'.js-sort-prime-material',SortMatPrime);

})

function SortMatPrime()
{
var id_house=$(this).attr('for');

var sort=$(this).attr('sort');
    var tr = $('tr[work_house='+id_house+']');

    if(sort==0) {
        var alphabeticallyOrderedTr = tr.get().sort(function (a, b) {
            return $(a).find(".s_j_name_sort").text().toLowerCase().localeCompare($(b).find(".s_j_name_sort").text().toLowerCase());
        });
        $(this).attr('sort',1);
    } else
    {
        var alphabeticallyOrderedTr = tr.get().sort(function (a, b) {
            return $(a).attr("rel_ma").localeCompare($(b).attr("rel_ma"));
        });
        $(this).attr('sort',0);
    }

    //$("#container").append(alphabeticallyOrderedTr);
    //console.log(alphabeticallyOrderedTr);

    $('tr[rel_id='+id_house+']').after(alphabeticallyOrderedTr);

}


//удалить раздел в себестоимости
function del_button_block()  {



    if ( $(this).is("[for]") )
    {
        if($.isNumeric($(this).attr("for")))
        {
            /*
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_dell_block.php?id='+$(this).attr("for"),
                afterLoading: function(data, el) {
                    //alert('afterLoading');
                },
                afterLoadingOnShow: function(data, el) {
                    //alert('afterLoadingOnShow');
                },
                afterClose: function(data, el) { // после закрытия окна ArcticModal
                    clearInterval(timerId);
                }

            });
            */

            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_dell_block_new.php?id=' + $(this).attr("for"),
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
    }

    return false;


}



//редактировать раздел в себестоимости
function edit_button_block()
{


    if ($(this).is("[for]")) {
        if ($.isNumeric($(this).attr("for"))) {
            /*
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_edit_block.php?id=' + $(this).attr("for"),
                afterLoading: function (data, el) {
                    //alert('afterLoading');
                },
                afterLoadingOnShow: function (data, el) {
                    //alert('afterLoadingOnShow');
                },
                afterClose: function (data, el) { // после закрытия окна ArcticModal
                    clearInterval(timerId);
                }

            });
*/

            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_edit_block_new.php?id=' + $(this).attr("for"),
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
    }

    return false;


}


//добавить работу для блока в себестоимости
function add_button_rabota() {

    if($(this).is("[for]"))
    {
        if($.isNumeric($(this).attr("for")))
        {
            /*
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_add_rabota.php?id='+$(this).attr("for")+'&freez='+$('#frezezz').val(),
                afterLoading: function(data, el) {
                    //alert('afterLoading');
                },
                afterLoadingOnShow: function(data, el) {
                    //alert('afterLoadingOnShow');
                },
                afterClose: function(data, el) { // после закрытия окна ArcticModal
                    clearInterval(timerId);
                }

            });
*/
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_add_rabota_new.php?id='+$(this).attr("for")+'&freez='+$('#frezezz').val(),
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
    }

    return false;

}

//добавить раздел в себестоимости
function add_button_block() {



    if ( $('.content_block').is("[dom]") )
    {

        if($.isNumeric($('.content_block').attr("dom")))
        {

            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_add_block.php?id='+$('.content_block').attr("dom"),
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
    }

    return false;


}