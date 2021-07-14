
//сохранить изменения в форме редактирование счета
function js_edit_save_acc_x() {
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.gloab').each(function (i, elem) {
        if ($(this).val() == '') {
            $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {
            $(this).parents('.input_2021').removeClass('required_in_2021');
            $(this).parents('.list_2021').removeClass('required_in_2021');
        }
    });

    var contractor_new = box_active.find('.js-type-soft-view1').val();


    if (contractor_new == 0) {
        box_active.find('.js-form-prime .gloab2').each(function (i, elem) {
            if ($(this).val() == '') {
                $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {
                $(this).parents('.input_2021').removeClass('required_in_2021');
                $(this).parents('.list_2021').removeClass('required_in_2021');
            }
        });
    } else {
        box_active.find('.js-form-prime .gloab1').each(function (i, elem) {
            if ($(this).val() == '') {
                $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {
                $(this).parents('.input_2021').removeClass('required_in_2021');
                $(this).parents('.list_2021').removeClass('required_in_2021');
            }
        });
    }


    if (err == 0) {
        var for_id = box_active.find('.gloab-cc').attr('for');


        AjaxClient('acc', 'edit_acc', 'POST', 0, 'AfterEditAcc', for_id, 'form_acc_edit_block');


        box_active.find('.js-edit-save-acc-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


    } else {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error', 'Не все поля заполнены');


    }
}


function AfterEditAcc(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        //обновляем вывод
        alert_message('ok','Данные сохранены');
        $('.js-acc-name-top').empty().append(data.name);
        $('.new-acc-block-2021[id_pre='+update+']').addClass('js-remove-block');


        $('.new-acc-block-2021[id_pre='+update+']').after(data.block);
        $('.js-remove-block').remove();
        //$('.new-acc-block-2021[id_pre='+update+']:first').remove();

        var box = $('.box-modal:last');
        clearInterval(timerId);
        box.find('.arcticmodal-close').click();

        return;
    }

    var box = $('.box-modal:last');
    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-save-acc-x').show();
    box.find('.b_loading_small').remove();


}


//удалить раздел в себестоимости
//  |
// \/
function js_dell_acc_x()
{
    var box_active = $(this).closest('.box-modal');
    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');
    var for_id=box_active.find('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor');



    AjaxClient('prime','dell_razdel','GET',data,'AfterRD',for_id,0);

    box_active.find('.js-dell-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


}


//добавление нового счета проверка в форме добавления
//  |
// \/
function js_add_acc_x()
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

   var contractor_new=box_active.find('.js-type-soft-view1').val();


   if(contractor_new==0)
   {
       box_active.find('.js-form-prime .gloab2').each(function(i,elem) {
           if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
               $(this).parents('.list_2021').addClass('required_in_2021');
               err++;
               //alert($(this).attr('name'));
           } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
       });
   } else
   {
       box_active.find('.js-form-prime .gloab1').each(function(i,elem) {
           if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
               $(this).parents('.list_2021').addClass('required_in_2021');
               err++;
               //alert($(this).attr('name'));
           } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
       });
   }


   // js-type-soft-view1 0 1
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







if(err==0)
{

    for ( var t = 0; t < cc.length; t++ )
    {
        var numty=$('[count='+cc[t]+']').val();
        var price=ctrim($('[price='+cc[t]+']').val());
        if(xvg=='')
        {
            xvg=numty+':'+price;
        } else
        {
            xvg=xvg+'-'+numty+':'+price;
        }

    }


    var for_id=box_active.find('.gloab-cc').attr('for');

    var files=box_active.find('.js-files-acc-new').val();

    if((contractor_new==0))
    {

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor')+'&number='+box_active.find("[name=number_soply1]").val()+'&date1='+box_active.find("[name=date_soply]").val()+'&date2='+box_active.find("[name=date_soply1]").val()+'&new_c='+contractor_new+'&post_p='+box_active.find("[name=id_kto]").val()+'&xvg='+xvg+'&com='+box_active.find("[name=text_comment]").val()+'&files='+files;
    } else
    {
        var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor')+'&number='+box_active.find("[name=number_soply1]").val()+'&date1='+box_active.find("[name=date_soply]").val()+'&date2='+box_active.find("[name=date_soply1]").val()+'&new_c='+contractor_new+'&name_c='+box_active.find("[name=name_contractor]").val()+'&address_c='+box_active.find("[name=address_contractor]").val()+'&inn_c='+box_active.find("[name=inn_contractor]").val()+'&xvg='+xvg+'&com='+box_active.find("[name=text_comment]").val()+'&files='+files;
    }

    AjaxClient('supply','add_soply','GET',data,'AfterAACC',$(".js-number-acc-new").val(),0);


    box_active.find('.js-add-acc-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

} else
{
    //найдем самый верхнюю ошибку и пролестнем к ней
    //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
    //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
    alert_message('error','Не все поля заполнены');


}
}


//постфункция добавление нового счета
function AfterAACC(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {

        //удалить все из кукки по этому счету и убрать все выделения
        var iu=$('.content_block').attr('iu');

        //пройтись по кукка этого счета и добавить иконки о новом счете в нужные места

        var cc = $.cookie('basket_supply_'+iu).split('.');
        for ( var t = 0; t < cc.length; t++ )
        {
          //  $('[supply_id='+cc[t]+']').find('.scope_scope').append('<div rel_score="'+data.ty+'" class="menu_click score_a"><i>'+cc.length+'</i><span>№'+update+'</span><strong><label>'+data.summa+'</label></strong></div><div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left: -50px; top: 5px; transform: scaleY(0);"><li><a href="javascript:void(0);" rel="1">Открыть</a></li><li><a href="javascript:void(0);" rel="2">Сделать текущим</a></li><li><a href="javascript:void(0);" rel="3">Согласовать</a></li><li><a href="javascript:void(0);" rel="4">Удалить</a></li></ul><input rel="x" name="vall" class="option_score1" value="0" type="hidden"></div>');

            $('[supply_id='+cc[t]+']').find('.scope_scope').append('<div rel_score="'+data.ty+'" data-tooltip="счет №'+update+' ('+data.dates+')" class="menu_click score_a"><span>№'+update+' ('+data.dates+')</span><strong><label>'+$.number(data.summa.toFixed(2), 2, '.', ' ')+'</label></strong><i>'+cc.length+'</i><form class="none"  action="acc/'+data.ty+'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data"><input name="a" value="open" type="hidden"></form></div><div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left: -50px; top: 5px; transform: scaleY(0);"><li><a href="javascript:void(0);" rel="1">Открыть</a></li><li><a href="javascript:void(0);" rel="2">Сделать текущим</a></li><li><a href="javascript:void(0);" rel="3">Согласовать</a></li><li><a href="javascript:void(0);" rel="4">Удалить</a></li></ul><input rel="x" name="vall" class="option_score1" value="0" type="hidden"></div>');


            alert_message('ok','Новый счет добавлен');


            var hf=$('[supply_id='+cc[t]+']').attr('supply_stock');
            var hf1=hf.split('_');
            //alert(hf1);
            UpdateStatusADA(hf1[0]);

            var box = $('.box-modal:last');
            clearInterval(timerId);
            box.find('.arcticmodal-close').click();


        }

        $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $('.checher_supply').removeClass('checher_supply');
        basket_supply();

        /*
        //показать панель для загрузки фото к договору
        $('.new_qqe').empty().append('Счет №'+update);
        $('.soply_step_1').hide();
        $('.img_ssoply').show();
        $('.hop_lalala').find(".loader_inter").before('<div id_upload="'+data.ty+'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'+data.ty+'" id_sc="'+data.ty+'" name="upload'+data.ty+'"><input class="sc_sc_loo11" type="file" name="myfile'+data.ty+'"></form><div class="loaderr_scan scap_load_'+data.ty+'" style="width:100%"><div class="scap_load__" style="width: 0%;"></div></div>');

        $('.hop_lalala').find(".loader_inter").remove();
*/


        return;
    }

    var box = $('.box-modal:last');
    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}

//редактирование раздела в себестоимость
//  |
// \/
function js_edit_acc_x()
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


//удалить мат их счета
//  |
// \/
function js_dell_acc_mat()
{
    var box_active = $(this).closest('.box-modal');
    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');
    var for_id=box_active.find('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor');



    AjaxClient('acc','dell_acc_material','GET',data,'AfterDMa',for_id,0);

    box_active.find('.js-dell-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


}

//постфункция удаление материл из счета
function AfterDMa(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {

        var title_url=$(document).attr('title');
        var url=window.location.href;
        url=url+'dell/';
        History.pushState('', title_url, url);

        autoReloadHak();
        clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        $.arcticmodal('close');


        $('[yi_sopp_='+update+']').slideUp("slow");


        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}


//переслать заявку
//  |
// \/
function js_add_forward_x()
{


        var box_active = $(this).closest('.box-modal');
        var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
        box_active.find('.js-form-forward .gloab').each(function (i, elem) {
            if ($(this).val() == '') {
                $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {
                $(this).parents('.input_2021').removeClass('required_in_2021');
                $(this).parents('.list_2021').removeClass('required_in_2021');
            }
        });

        if (err == 0) {

            $('.js-form-forward').submit();

        } else {
            //найдем самый верхнюю ошибку и пролестнем к ней
            //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
            //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
            alert_message('error', 'Не все поля заполнены');


        }

}


//добавление причины по отклонению заявки
//  |
// \/
function js_add_reject_x()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-reject .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    if(err==0)
    {

        $('.js-form-reject').submit();

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}

//добавление нового замечания в форме согласовать
//  |
// \/
function js_add_remark_x()
{
    var box_active = $(this).closest('.box-modal');
var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-remark .gloab').each(function(i,elem) {
    if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
        $(this).parents('.list_2021').addClass('required_in_2021');
        err++;
        //alert($(this).attr('name'));
    } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
});

if(err==0)
{

    $('.js-form-remark').submit();

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

//var FormsFlag = true;

//функция определения загружен ли скрипт forms.js
//она пустая но с помощью ее можно узнать определена она или нет в окнах
function forms_js_load()
{

}


//форма зайти в систему
//  |
// \/
function js_login_login()
{
	var box_active = $(this).closest('.box-modal');
	var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
	box_active.find('.js-form-login-x .gloab').each(function(i,elem) {
		if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
			$(this).parents('.list_2021').addClass('required_in_2021');
			err++;
			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
	});

	if(err==0)
	{
		box_active.find('.js-form-login-x').submit();
	}
}

//Закрыть второе,третье.. окно которое открыто поверх какого-то
//  |
// \/
function js_exit_form_sel1()
{

	//$(this).closest('.box-modal');
	$( '.arcticmodal-close', $( this ).closest( '.box-modal' )).click();

}

//выбор города при формирование отчета на печать

function stock_kvartal_x()
{

	var val=$(this).val();
	if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
	{
		$('.stock_ob_x').empty().hide();
		var data ='url='+window.location.href+'&id='+val;
		AjaxClient('stock','search_kvartal','GET',data,'AfterStock_Kvartal_',val,0);
	} else
	{
		if(val==0)
		{
			$('.stock_ob_x').empty().hide();
		}
	}
}



//выбор города при формирование отчета на печать
function stock_town_x()
{

	var val=$(this).val();
	if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
	{
		$('.stock_kv_x').empty().hide();
		$('.stock_ob_x').empty().hide();
		var data ='url='+window.location.href+'&id='+val;
		AjaxClient('stock','search_town','GET',data,'AfterStock_Town_',val,0);
	} else
	{
		if(val==0)
		{
			$('.stock_kv_x').empty().hide();
			$('.stock_ob_x').empty().hide();
		}
	}
}


function option_demo()
{
	//alert($(this).val());
	var val=$(this).val();
	if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
	{
		$('.search_bill').hide();


		$('#yes_material_invoice').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		$('.no_bill_material').hide();
		var col=$('.h111').attr('col');
		var data ='url='+window.location.href+'&id='+val+'&col='+col;
		AjaxClient('invoices','search_bill','GET',data,'AfterOptionDemoS',val,0);
	}
}

function option_checkbox_xvg()
{
	//alert("!");
	//var ini=$('#wall_summ');
	if($(this).is('.active_bill'))
	{
		$(this).removeClass('active_bill');
		//$('.cha_1').removeClass('active_option');
		var intt=$(this).find('.input_option_xvg');
		intt.val('0');
		$(this).next('.option_slice_xxg').slideUp( "slow", function() { $(this).next('.option_slice_xxg').removeClass('active_option'); } );
		//$('.cha_1').slideUp( "slow", function() { $('.cha_1').addClass('active_option'); } );
		//ini.val(ini.attr('max')).prop('readonly',true);


	} else
	{
		$(this).addClass('active_bill');
		//$('.cha_1').addClass('active_option');
		//$('.cha_1').slideDown( "slow", function() { $('.cha_1').addClass('active_option'); } );

		$(this).next('.option_slice_xxg').slideDown( "slow", function() { $(this).next('.option_slice_xxg').addClass('active_option'); } );

		var intt=$(this).find('.input_option_xvg');
		intt.val('1');

	}

}



//двойно клик по инпуту
function MydblclickPay()
{
	if($(this).attr('readonly')==undefined) {
		$(this).val($(this).attr('max')).change();
	}

}

//функция ввода суммы договора
function EditSummWall()
{

	var sum_doc=parseFloat($(this).val());
	var sum_max=parseFloat($(this).attr('max'));
	//alert(sum_max);
	if(sum_doc>sum_max)
	{
		$('#yes_bill_non').hide();
	} else
	{
		$('#yes_bill_non').show();
	}
}


//нажатие на материал в кошельке
function wallet_checkbox()
{
	//alert("!");
	var pp=$(this).parents('.wallet_material');
	var id=pp.attr('wall_id');

	if(pp.is('.active_wall'))
	{

		pp.removeClass('active_wall');
		pp.find('.yop_'+id).val(0);

	} else
	{
		pp.addClass('active_wall');
		pp.find('.yop_'+id).val(1);
	}

}


//удаление материала из формы редактирование договора
function del_basket_joo1()
{
	var att=$(this).attr('id_rel');
//проверить что это не последний материал из заявок по этому счету
	//alert($('[yi_sopp_]').length);
	if($('[yi_sopp_]').length!=1)
	{
		var data ='url='+window.location.href+'&id='+att;
		AjaxClient('supply','del_material','GET',data,'AfterDellSUPM',att,0);
		$(this).parents('[yi_sopp_]').hide();
	} else
	{
		$(this).remove();
	}
}

//удаление материала из формы добавление договора
function del_basket_joo()
{
	var att=$(this).attr('id_rel');

	var iu=$('.content_block').attr('iu');

	var tr=$(this).parents('.js-acc-block').find('.xvg_material_doc').val();

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

	var cc = tr.split('.');
	for ( var t = 0; t < cc.length; t++ )
	{


		//alert(ssup);
		CookieList(ssup+iu,cc[t],'del');
		// alert($(this).parents('[rel_id]').attr('rel_id'));
		basket_supply();
		ToolTip();
		$('[supply_id='+cc[t]+']').removeClass("checher_supply");
	}


	$('[yi_sopp_='+att+']').remove();



	//если не осталось не одного материала закрыть форму
	var cookie_new = $.cookie('basket_supply_'+iu);
	if(cookie_new==null)
	{
		clearInterval(timerId);
		$.arcticmodal('close');
	}

}


function EditPay()
{
	$(this).val($(this).val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
	var summ=parseFloat($(this).val());
	var max=parseFloat($(this).attr('max'));
	if((summ!=0)&&(summ!='')&&($.isNumeric(summ))&&(max!=0)&&(max!='')&&($.isNumeric(max)))
	{
		if(summ<=max)
		{
			var dept=max-summ;
			if(dept>=1)
			{
				$('.debts').empty().append('<span class="morr">'+$.number(dept, 2, '.', ' ')+'</span>');
			} else
			{
				$('.debts').empty().append('<span class="morr1">'+$.number(dept, 2, '.', ' ')+'</span>');
			}

			$('#yes_pay').show();
			$('#yes_pay_avans').show();
		} else
		{
			$('#yes_pay').hide();
			$('#yes_pay_avans').hide();
			$('.debts').empty().append('<span class="morr1">0</span>');
		}


	} else
	{
		$('#yes_pay').hide();
	}

}

//функция проверки ввода только чисел и с запятой
var validate = function() {
	$(this).val($(this).val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
}

//функция проверки ввода только чисел целых
var validate_cel = function() {
	$(this).val($(this).val().replace(/[^\d]*/g, '').replace(/([])[]+/g, '$1').replace(/^[^\d]*(\d+([]\d{0,5})?).*$/g, '$1'));
}

//подсчет итоговой суммы работы при ее добавлении
var itogprice = function() {
	var count= $('#count_work').val();
	var price= $('#price_work').val();
	if((count!=0)&&(count!='')&&(price!=0)&&(price!=''))
	{
		$('.fg_summ').slideDown( "slow" );
		$('#summa_work').addClass('ok_green').val((count*price).toFixed(2));
	} else{

		$('#summa_work').removeClass('ok_green').val('');
		$('.fg_summ').slideUp( "slow" );
	}


}




//подсчет итоговой суммы для материала при редактирование материала
var itogprice_mm = function() {
	var count= $('#count_work_mm').val();
	var price= $('#price_work_mm').val();
	if((count!=0)&&(count!='')&&(price!=0)&&(price!=''))
	{
		$('.fg_summ').slideDown( "slow" );
		$('#summa_work_mm').addClass('ok_green').val((count*price).toFixed(2));
	} else{

		$('#summa_work_mm').removeClass('ok_green').val('');
		$('.fg_summ').slideUp( "slow" );
	}


}




//подсчет итоговой суммы для материалов добавляющихся при доб. работы
var itogprice1 = function(id) {
	var count= $('#count_material_'+id).val();
	var price= $('#price_material_'+id).val();


	if((count!=0)&&(count!='')&&(price!=0)&&(price!=''))
	{
		$('.fg_summ_'+id).slideDown( "slow" );
		$('#summa_material_'+id).addClass('ok_green').val((count*price).toFixed(2));
	} else
	{
		$('#summa_work_'+id).removeClass('ok_green').val('');
		$('.fg_material_'+id).slideUp( "slow" );
	}


}

//нажатие на кроку плюс добавить материал в форме
var material_plus = function(){
	$(this).hide();
	//$('.over11_'+$('#count_material').val()).empty().height("1px");
	$(this).parent().empty().height("1px");
	var count__=$('#count_material').val();
	var dee=parseInt(count__)+1;
	$('#count_material').val(dee);

	var html = $( '.replace_mm' ).html ();
	html = html.replace ( /IDMID/g, dee);
	$('._right_ajax_form').append(html);
	update_block_x(dee);
	//$('.loader_inter').remove();

}


var updatepay = function(vid,idd)
{
	$('[rel_id='+idd+']').find('.yes_pay_grey').remove();

	if($.isNumeric(vid))
	{
		if(vid!=0)
		{
			$('[rel_id='+idd+']').find('.pay_meta').after('<div data-tooltip="Есть неподписанные выдачи" class="yes_pay_grey">'+vid+'</div>');
		}
	}




	ToolTip();
}


//обновление итоговых сумм по разделу
var update_itog_razdel = function(update)
{


	//делаем загрузчик
	if($('.block_i[rel="'+update+'"]').find('.itog').length)
	{
		$('.block_i[rel="'+update+'"]').find('.itog:last').after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
		$('.block_i[rel="'+update+'"]').find('.itog').remove();
	} else
	{
		//вдруг итогов по разделу еще нет это первое добавление раздела
		$('.block_i[rel="'+update+'"]').find('.rls').append('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');

	}
	var data ='url='+window.location.href+'&id='+update;
	AjaxClient('prime','update_subtotal_razdel','GET',data,'AfterUIR',update,0);

}

//обновление итоговых сумм по разделу
var update_itog_seb = function()
{
	$('.block_is:last').after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	$('.block_is').remove();

	//делаем загрузчик
	//$('.block_i[rel="'+update+'"]').append('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	var id_dom=$('.content_block').attr('dom');

	var data ='url='+window.location.href+'&id='+id_dom;
	AjaxClient('prime','update_subtotal_seb','GET',data,'AfterUIS',id_dom,0);

}

//выполнять при добавление нового товара в форме
var update_block_x = function(id) {
	//маска для полей числовых
	$('.count_mask_'+id).unbind("change keyup input click");
	$('.count_mask_'+id).bind("change keyup input click", validate);
	//высчитываем итоговую сумму по работе
	//alert(id);

	//$('#count_material_'+id+',#price_material_'+id).unbind("change keyup input click");
	$('#count_material_'+id+',#price_material_'+id).bind("change keyup input click", function() { itogprice1(id); });

	//вывод дополнительного меню для выбора единиц
	$('.icon_cal1').unbind("click");
	$('.icon_cal1').bind("click", icon_cal1);
	//нажатие на выпавшее меню
	$('.dop_table span').unbind( "click");
	$('.dop_table span').bind( "click", dop_table_span);

	//$('.text_material').autoResize({extraSpace : 50});
	$('.text_material').focus().trigger('keyup');
	//удалить материал нажатие на иконку
	$('.del_icon_material').unbind( "click");
	$('.del_icon_material').bind( "click",del_icon_material);
	//кнопка плюс
	$('.i___').unbind( "click");
	$('.i___').bind( "click", material_plus);
}

//удалить материал нажатие на иконку в форме добавить работу
var del_icon_material = function(){
	var ss=$('.material__'+$(this).attr("for")).prev().find('.over11');
	//alert(ss.length);
	if ( $(this).is("[for]") )
	{
		if($.isNumeric($(this).attr("for")))
		{
			$('.material__'+$(this).attr("for")).remove();
		}
	}
	if($('.matr_add__').length==1)
	{
		$("#Modal-one").removeClass('_form_2_');
		$("#Modal-one").children(':first').children(':first').removeClass('_left_ajax_form');
		$('._right_ajax_form').hide();
		$('#ma_rd').show();
	}

	var flag_plus=$(this).parent().parent().find('.i___').length;
	if((flag_plus==1)&&($('.matr_add__').length!=1))
	{
		ss.empty().append('<i data-tooltip="добавить еще материал" class="i___">+</i>').height("65px");
		$('.i___').unbind( "click");
		$('.i___').bind( "click", material_plus);

	}



}

//клик для меню ед. измерения
var icon_cal1 = function(){

	if( $(this).parent().next().is(':visible') ) { $(this).parent().next().hide();  } else {
		$(this).parent().next().show(); }

}
//нажатие на выпавшее меню единицы измерения
var dop_table_span  = function(){
	$(this).parent().hide();
	$(this).parent().prev().children().val($(this).text());
}


$(document).ready(function(){

	$('.label_s').unbind("change keyup input click", label_show);
	$('.label_s').bind("change keyup input click", label_show);
	$('.box-modal').on("change keyup input click",'.option_xvg2',option_checkbox_xvg);


	$('.invoice_step_1').on("change",'.demo-5',option_demo);


	$('.print_stocks').on("change",'#stock_town_',stock_town_x);
	$('.print_stocks').on("change",'#stock_kvartal_',stock_kvartal_x);


	$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

	$('.bill_wallet').on("change keyup input click",'.summ_input_ww',EditSummWall);

	$(".cal_223").bind('click', function() { $(this).prev('.calendar_t').trigger('focus');});

	$('.img_ssoply').on("click",'.del_icon_blockbb',DellImageSupply);
//авторизация войти
//авторизация войти
//авторизация войти

	$("#email_formi").keyup(function(){

		var email = $("#email_formi").val();

		if(email != '')
		{
		} else
		{
			$("#email_formi").addClass('error_formi');

		}


	});

	$("#password_formi").keyup(function(){

		if(($("#password_formi").val()=='')||($("#password_formi").val()==0))
		{
			$("#password_formi").addClass('error_formi');

		} else
		{
			$("#password_formi").removeClass('error_formi');
		}

	});

	$('#yes_print_stock').on( "click", function() {

		$('#lalala_form22').submit();

	});

//добавить материал в накладную после выбора из склада и счета
	$('#yes_material_invoice').on( "click", function() {

		var demo=$('.demo-5').val();
		var news=$('.new_sklad_i').val();
		if((demo!=0)&&($.isNumeric(demo))&&(news==0))
		{

			$('#yes_material_invoice').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

			var val=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+val+'&demo='+demo+'&number='+$('.demo-6').val()+'&ss='+$('[name=ss]').val();
			AjaxClient('invoices','add_material','GET',data,'AfterOptionDemo',demo,0);

		}
		if(news==1)
		{
			var err=0;
			$('.ee_group,.ed_new_stock,.name_new_stock').removeClass('error_formi');

			//добавление нового материала на склад
			var ed=$('.ed_new_stock').val();
			var name=$('.name_new_stock').val();
			var group=$('#group_new_stock').val();
			if((ed=='')||(ed==0))
			{
				$('.ed_new_stock').addClass('error_formi');
				err=1;
			}
			if((name=='')||(name==0))
			{
				$('.name_new_stock').addClass('error_formi');
				err=1;
			}
			if((group=='')||(group==0))
			{
				$('.ee_group').addClass('error_formi');
				err=1;
			}
			if(err==0)
			{
				$('#yes_material_invoice').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

				var val=$('.h111').attr('for');
				var data ='url='+window.location.href+'&id='+val+'&name='+name+'&ed='+ed+'&group='+group+'&ss='+$('[name=ss]').val();
				AjaxClient('invoices','add_material_new','GET',data,'AfterOptionDemo',demo,0);
			}
		}


	});


//авторизация войти
//авторизация войти
//авторизация войти





//добавить работу к разделу	проверка заполнения всех данных
	$('#yes_wa').on( "click", function() {
		var err = [0,0,0,0];

		$(".div_text_glo,#number_r,#count_work,#price_work").removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');


		if($("#number_r").val() == '')
		{
			$("#number_r").addClass('error_formi');
			err[0]=1;
		}
		if($("#otziv_area").val() == '')
		{
			$(".div_text_glo").addClass('error_formi');
			err[1]=1;
		}
		if(($("#count_work").val() == '')||($.isNumeric($("#count_work").val()) == false))
		{
			$("#count_work").addClass('error_formi');
			err[2]=1;
		}
		if(($("#price_work").val() == '')||($.isNumeric($("#price_work").val()) == false))
		{
			$("#price_work").addClass('error_formi');
			err[3]=1;
		}



		var count_mat=$('#count_material').val();
		var err_m = new Array();
		var er_b=0;
		for ( var t = 1; t <= count_mat; t++ )
		{
			if ( $( ".material__"+t ).length )
			{
				$(".div_text_glo_"+t+",#number_rm1_"+t+",#count_material_"+t+",#price_material_"+t+"").removeClass('error_formi');
				if($("#number_rm1_"+t).val() == '')
				{
					$("#number_rm1_"+t).addClass('error_formi');
					err_m.push(1);
				}
				if($("#otziv_area_"+t).val() == '')
				{
					$(".div_text_glo_"+t).addClass('error_formi');
					err_m.push(1);
				}
				if(($("#count_material_"+t).val() == '')||($.isNumeric($("#count_material_"+t).val()) == false))
				{
					$("#count_material_"+t).addClass('error_formi');
					err_m.push(1);
				}
				if(($("#price_material_"+t).val() == '')||($.isNumeric($("#price_material_"+t).val()) == false))
				{
					$("#price_material_"+t).addClass('error_formi');
					err_m.push(1);
				}
			}



		}
		$.each(err_m, function(index, value){
			if(value==1)
			{
				er_b=1;
				return false;
			}
		});



		if((err[0]==0)&&(err[1]==0)&&(err[2]==0)&&(err[3]==0)&&(er_b==0))
		{




			clearInterval(timerId);
			$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			//изменить кнопку на загрузчик
			$('#yes_wa').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');


			AjaxClient('prime','add_work','GET',0,'AfterWA',for_id,'lalala_form');

		}



	});

	$('.add_sk_sk_sk').on( "click", function() {
		$('.select-mania').show();
		$('.add_sklad_pl').hide();
		$('.new_sklad_name').val(0);
	});

	$('.add_sk_sk_sk1').on( "click", function() {
		$('.add_sklad_pl1').hide();
		$('.select-mania-theme-orange2').show();
		$('.new_sklad_i').val(0);
	});


//изменить наименование на складе
	$('#yes_add_stock1').on( "click", function() {


		var err = 0;

		//$("#number_r").removeClass('error_formi');
		$('.ee_group,.ed_new_stock,.white_list_name').removeClass('error_formi');

		//добавление нового материала на склад
		var ed=$('.ed_new_stock').val();
		var name=$('.white_list_name').val();
		var group=$('#group_new_stock').val();

		if((ed=='')||(ed==0))
		{
			$('.ed_new_stock').addClass('error_formi');
			err=1;
		}
		if((name=='')||(name==0))
		{
			$('.white_list_name').addClass('error_formi');
			err=1;
		}
		if((group=='')||(group==0))
		{
			$('.ee_group').addClass('error_formi');
			err=1;
		}
		$('.sk_error').empty();
		if(err==1)
		{
			$('.sk_error').empty().append('Заполните все необходимые поля').show();
			err=1;
		}

		if(err==0)
		{
			$('#yes_add_stock1').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			$('.no_add_sss').hide();
			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+'&name='+$(".white_list_name").val()+'&ed='+ed+'&group='+group+'&id='+for_id;

			AjaxClient('stock','edit_stock','GET',data,'AfterAddStock1',for_id,0);
		}


	});


//добавить новый материал на склад
	$('#yes_add_stock').on( "click", function() {


		var err = 0;

		//$("#number_r").removeClass('error_formi');
		$('.ee_group,.ed_new_stock,.white_list_name').removeClass('error_formi');

		//добавление нового материала на склад
		var ed=$('.ed_new_stock').val();
		var name=$('.white_list_name').val();
		var group=$('#group_new_stock').val();

		if((ed=='')||(ed==0))
		{
			$('.ed_new_stock').addClass('error_formi');
			err=1;
		}
		if((name=='')||(name==0))
		{
			$('.white_list_name').addClass('error_formi');
			err=1;
		}
		if((group=='')||(group==0))
		{
			$('.ee_group').addClass('error_formi');
			err=1;
		}
		$('.sk_error').empty();
		if(err==1)
		{
			$('.sk_error').empty().append('Заполните все необходимые поля').show();
			err=1;
		}

		if(err==0)
		{
			$('#yes_add_stock').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			$('.no_add_sss').hide();

			var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+'&name='+$(".white_list_name").val()+'&ed='+ed+'&group='+group;

			AjaxClient('stock','add_stock','GET',data,'AfterAddStock',0,0);
		}


	});

//сохранить связь с материалом и складом
	$('#yes_update_sk_sk').on( "click", function() {

		var for_id=$('.h111').attr('for');
		var err = 0;
		$('.sk_error').empty().hide();


		//$("#number_r").removeClass('error_formi');
		$('.ee_group,.ed_new_stock,.white_list_name').removeClass('error_formi');

		//добавление нового материала на склад
		var ed=$('.ed_new_stock').val();
		var name=$('.white_list_name').val();
		var group=$('#group_new_stock').val();

		if((ed=='')||(ed==0))
		{
			$('.ed_new_stock').addClass('error_formi');
			err=1;
		}
		if((name=='')||(name==0))
		{
			$('.white_list_name').addClass('error_formi');
			err=1;
		}
		if((group=='')||(group==0))
		{
			$('.ee_group').addClass('error_formi');
			err=1;
		}



		if(err==1)
		{
			$('.sk_error').empty().append('Заполните новое название материала на складе').show();
			err=1;
		}


		if(err==0)
		{
			$('#yes_update_sk_sk').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			$('.end_list_white').hide();

			var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&select='+$(".demo-3").val()+'&new='+$(".new_sklad_name").val()+'&name='+$(".white_list_name").val()+'&ed='+ed+'&group='+group;

			AjaxClient('supply','svyz_sklad','GET',data,'AfterSVS',for_id,0);
		}


	});


	$('#yes_material_zayva').on( "click", function() {
		var for_id=$('.h111').attr('for');
		var dom_id=$('.h111').attr('dom');

		//alert($.cookie('basket_'+dom_id));
		//CookieList("basket_"+dom_id,for_id,'del');
		CookieList(window.b_cm+'_'+dom_id,for_id,'del');

		//alert($.cookie('basket_'+dom_id));

		//если это не единсвенный материал по этой работе то удалить только материал
		//если это единсвенный материал удалить вместе с работой

		var work=$('[mat_zz='+for_id+']').attr('works');
		$('[mat_zz='+for_id+']').remove();

		if($('[works='+work+']').length==0)
		{ $('[work='+work+']').remove()   }

		BasketUpdate_Z(dom_id);


		clearInterval(timerId);
		$.arcticmodal('close');

	});

	$('#yes_material_zayva1').on( "click", function() {
		var for_id=$('.h111').attr('for');
		var dom_id=$('.h111').attr('dom');

		//alert($.cookie('basket_'+dom_id));
		//CookieList("basket_"+dom_id,for_id,'del');


		//alert($.cookie('basket_'+dom_id));

		//если это не единсвенный материал по этой работе то удалить только материал
		//если это единсвенный материал удалить вместе с работой
		//alert(dom_id);
		var work=$('[mat_zz='+dom_id+']').attr('works');
		$('[mat_zz='+dom_id+']').remove();

		if($('[works='+work+']').length==0)
		{ $('[work='+work+']').remove()   }

		//BasketUpdate_Z(dom_id);


		var data ='url='+window.location.href+'&id='+for_id+'&n='+dom_id+'&tk='+$('.h111').attr('mor');
		AjaxClient('app','dell_material_is_zayvka','GET',data,'AfterDZZ',for_id,0);


		clearInterval(timerId);
		$.arcticmodal('close');

	});

	$('#yes_naryd_work').on( "click", function() {
		var for_id=$('.h111').attr('for');
		var dom_id=$('.h111').attr('dom');

		//alert($.cookie('basket_'+dom_id));
		//CookieList("basket_"+dom_id,for_id,'del');
		CookieList(window.b_co+'_'+dom_id,for_id,'del');

		//alert($.cookie('basket_'+dom_id));

		$('[work='+for_id+']').remove();

		BasketUpdate(dom_id);
		UpdateItog();

		clearInterval(timerId);
		$.arcticmodal('close');

	});

//редактировать- подготовить к оплате счет
	$('#yes_bill_non1').on( "click", function() {
		var err = 0;
		//alert("~");

		$('.summ_input_ww').removeClass('error_summ');
		$('.wallet_material').find('.calendar_t').removeClass('error_formi');
		$('.cha_1').find('.wallet_material').removeClass('error_material');
		if($('.option_y1').is('.active_bill'))
		{
			var inputs=$('.summ_input_ww');
			var inputs_val=parseFloat(inputs.val());
			var maxx=parseFloat(inputs.attr('max'));
			if((inputs_val==0)||(inputs_val=='')||(!$.isNumeric(inputs_val))||(inputs_val>maxx))
			{
				err=1;
				$('.summ_input_ww').addClass('error_summ');
			}


			var count_rt=0;

			$('.rt_wall').each(function(i,elem) {



				if($(this).val()==1) {count_rt++;



				}
			});
			if(count_rt==0)
			{
				$('.cha_1').find('.wallet_material').addClass('error_material');
				err=1;
			}



		}
		if($('.option_y2').is('.active_bill'))
		{
			var calle=$('#date_hidden_table_gr1').val();

			if(calle=='')
			{
				$('.wallet_material').find('.calendar_t').addClass('error_formi');
				err=1;
			}
		}


		if((err==0))
		{

			var add='';
			$('.rt_wall').each(function(i,elem) {



				if($(this).val()==1) {

					var tyy=$(this).parents('.wallet_material').attr('wall_id');
					if(add=='')
					{
						add=tyy;
					} else
					{
						add=add+'.'+tyy;
					}



				}
			});


			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&comm='+$("#otziv_area_adaxx").val()+'&date='+$("#date_hidden_table_gr1").val()+'&summa='+$(".summ_input_ww").val()+'&add='+add+'&pol='+$(".popol_bill_").val();

			AjaxClient('bill','edit_bill_yes_buy','GET',data,'AfterWalletBill',for_id,0);


			$(this).hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		}

	});

//ок- подготовить к оплате счет
	$('#yes_bill_non').on( "click", function() {
		var err = 0;
		//alert("~");

		$('.summ_input_ww').removeClass('error_summ');
		$('.wallet_material').find('.calendar_t').removeClass('error_formi');
		$('.cha_1').find('.wallet_material').removeClass('error_material');
		if($('.option_y1').is('.active_bill'))
		{
			var inputs=$('.summ_input_ww');
			var inputs_val=parseFloat(inputs.val());
			var maxx=parseFloat(inputs.attr('max'));
			if((inputs_val==0)||(inputs_val=='')||(!$.isNumeric(inputs_val))||(inputs_val>maxx))
			{
				err=1;
				$('.summ_input_ww').addClass('error_summ');
			}


			var count_rt=0;

			$('.rt_wall').each(function(i,elem) {



				if($(this).val()==1) {count_rt++;



				}
			});
			if(count_rt==0)
			{
				$('.cha_1').find('.wallet_material').addClass('error_material');
				err=1;
			}



		}
		if($('.option_y2').is('.active_bill'))
		{
			var calle=$('#date_hidden_table_gr1').val();

			if(calle=='')
			{
				$('.wallet_material').find('.calendar_t').addClass('error_formi');
				err=1;
			}
		}


		if((err==0))
		{

			var add='';
			$('.rt_wall').each(function(i,elem) {



				if($(this).val()==1) {

					var tyy=$(this).parents('.wallet_material').attr('wall_id');
					if(add=='')
					{
						add=tyy;
					} else
					{
						add=add+'.'+tyy;
					}



				}
			});


			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&comm='+$("#otziv_area_adaxx").val()+'&date='+$("#date_hidden_table_gr1").val()+'&summa='+$(".summ_input_ww").val()+'&add='+add+'&pol='+$(".popol_bill_").val();

			AjaxClient('bill','bill_yes_buy','GET',data,'AfterWalletBill',for_id,0);


			$(this).hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		}

	});

//сохранение изменения в счете
	/*
$('#yes_soply12').on( "click", function() {


    var err = 0;
	$('.box-soply').find('.required_in_2018').removeClass('required_in_2018');

	//$("#number_r").removeClass('error_formi');
	$('.jj_number').removeClass('error_formi');
 var xvg='';

	$('.jj_number').each(function(i,elem) {
	var numty=$(this).val();
	if((numty==0)||(numty=='')||(!$.isNumeric(numty)))
	    {
		 $(this).addClass('error_formi');
		 err=1;
		}
		if(xvg=='')
			{
				xvg=numty;
			} else
				{
					xvg=xvg+'-'+numty;
				}
});





    if(($(".post_p").val() == '')&&($(".new_contractor_").val()==0))
	{
		$(".loll_div").addClass('required_in_2018');
		err=1;
	}
	if($(".new_contractor_").val()==1)
	{
	    if($("#name_contractor").val() == '')
	    {
		$("#name_contractor").parents('.input_2018').addClass('required_in_2018');
		err=1;
	    }
	    if($("#address_contractor").val() == '')
	    {
		$("#address_contractor").parents('.input_2018').addClass('required_in_2018');
		err=1;
	    }
	    if($("#inn_contractor").val() == '')
	    {
		$("#inn_contractor").parents('.input_2018').addClass('required_in_2018');
		err=1;
	    }
	}


	if($("#number_soply1").val() == '')
	{
		$("#number_soply1").parents('.input_2018').addClass('required_in_2018');
		err=1;
	}
	if($("#summa_soply").val() == '')
	{
		$("#summa_soply").parents('.input_2018').addClass('required_in_2018');
		err=1;
	}
	if($("#date_soply").val() == '')
	{
		$("#date_soply").parents('.input_2018').addClass('required_in_2018');
		err=1;
	}

	if((err==0))
	{




	//clearInterval(timerId);
	//$.arcticmodal('close');
	var for_id=$('.h111').attr('for');
	//изменить кнопку на загрузчик
	$('#yes_soply12').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	$('#no_rd').hide();
	$('.box-soply').find('._50_x').hide();

	  if(($(".new_contractor_").val()==0))
	{

   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".post_p").val()+'&xvg='+xvg+'&com='+$("#otziv_area_ada").val();
	} else
	{
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val()+'&xvg='+xvg+'&com='+$("#otziv_area_ada").val();
	}
   AjaxClient('supply','rewrite_soply','GET',data,'AfterAACC1',for_id,0);
	//AjaxClient('supply','add_acc','GET',0,'AfterAACC',for_id,'lalala_form');

	}

});
*/

//изменить счет
	$('#yes_soply12').on( "click", function() {


		// var err = [0,0,0,0,0,0,0];
		var err  = 0
		$('.box-soply').find('.required_in_2018').removeClass('required_in_2018');
		$('.select-mania-theme-orange1').removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');

		var iu=$('.content_block').attr('iu');
		//var tr=$(this).parents('.tr_dop_supply');

		//var cookie_new = $.cookie('basket_supply_'+iu);
		//var cookie_flag_current = $.cookie('current_supply_'+iu);
		//alert(cookie_new);
		/*
        if(cookie_flag_current==null)
        {
            var ssup='basket_supply_';
        } else
        {
            var ssup='basket_score_';
        }
        */
		$('.jj_number').removeClass('error_formi');


		$('.jj_number').each(function (index, value) {

			var numty=$(this).val();
			if((numty==0)||(numty=='')||(!$.isNumeric(numty)))
			{
				$(this).addClass('error_formi');
				err=1;
			}

		});

		var xvg='';

		$('[yi_sopp_]').each(function(i,elem) {
			var numty=$(this).find('[count]').val();
			var price=$(this).find('[price]').val();
			if(xvg=='')
			{
				xvg=numty+':'+price;
			} else
			{
				xvg=xvg+'-'+numty+':'+price;
			}
		});



		if(($(".demo-4").val() ==0)&&($(".new_contractor_").val()==0))
		{
			$('.select-mania-theme-orange1').addClass('error_formi');
			//alert("!");
			err=1;
		}
		if($(".new_contractor_").val()==1)
		{
			if($("#name_contractor").val() == '')
			{
				$("#name_contractor").parents('.input_2018').addClass('required_in_2018');
				err=1;
			}
			if($("#address_contractor").val() == '')
			{
				$("#address_contractor").parents('.input_2018').addClass('required_in_2018');
				err=1;
			}
			if($("#inn_contractor").val() == '')
			{
				$("#inn_contractor").parents('.input_2018').addClass('required_in_2018');
				err=1;
			}
		}


		if($("#number_soply1").val() == '')
		{
			$("#number_soply1").parents('.input_2018').addClass('required_in_2018');
			err=1;
		}

		if($("#summa_soply1").val() == '')
		{
			$("#summa_soply1").parents('.input_2018').addClass('required_in_2018');
			err=1;
		}

		if($("#date_soply").val() == '')
		{
			$("#date_soply").parents('.input_2018').addClass('required_in_2018');
			err=1;
		}

		if((err==0))
		{




			//clearInterval(timerId);
			//$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			//изменить кнопку на загрузчик
			$('#yes_soply12').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			$('#no_rd').hide();
			//$('.box-soply').find('._50_x').hide();

			if(($(".new_contractor_").val()==0))
			{

				var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".demo-4").val()+'&xvg='+xvg+'&com='+$("#otziv_area_ada").val();
			} else
			{
				var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val()+'&xvg='+xvg+'&com='+$("#otziv_area_ada").val();
			}

			//AjaxClient('supply','add_soply','GET',data,'AfterAACC',$("#number_soply1").val(),0);
			AjaxClient('supply','rewrite_soply','GET',data,'AfterAACC1',for_id,0);
			//AjaxClient('supply','add_soply','GET',0,'AfterAACC',for_id,'lalala_form')

			//AjaxClient('supply','add_acc','GET',0,'AfterAACC',for_id,'lalala_form');

		}

	});

//сохранение нового счета
	$('#yes_soply11').on( "click", function() {


		// var err = [0,0,0,0,0,0,0];
		var err  = 0
		$('.box-soply').find('.required_in_2018').removeClass('required_in_2018');
		$('.select-mania-theme-orange1').removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');

		var iu=$('.content_block').attr('iu');
		//var tr=$(this).parents('.tr_dop_supply');

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

		$('.jj_number').removeClass('error_formi');


		$('.jj_number').each(function (index, value) {

			var numty=$(this).val();
			if((numty==0)||(numty=='')||(!$.isNumeric(numty)))
			{
				$(this).addClass('error_formi');
				err=1;
			}

		});

		var basket_score_ = $.cookie(ssup+iu);
		var cc = basket_score_.split('.');
		var xvg='';
		for ( var t = 0; t < cc.length; t++ )
		{
			var numty=$('[count='+cc[t]+']').val();
			var price=$('[price='+cc[t]+']').val();
			if(xvg=='')
			{
				xvg=numty+':'+price;
			} else
			{
				xvg=xvg+'-'+numty+':'+price;;
			}

		}



		if(($(".demo-4").val() ==0)&&($(".new_contractor_").val()==0))
		{
			$('.select-mania-theme-orange1').addClass('error_formi');
			//alert("!");
			err=1;
		}
		if($(".new_contractor_").val()==1)
		{
			if($("#name_contractor").val() == '')
			{
				$("#name_contractor").parents('.input_2018').addClass('required_in_2018');
				err=1;
			}
			if($("#address_contractor").val() == '')
			{
				$("#address_contractor").parents('.input_2018').addClass('required_in_2018');
				err=1;
			}
			if($("#inn_contractor").val() == '')
			{
				$("#inn_contractor").parents('.input_2018').addClass('required_in_2018');
				err=1;
			}
		}


		if($("#number_soply1").val() == '')
		{
			$("#number_soply1").parents('.input_2018').addClass('required_in_2018');
			err=1;
		}

		if($("#date_soply1").val() == '')
		{
			$("#date_soply1").parents('.input_2018').addClass('required_in_2018');
			err=1;
		}

		if($("#date_soply").val() == '')
		{
			$("#date_soply").parents('.input_2018').addClass('required_in_2018');
			err=1;
		}

		if((err==0))
		{




			//clearInterval(timerId);
			//$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			//изменить кнопку на загрузчик
			$('#yes_soply11').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			$('#no_rd').hide();
			//$('.box-soply').find('._50_x').hide();

			if(($(".new_contractor_").val()==0))
			{

				var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".demo-4").val()+'&xvg='+xvg+'&com='+$("#otziv_area_ada").val();
			} else
			{
				var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val()+'&xvg='+xvg+'&com='+$("#otziv_area_ada").val();
			}

			AjaxClient('supply','add_soply','GET',data,'AfterAACC',$("#number_soply1").val(),0);

			//AjaxClient('supply','add_soply','GET',0,'AfterAACC',for_id,'lalala_form')

			//AjaxClient('supply','add_acc','GET',0,'AfterAACC',for_id,'lalala_form');

		}

	});

//удаление накладной
	$('#yes_soply_dell_invoice').on( "click", function() {

		var for_id=$('.h111').attr('for');

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
		AjaxClient('invoices','dell_invoices','GET',data,'Afterdell_invoice',for_id,0);




	});



//удаление счета
	$('#yes_soply').on( "click", function() {

		var for_id=$('.h111').attr('for');

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
		AjaxClient('supply','dell_soply','GET',data,'Afterdell_soply',for_id,0);




	});


//оплата после даты
	$('.option_y2').on( "click", function() {
		//alert("!");
		//var ini=$('#wall_summ');
		if($(this).is('.active_bill'))
		{
			$(this).removeClass('active_bill');
			//$('.date_cha').removeClass('active_option');
			$('.date_cha').slideUp( "slow", function() { $('.date_cha').addClass('active_option'); } );


		} else
		{
			$(this).addClass('active_bill');
			$('.date_cha').slideDown( "slow", function() { $('.date_cha').addClass('active_option'); } );
			//$('.date_cha').addClass('active_option');
		}
	});


//частичная оплата
	$('.option_y1').on( "click", function() {
		//alert("!");
		var ini=$('#wall_summ');
		if($(this).is('.active_bill'))
		{
			$(this).removeClass('active_bill');
			//$('.cha_1').removeClass('active_option');
			$('.cha_1').slideUp( "slow", function() { $('.cha_1').addClass('active_option'); } );
			ini.val(ini.attr('max')).prop('readonly',true);


		} else
		{
			$(this).addClass('active_bill');
			//$('.cha_1').addClass('active_option');
			$('.cha_1').slideDown( "slow", function() { $('.cha_1').addClass('active_option'); } );

			var hop = ini.val();
			if(ini.attr('max')==hop)
			{
				ini.val('').removeAttr('readonly').focus();
			}

		}
	});


//удалить  наряда
	$('#yes_naryd_work114').on( "click", function() {
		var for_id=$('.h111').attr('for');

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('finery','dell_nariad','GET',data,'AfterDNA',for_id,0);

	});

//удалить  заявку на материалы
	$('#yes_naryd_work1140').on( "click", function() {
		var for_id=$('.h111').attr('for');

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('app','dell_app','GET',data,'AfterDNAA',for_id,0);

	});

//удалить работу из существующего наряда
	$('#yes_naryd_work11').on( "click", function() {
		var for_id=$('.h111').attr('for');
		var dom_id=$('.h111').attr('dom');

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&n='+dom_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('finery','dell_work_is_nariad','GET',data,'AfterDWN',for_id,0);

	});


//редактировать работу к разделу проверка заполнения всех данных
	$('#yes_wwa').on( "click", function() {
		var err = [0,0,0,0];

		$(".div_text_glo,#number_r,#count_work,#price_work").removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');


		if($("#number_r").val() == '')
		{
			$("#number_r").addClass('error_formi');
			err[0]=1;
		}
		if($("#otziv_area").val() == '')
		{
			$(".div_text_glo").addClass('error_formi');
			err[1]=1;
		}
		if(($("#count_work").val() == '')||($.isNumeric($("#count_work").val()) == false))
		{
			$("#count_work").addClass('error_formi');
			err[2]=1;
		}
		if(($("#price_work").val() == '')||($.isNumeric($("#price_work").val()) == false))
		{
			$("#price_work").addClass('error_formi');
			err[3]=1;
		}



		var count_mat=$('#count_material').val();
		var err_m = new Array();
		var er_b=0;
		for ( var t = 1; t <= count_mat; t++ )
		{
			if ( $( ".material__"+t ).length )
			{
				$(".div_text_glo_"+t+",#number_rm1_"+t+",#count_material_"+t+",#price_material_"+t+"").removeClass('error_formi');
				if($("#number_rm1_"+t).val() == '')
				{
					$("#number_rm1_"+t).addClass('error_formi');
					err_m.push(1);
				}
				if($("#otziv_area_"+t).val() == '')
				{
					$(".div_text_glo_"+t).addClass('error_formi');
					err_m.push(1);
				}
				if(($("#count_material_"+t).val() == '')||($.isNumeric($("#count_material_"+t).val()) == false))
				{
					$("#count_material_"+t).addClass('error_formi');
					err_m.push(1);
				}
				if(($("#price_material_"+t).val() == '')||($.isNumeric($("#price_material_"+t).val()) == false))
				{
					$("#price_material_"+t).addClass('error_formi');
					err_m.push(1);
				}
			}



		}
		$.each(err_m, function(index, value){
			if(value==1)
			{
				er_b=1;
				return false;
			}
		});



		if((err[0]==0)&&(err[1]==0)&&(err[2]==0)&&(err[3]==0)&&(er_b==0))
		{




			clearInterval(timerId);
			$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			//изменить кнопку на загрузчик
			$('#yes_wa').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');


			AjaxClient('prime','edit_work','GET',0,'AfterE_A',for_id,'lalala_form');

		}



	});

//редактировать настройки дома
	$('#yes_he').on( "click", function() {

		var err = [0,0];


		$(".name_obb").removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');


		if($(".tt_obb").val() == '')
		{
			$(".name_obb").addClass('error_formi');
			err[1]=1;
		}

		if((err[0]==0)&&(err[1]==0))
		{


			//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			//$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&name='+$('.tt_obb').val()+'&number='+$('#number_r').val()+'&text='+$('#otziv_area').val()+'&tk='+$('.h111').attr('mor');


			//изменить кнопку на загрузчик
			$('#yes_he').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');



			AjaxClient('prime','edit_object','GET',data,'AfterHE',for_id,0);
		}



	});


//редактировать график работ
	$('#yes_reff').on( "click", function() {

		var err = [0,0];


		//проверить что одна дата больше другой или равно
		$('#date_table_gr1').removeClass('error_formi');
		$('#date_table_gr2').removeClass('error_formi');

		if($('#date_hidden_table_gr1').val()>$('#date_hidden_table_gr2').val())
		{
			$('#date_table_gr2').addClass('error_formi');
			err[0]=1;
		}


		if((err[0]==0)&&(err[1]==0))
		{


			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&data1='+$('#date_table_gr1').val()+'&data2='+$('#date_table_gr2').val()+'&tk='+$('.h111').attr('mor');


			//изменить кнопку на загрузчик
			$('#yes_reff').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');



			AjaxClient('prime','edit_grafic','GET',data,'AfterGR',for_id,0);
		}



	});


//редактировать раздел в себестоимости
	/*
	$('#yes_re').on( "click", function() {

		var err = [0,0];


		$(".div_textarea_otziv").removeClass('error_formi');
		$("#number_r").removeClass('error_formi');


		if($("#number_r").val() == '')
		{
			$("#number_r").addClass('error_formi');
			err[0]=1;
		}
		if($(".text_area_otziv").val() == '')
		{
			$(".div_textarea_otziv").addClass('error_formi');
			err[1]=1;
		}

		if((err[0]==0)&&(err[1]==0))
		{


			//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			//$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&number='+$('#number_r').val()+'&text='+$('#otziv_area').val()+'&tk='+$('.h111').attr('mor');


			//изменить кнопку на загрузчик
			$('#yes_re').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');



			AjaxClient('prime','edit_razdel','GET',data,'AfterRE',for_id,0);
		}



	});
*/


//редактировать материал в работе в себестоимости
	$('#yes_me').on( "click", function() {


		var err = [0,0,0,0];

		$(".div_text_glo,#number_r,#count_work_mm,#price_work_mm").removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');


		if($("#number_r").val() == '')
		{
			$("#number_r").addClass('error_formi');
			err[0]=1;
		}
		if($("#otziv_area").val() == '')
		{
			$(".div_text_glo").addClass('error_formi');
			err[1]=1;
		}
		if(($("#count_work_mm").val() == '')||($.isNumeric($("#count_work_mm").val()) == false))
		{
			$("#count_work_mm").addClass('error_formi');
			err[2]=1;
		}
		if(($("#price_work_mm").val() == '')||($.isNumeric($("#price_work_mm").val()) == false))
		{
			$("#price_work_mm").addClass('error_formi');
			err[3]=1;
		}


		if((err[0]==0)&&(err[1]==0)&&(err[2]==0)&&(err[3]==0))
		{


			//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			//$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&price='+$('#price_work_mm').val()+'&ed='+$('#number_r').val()+'&count='+$('#count_work_mm').val()+'&text='+$('#otziv_area').val()+'&tk='+$('.h111').attr('mor');


			//изменить кнопку на загрузчик
			//$('#yes_ra').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			$.arcticmodal('close');


			AjaxClient('prime','edit_material','GET',data,'AfterEM',for_id,0);
		}
	});

//добавить материал к работе в себестоимости
	$('#yes_ma').on( "click", function() {


		var err = [0,0,0,0];

		$(".div_text_glo,#number_r,#count_work_mm,#price_work_mm").removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');


		if($("#number_r").val() == '')
		{
			$("#number_r").addClass('error_formi');
			err[0]=1;
		}
		if($("#otziv_area").val() == '')
		{
			$(".div_text_glo").addClass('error_formi');
			err[1]=1;
		}
		if(($("#count_work_mm").val() == '')||($.isNumeric($("#count_work_mm").val()) == false))
		{
			$("#count_work_mm").addClass('error_formi');
			err[2]=1;
		}
		if(($("#price_work_mm").val() == '')||($.isNumeric($("#price_work_mm").val()) == false))
		{
			$("#price_work_mm").addClass('error_formi');
			err[3]=1;
		}


		if((err[0]==0)&&(err[1]==0)&&(err[2]==0)&&(err[3]==0))
		{


			//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			//$.arcticmodal('close');
			var for_id=$('.h111').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&price='+$('#price_work_mm').val()+'&ed='+$('#number_r').val()+'&count='+$('#count_work_mm').val()+'&text='+$('#otziv_area').val()+'&tk='+$('.h111').attr('mor');


			//изменить кнопку на загрузчик
			//$('#yes_ra').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
			clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			$.arcticmodal('close');


			AjaxClient('prime','add_material','GET',data,'AfterAM',for_id,0);
		}
	});




//отправить сообщение
	$('#yes_send').on( "click", function() {
		var tt=$('#otziv_area').val();

		var err = [0];

		$(".otziv_mess").removeClass('error_formi');
		//$("#number_r").removeClass('error_formi');


		if($("#otziv_area").val() == '')
		{
			$(".otziv_mess").addClass('error_formi');
			err[0]=1;
		} else
		{

			var for_id=$('.mess_h2').attr('for');
			var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.mess_h2').attr('mor')+'&text='+$('#otziv_area').val();
			AjaxClient('message','send_message','GET',data,'AfterSendM',for_id,0);
			$.arcticmodal('close');
		}
	});
//редактировать исполнителя
	$('#yes_opt_imp').on( "click", function() {
		var for_id=$('.h111').attr('for');
		var data='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&name='+$('#otziv_area11').val()+'&fio='+$('#otziv_area').val()+'&fio1='+$('#otziv_area_p').val()+'&tel='+$('#otziv_area12').val();
		AjaxClient('implementer','edit_implementer','GET',data,'AfterUP_IMP',for_id,0);
	});


//добавить исполнителя
	$('#yes_opt_imp_add').on( "click", function() {
		var for_id=$('.h111').attr('for');
		var data='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&names='+$('#otziv_area_ppp').val()+'&name='+$('#otziv_area11').val()+'&fio='+$('#otziv_area').val()+'&fio1='+$('#otziv_area_p').val()+'&tel='+$('#otziv_area12').val();
		AjaxClient('implementer','add_implementer','GET',data,'AfterUP_IMP_ADD',for_id,0);
	});


//удалить оплату исполнителю
	$('#yes_dell_pay').on( "click", function() {
		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('cashbox','dell_pay','GET',data,'AfterDELL_PAY',for_id,0);
	});


//распровести оплату исполнителю
	$('#yes_dis_cash')	.on( "click", function() {
		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('cashbox','disband_cash','GET',data,'AfterDIS_C',for_id,0);
	});
//удалить материал в себестоимости
	$('#yes_mmd').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('prime','dell_material','GET',data,'AfterMMD',for_id,0);

	});


//провести безнал
	$('#yes_del_dia_bez').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('cashbox','add_beznal','GET',data,'AfterBEZ',for_id,0);

	});


//удалить диалог
	$('#yes_del_dia').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('message','dell_dialog','GET',data,'AfterDIA',for_id,0);

	});

//удалить работы в себестоимости
	$('#yes_wwd').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('prime','dell_work','GET',data,'AfterWWD',for_id,0);

	});

//выдать аванс
	$('#yes_pay_avans').on( "click", function() {

		clearInterval(timerId);
		$.arcticmodal('close');
		var for_id=$('.pay_uf').attr('for');
		var flag=0;
		if($('.j_cash').length)
		{
			flag=1;
			if($('#table_freez_cash').length)
			{
				flag=2;
			}
		}
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.pay_uf').attr('mor')+'&summ='+$('#number_rrss').val()+'&flag='+flag;



		AjaxClient('cashbox','add_cash_avans','GET',data,'AfterCAD',for_id,0);

	});

//выдать деньги исполнителю
	$('#yes_pay').on( "click", function() {

		clearInterval(timerId);
		$.arcticmodal('close');
		var for_id=$('.pay_uf').attr('for');
		var flag=0;
		if($('.j_cash').length)
		{
			flag=1;
			if($('#table_freez_cash').length)
			{
				flag=2;
			}
		}
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.pay_uf').attr('mor')+'&summ='+$('#number_rrss').val()+'&flag='+flag;



		AjaxClient('cashbox','add_cash','GET',data,'AfterCAD',for_id,0);

	});


//отменить статус к оплате
	$('#yes_bill_no11').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
		AjaxClient('bill','bill_dell_yes_buy','GET',data,'AfterWalletBill',for_id,0);
	});

//удалить наименование из склада
	$('#yes_dell_stock').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
		$('[idu_stock='+for_id+']').hide();
		AjaxClient('stock','dell_stock','GET',data,'AfterDellStock',for_id,0);
	});

//не оплачивать счет
	$('#yes_bill_no').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&comm='+$('.no_comment_bill').val();
		AjaxClient('bill','bill_no_buy','GET',data,'AfterNoBuyBill',for_id,0);
	});


//оплатить бухгалтерия
	$('#yes_booker_yes').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&date='+$('#date_hidden_table_gr1').val();
		AjaxClient('booker','booker_yes','GET',data,'AfterBookerYes',for_id,0);
	});

//удалить всю себестоимость
	$('#yes_sd').on( "click", function() {

		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		$.arcticmodal('close');
		var for_id=$('.h111').attr('for');
		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



		AjaxClient('prime','dell_prime','GET',data,'AfterSD',for_id,0);

	});

//кнопка отменить закрыть форму
	$('#no_rd').on( "click", function() {
		clearInterval(timerId);
		$.arcticmodal('close');
	});

	$('.select-mania-theme-orange').find('.select-mania-add-icon').on( "click", function() {
		//e.stopPropagation();
		$('.select-mania').hide();
		$('.add_sklad_pl').show();
		$('.new_sklad_name').val(1);
	});


	$('.select-mania-theme-orange1').find('.select-mania-add-icon').on( "click", function() {
		//e.stopPropagation();
		$('.contractor_add').show();
		$('.select-mania-theme-orange1').hide();
		$('.new_contractor_').val(1);

	});


	$('.select-mania-theme-orange2').find('.select-mania-add-icon').on( "click", function() {
		//e.stopPropagation();
		$('.add_sklad_pl1').show();
		$('.select-mania-theme-orange2').hide();
		$('.new_sklad_i').val(1);
	});



//нажатие в форме на кнопку добавить материал
	$('#ma_rd')	.on( "click", function() {

		if (!$('#Modal-one').is( "._form_2_" ) ) { $("#Modal-one").addClass('_form_2_'); $("#Modal-one").children(':first').children(':first').addClass('_left_ajax_form'); $('._right_ajax_form').show();
			$('#ma_rd').hide();
			var count__=$('#count_material').val();
			var dee=parseInt(count__)+1;
			$('#count_material').val(dee);
			//alert($('#count_material').val());

			var html = $( '.replace_mm' ).html ();
			html = html.replace ( /IDMID/g, dee);
			$('._right_ajax_form').empty().append(html);
			$('.i___').unbind( "click");
			$('.i___').bind( "click", material_plus);
			update_block_x(dee);

		}
	});


	//$('.del_basket_joo').bind("change keyup input click", del_basket_joo);
	$('body').on("change keyup input click",'.del_basket_joo',del_basket_joo);


	$('.del_basket_joo1').bind("change keyup input click", del_basket_joo1);

//делаем поля с классом только целыми числами
	//$('.count_mask_cel').bind("change keyup input click", validate_cel);
	$('body').on("change keyup input click",'.count_mask_cel',validate_cel);



//двойное нажатие на поле при выплате исполнителю
	$('.input_pay_imp').bind("dblclick", MydblclickPay);

//изменения поля выплаты исполнителям
	$('.input_pay_imp').bind("change keyup input click",EditPay);

	//делаем поля с классом только дробными и целыми числами
	$('.count_mask').bind("change keyup input click", validate);

//высчитываем итоговую сумму по работе
	$('#count_work,#price_work').bind("change keyup input click", itogprice);

//высчитываем итоговую сумму при редактирование материала
	$('#count_work_mm,#price_work_mm').bind("change keyup input click", itogprice_mm);

	//$('.price_xvg_,.count_xvg_').bind("change keyup input click", itogprice_xvg);

	//$('body').on("change keyup input click",'.price_xvg_,.count_xvg_',itogprice_xvg);


//вывод дополнительного меню для выбора единиц
	$('.icon_cal1').bind("click", icon_cal1);
//нажатие на выпавшее меню
	$('.dop_table span').bind( "click", dop_table_span);


//$('.dop_table_x').focus(function() { $(this).parent().next().hide();});


	$("body").click(function(e) {
		if($(e.target).closest(".icon_cal1").length==0) $(".dop_table").hide();
	});




	/*клик на раскрывающее меню исполнитель*/
	$(document).mouseup(function (e) {
		var container = $(".select_box");
		if (container.has(e.target).length === 0){
			//клик вне блока и включающих в него элементов
			//$(".drop_box").hide();
			$(".drop_box_form").css("transform", "scaleY(0)");
			$(".slct_box_form").removeClass("active");
		}
	});
	window.slctclick_box_form = function() {


		if($(this).is(".active"))
		{
			$(this).removeClass("active");
			//$(this).next().hide();
			$(this).next().css("transform", "scaleY(0)");
		} else
		{
			$(this).addClass("active");
			//$(this).next().show();
			$(this).next().css("transform", "scaleY(1)");
		}




		var elemss_box=$(this).attr('data_src');


		$('.slct_box_form').each(function(i,elem)
		{
			var att=$(this).attr('data_src');
			if ($(this).attr('data_src')!=elemss_box) {
				$(this).removeClass("active");
				$(this).next().css("transform", "scaleY(0)");
			}
		});
		return false;
	}
	$(".slct_box_form").bind('click', slctclick_box_form);


	window.dropli_box_form = function() {

		var active_old=$(this).parent().parent().find(".slct_box_form").attr("data_src");
		var active_new=$(this).find("a").attr("rel");

		var f=$(this).find("a").text();
		var e=$(this).find("a").attr("rel");

		if(active_old!=active_new)
		{
			$(this).parent().find("li").removeClass("sel_active");
			$(this).addClass("sel_active");



			// $(this).parent().parent().find(".slct").removeClass("active").html(f);
			$(this).parent().parent().find(".slct_box_form").removeClass("active").empty().append(f);
			$(this).parent().parent().find(".slct_box_form").attr("data_src",e);

			//$(this).parent().parent().find(".drop_box").hide();
			$(this).parent().parent().find(".drop_box_form").css("transform", "scaleY(0)");

			$(this).parent().parent().find("input").val(e).change();
		} else
		{
			//$(this).parent().parent().find(".drop_box").hide();
			$(this).parent().parent().find(".drop_box_form").css("transform", "scaleY(0)");
			$(this).parent().parent().find(".slct_box_form").removeClass("active");
		}


	}

	$(".drop_box_form").find("li").bind('click', dropli_box_form);


});

function autoReload(){
	var goal = self.location;
	location.href = goal;
}

//обновление статуса в счете
function AfterUpdateWalletStatus(data,update)
{

}



//постфункция удаления материала из счета при редактировании счета
function AfterDellSUPM(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if(data.status=='error')
	{
		$('[id_rel='+update+']').parents('[yi_sopp_]').show();
	}
	if(data.status=='ok')
	{


		//делаем изменения в списке снабжения
		var yi_sopp=$('[id_rel='+update+']').parents('[yi_sopp_]').attr('yi_sopp_');

		var forr=$('.h111').attr('for');

		$('[id_rel='+update+']').parents('[yi_sopp_]').remove();

		var count_yoi=$('[yi_sopp_]').length;
		$('[rel_score='+forr+']').find('i').empty().append(count_yoi);
		$('[supply_id='+yi_sopp+']').find('[rel_score='+forr+']').next().remove();
		$('[supply_id='+yi_sopp+']').find('[rel_score='+forr+']').remove();

		//делаем изменения если он был выбран текущим
		var iu=$('.content_block').attr('iu');
		var cookie_flag_current = $.cookie('current_supply_'+iu);
		if(cookie_flag_current!=null)
		{
			$('[supply_id='+yi_sopp+']').find('.st_div_supply').trigger('click');
		}

	}
}


function AfterOptionDemoS(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		$('#yes_material_invoice').next().remove();
		$('#yes_material_invoice').show();
		$('.search_bill').empty().append(data.echo).show();

		if(data.echo=='')
		{
			$('.no_bill_material').show();
		}

		$('.demo-6').selectMania({themes: ['orange3'], placeholder: '',removable: true,search: true});
	}
}


function AfterSVS(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='hide' )
	{
		clearInterval(timerId);
		$.arcticmodal('close');
	}
	if ( data.status=='no_name' )
	{
		$('.sk_error').empty().append('Заполните новое название материала на складе').show();

		$('#yes_update_sk_sk').show();
		$('.end_list_white').show();
		$('.loader_inter').remove();
	}
	if ( data.status=='name_yest' )
	{
		$('.sk_error').empty().append('Материал с таким названием уже есть на складе').show();

		$('#yes_update_sk_sk').show();
		$('.end_list_white').show();
		$('.loader_inter').remove();
	}
	if ( data.status=='ok' )
	{
		var id_s= $('[supply_id='+update+']').attr('supply_stock');




		if(data.select==0)
		{
			//связь изменилась на нет связи



			var iu=$('.content_block').attr('iu');
			var ssup='basket_supply_';
			CookieList(ssup+iu,update,'del');
			setTimeout ( function () { autoReload(); }, 100 );
		} else
		{
			if($('[supply_stock='+data.select+'_'+data.basket+']').length==0)
			{

				$('[supply_id='+update+']').remove();
				setTimeout ( function () { autoReload(); }, 100 );
			} else
			{
				$("[supply_stock="+data.select+"_"+data.basket+"]:last").after($('[supply_id='+update+']'));
				$('[supply_id='+update+']').attr('supply_stock', data.select+"_"+data.basket);
				$('[supply_id='+update+']').find('.st_div_supply').show();
			}
			//alert(id_s);
			//alert($('[supply_stock='+id_s+']').length);
			if($('[supply_stock='+id_s+']').length==1)
			{
				$('[rel_id='+id_s+']').remove();
			}



			clearInterval(timerId);
			$.arcticmodal('close');
		}

		UpdateStatusADA(data.select);
	}

}


//постфункция сохранить данные в счете номер и так далее
function AfterAACC1(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{

		var forr=$('.h111').attr('for');

		clearInterval(timerId);
		$.arcticmodal('close');


		$('[rel_score='+forr+']').find('span').empty().append('№'+data.number);
		$('[rel_score='+forr+']').find('label').empty().append(data.summa);

		var iu=$('.content_block').attr('iu');
		var cookie_flag_current = $.cookie('current_supply_'+iu);
		if((cookie_flag_current!=null)&&(cookie_flag_current==update))
		{

			$('.current_score').find('.number_score').empty().append('№'+data.number+' от '+data.dd);

		}
		//alert("!");

		var hf=$('[rel_score='+forr+']').parents('[supply_stock]').attr('supply_stock');
		var hf1=hf.split('_');
		//alert(hf1[0]);
		UpdateStatusADA(hf1[0]);

	}

	if(data.status=='error')
	{
		$('.hop_lalala').find(".loader_inter").remove();

		$('#no_rd').show();
		$('.box-soply').find('._50_x').show();
	}
}




//постфункция не оплачивать счет
function AfterNoBuyBill(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('.billl[rel_id='+update+']').remove();
		$('[supply_stock='+update+']').remove();
		$('.xvg_bill_score[rel_score='+update+']').remove();
	}
}


//постфункция изменения графика работы
function AfterGR(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('.UGRAFE[for="'+update+'"]').empty().append(data.echo);
		clearInterval(timerId);
		$.arcticmodal('close');
		//обновить события связанные с работой с блоком
		update_block();
	}

	if(data.status=='error')
	{
		$('#yes_reff').show();
		$('.loader_inter').remove();
	}
}


//постфункция добавление работы с материалами в  раздел в себестоимость
function AfterWA(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		if($('.block_i[rel="'+update+'"]').find('.smeta').length!=0)
		{
			//уже есть работы в этом разделе значит просто добавляем в конец
			$('.block_i[rel="'+update+'"]').find('tr:last').after(data.echo);

			jQuery.scrollTo('.n1n[rel_id="'+data.id+'"]', 1000, {offset:-200});
			//обновить события связанные с работой с блоком
			update_block();

		} else
		{
			//добавить таблицу полностью в блог
			$('.block_i[rel="'+update+'"]').find('.rls').empty().append(data.table+data.echo+'</tbody></table>');

			//запусть freez для таблицы
			OLD("#table_freez_"+$('#frezezz').val()).freezeHeader({'offset' : '59px'});

			jQuery.scrollTo('.n1n[rel_id="'+data.id+'"]', 1000, {offset:-200});



			//запусть freez для таблицы
			var count__=$('#frezezz').val();
			var dee=parseInt(count__)+1;
			$('#frezezz').val(dee);

			//обновить события связанные с работой с блоком
			update_block();

		}
		//обновление итоговых сумм
		update_itog_razdel(update);

		//открыть раздел автоматически
		if($('.block_i[rel="'+update+'"]').is(".active"))
		{

		} else
		{
			$('.block_i[rel="'+update+'"]').addClass("active");
			CookieList("l_"+update,$('.block_i[rel="'+update+'"]').attr('rel'),'add');
			$('.block_i[rel="'+update+'"]').find('.i__').empty().append("-");
		}


	}
}



//постфункция отправки сообщения
function AfterSendM(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{

	}
}



//постфункция удаление всей себестоимость
function AfterSD(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('.block_i').remove();
	}

}

//постфункция удаление материала в себестоимость
function AfterMMD(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{

		//запускаем обновление раздела итоговых сумм
		update_itog_razdel($('.material[rel_ma="'+update+'"]').parents('.block_i').attr('rel'));
		$('.material[rel_ma="'+update+'"]').remove();
	}

}


//постфункция удаление заявки на материал
function AfterDNAA(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('[rel_id='+update+']').remove();
	}
}

//постфункция удаление наряда
function AfterDNA(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('[rel_id='+update+']').remove();
	}
}

//постфункция выдать деньги исполнителю
function AfterCAD(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		var id= data.id;
		$.arcticmodal({
			type: 'ajax',
			url: 'forms/form_print_pay.php?id='+id,
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


		//значит мы просматриваем какого то исполнителя
		if($('.j_cash').length)
		{
			var tr_cash=$('[rel_cash]:first');
			if(tr_cash.length)
			{
				tr_cash.before(data.echo);
			} else
			{
				//создать новую таблицу
				$('.j_n_cash').before(data.echo1);
				$('.pay_imp').on("click",'.naryd_upload',UploadScan);
				$('.pay_imp').on("change",'.sc_sc_loo',UploadScanChange);
				$('.pay_imp').on("click",'.rasp_pay',DellCash);
				$('.pay_imp').on("click",'.del_pay',DellPay);

			}
			ToolTip();
		}	else
		{
			//обновление по кассе в таблице исполнителей
			updatepay(data.vid,update);
		}
	}
}

//постфункция удаления работы из наряда
function AfterDWN(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('[work='+update+']').remove();
		// BasketUpdate(data.dom);
		UpdateItog();
	}
}

//постфункция удаление работы вместе с себестоимостью
function AfterWWD(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//запускаем обновление раздела итоговых сумм
		//alert($('.n1n[rel_id="'+update+'"]').parents('.block_i').attr('rel'));
		update_itog_razdel($('.n1n[rel_id="'+update+'"]').parents('.block_i').attr('rel'));
		//alert($('.n1n[rel_id="'+update+'"]').nextAll("tr").length);

		$('.n1n[rel_id="'+update+'"]').nextAll("tr").each(function(index, value){

			if ( $(this).is( ".material" ) ) {
				$(this).remove();
			} else
			{
				return false; //намеренный выход из each
			}
		});

		$('.n1n[rel_id="'+update+'"]').prev().remove();
		$('.n1n[rel_id="'+update+'"]').remove();

	}

}

//постфункция удаления операции по оплате
function AfterDELL_PAY(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//
		var tr_cash=$('[rel_cash='+update+']');
		tr_cash.remove();
	}
}


//постфункция распроводки выдачи денег исполнителю
function AfterDIS_C(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//
		var tr_cash=$('[rel_cash='+update+']');
		tr_cash.removeClass('whites').find('[cl_pay='+update+']').empty().append(data.echo);
		tr_cash.find('[or_pay='+update+']').empty().append(data.echo1);

		$('.pay_summ2').remove();
		$('.pay_summ3').remove();
		$('.pay_summ4').remove();
		$('.j_cash').after(data.echo2);

		ToolTip();
	}
}


//постфункция редактирования исполнителя
function AfterUP_IMP(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		autoReload();
	}

}
//постфункция добавления исполнителя
function AfterUP_IMP_ADD(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		autoReload();
	}

}


//постфункция редактирование работы вместе с себестоимостью
function AfterE_A(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//запускаем обновление раздела итоговых сумм
		update_itog_razdel($('.n1n[rel_id="'+update+'"]').parents('.block_i').attr('rel'));


		$('.n1n[rel_id="'+update+'"]').nextAll("tr").each(function(index, value){

			if ( $(this).is( ".material" ) ) {
				$(this).remove();
			} else
			{
				return false; //намеренный выход из each
			}
		});



		$('.n1n[rel_id="'+update+'"]').empty().append(data.echo);
		$('.n1n[rel_id="'+update+'"]').after(data.table);
		//обновить события связанные с работой с блоком
		update_block();

	}

}

//постфункция редактироватие материала в себестоимость
function AfterEM(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//запускаем обновление раздела итоговых сумм
		update_itog_razdel($('.material[rel_ma="'+update+'"]').parents('.block_i').attr('rel'));

		$('.material[rel_ma="'+update+'"]').empty().append(data.echo);

		//обновить события связанные с работой с блоком
		update_block();
	}

}

//постфункция удвление диалога
function AfterDIA(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//добавляем материал в начало для этой работы
		$('[rel_diagol="'+update+'"]').remove();

	}

}

//постфункция проводки безналичной оплаты
function AfterBEZ(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{

		$('[id_bez='+update+']').remove();
		updatecash(update);
	}

}

//постфункция редактирование наименование на складе
function AfterAddStock1(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		clearInterval(timerId);
		$.arcticmodal('close');

		$('[idu_stock='+update+']:first').before(data.echo);
		$('[idu_stock='+update+']:last').remove();
		$('[idu_stock='+update+']:last').remove();

	}
	if(data.status=='name_yest')
	{
		$('.sk_error').empty().append('Наименование с таким названием уже есть на складе').show();
		$('#yes_add_stock').show();
		$('.loader_inter').remove();
		$('.no_add_sss').show();
	}
}

//постфункция добавление наименования на склад
function AfterAddStock(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		clearInterval(timerId);
		$.arcticmodal('close');

		$('[idu_stock]:first').before(data.echo);
		jQuery.scrollTo('.head_h', 1000);
	}
	if(data.status=='name_yest')
	{
		$('.sk_error').empty().append('Наименование с таким названием уже есть на складе').show();
		$('#yes_add_stock').show();
		$('.loader_inter').remove();
		$('.no_add_sss').show();
	}
}


//постфункция добавление материала в себестоимость
function AfterAM(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//запускаем обновление раздела итоговых сумм
		update_itog_razdel($('.n1n[rel_id="'+update+'"]').parents('.block_i').attr('rel'));


		//добавляем материал в начало для этой работы
		$('.n1n[rel_id="'+update+'"]').after(data.echo);




		//обновить события связанные с работой с блоком
		update_block();
	}

}



function AfterWalletBill(data,update)
{

	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		UpdateWalletStatus(update);
	}
	clearInterval(timerId);
	$.arcticmodal('close');
}


//постфункция бухгалтерия оплатить
function AfterBookerYes(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		clearInterval(timerId);
		$.arcticmodal('close');
		autoReload();
	}

}

//постфункция редактирование объекта
function AfterHE(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		clearInterval(timerId);
		$.arcticmodal('close');
		autoReload();
	}

}

//постфункция обновление итоговой суммы по разделу
function AfterUIR(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{

		$('.block_i[rel="'+update+'"]').find('.loader_inter').after(data.echo);

		$('.block_i[rel="'+update+'"]').find('.summ_blogi').empty().append(data.echo1);

		//$('.block_i[rel="'+update+'"]').append(data.echo);
		$('.block_i[rel="'+update+'"]').find('.loader_inter').remove();
	}
	if(data.status=='error')
	{
		$('.block_i[rel="'+update+'"]').find('.loader_inter').remove();
	}

	//обновление общей итоговых сумм по дому
	update_itog_seb();

}

//постфункция обновление итоговой суммы по смете
function AfterUIS(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{

		$('.content_block').find('.loader_inter').remove();
		$('.content_block').append(data.echo);

	}
	if ( data.status=='error' )
	{
		$('.content_block').find('.loader_inter').remove();
	}

	//обновление общей итоговых сумм по дому
	//update_itog_seb();

}


//постфункция добавление материала в накладную
function AfterOptionDemo(data,update)
{

	clearInterval(timerId);
	$.arcticmodal('close');

	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		var ss=$('[name=ss]').val();
		var value=parseInt(ss)+1;
		$('[name=ss]').val(value);




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





	}
}


//удаление наименование из склада
function AfterDellStock(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		$('[idu_stock='+update+']').remove();
	}
	if ( data.status=='error' )
	{
		$('[idu_stock='+update+']').show();
	}
}


//удаление наряда постфункци
function Afterdell_invoice(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		$('[rel_invoice_='+update+']').remove();
		//если этот счет был текущим

	}
	if ( data.status=='error' )
	{

	}
}


function AfterStock_Kvartal_(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		$('.stock_ob_x').empty().append(data.echo).show();
		$(".slct_box_form").unbind('click', slctclick_box_form);
		$(".slct_box_form").bind('click', slctclick_box_form);

		$(".drop_box_form").find("li").unbind('click', dropli_box_form);
		$(".drop_box_form").find("li").bind('click', dropli_box_form);


	}
	if ( data.status=='no' )
	{
		$('.stock_ob_x').empty().append('Объектов не найдено.').show();
	}
}


function AfterStock_Town_(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		$('.stock_kv_x').empty().append(data.echo).show();
		$(".slct_box_form").unbind('click', slctclick_box_form);
		$(".slct_box_form").bind('click', slctclick_box_form);

		$(".drop_box_form").find("li").unbind('click', dropli_box_form);
		$(".drop_box_form").find("li").bind('click', dropli_box_form);


	}
	if ( data.status=='no' )
	{
		$('.stock_kv_x').empty().append('Кварталы по данному городу не найдены.').show();
	}
}


//удаление счета в снабжении
function Afterdell_soply(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}
	if ( data.status=='ok' )
	{
		$('[rel_score='+update+']').remove();
		//если этот счет был текущим
		var iu=$('.content_block').attr('iu');

		var cookie_flag_current = $.cookie('current_supply_'+iu);
		if((cookie_flag_current!=null)&&(cookie_flag_current==update))
		{
			$.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
			$.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
			$.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

			$('.js-basket-supply-acc').find('.dop-21').empty();
			$('.js-basket-supply-acc').find('i').empty();
			$('.js-basket-supply-acc').hide();
			//$('.more_supply2').hide();

			$('.checher_supply').removeClass('checher_supply');
			$('.score_active').removeClass('score_active');
		}

	}
	if ( data.status=='error' )
	{

	}
}



//переменная которая говорит что forms уже загружен
window.yesform=1;


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
