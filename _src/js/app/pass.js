$(function (){

    //изменить объект
    //$('body').on("change keyup input click",'.js-pass-edit',js_edit_pass);

    //удалить объект
    $('body').on("change keyup input click",'.js-pass-del',js_pass_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-pass',js_add_pass);

    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-pass-add0", js_add_pass);

    //добавить комментарий
    $('body').on("change keyup input click",'.js-add-comment-trips',{key: "008U"},add_comm_trips);
    $('body').on("change keyup input click",'.js-exit-form-comm-trips',exit_comm_trips);
    $('body').on("change keyup input click",'.js-add-comment-yes-trips',add_comment_yes_trips);
    $('body').on("change keyup input click",'.js-com-trips-del',del_comm_trips);

    //получение информации по нажатию на объект
    $('body').on("click",".js-info-pass",doc_pass);
    //нажатие на вкладку в форме информации по объекту



    //Быстрый поиск пропуска
    $('body').on("change keyup input click",'.js-search-global-page',js_search_global_page);



//остальные клиенты выбор клиента в туре
    $('body').on("change keyup input click",'.js-eshe-client-x',eshe_say_client);
//ввод поиска в клиенте при выборе клиента

//ввод в строке поиска туриста
    $('body').on("keyup",'.js-choice-keyup',js_choice_keyup);

});

//ввод текста в поиске в форме form_choice_client
function js_choice_keyup()
{
    var search_min2_search_c = 2;  //мин количество символов для быстрого поиска
    var search_deley2_search_c=800;	//задержка между вводами символов - начало поиска телефона в базе
    var object_key=$('.js-choice-keyup');

    delays(function(){
        //alert(object_key.val());

        if((jQuery.trim(object_key.val().length) >= search_min2_search_c)||(jQuery.trim(object_key.val().length)==0))
        {

            var val1= $('.js-tabs-menu-choiche').find('.active').attr('id');
            if(val1 == undefined)
            {
                val1=4;
            }

            var data ='url='+window.location.href+
                '&all='+$('.js-eshe-client-x').attr("all")+
                '&tk='+$('.js-s_form_xx').attr('mor')+
                '&id='+$('.js-s_form_xx').attr('for')+
                '&search='+encodeURIComponent(object_key.val())+
                '&tabs='+val1;


            $('.js-icon-load').hide().after('<div class="b_loading_small" style="margin-right:-20px; position:relative; top: 0px; right: 0px; padding-top:0px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

            AjaxClient('pass','search_pass','GET',data,'AfterSearchClientT',1,0);
        }


    }, search_deley2_search_c);
}

//постункция получения списка клиентов при поиске клиентов
function AfterSearchClientT(d,c)
{
    $('.b_loading_small').remove();
    $('.js-icon-load').show();



    if(d.status=="ok"){
        $('.js-eshe-client-x').attr('pg',1);
        $('.js-eshe-client-x').attr('start',0);
        $('.list-scroll-client').find('.block_pass_small').remove();
        $('.list-scroll-client').prepend(d.query);




        if(d.query=='')
        {
            $('.js-message-search-cc').show();
        } else
        {
            $('.js-message-search-cc').hide();
        }

        if(d.eshe==1)
        {
            $('.js-eshe-client-x').show();
        } else
        {
            $('.js-eshe-client-x').hide();
        }
    }else{

        $(".list-scroll-client").hide();

    }

}


//показать других клиентов при выборе кнопка еще
var eshe_say_client = function()
{
    //alert("!");
    var pg=$(this).attr("pg");
    var start=$(this).attr("start");
    var all=$(this).attr("all");



    $('.js-eshe-client-x').empty().append('<div class="b_loading_small" style="position:relative; top: -5px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    var val1= $('.js-tabs-menu-choiche').find('.active').attr('id');
    if(val1== undefined)
    {
        val1=4;
    }


    var data ='url='+window.location.href+'&pg='+pg+'&start='+start+'&all='+all+
        '&tk='+$('.js-s_form_xx').attr('mor')+
        '&id='+$('.js-s_form_xx').attr('for')+
        '&query='+ec($('.js-choice-keyup').val())+
        '&tabs='+val1;
    AjaxClient('pass','tabs_pass_eshe','GET',data,'AfterClientEshe',1,0);
}

//постфункция показать еще клиентов при выборе клиента
function AfterClientEshe(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }
    if ( data.status=='ok' )
    {
        $('.js-eshe-client-x').before(data.echo);
        if(data.eshe==1)
        {

            $('.js-eshe-client-x').attr('pg',data.pg).empty().append('<span>показать еще</span>');
        } else
        {
            $('.js-eshe-client-x').hide();
            $('.js-eshe-client-x').empty().append('<span>показать еще</span>');
        }
        ToolTip();
    }
}

//нажатие на главной на кнопку найти пропуск
function js_search_global_page()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/pass/form_choice_pass.php?tabs=1&tabss=all&several=0&posta=choice_user_task1&new=0',
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
 * удалить из истории что-то в турах
 */
function del_comm_trips(event)
{

    var del_id=$(this).parents('.comm-trips-block').attr('rel_notibss');

    var data ='url='+window.location.href+
        '&id='+$('.h111').attr('for')+'&sel='+del_id;

    $('.comm-trips-block[rel_notibss='+del_id+']').slideUp("slow");

    AjaxClient('devices','dell_comm','GET',data,'AfterZero',del_id,0,1);

    alert_message('ok','Комментарий к устройству удален');

}

/**
 * нажать на кнопку отменить комментарий в журнале тура уже в форме добавления
 */
function add_comment_yes_trips(event)
{
    var err = 0;
    //alert("!");

    var form_move=$(this).parents('.js-ssay');
    //var form_move=$('.js-comment-add-'+event.data.key)

    form_move.find(".div_textarea_say").removeClass('error_textarea_2018');

    if(form_move.find('.js-comment-add-trips-v').val() == '')
    {
        form_move.find(".div_textarea_say").addClass('error_textarea_2018');
        err=1;

    }



    if(err==0)
    {
        var id_trips=$('.gloab-cc').attr('for');
       // var for_id=$('.gloab-cc').attr('for');

        var data ='url='+window.location.href+
            '&id='+id_trips+'&text='+ec(form_move.find('.js-comment-add-trips-v').val());


        //изменить кнопку на загрузчик
        form_move.find('.js-add-comment-yes-trips').hide();

        form_move.find('.js-exit-form-comm-trips').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('devices','add_comment','GET',data,'AfterAddCommentTrips',id_trips,0,1);


    }else
    {
        var text_bb22 = $('.js-add-say').text();
        $('.js-add-say').empty().append('Ошибка заполнения!');
        $('.js-add-say').addClass('new-say1');
        setTimeout ( function () { $('.js-add-say').removeClass('new-say1'); $('.js-add-say').empty().append(text_bb22);  }, 4000 );
        alert_message('error','Заполните комментарий');


    }
}

/**
 *
 * Постфункция добавить комментарий в журнале о туре
 * @param data
 * @param update
 * @constructor
 */
function AfterAddCommentTrips(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }
    if ( data.status=='ok' )
    {
        var form_move=$('.box-modal').find('.js-ssay');

        form_move.find('.js-add-comment-yes-trips').show();
        form_move.find('.js-exit-form-comm-trips').show();


        form_move.find('.b_loading_small').remove();



        form_move.slideUp( "slow" );
        form_move.prev().slideDown( "slow" );


        form_move.find('.js-comment-add-trips-v').val('');

        form_move.after(data.echo);
        setTimeout ( function () { form_move.parents('.box-modal').find( '.new-say-com-t ' ).removeClass('new-say-com-t '); }, 4000 );
        ToolTip();

        form_move.find('.js-message-com-t').slideUp("slow");
        alert_message('ok','Комментарий к устройству добавлен');

    }
}

/*
 * нажать на кнопку отменить комментарий в журнале тура
 */
function exit_comm_trips(event)
{
    $(this).parents('.js-ssay').slideUp("slow");
    $(this).parents('.js-ssay').prev().slideDown( "slow" );
}

/*
 * нажать на кнопку добавить комментарий в журнале тура
 */
function add_comm_trips(event)
{
    $(this).slideUp("slow");
    $(this).next().slideDown( "slow" );
}










/*вывод информации по объекту
 *
 */
function doc_pass(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }


    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-menu-jjs-b'))&&(!$target.hasClass('more_supply1'))&&(!$target.hasClass('js-no-no-click'))) {

        var for_id = $(this).attr('pass_rel');

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/pass/form_doc_pass.php?id=' + for_id + '&tabs=0',
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


/*
 добавить новый объект
 */
function js_add_pass()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/pass/form_add_pass.php',
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

/*
 * изменить Объекта
 */
function js_edit_pass(event)
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


        var id_buy = $(this).parents('.pass_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/pass/form_edit_pass.php?id_buy='+id_buy,
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


/*
 * удалить объект
 */
function js_pass_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.pass_block_pass').attr('op_rel');
    }

    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/pass/form_dell_pass.php?id_buy='+id_buy,
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