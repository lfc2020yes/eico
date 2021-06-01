$(function (){

    //изменить объект
    //$('body').on("change keyup input click",'.js-pass-edit',js_edit_pass);

    //удалить объект
    $('body').on("change keyup input click",'.js-set-del',js_set_del);


});

/*
 * удалить объект
 */
function js_set_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.set_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/set/form_dell_set.php?id_buy='+id_buy,
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

    /*
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/pass/form_dell_pass.php?id_buy='+id_buy,
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
}