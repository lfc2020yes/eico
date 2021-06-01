$(function (){

    //изменить объект
    $('body').on("change keyup input click",'.js-assess-edit',js_edit_assess);

    //удалить объект
    $('body').on("change keyup input click",'.js-assess-del',js_assess_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-assess',js_add_assess);

    //добавить новый объект меню слева
    $('body').on("change keyup input click",".js-assess-add0", js_add_assess);

    //получение информации по нажатию на объект
    $('.js-cloud-assess').on("click",".js-info-assess",doc_assess);
    //нажатие на вкладку в форме информации по объекту
  //  $('body').on("change keyup input click",'.tabsss',tabs_assess);

});

/**табсы в окне об объекте
 *
 */
function tabs_assess() {
    //alert("!");
    var uoo=$(this).attr("id");
    if ( $(this).is(".active") )
    {
        //уже активная вкладка
    } else
    {
        $('.client_window .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        $('.js-tabs-menu').find('.tabsss').removeClass('active');
        $('.js-tabs-menu').find('.tabsss[id='+uoo+']').addClass('active');

        //var key_='002U';

        var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
            '&tk='+$('.h111').attr('mor')+
            '&id='+$('.h111').attr('for');
        //alert(data);
        AjaxClient('assess','tabs_info','GET',data,'AfterTabsInfo',$(this).attr("id"),0);
    }
}


/**вывод информации по объекту
 *
 */
function doc_assess(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-assess-del'))&&(!$target.hasClass('js-assess-edit'))) {


        var for_id = $(this).attr('op_rel');

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/assess/form_doc_assess.php?id=' + for_id + '&tabs=0',
            beforeOpen: function (data, el) {
                $('.loader_ada_forms').show();
                $('.loader_ada1_forms').addClass('select_ada');

            },
            afterOpen: function (data, el) {
                $('.loader_ada_forms').hide();
                $('.loader_ada1_forms').removeClass('select_ada');
                ToolTip();
            },
            afterClose: function (data, el) { // после закрытия окна ArcticModal
                clearInterval(timerId);
            }

        });
    }
}


/**
 добавить новый объект
 **/
function js_add_assess()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/access/form_add_assess.php',
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
function js_edit_assess(event)
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


        var id_buy = $(this).parents('.assess_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/access/form_edit_assess.php?id_buy='+id_buy,
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
function js_assess_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.assess_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/access/form_dell_assess.php?id_buy='+id_buy,
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