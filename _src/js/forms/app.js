


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
