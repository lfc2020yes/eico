$(function (){

    //форма добавление тура - выбор паспорт какой
    $('body').on("change keyup input click",'.js-password-acc',password_acc);
    //новый старый поставщик
    $('body').on("change keyup input click",'.js-type-soft-view',view_type);

    //набор текста в поиске

    $('body').on("change keyup input click",'.price_xvg_,.count_xvg_,.delivery_xvg_',itogprice_xvg);


    $('body').on("change keyup input click",'.js-del-items-basket-view',del_acc_material);


    $('body').on("change keyup input click",'.js-add-acc-save',save_acc);


    $('body').on("change keyup input click",'.js-edit-acc-more',edit_more_acc);
    $('body').on("change keyup input click",'.js-dell-acc-more',dell_more_acc);

    $('body').on("change keyup input click",'.tabs_006U',{key: "006U"},tabs_acc);


    $('body').on("change keyup input click",'.js-reject-acc',RejectFoA);
    $('body').on("change keyup input click",'.js-forward-acc',ForwardFoA);

    $('body').on("change keyup input click",'.js-sign-a1',SingFoA);

    $('body').on("change keyup input click",'.js-sign-end',SingFoEnd);

    $('body').on("change keyup input click",'.js-sign-pay',SingFoPay);

    $('body').on("change",'.js-id-kto-ajax',kto_fns);

    $(".drop-radio").find("li").bind('click', dropliradio);

    //$('#acc_3').bind('change', changeacc_3);
    //$('#acc_2').bind('change', changeacc_2(2));
    //$('#acc_4').bind('change', changeacc_2(4));
    $('body').on("change",'#acc_3',{key: "3"},changeacc);
    $('body').on("change",'#acc_2',{key: "2"},changeacc);
    $('body').on("change",'#acc_7',{key: "7"},changeacc);
    $('body').on("change",'#acc_8',{key: "8"},changeacc);
    $('body').on("change",'#acc_9',{key: "9"},changeacc);
    $('body').on("change",'#acc_4',{key: "4"},changeacc);
});



function changeacc(event) {
    var iu=$('.content_block').attr('iu');

    $.cookie("acc_"+event.data.key+iu, null, {path:'/',domain: window.is_session,secure: false});
    CookieList("acc_"+event.data.key+iu,$(this).val(),'add');

    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');


    if(event.data.key==7)
    {
        //выбрал город другой
        //обнавляем списки квартал,объект
        var data = 'url='+window.location.href+'&id='+$(this).val();
        //alert(data);
        AjaxClient('acc','select_town','GET',data,'AfterSelectTown',0,0);
        $('.js-kvartal').remove();
        $('.js-object-c').remove();

    }
    if(event.data.key==8)
    {
        //выбрал квартал другой
        //обнавляем списки объект
        var data = 'url='+window.location.href+'&id='+$(this).val();
        //alert(data);
        AjaxClient('acc','select_kvartal','GET',data,'AfterSelectKvartal',0,0);
        $('.js-object-c').remove();


    }

};



function AfterSelectTown(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        $('.js-city').after(data.echo);
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);
        Zindex();
        $(".drop-radio").find("li").unbind('click');
        $(".drop-radio").find("li").bind('click', dropliradio);
    }

}

function AfterSelectKvartal(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        $('.js-kvartal').after(data.echo);
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);
        Zindex();
        $(".drop-radio").find("li").unbind('click');
        $(".drop-radio").find("li").bind('click', dropliradio);
    }

}

function dropliradio() {

    var active_old=$(this).parent().parent().find(".slct").attr("data_src");
    var active_new=$(this).find("a").attr("rel");

    var f=$(this).find("a").text();
    var e=$(this).find("a").attr("rel");
    var drop_object=$(this).parents('.drop-radio');

    if ($(this).find('i').is(".active_task_cb"))
    {
        $(this).find('i').removeClass("active_task_cb");
    } else
    {
        $(this).find('i').addClass("active_task_cb");
    }


    //пробежаться по всей выбранному селекту
    var select_li='';
    var select_li_text='';
    drop_object.find('li').each(function(i,elem) {
        if ($(this).find('i').is(".active_task_cb")) {  if(select_li==''){select_li=$(this).find("a").attr("rel");
            select_li_text=$(this).find("a").text();
        } else {select_li=select_li+','+$(this).find("a").attr("rel");
            select_li_text=select_li_text+', '+$(this).find("a").text();
        }}
    });


    if(drop_object.is('.js-no-nul-select'))
    {
        //есть класс который говорит что если убрать галки со всех то загарятся все сразу
        if(select_li=='')
        {
            drop_object.find('li').each(function(i,elem) {
                if(select_li==''){select_li=$(this).find("a").attr("rel");
                    select_li_text=$(this).find("a").text();
                } else {select_li=select_li+','+$(this).find("a").attr("rel");
                    select_li_text=select_li_text+', '+$(this).find("a").text();
                }
            });
            drop_object.find('i').addClass("active_task_cb");
        }


    }

    /*
                if(e!=0)
                {
                    $(this).parents('.left_drop').find('label').addClass('active_label');
                } else
                    {
$(this).parents('.left_drop').find('label').removeClass('active_label');
                    }
    */
    /*
  $(this).parent().find("li").removeClass("sel_active");
  $(this).addClass("sel_active");
*/


    // $(this).parent().parent().find(".slct").removeClass("active").html(f);
    if(select_li_text=='')
    {
        select_li_text='Не выбрано';
    }

    $(this).parent().parent().find(".slct").empty().append(select_li_text);
    $(this).parent().parent().find(".slct").attr("data_src",select_li);

    //$(this).parent().parent().find(".drop").hide();
    // $(this).parent().parent().find(".drop").css("transform", "scaleY(0)");

    $(this).parent().parent().find("input").val(select_li).change();



}



function kto_fns()
{
    //alert("!");
    var kto=$(this).val().slice(1);
    var new_s=$(this).val()[0];
    if(new_s=='n')
    {
        //это новый пользователь с фнс

        //перейти на вкладку новый контрагент
        $('.js-ajax-new-profi[id=1]').trigger('click');

        $('.js-options-supply-1').hide();

        $('.js-options-supply-1').after('<div class="b_loading_small js-metka" style="position:relative; margin-bottom: 20px; "><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        var data = 'url='+window.location.href+'&inn='+kto;
        //alert(data);
        AjaxClient('acc','new_contractor','GET',data,'Afterkto_fns',0,0);

    }
}

function Afterkto_fns(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        $('.js-options-supply-1').find('[name=name_contractor]').val(data.name).trigger('click');
        $('.js-options-supply-1').find('[name=address_contractor]').val(data.adress).trigger('click');
        $('.js-options-supply-1').find('[name=dir_contractor]').val(data.dir).trigger('click');
        $('.js-options-supply-1').find('[name=inn_contractor]').val(data.inn).trigger('click');
        $('.js-options-supply-1').find('[name=ogrn_contractor]').val(data.ogrn).trigger('click');

        $('.js-options-supply-1').find('[name=name_small_contractor]').val(data.name_small);
        $('.js-options-supply-1').find('[name=status_contractor]').val(data.status_f);

        $('.js-metka').remove();
        $('.js-options-supply-1').slideDown("slow");
        return;
    }
    alert_message('error','Ошибка выбора поставщика. Попробуйте еще раз.');
}


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

function SingFoPay()
{
    if(!$(this).is('.gray-bb')) {
        var fo = $(this);
        if (!fo.hasClass("gray-bb")) {
            //alert("!");
            //открыть окно для вписание замечания
            var pre = $('.preorders_block_global').attr('id_pre');
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_booker_yes.php?id=' + pre,
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



function dell_more_acc()
{
    var oppf=$(this).parents('[id_pre]').attr("id_pre");

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_dell_soply.php?id=' + oppf,
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

//доставка
    if($('.delivery_xvg_').length!=0) {
        var delivery = parseFloat(ctrim($('.delivery_xvg_').val()));

        if ((delivery != 0) && (delivery != '') && ($.isNumeric(delivery))) {

            summ_xvg = (parseFloat(summ_xvg) + parseFloat(delivery)).toFixed(2);
        }


        if($('.delivery_xvg_').parents('.items_acc_basket').find('.pay_summ_bill1').length!=0) {

            if ((delivery != 0) && (delivery != '') && ($.isNumeric(delivery))) {

                $('.delivery_xvg_').parents('.items_acc_basket').find('.pay_summ_bill1').empty().append($.number(delivery, 2, '.', ' '));

            } else
            {
                $('.delivery_xvg_').parents('.items_acc_basket').find('.pay_summ_bill1').empty().append(0);
            }

        }


    }



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

