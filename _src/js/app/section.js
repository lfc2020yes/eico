$(function (){

    //изменить объект
    $('body').on("change keyup input click",'.js-section-edit',js_edit_section);

    //удалить объект
    $('body').on("change keyup input click",'.js-section-del',js_section_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-section',js_add_section);

    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-section-add0", js_add_section);


});

//добавление Отдела
function section_adds()
{
    if(typeof timerId !== "undefined")
    {
        clearInterval(timerId);
        $.arcticmodal('close');
    }

    //var at= $(this).attr('tabs_g');


    $.arcticmodal({
        type: 'ajax',
        url: 'forms/section/form_add_section.php',
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
function tabs_section() {
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
        AjaxClient('section','tabs_info','GET',data,'AfterTabsInfo',$(this).attr("id"),0);
    }
}


/**вывод информации по объекту
 *
 */
function doc_section(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-section-del'))&&(!$target.hasClass('js-section-edit'))) {


        var for_id = $(this).attr('op_rel');

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/section/form_doc_section.php?id=' + for_id + '&tabs=0',
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
function js_add_section()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/section/form_add_section.php',
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
function js_edit_section(event)
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


        var id_buy = $(this).parents('.section_block_pass').attr('op_rel');
    }
    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/section/form_edit_section.php?id_buy='+id_buy,
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
function js_section_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.section_block_pass').attr('op_rel');
    }

    event.stopPropagation();




    $.arcticmodal({
        type: 'ajax',
        url: 'forms/section/form_dell_section.php?id_buy='+id_buy,
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