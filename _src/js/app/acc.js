$(function (){

    //форма добавление тура - выбор паспорт какой
    $('body').on("change keyup input click",'.js-password-acc',password_acc);
    //новый старый поставщик
    $('body').on("change keyup input click",'.js-type-soft-view',view_type);

    //набор текста в поиске

    $('body').on("change keyup input click",'.price_xvg_,.count_xvg_',itogprice_xvg);


    $('body').on("change keyup input click",'.js-del-items-basket-view',del_acc_material);


    $('body').on("change keyup input click",'.js-add-acc-save',save_acc);


    $('body').on("change keyup input click",'.js-edit-acc-more',edit_more_acc);

    $('body').on("change keyup input click",'.tabs_006U',{key: "006U"},tabs_acc);


    $('body').on("change keyup input click",'.js-reject-acc',RejectFoA);
    $('body').on("change keyup input click",'.js-forward-acc',ForwardFoA);

    $('body').on("change keyup input click",'.js-sign-a1',SingFoA);

    $('body').on("change keyup input click",'.js-sign-end',SingFoEnd);


});

function AfterSignAcc(data,update)
{

    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        var iu=$('.content_block').attr('iu');

        var cookie_flag_current = $.cookie('current_supply_'+iu);

        //если счет который согласовывали был текущим
        if((cookie_flag_current!=null)&&(cookie_flag_current==update)) {
            $.cookie("current_supply_" + iu, null, {
                path: '/',
                domain: window.is_session,
                secure: false,
                samesite: 'lax'
            });
            $.cookie("basket_score_" + iu, null, {
                path: '/',
                domain: window.is_session,
                secure: false,
                samesite: 'lax'
            });
            $.cookie("basket_supply_" + iu, null, {
                path: '/',
                domain: window.is_session,
                secure: false,
                samesite: 'lax'
            });

            $('.js-basket-supply-acc').hide();
            $('.js-basket-supply-acc').removeClass('more-active-s');
            $('.js-basket-supply-acc').removeClass('more-active-s1');
            $('.js-basket-supply-acc .more_supply1').find('i').empty();

            //убрать выделения на мателиалах
            $('.checher_supply').removeClass('checher_supply');

            //убрать активность со счета
            $('.score_active').removeClass('score_active');

        }
            //удаяем их меню лишнее теперь
            $('[rel_score='+update+']').next().find('[rel=2]').parents('li').hide();
            $('[rel_score='+update+']').next().find('[rel=3]').parents('li').hide();
            $('[rel_score='+update+']').next().find('[rel=4]').parents('li').hide();


            //добавить к этой заявке статус который пришел из системы
            $('[rel_score='+update+']').find('.js-state-acc-link').remove();
            $('[rel_score='+update+']').find('i').after(data.echo);


            //обновление для материала еще необходимо
            var hf=$('[rel_score='+update+']').parents('[supply_stock]');
            hf.each(function(i,elem) {
                var rttt=$(this).attr('supply_stock');
                var hf1= [];
                hf1=rttt.split('_');
                //alert(hf1[0]);
                UpdateStatusADA(hf1[0]);
            });

        alert_message('ok','Счет отправлен на согласование');


        }



    if ( data.status=='error' ) {

        alert_message('error', 'Ошибка - попробуйте еще раз');
    }

    var box = $('.box-modal:last');
    clearInterval(timerId);
    box.find('.arcticmodal-close').click();

}

//отклонить заявку
function RejectFoA()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_acc_reject.php?id=' + pre,
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


//переслать заявку
function ForwardFoA()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_acc_forward.php?id=' + pre,
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

function SingFoA()
{
    if(!$(this).is('.gray-bb')) {
        var fo = $(this);
        if (!fo.hasClass("gray-bb")) {
            //alert("!");
            if (fo.find('input').val() == 1) {
                //открыть окно для вписание замечания
                var pre = $('.preorders_block_global').attr('id_pre');
                $.arcticmodal({
                    type: 'ajax',
                    url: 'forms/form_add_acc_remark.php?id=' + pre,
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


            } else {
                //Отправить прямую форму на согласование
                $('#js-form-next-sign').submit();
            }
        }
    }
}

function SingFoEnd()
{
    if(!$(this).is('.gray-bb')) {
        var fo = $(this);
        if (!fo.hasClass("gray-bb")) {
            //alert("!");
                //открыть окно для вписание замечания
                var pre = $('.preorders_block_global').attr('id_pre');
                $.arcticmodal({
                    type: 'ajax',
                    url: 'forms/form_yes_bill.php?id=' + pre,
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
}

//табсы в обращениях
var tabs_acc = function(event) {
    //event.data.key

    var uoo=$(this).attr("id");


    if(uoo!=0) {
        $(this).parents('.mm_w-preorders').addClass('active-trips-menu');
    } else
    {

        $(this).parents('.mm_w-preorders').removeClass('active-trips-menu');
        $(this).parents('.mm_w-preorders').next().empty().hide();
        $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
    }

    if ( $(this).is(".active") )
    {
        //уже активная вкладка
        $(this).parents('.mm_w-preorders').removeClass('active-trips-menu');
        $(this).parents('.mm_w-preorders').next().empty().hide();
        $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
    } else
    {
        //alert(event.data.key);
        if(uoo!=0) {
            $(this).parents('.mm_w-preorders').next().empty().append('<div class="b_loading_small" style="position:relative; left: calc(50% - 30px); "><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            $(this).parents('.mm_w-preorders').next().slideDown("slow");

            /*
                    $('.form'+event.data.key+' .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            */
            $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
            $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key + '[id=' + uoo + ']').addClass('active');

            //var key_='002U';

            var data = 'url=' + window.location.href + '&id_tabs=' + $(this).attr("id") +
                '&id=' + $(this).parents('.preorders_block_global').attr('id_pre');
            //alert(data);
            AjaxClient('acc','tabs_info','GET',data,'AfterTabsInfoAcc',$(this).attr("id")+','+$(this).parents('.preorders_block_global').attr('id_pre'),0,1);
        }
    }
}

//постфункция вкладки в обращениях
function AfterTabsInfoAcc(data,update)
{
    if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }

    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        $('.preorders_block_global[id_pre='+update[1]+']').find('.px_bg_trips').empty().append(data.query);
        //$('.form'+update[1]+' .px_bg').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        //$('.form'+update[1]+' .js-tabs_docc').hide();
        //$('.form'+update[1]+' .js-tabs_'+update[0]).show();

        NumberBlockFile();
        ToolTip();
        if((update[0]==3)||(update[0]==4))
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            //$('#typesay').unbind('change', changesay);
            //$('#typesay').bind('change', changesay);
            //alert("!");
        }

    }
}

function edit_more_acc()
{
    var oppf=$(this).parents('[id_pre]').attr("id_pre");

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_edit_acc_more.php?id=' + oppf,
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


//сохранить счет при изменении количества
function save_acc()
{
    var err = 0;
    $('.js-save-form-acc').find('.gloab').each(function(i,elem) {
        if(($(this).val() == '')||($(this).val() == '0')) { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    if(err==0) {

        $('.js-save-form-acc').submit();

    } else
    {
        alert_message('error','Не все поля заполнены');
    }
}


//удалить материал из счета внутри счета
function del_acc_material(event)
{

    var cc_mat=$('.js-acc-block').length;
//alert(cc_mat);
    if(cc_mat>1) {
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_dell_material_acc.php?id=' + $(this).attr("id_rel"),
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
    event.stopPropagation();
}

//подсчет итоговой сумму при добавлении счета
var itogprice_xvg = function() {

    var box_active = $(this).closest('.box-modal');
    var xvg=$('.js-acc-block');
    box_active.find('.js-add-acc-block-x').show();
    //$('#yes_soply11').show();
    //$('#yes_soply12').show();
    var summ_xvg=0;
    xvg.each(function(i,elem) {

        $(this).find('.count_xvg_').parents('.input_2021').removeClass('redaas');
        $(this).find('.price_xvg_').parents('.input_2021').removeClass('redaas');

        var count= parseFloat($(this).find('.count_xvg_').val());
        var count_max= parseFloat($(this).find('.count_xvg_').attr('max'));
        var price= parseFloat(ctrim($(this).find('.price_xvg_').val()));
        var price_max= parseFloat(ctrim($(this).find('.price_xvg_').attr('max')));
        // var max_count=parseFloat($('#count_work_'+id_trr).attr('max'));

        if(count>count_max)
        {
            //выделяем красным и открываем служебную записку
            $(this).find('.count_xvg_').parents('.input_2021').addClass('redaas');
            //box_active.find('.js-add-acc-block-x').hide();
        }
        if(price>price_max)
        {
            //выделяем красным и открываем служебную записку
            $(this).find('.price_xvg_').parents('.input_2021').addClass('redaas');
        }


        var value=(count*price).toFixed(2);

        if((value!=0)&&(value!='')&&($.isNumeric(value)))
        {
            $(this).find('.all_price_count_xvg span').empty().append($.number(value, 2, '.', ' '));
            summ_xvg=(parseFloat(summ_xvg)+parseFloat(value)).toFixed(2);

        } else
        {
            $(this).find('.all_price_count_xvg span').empty().append('0');
        }


    });


    $('.all_summa_xvg').find('span').empty().append($.number(summ_xvg, 2, '.', ' '));
    if(summ_xvg>0)
    {
        //$('.all_xvg').show();
        $('.all_xvg').slideDown( "slow" );
    } else
    {
        //$('.all_xvg').hide();
        $('.all_xvg').slideUp( "slow" );
    }



}

//выбор какой паспорт
function password_acc()
{
    var cb_h=$(this).parents('.password_acc').find('input');
    if(cb_h.val()!=$(this).attr('id'))
    {
        cb_h.val($(this).attr('id'));

        $(this).parents('.password_acc').find('.choice-radio i').removeClass('active_task_cb');
        $(this).parents('.password_acc').find('.input-choice-click-pass').removeClass('active_pass');

        $(this).find('.choice-radio i').addClass('active_task_cb');
        $(this).addClass('active_pass');
    }
}

function view_type()
{

    var t_soft=$('.js-type-soft-view1').val();
    if(t_soft==1)
    {
        $('.js-options-supply-1').slideDown("slow"); //показать
        $('.js-options-supply-0').slideUp("slow"); //скрыть

    } else
    {
        $('.js-options-supply-0').slideDown("slow");
        $('.js-options-supply-1').slideUp("slow");
    }
}

var delay1 = (function(th){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

var delays = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

