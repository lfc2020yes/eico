$(function (){

    //изменить объект
    $('body').on("change keyup input click",'.js-business-edit',js_edit_business);

    //удалить объект
    $('body').on("change keyup input click",'.js-business-del',js_business_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-business',js_add_business);

    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-business-add0", js_add_business);


});



/**
 добавить новый объект
 **/
function js_add_business()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/business/form_add_business.php',
        beforeOpen: function(data, el) {
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');

        },
        afterOpen: function(data, el) {
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
            ToolTip();
        },
        afterClose: function(data, el) { // после закрытия окна ArcticModal
            clearInterval(timerId);
        }

    });
}

/**
 * изменить Объекта
 */
function js_edit_business(event)
{
    //alert("!");
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }
    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {


        var id_buy = $(this).parents('.business_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/business/form_edit_business.php?id_buy='+id_buy,
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

}


/**
 * удалить объект
 */
function js_business_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.business_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/business/form_dell_business.php?id_buy='+id_buy,
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

}