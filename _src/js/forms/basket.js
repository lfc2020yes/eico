$(function () {



    $('body').on("change keyup input click",'.js-yes-basket-x',js_yes_basket_x);
});

//нажать на добавить в устройство в форме
function js_yes_basket_x()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-yes-basket .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-person-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.js-box-modal-two .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('basket','add_device','POST',0,'after_js_yes_basket_x',0,'vino_xd_fiance_pay_212');


        $('.js-box-modal-two .js-yes-basket-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}


function after_js_yes_basket_x(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Позиции добавлены к устройству');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();
        var iu=$('.content').attr('iu');
        var cookie_new = $.cookie('basket_item_'+iu);
        UpdateItems(cookie_new);
        erase_basket();

        //обновление по устройству но пока этого нет


        $( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();


    } else
    {
        $('.js-yes-basket-x').show();
        $('.js-yes-basket-x').parents('.box-modal').find('.button-50 .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['name_b'];

            var err_name = ['некорректно заполнено - устройство'];

            numbers=$.inArray(value, err);
            //alert(numbers);
            if(numbers!=-1)
            {
                /*
                var ins=number[numbers];
                $('.js-form-tender-new .js-in'+ins).parents('.input_2018').addClass('required_in_2018');
    $('.js-form-tender-new .js-in'+ins).parents('.input_2018').find('.div_new_2018').append('<div class="error-message">некорректно заполнено поле</div>');
    */
                alert_message('error',err_name[numbers]);
            } else
            {
                //$('.js-form-register .message-form').empty().append('Ошибка! ');
                alert_message('error','Ошибка!');
            }
            //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        });
    }
}





