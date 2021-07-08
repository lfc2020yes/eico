$(function (){

    //кликнуть на что то в раскрывающем меню корзины
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-basket',menu_supply_basket_21);

    $('.scope_scope').on("change",'.option_score1',option_score1);

    $('.tr_dop_supply').on("click",'.st_div_supply',st_div_supply);
    //$('.menu1').on("click",'.score_plus,.score_',add_soply);
    //инициализация корзины компонентов сверху
    basket_supply();

});

//очистить корзину счетов
function erase_basket()
{
    var u_key=$('.users_rule').attr('iu');
    var iu=$('.content_block').attr('iu');
    $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

    $('.checher_supply').removeClass('checher_supply');
    basket_supply();
}

//кликнуть на что то в раскрывающем меню корзины
function menu_supply_basket_21(event)
{
    event.stopPropagation();

    var rel=$(this).find('a').attr('rel');
//alert(rel);
    if(rel==2)
    {
        //очистить корзину
        erase_basket();

    }
    if(rel==1)
    {
        //добавить к устройству
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }

        event.stopPropagation();
        add_soply();
/*
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/items/form_basket.php',
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
*/
    }

}


//корзина счетов новый/текущий инициализация обновление
function basket_supply()
{

    var u_key=$('.users_rule').attr('iu');
    var iu=$('.content_block').attr('iu');
    var cookie_new = $.cookie('basket_supply_'+iu);
    var cookie_score = $.cookie('basket_score_'+iu);
    var cookie_flag_current = $.cookie('current_supply_'+iu);
    //alert(cookie_new);
    if(cookie_flag_current==null)
    {
        //значит состояние по новому счету выводить
        if(cookie_new==null) {

            $('.js-basket-supply').hide();
            $('.js-basket-supply').removeClass('more-active-s');

            //$('.add_score').remove(); $('.more_supply').hide();
        } else
        {
            $('.js-basket-supply').addClass('more-active-s');
            $('.js-basket-supply').show();

            $('.add_nar').show();
            $('.add_zayy').show();
            if(!$(".add_score").length)
            {
                //$('.add_sss').after('<a data-tooltip="добавить счет" class="add_score"><i class="score_plus"></i><i class="score_"></i></a>');
                //$('.more_supply').show();

                ToolTip();
            }
            var cc = cookie_new.split('.');
            var counts=cc.length;
            $('.add_score .score_').empty().append(counts);

            $('.js-basket-supply .more_supply1').find('i').empty().append(counts);
            $('.js-basket-supply').addClass('more-active-s');

            /*
                       $('.add_score .score_').animate({scale: "1.5"}, 200, function() {  $('.add_score .score_').animate({scale: "1"}, 200); });
                       $('#nprogress').show();
                       $('#nprogress .bar').animate({width: "100%"}, 200, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });*/
        }
    } else
    {
        //значит активен текущий счет
        $('.add_score').remove(); $('.more_supply').hide();
        $('.current_score').show();  $('.more_supply2').show();

        $('.current_score').find('.count_scire').show();
        $('.menu_supply').find('[rel=1]').parents('li').show();
        if(cookie_score!=null)
        {
            var cc = cookie_score.split('.');
            var counts=cc.length;
        } else
        {
            counts='';
            $('.current_score').find('.count_scire').hide();
            $('.menu_supply').find('[rel=1]').parents('li').hide();
        }

        //$('.add_score .score_').empty().append(counts);
        $('.current_score').find('.count_numb_score').empty().append(counts);

        //$('.current_score').find('.count_scire').hide();

    }

}

//добавить новый счет
function add_soply()
{
    var u_key=$('.users_rule').attr('iu');
    var iu=$('.content_block').attr('iu');
    var cookie_new = $.cookie('basket_supply_'+iu);
    if(cookie_new!=null)
    {



        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_soply.php',
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

//нажать на материал в снабжении - добавить/убрать из корзины счетов
function st_div_supply() {

    var u_key=$('.users_rule').attr('iu');
    var iu=$('.content_block').attr('iu');
    var tr=$(this).parents('.tr_dop_supply');

    //var cookie_new = $.cookie('basket_supply_'+iu);
    var cookie_flag_current = $.cookie('current_supply_'+iu);
    //alert(cookie_new);
    if(cookie_flag_current==null)
    {
        var ssup='basket_supply_';
    } else
    {
        var ssup='basket_score_';
    }

    //alert(ssup);
    if(tr.is(".checher_supply"))
    {
        tr.removeClass("checher_supply");
        CookieList(ssup+iu,tr.attr('supply_id'),'del');
        // alert($(this).parents('[rel_id]').attr('rel_id'));
        basket_supply();
        ToolTip();
    } else
    {
        tr.addClass("checher_supply");
        CookieList(ssup+iu,tr.attr('supply_id'),'add');
        basket_supply();
        ToolTip();
    }


}

//сохранить текущий счет
function save_soply() {
    var iu=$('.content_block').attr('iu');
    var cookie_flag_current = $.cookie('current_supply_'+iu);
    //alert(cookie_new);
    if(cookie_flag_current!=null)
    {

        var data ='url='+window.location.href;
        AjaxClient('supply','update_soply','GET',data,'Afterupdate_soply',1,0);

    }

}

//постфункция сохранить текущий счет
function Afterupdate_soply(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        var iu=$('.content_block').attr('iu');

        var basket_score_ = $.cookie('basket_score_'+iu);
        var cookie_flag_current = $.cookie('current_supply_'+iu);
        var cc = basket_score_.split('.');


        //удаляем все старые иконки счетов и обновляем на новые

        $('[rel_score='+cookie_flag_current+']').next().remove();
        $('[rel_score='+cookie_flag_current+']').remove();

        for ( var t = 0; t < cc.length; t++ )
        {
            var tr=$('[supply_id='+cc[t]+']');

            tr.find('.scope_scope').append('<div rel_score="'+cookie_flag_current+'" class="menu_click score_a  "><i>'+cc.length+'</i><span>№'+data.number+'</span></div><div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left: -50px; top: 5px; transform: scaleY(0);"><li><a href="javascript:void(0);" rel="1">Открыть</a></li><li><a href="javascript:void(0);" rel="2">Сделать текущим</a></li><li><a href="javascript:void(0);" rel="3">Согласовать</a></li><li><a href="javascript:void(0);" rel="4">Удалить</a></li></ul><input rel="x" name="vall" class="option_score1" value="0" type="hidden"></div>');

        }





        $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

        $('.current_score').find('.number_score').empty();
        $('.current_score').find('.count_numb_score').empty();
        $('.current_score').hide();
        $('.more_supply2').hide();

        $('.checher_supply').removeClass('checher_supply');
        $('.score_active').removeClass('score_active');

    }
    if ( data.status=='error' )
    {

    }
}


function option_score1() {
    var el_v=$(this).val();
    var soply=$(this).parents('.menu_supply').prev();
    var id_soply=soply.attr('rel_score');
    if(el_v==2)
    {
        //сделать текущим

        $('.checher_supply').removeClass('checher_supply');



        var iu=$('.content_block').attr('iu');
        $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        CookieList("current_supply_"+iu,id_soply,'add');

        $('.score_active').removeClass('score_active');
        $('[rel_score='+id_soply+']').addClass('score_active');





        var data ='url='+window.location.href+'&id='+id_soply;
        AjaxClient('supply','current_soply','GET',data,'Aftercurrent_soply',id_soply,0);
    }
    if(el_v==3)
    {

        //согласовать счет
        var data ='url='+window.location.href+'&id='+id_soply;
        AjaxClient('supply','app_soply','GET',data,'Afterapp_soply',id_soply,0);


    }
    if(el_v==1)
    {

        //открыть счет

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_update_soply.php?id='+id_soply,
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




    if(el_v==4)
    {
        //удалить счет

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_dell_soply.php?id='+id_soply,
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

        //var data ='url='+window.location.href+'&id='+id_soply;
        //AjaxClient('supply','dell_soply','GET',data,'Afterdell_soply',id_soply,0);

    }


}

//постфункция согласовать счет
function Afterapp_soply(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        $('[rel_score='+update+']').addClass('score_app');


        var hf=$('[rel_score='+update+']').parents('[supply_stock]');
        hf.each(function(i,elem) {
            var rttt=$(this).attr('supply_stock');
            var hf1= [];
            hf1=rttt.split('_');
            //alert(hf1[0]);
            UpdateStatusADA(hf1[0]);
        });

        //alert(hf.length);

        //var hf1=hf.split('_');
        //alert(hf1[0]);
        //UpdateStatusADA(hf1[0]);


        var iu=$('.content_block').attr('iu');

        $('[rel_score='+update+']').next().find('[rel=2]').parents('li').hide();
        $('[rel_score='+update+']').next().find('[rel=3]').parents('li').hide();
        $('[rel_score='+update+']').next().find('[rel=4]').parents('li').hide();

        var cookie_flag_current = $.cookie('current_supply_'+iu);
        if((cookie_flag_current!=null)&&(cookie_flag_current==update))
        {
            $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
            $.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
            $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

            $('.current_score').find('.number_score').empty();
            $('.current_score').find('.count_numb_score').empty();
            $('.current_score').hide();
            $('.more_supply2').hide();

            $('.checher_supply').removeClass('checher_supply');
            $('.score_active').removeClass('score_active');
        }

        var id_mateo='';
        $('[rel_score='+update+']').each(function (index, value) {
            if(index==0)
            {
                id_mateo=id_mateo+$(this).parents('[supply_id]').attr('supply_id');
            } else
            {
                id_mateo=id_mateo+'.'+$(this).parents('[supply_id]').attr('supply_id');
            }

        });
        var data ='url='+window.location.href+'&id='+id_mateo;
        AjaxClient('supply','update_status','GET',data,'Afterupdate_status',id_mateo,0);

    }
    if ( data.status=='error' )
    {

    }
}