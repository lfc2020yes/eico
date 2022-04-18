
$(function (){
$('body').on("change keyup input click",'.js-type-stock-prime',view_prime_stock);

$('body').on("change keyup",'.js-click-inpute-stock',view_itog_stock_new);

});

function js_dell_acc_dop()
{
    var box_active = $(this).closest('.box-modal');
    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');
    var for_id=box_active.find('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor');



    AjaxClient('prime','dell_dop','GET',data,'AfterDopD',for_id,0);

    box_active.find('.js-dell-acc-dop-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


}


function js_edit_dop_new_x()
{

    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-edit-works .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    if(err==0)
    {
        var for_id=box_active.find('.gloab-cc').attr('for');


        AjaxClient('prime','edit_dop','GET',0,'AfterE_ADOP',for_id,'form_prime_edit_work_new');

        // AjaxClient('prime','edit_material_2021','POST',0,'AfterEditMaTS',for_id,'form_prime_edit_mat_stock');

        box_active.find('.js-edit-dop-work-new-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }



}

function js_edit_work_new_x()
{

    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-edit-works .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    if(err==0)
    {
        var for_id=box_active.find('.gloab-cc').attr('for');


        AjaxClient('prime','edit_work','GET',0,'AfterE_A',for_id,'form_prime_edit_work_new');

        // AjaxClient('prime','edit_material_2021','POST',0,'AfterEditMaTS',for_id,'form_prime_edit_mat_stock');

        box_active.find('.js-edit-prime-work-new-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }



}


function js_add_work_new_x()
{

    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-add-works .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    if(err==0)
    {
        var for_id=box_active.find('.gloab-cc').attr('for');


        AjaxClient('prime','add_work','GET',0,'AfterWA',for_id,'form_prime_add_work_new');

       // AjaxClient('prime','edit_material_2021','POST',0,'AfterEditMaTS',for_id,'form_prime_edit_mat_stock');

        box_active.find('.js-add-prime-work-new-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }



}





//изменение материала в себестоимости клик по кнопке в форме добавить
//  |
// \/
function js_edit_prime_mat_stock()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-price-mats .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    var contractor_new=box_active.find('.js-type-stock-prime1').val();


    if(contractor_new==0)
    {
        box_active.find('.js-form-price-mats .gloab2').each(function(i,elem) {
            if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    } else
    {
        box_active.find('.js-form-price-mats .gloab1').each(function(i,elem) {
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


        AjaxClient('prime','edit_material_2021','POST',0,'AfterEditMaTS',for_id,'form_prime_edit_mat_stock');

        box_active.find('.js-edit-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }
}


//добавление связи работы с доп. сметой
//  |
// \/
function js_add_dop_mat_stock()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-price-mats .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    var contractor_new=box_active.find('.js-type-stock-prime1').val();





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


        AjaxClient('prime','add_dop_2021','POST',0,'AfterAddDOPS',for_id,'form_prime_add_mat_stock');

        box_active.find('.js-add-dop-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }
}


//добавление нового материала в себестоимости клик по кнопке в форме добавить
//  |
// \/
function js_add_prime_mat_stock()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-price-mats .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    var contractor_new=box_active.find('.js-type-stock-prime1').val();


    if(contractor_new==0)
    {
        box_active.find('.js-form-price-mats .gloab2').each(function(i,elem) {
            if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    } else
    {
        box_active.find('.js-form-price-mats .gloab1').each(function(i,elem) {
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


        AjaxClient('prime','add_material_2021','POST',0,'AfterAddMaTS',for_id,'form_prime_add_mat_stock');

        box_active.find('.js-add-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }
}


function AfterEditMaTS(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {
        //запускаем обновление раздела итоговых сумм
        update_itog_razdel($('.material[rel_ma="'+update+'"]').parents('.block_i').attr('rel'));

        $('.material[rel_ma="'+update+'"]').empty().append(data.echo);

        //обновить события связанные с работой с блоком
        update_block();


        clearInterval(timerId);
        $.arcticmodal('close');
        //обновить события связанные с работой с блоком
        alert_message('ok','Материал изменен');
        ToolTip();



        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}

function AfterAddDOPS(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {

        clearInterval(timerId);
        $.arcticmodal('close');
        //обновить события связанные с работой с блоком
        alert_message('ok','Связь добавлена');
        ToolTip();

        autoReloadHak();

        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-add-dop-block-x').show();
    box.find('.b_loading_small').remove();
}


function AfterAddMaTS(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {
        //запускаем обновление раздела итоговых сумм
        update_itog_razdel($('.n1n[rel_id="'+update+'"]').parents('.block_i').attr('rel'));


        //добавляем материал в начало для этой работы
        //но после доп. накладных если они есть
        if($('.n1n[rel_id='+update+']').next().is("[dop_house]"))
        {
            $('[rel_id_dop_x='+update+']').last().after(data.echo);
        } else {

            $('.n1n[rel_id="' + update + '"]').after(data.echo);
        }

        //обновить события связанные с работой с блоком
        update_block();


        clearInterval(timerId);
        $.arcticmodal('close');
        //обновить события связанные с работой с блоком
        alert_message('ok','Материал добавлен');
        ToolTip();

        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-add-prime-block-x').show();
    box.find('.b_loading_small').remove();
}

function view_itog_stock_new()
{
    var box_active = $(this).closest('.box-modal');
    var count_stock=parseFloat(ctrim(box_active.find('[name=count_work]').val()));
    var price_stock=parseFloat(ctrim(box_active.find('[name=price_work]').val()));
var flag_yes=0;
    if((count_stock!='')&&(count_stock!=0)&&(count_stock!= undefined)&&($.isNumeric(count_stock)))
    {
        if((price_stock!='')&&(price_stock!=0)&&(price_stock!= undefined)&&($.isNumeric(price_stock)))
        {
            var summaa=(count_stock*price_stock).toFixed(2);
            box_active.find('.all-summ-stock').slideDown("slow");
            box_active.find('.all-summ-stock input').val($.number(summaa, 2, '.', ' '));
            flag_yes=1;
        }
    }
    if(flag_yes==0)
    {
        box_active.find('.all-summ-stock').slideUp("slow");
    }

}


function view_prime_stock()
{
//alert("!");
    var t_soft=$('.js-type-stock-prime1').val();
    if(t_soft==1)
    {
        $('.js-options-invoice-1').slideDown("slow"); //показать
        $('.js-options-invoice-0').slideUp("slow"); //скрыть
        $('.search_bill_ed').hide();

    } else
    {
        $('.js-options-invoice-0').slideDown("slow");
        $('.js-options-invoice-1').slideUp("slow");

        if($('.js-mat-inv-posta10').val()!='') {
            $('.search_bill_ed').show();
        }
    }
}


//показать единицы в выбранном материале
//  |
// \/
function option_demo20(event)
{
    var box_active = $(this).closest('.box-modal');
    //alert($(this).val());
    var val=$(this).val();
    if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
    {
        $('.search_bill_ed').empty().hide();

        box_active.find('.js-add-prime-block-x,.js-edit-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


        var data ='url='+window.location.href+'&id='+val;
        AjaxClient('search','search_stock_units','GET',data,'AfterOptionDemo_Ed',val,0);

        event.stopPropagation();
    }
}


function AfterOptionDemo_Ed(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }
    if ( data.status=='ok' )
    {

        box.find('.js-add-prime-block-x').show();
        box.find('.js-edit-prime-block-x').show();
        box.find('.b_loading_small').remove();


        $('.search_bill_ed').empty().append(data.echo).slideDown("slow");


        //input_2021();
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);
        Zindex();
        return;
    }
    box.find('.js-add-prime-block-x').show();
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
    alert_message('error','Ошибка выбора материала');
}


//удалить раздел в себестоимости
//  |
// \/
function js_dell_block_x()
{
    var box_active = $(this).closest('.box-modal');
    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');
    var for_id=box_active.find('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor');



    AjaxClient('prime','dell_razdel','GET',data,'AfterRD',for_id,0);

    box_active.find('.js-dell-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


}


//добавление нового раздела в себестоимость
//  |
// \/
function js_add_block_x()
{
    var box_active = $(this).closest('.box-modal');
var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-prime .gloab').each(function(i,elem) {
    if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
        $(this).parents('.list_2021').addClass('required_in_2021');
        err++;
        //alert($(this).attr('name'));
    } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
});

if(err==0)
{

    var for_id=box_active.find('.gloab-cc').attr('for');


    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');

    AjaxClient('prime','add_razdel','POST',0,'AfterRA',for_id,'form_prime_add_block');



    //AjaxClient('prime','add_razdel','GET',data,'AfterRA',for_id,0);


    box_active.find('.js-add-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



} else
{
    //найдем самый верхнюю ошибку и пролестнем к ней
    //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
    //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
    alert_message('error','Не все поля заполнены');


}
}


//редактирование раздела в себестоимость
//  |
// \/
function js_edit_block_x()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-prime .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    if(err==0)
    {

        var for_id=box_active.find('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('prime','edit_razdel','POST',0,'AfterRE',for_id,'form_prime_edit_block');



        //AjaxClient('prime','add_razdel','GET',data,'AfterRA',for_id,0);


        box_active.find('.js-edit-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}


//постфункция удаление раздела в себестоимость
function AfterRD(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {

        $('.block_i[rel="'+update+'"]').remove();
        //обновляем итоговую сумму последнюю
        //обновление общей итоговых сумм по дому
        update_itog_seb();
        alert_message('ok','Раздел удален');
        clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        $.arcticmodal('close');
        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}




//постфункция редактирование раздела в себестоимости
function AfterRE(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }
    if ( data.status=='number' )
    {


        box.find('.js-edit-prime-block-x').show();
        box.find('.b_loading_small').remove();

        alert_message('error','Такой номер раздела уже существует');
        box.find("#number_r").addClass('error_formi');
        return;
    }
    if ( data.status=='ok' )
    {

        $('.block_i[rel="'+update+'"]').find('.top_bl').find('h2').empty().append(data.echo);
        clearInterval(timerId);
        $.arcticmodal('close');
        //обновить события связанные с работой с блоком
        alert_message('ok','Раздел изменен');
        update_block();
        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}



//постфункция добавление раздела в себестоимость
function AfterRA(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {
        //$('.block_is').first().before('<div rel="'+data.id+'" class="block_i"><div class="top_bl"><i class="i__">+</i><h2>'+data.echo+'</h2><span class="edit_12"><div for="'+data.id+'" data-tooltip="редактировать раздел" class="edit_icon_block"></div><div for="'+data.id+'" data-tooltip="Удалить раздел" class="del_icon_block"></div><div for="'+data.id+'" data-tooltip="Добавить работу" class="add_icon_block"></div></span><div class="count_basket_razdel"></div></div><div class="rls"></div></div>');
        $('.block_is').first().before(data.echo);

        if($('.icon17[on="show"]').length)
        {
            $('.summ_blogi[id_sub="'+data.id+'"]').show();
        }

        clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä


        $.arcticmodal('close');
        jQuery.scrollTo('.block_i[rel="'+data.id+'"]', 1000, {offset:-200});

        //обновить события связанные с работой с блоком
        update_block();
        alert_message('ok','Раздел добавлен');
        return;
    }
    if ( data.status=='number' )
    {


        box.find('.js-add-prime-block-x').show();
        box.find('.b_loading_small').remove();

        box.find("#number_r").addClass('error_formi');
        alert_message('error','Такой номер раздела уже существует');
        /*
        $('#yes_ra').after('<div class="error_text">Такой номер раздела уже существует</div>');
        $("#number_r").focus();
        setTimeout ( function () { $('.error_text').remove (); }, 7000 );
        */
        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-add-prime-block-x').show();
    box.find('.b_loading_small').remove();


}
