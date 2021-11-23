$(function (){

    $('.material-prime-v22').on("click",'.history_icon',HistoryN1);


    //кликнуть на что то в раскрывающем меню корзины
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-basket',menu_supply_basket_21);
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-basket-acc',menu_supply_basket_acc_21);
    $('.scope_scope').on("change",'.option_score1',option_score1);

    $('.tr_dop_supply').on("click",'.st_div_supply',st_div_supply);
    //$('.menu1').on("click",'.score_plus,.score_',add_soply);
    //инициализация корзины компонентов сверху
    basket_supply();

    $('.js-call-no-v').find('.drop').on("change keyup input click","li",list_number);

    $('body').on("change keyup input click",'.js-dava-click',dava_supply);


    $('body').on("change keyup input click",'.js-waves-app',waves);

});


function waves()
{
    var id_pole=$(this).parents('.tr_dop_supply').attr('supply_id');
    //alert(cookie_new);

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_waves_app.php?id=' + id_pole,
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


//изменение материала в себестоимости клик по кнопке в форме добавить
//  |
// \/
function js_edit_supply_mat_stock()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-supply-mats .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    var contractor_new=box_active.find('.js-type-stock-prime1').val();


    if(contractor_new==0)
    {
        box_active.find('.js-form-supply-mats .gloab2').each(function(i,elem) {
            if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    } else
    {
        box_active.find('.js-form-supply-mats .gloab1').each(function(i,elem) {
            if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    }


    // js-type-soft-view1 0 1
    /*
    var iu=$('.content_block').attr('iu');
    var cookie_flag_current = $.cookie('current_supply_'+iu);
    //alert(cookie_new);
    if(cookie_flag_current==null)
    {
        var ssup='basket_supply_';
    } else
    {
        var ssup='basket_score_';
    }

    var basket_score_ = $.cookie(ssup+iu);
    var cc = basket_score_.split('.');
    var xvg='';



    if(cc.length==0)
    {
        err++;
    }

*/





    if(err==0)
    {
        var for_id=box_active.find('.gloab-cc').attr('for');


        AjaxClient('supply','svyz_sklad','POST',0,'AfterSVS',for_id,'form_supply_edit_mat_stock');

        box_active.find('.js-edit-supply-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }
}


function list_number() {
    //alert("!");
//.next().find('li')
    var active_new=$(this).find('a').attr("rel");
    //alert(active_new);
    if(active_new==2)
    {
        $("#date_table").show();
        //$("#date_table").focus();
        $('.bookingBox_range').css({
            display:'block'
        });
    }
}



function dava_supply()
{
    var active_new=$(this).find('.choice-radio i');
    var iu=$('.content_block').attr('iu');

    var fpx=1;
    if(!active_new.is('.active_task_cb')) {
        var fpx = 0;
    }


    $.cookie("dava_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
    CookieList("dava_"+iu,fpx,'add');
    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');

    /*
    if(fpx==1)
    {
$('.js-dava-hide').hide();
    } else
    {
        $('.js-dava-hide').show();
    }
    */

    //скрыть неиспользуемые поиски при это режиме


}


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


//кликнуть на что то в раскрывающем меню корзины
function menu_supply_basket_acc_21(event)
{
    event.stopPropagation();

    var rel=$(this).find('a').attr('rel');
//alert(rel);
    if(rel==1)
    {
        //сохранить
        save_soply();

    }
    if(rel==2)
    {
        //закрыть текущий
        var iu=$('.content_block').attr('iu');
        $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});


        //скрыть текущий сверху
        /*
        $('.current_score').find('.number_score').empty();
        $('.current_score').find('.count_numb_score').empty();
        $('.current_score').hide();
        $('.more_supply2').hide();
*/
        $('.js-basket-supply-acc').hide();
        $('.js-basket-supply-acc').removeClass('more-active-s');
        $('.js-basket-supply-acc').removeClass('more-active-s1');
        $('.js-basket-supply-acc .more_supply1').find('i').empty();

        //убрать выделения на мателиалах
        $('.checher_supply').removeClass('checher_supply');

        //убрать активность со счета
        $('.score_active').removeClass('score_active');

        alert_message('ok','Текущий счет закрыт');
    }

    if(rel==3)
    {

        //var id_acc_s= $(this).parents('.menu_supply').prev().attr('rel_score');
        var cookie_flag_current = $.cookie('current_supply_'+iu);
        //alert(cookie_new);
        if(cookie_flag_current!=null) {
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_sign_acc.php?id=' + cookie_flag_current,
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

        /*
        //открыть
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }

        event.stopPropagation();


        //открыть
        var iu=$('.content_block').attr('iu');
        var cookie_flag_current = $.cookie('current_supply_'+iu);
        //alert(cookie_new);
        if(cookie_flag_current!=null)
        {
            id_soply=cookie_flag_current;


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
*/
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

        $('.js-basket-supply').hide();
        $('.js-basket-supply').removeClass('more-active-s');

        $('.js-basket-supply-acc').show();
        $('.js-basket-supply-acc').removeClass('more-active-s1');
        $('.js-basket-supply-acc').addClass('more-active-s');
        //значит активен текущий счет
        /*
        $('.add_score').remove(); $('.more_supply').hide();
        $('.current_score').show();  $('.more_supply2').show();

        $('.current_score').find('.count_scire').show();
        $('.menu_supply').find('[rel=1]').parents('li').show();
*/
        //$('.js-basket-supply-acc .menu_supply').find('[rel=1]').parents('li').show();
        //$('.js-basket-supply-acc .more_supply1').find('i').empty().append(counts);


        if(cookie_score!=null)
        {
            var cc = cookie_score.split('.');
            var counts=cc.length;
        } else
        {
            counts='';
            //$('.current_score').find('.count_scire').hide();
            //$('.menu_supply').find('[rel=1]').parents('li').hide();
            $('.js-basket-supply-acc').addClass('more-active-s1');
            $('.js-basket-supply-acc').removeClass('more-active-s');

        }

        //$('.add_score .score_').empty().append(counts);
        //$('.current_score').find('.count_numb_score').empty().append(counts);
        $('.js-basket-supply-acc .more_supply1').find('i').empty().append(counts);
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
            url: 'forms/form_add_soply_2021.php',
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



            tr.find('.scope_scope').append('<div rel_score="'+cookie_flag_current+'" data-tooltip="счет №'+data.number+' ('+data.dates+')" class="menu_click score_a"><span>№'+data.number+' ('+data.date+')</span><strong><label>'+$.number(parseFloat(data.sum).toFixed(2), 2, '.', ' ')+'</label></strong><i>'+cc.length+'</i><form class="none" target = "_blank"  action="acc/'+cookie_flag_current+'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data"><input name="a" value="open" type="hidden"></form></div><div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left: -50px; top: 5px; transform: scaleY(0);"><li><a href="javascript:void(0);" rel="1">Открыть</a></li><li><a href="javascript:void(0);" rel="2">Сделать текущим</a></li><li><a href="javascript:void(0);" rel="3">Согласовать</a></li><li><a href="javascript:void(0);" rel="4">Удалить</a></li></ul><input rel="x" name="vall" class="option_score1" value="0" type="hidden"></div>');


/*
            tr.find('.scope_scope').append('<div rel_score="'+cookie_flag_current+'" class="menu_click score_a  "><i>'+cc.length+'</i><span>№'+data.number+'</span></div><div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left: -50px; top: 5px; transform: scaleY(0);"><li><a href="javascript:void(0);" rel="1">Открыть</a></li><li><a href="javascript:void(0);" rel="2">Сделать текущим</a></li><li><a href="javascript:void(0);" rel="3">Согласовать</a></li><li><a href="javascript:void(0);" rel="4">Удалить</a></li></ul><input rel="x" name="vall" class="option_score1" value="0" type="hidden"></div>');
*/
        }
        alert_message('ok','Текущий счет сохранен');





        $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

        /*
        $('.current_score').find('.number_score').empty();
        $('.current_score').find('.count_numb_score').empty();
        $('.current_score').hide();
        $('.more_supply2').hide();
        */

        $('.js-basket-supply-acc').hide();
        $('.js-basket-supply-acc').removeClass('more-active-s');
        $('.js-basket-supply-acc').removeClass('more-active-s1');
        $('.js-basket-supply-acc .more_supply1').find('i').empty();
        $('.js-basket-supply-acc .more_supply1').find('.dop-21').empty();

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
        var id_acc_s= $(this).parents('.menu_supply').prev().attr('rel_score');
        //alert(id_acc_s);
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_sign_acc.php?id=' + id_acc_s,
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
    if(el_v==1)
    {

        //открыть счет
        $('[rel_score='+id_soply+']:first').find('form').submit();

/*
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
        */
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
/*
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
*/
//обновить сколько осталось сколько на складе и так далее
function UpdateStatusADA(id)
{
    if(id!=0)
    {
        $('[id_ada='+id+']').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
        var data ='url='+window.location.href+'&id='+id;
        AjaxClient('supply','update_ada','GET',data,'AfterUpdateStatusADA',id,0);
    }
}

//обновление данных по складу и по заявкам
function AfterUpdateStatusADA(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='error' )
    {
        $('.loader_inter').remove();
    }


    if ( data.status=='ok' )
    {
        $('[id_ada='+update+']').empty().append(data.echo);
        ToolTip();
        $('.loader_inter').remove();
        $('[id_ada='+update+']').show();
    }
}


//постфункция сделать текущим
function Aftercurrent_soply(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        var iu=$('.content_block').attr('iu');
        $('.js-basket-supply-acc').show();
        $('.js-basket-supply-acc').find('.dop-21').empty().append('<label>текущий счет</label>'+data.status_echo);
        $('.js-basket-supply-acc').find('i').empty().append(data.count);
       // $('.current_score').show();

        $.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

        CookieList("basket_score_"+iu,data.basket,'add');

        //выделить все элементы если они есть на странице с такими id
        var cc = data.basket.split('.');
        for ( var t = 0; t < cc.length; t++ )
        {
            $('[supply_id='+cc[t]+']').addClass('checher_supply');
        }
        basket_supply();
    }
    if ( data.status=='error' )
    {

    }
}


function tek_acc(id)
{

    $('.checher_supply').removeClass('checher_supply');



    var iu=$('.content_block').attr('iu');
    $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
    CookieList("current_supply_"+iu,id,'add');

    $('.score_active').removeClass('score_active');
    $('[rel_score='+id+']').addClass('score_active');





    var data ='url='+window.location.href+'&id='+id;
    AjaxClient('supply','current_soply','GET',data,'Aftercurrent_soply',id,0);


}