$(function () {

//меню открытие внизу блока наряда
    $('body').on("change keyup input click",'.tabs_009U',{key: "009U"},tabs_worder);
    //открыть календарь период
    $('body').on("click",'.cal_rang_2021',calc_open_2021_rang);

    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-print',menu_print);

    $('body').on("change keyup input click",'.js-reject-worder',RejectWo);

    $('body').on("change keyup input click",'.js-forward-worder',ForwardWo);

    $('body').on("change keyup input click",'.js-sign-worder',SingWo);


    $('body').on("change keyup input click",'.js-sign-seal',SealWo);


    //нажатие на кнопку сохранить наряд на материал
    $(".js-add-worder").bind('click', save_worder);

    setTimeout ( function () {
        //если переход в любое редактируемое поле наряда то сбрасывать кнопку подписать и показывать кнопку сохранить
    $('.my_no').on("change keyup input click.naryd",'.count_finery_mater_,.price_finery_mater_,.text_finery_message_,.count_finery_,.price_finery_,.slct_box,#date_table,#date_table1,[name=ispol_work]',

    function(){  if(($(this).attr('readonly')==undefined)||(($(this).attr('disabled')==undefined)&&(($(this).is('.cal_rang_2021'))||($(this).is('.cal_2021'))))) {  $('.pod_zay').hide(); $('.add_zay').show(); }   }



        );


}, 2000 );

});


function menu_print(event)
{
        event.stopPropagation();

        var rel=$(this).find('a').attr('rel');

    }



function SingWo()
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
                    url: 'forms/form_add_worder_remark.php?id=' + pre,
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

function SealWo()
{
    //Отправить прямую форму на согласование
    $('#lalala_seal_form').submit();
}


//переслать заявку
function ForwardWo()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_worder_forward.php?id=' + pre,
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


function RejectWo()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_worder_reject.php?id=' + pre,
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



//сохранить заявку на материал
var save_worder = function()
{
    var error=0;

    $('.messa:visible').find('.text_finery_message_').removeClass('error_formi');
    $('.messa:visible').find('.text_finery_message_').each(function(i,elem) {

        var text=$(this).val();
        if(text=='')
        {
            error=1;
            $(this).addClass('error_formi');
        }
    });
    $('.work__s').find('.price_finery_').removeClass('error_formi');
    $('.work__s').find('.count_finery_').removeClass('error_formi');
    $('.mat').find('.price_finery_mater_').removeClass('error_formi');
    $('.mat').find('.count_finery_mater_').removeClass('error_formi');

    $('.messa:visible').each(function(i,elem) {
        var id_work=$(this).attr('id_mes');
        //проверим что все поля для каждой служебной записки заполнены


        //определим отностимся записка к работе или материалу
        var aa = id_work.split('_');
        if(aa.length==1)
        {
            //это работа
        } else
        {
            //материал
        }
        id_work=aa[0];

        var count=$('.work__s[rel_id='+id_work+']').find('.count_finery_').val();
        var price=$('.work__s[rel_id='+id_work+']').find('.price_finery_').val();
        $('.work__s[rel_id='+id_work+']').find('.price_finery_').removeClass('error_formi');
        $('.work__s[rel_id='+id_work+']').find('.count_finery_').removeClass('error_formi');
        if((count==0)||(count=='')||(!$.isNumeric(count)))
        {
            $('.work__s[rel_id='+id_work+']').find('.count_finery_').addClass('error_formi');
            error=1;
        }
        if((price==0)||(price=='')||(!$.isNumeric(price)))
        {
            $('.work__s[rel_id='+id_work+']').find('.price_finery_').addClass('error_formi');
            error=1;
        }


        $('.mat[rel_w='+id_work+']').each(function(i,elem) {
            var count=$(this).find('.count_finery_mater_').val();
            var price=$(this).find('.price_finery_mater_').val();
            $(this).find('.price_finery_mater_').removeClass('error_formi');
            $(this).find('.count_finery_mater_').removeClass('error_formi');
            //if((count==0)||(count=='')||(!$.isNumeric(count)))

            if((count=='')||(!$.isNumeric(count)))
            {
                $(this).find('.count_finery_mater_').addClass('error_formi');
                error=1;
            }
            /*
            if((price==0)||(price=='')||(!$.isNumeric(price)))
            {
                $(this).find('.price_finery_mater_').addClass('error_formi');
                error=1;
            }
            */

        });


    });
    $('.js-add-worder-material .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            error++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });


    if(error!=0)
    {

        alert_message('error','Не все поля заполнены');

    } else
    {
        $('#lalala_add_form').submit();
    }




}


function calc_open_2021_rang() {
    //alert_message('ok','открыть');
    $("#date_table1").show();
//$("#date_table").focus();
    $('.bookingBox1').css({
        display: 'block'
    });
}


//табсы в обращениях
var tabs_worder = function(event) {
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
            AjaxClient('worder','tabs_info','GET',data,'AfterTabsInfoWorder',$(this).attr("id")+','+$(this).parents('.preorders_block_global').attr('id_pre'),0,1);
        }
    }
}

//постфункция вкладки в обращениях
function AfterTabsInfoWorder(data,update)
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

