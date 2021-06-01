$(function (){

    //изменить объект
    $('body').on("change keyup input click",'.js-object-edit',js_edit_object);

    //удалить объект
    $('body').on("change keyup input click",'.js-object-del',js_object_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-office',office_adds);
    $('.menu_x').on("change keyup input click",".js-office-add0", office_adds);



    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-object-add0", js_add_object);

    //получение информации по нажатию на объект
    $('.js-cloud-object').on("click",".js-info-object",doc_object);
    //нажатие на вкладку в форме информации по объекту
    $('body').on("change keyup input click",'.tabsss',tabs_object);

});

//добавление офиса
function office_adds()
{
    if(typeof timerId !== "undefined")
    {
        clearInterval(timerId);
        $.arcticmodal('close');
    }

    //var at= $(this).attr('tabs_g');


    $.arcticmodal({
        type: 'ajax',
        url: 'forms/object/form_add_object.php',
        beforeOpen: function(data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function(data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function(data, el) { // после закрытия окна ArcticModal
            if(typeof timerId !== "undefined")
            {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });



}


/**табсы в окне об объекте
 *
 */
function tabs_object() {
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
        AjaxClient('object','tabs_info','GET',data,'AfterTabsInfo',$(this).attr("id"),0);
    }
}


/**вывод информации по объекту
 *
 */
function doc_object(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-object-del'))&&(!$target.hasClass('js-object-edit'))) {


        var for_id = $(this).attr('op_rel');

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/object/form_doc_object.php?id=' + for_id + '&tabs=0',
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
function js_add_object()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/object/form_add_object.php',
        beforeOpen: function(data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function(data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function(data, el) { // после закрытия окна ArcticModal
            if(typeof timerId !== "undefined")
            {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });
}

/**
 * изменить Объекта
 */
function js_edit_object(event)
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


        var id_buy = $(this).parents('.object_block_pass').attr('op_rel');
    }
    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/object/form_edit_object.php?id_buy='+id_buy,
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


/**
 * удалить объект
 */
function js_object_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.object_block_pass').attr('op_rel');
    }

    event.stopPropagation();




    $.arcticmodal({
        type: 'ajax',
        url: 'forms/object/form_dell_object.php?id_buy='+id_buy,
        beforeOpen: function(data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function(data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function(data, el) { // после закрытия окна ArcticModal
            if(typeof timerId !== "undefined")
            {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });



}