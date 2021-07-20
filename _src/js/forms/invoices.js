$(function (){

    //$('body').on("change",'.js-mat-inv-posta',option_demo);

});

//выбрать счет если таких материалов в нескольких счетах
function option_demo(event)
{
    var box_active = $(this).closest('.box-modal');
   //alert($(this).val());
    var val=$(this).val();
    if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
    {
        $('.search_bill').empty().hide();

        box_active.find('.js-add-inv-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


        $('.no_bill_material').hide();
        var col=box_active.find('.gloab-cc').attr('col');

        var data ='url='+window.location.href+'&id='+val+'&col='+col;
        AjaxClient('invoices','search_bill','GET',data,'AfterOptionDemoS',val,0);

        event.stopPropagation();
    }
}



function AfterOptionDemoS(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }
    if ( data.status=='ok' )
    {

        box.find('.js-add-inv-block-x').show();
        box.find('.b_loading_small').remove();


        $('.search_bill').empty().append(data.echo).slideDown("slow");

        if(data.echo=='')
        {
            $('.no_bill_material').show();
        }
        //input_2021();
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);
        Zindex();
        return;
    }
    box.find('.js-add-inv-block-x').show();
    box.find('.b_loading_small').remove();
    alert_message('error','Ошибка выбора материала');
}

//добавление нового счета проверка в форме добавления
//  |
// \/
function js_add_inv_x()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-invoice-mat .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    var contractor_new=box_active.find('.js-type-stock-view1').val();


    if(contractor_new==0)
    {
        box_active.find('.js-form-invoice-mat .gloab2').each(function(i,elem) {
            if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    } else
    {
        box_active.find('.js-form-invoice-mat .gloab1').each(function(i,elem) {
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
        var demo=box_active.find('.js-posta').val();
        var news=contractor_new;

        var val=box_active.find('.gloab-cc').attr('for');
        if(contractor_new==0)
        {
            var data ='url='+window.location.href+'&id='+val+'&demo='+demo+'&number='+$('.demo-6').val()+'&ss='+$('[name=ss]').val()+'&tk='+box_active.find('.h111').attr('mor');;
            AjaxClient('invoices','add_material','GET',data,'AfterOptionDemo',demo,0);
        } else
        {
            var ed=box_active.find('.js-ed-stock').val();
            var name=box_active.find('.js-name-stock').val();
            var group=box_active.find('.js-group-stock').val();

            var data ='url='+window.location.href+'&id='+val+'&name='+name+'&ed='+ed+'&group='+group+'&ss='+$('[name=ss]').val()+'&tk='+box_active.find('.h111').attr('mor');;
            AjaxClient('invoices','add_material_new','GET',data,'AfterOptionDemo',demo,0);
        }


        box_active.find('.js-add-inv-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}



//постфункция добавление материала в накладную
function AfterOptionDemo(data,update)
{

    var box = $('.box-modal:last');

    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }
    if ( data.status=='ok' )
    {
        var ss=$('[name=ss]').val();
        var value=parseInt(ss)+1;
        $('[name=ss]').val(value);


        alert_message('ok','Материал добавлен');

        if(value==1)
        {
            $('.block_invoice_2019').show();
        }

        $('.itogss').before(data.echo);

        $('.messa_form_a').append(data.echo1);

        ToolTip();
        itog_invoice();


        var nds_x=$('[name=nds_ff]').val();

        if(!$('#number_invoice').is('.grey_edit'))
        {

            if((nds_x==0))
            {

                $('.price_nds_in_').removeAttr('readonly').removeClass('grey_edit');
                $('.price_in_').val(0);
                $('.price_in_').prop('readonly',true).addClass('grey_edit');
            } else
            {
                $('.price_in_').removeAttr('readonly').removeClass('grey_edit');
                $('.price_nds_in_').val(0);
                $('.price_nds_in_').prop('readonly',true).addClass('grey_edit');
            }
        }


        clearInterval(timerId);
        $.arcticmodal('close');
return;

    }


    box.find('.js-add-inv-block-x').show();
    box.find('.b_loading_small').remove();
    alert_message('error','Ошибка - попробуйте еще раз');


}

