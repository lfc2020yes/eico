$(function (){

    //изменить объект
    $('body').on("change keyup input click",'.js-question-edit',js_edit_question);


    //удалить объект
    $('body').on("change keyup input click",'.js-question-del',js_question_del);
    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-question',js_add_question);
    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-question-add0", js_add_question);
    //получение информации по нажатию на объект
    $('.js-cloud-question').on("click",".js-info-question",doc_question);
    //нажатие на вкладку в форме информации по объекту
    $('body').on("change keyup input click",'.tabsss',tabs_question);

});

/**табсы в окне об объекте
 *
 */
function tabs_question() {
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
        AjaxClient('question','tabs_info','GET',data,'AfterTabsInfo',$(this).attr("id"),0);
    }
}


/**вывод информации по объекту
 *
 */
function doc_question(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-question-del'))&&(!$target.hasClass('js-question-edit'))) {


        var for_id = $(this).attr('op_rel');

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/question/form_doc_question.php?id=' + for_id + '&tabs=0',
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
function js_add_question()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/question/form_add_question.php',
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
function js_edit_question(event)
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


        var id_buy = $(this).parents('.question_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/question/form_edit_question.php?id_buy='+id_buy,
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
function js_question_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.question_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/question/form_dell_question.php?id_buy='+id_buy,
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