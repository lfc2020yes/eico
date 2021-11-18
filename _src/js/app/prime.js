$(function () {


//добавить раздел
    $(".add__razdel").bind('change keyup input click', add_button_block);

    $('.material-prime-v2').on("click",'.history_icon',HistoryN1);



})


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