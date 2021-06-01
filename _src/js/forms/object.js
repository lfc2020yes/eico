$(function (){

//добавление объекта с проверкой в форме
    //$('.box-modal').on("change keyup input click",'.js-add-object-but-x',add_object_yes);

    $('.box-modal').on("click",'.js-add-object-but-x',AddOfficeX);

//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-object-x',edit_object_yes);


//удалить объект с проверкой в форме
    $('.js-dell-object-b').on( "click", function() {

        var for_id=$('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');

        AjaxClient('object','dell','GET',data,'Afterdell_object',for_id,0);





        $('.js-dell-object-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


});

/*
 * постфункцию получение информации по нажатию на вкладку об объекте
 * @param data
 * @param update
 * @constructor
 */
function AfterTabsInfo(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        //alert("!");
        $('.client_window .px_bg').empty().append(data.query);

        $('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        $('.js-tabs_docc').hide();
        $('.js-tabs_'+update).show();
        ToolTip();
        NumberBlockFile();
        if(update==3)
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            $('#typesay').unbind('change', changesay);
            $('#typesay').bind('change', changesay);

        }
    }
}

/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */
function Afterdell_object(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Офис удален');



        var block_count=parseInt($('.js-count-office .smena_').text());
        block_count--;
        $('.js-count-office .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-office').after(data.blocks);

        var tytt=PadejNumber((block_count),'отдел,отдела,отделов');
        $('.js-count-office .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-office .help_div').slideDown("slow");
            $('.js-cloud-office .js-count-office').slideUp("slow");
        }



        $('.object_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.object_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_object(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Офис изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.object_block_pass[op_rel=' + data.update + ']').addClass('remove-object-x')
        $('.object_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.object_block_pass.remove-object-x').remove();


        setTimeout ( function () { $('.object_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        $('.js-edit-object-x').show();
        $('.js-form-edit-office').parents('.box-modal').find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['sum','sum1'];

            var err_name = ['некорректно заполнено - Название','некорректно заполнен - Адрес'];



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


/*
 * нажатие на кнопку добавить в форме добавление объекта
 */
function AddOfficeX()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-add-office .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-office-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните офис');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('office','add','POST',0,'after_add_object',0,'vino_xd_fiance_pay');


        $('.box-modal .js-add-object-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }


}


/*
 * изменение объекта нажатие на кнопку в форме
 */
function edit_object_yes()
{

    var err = 0;


    //проверка ссылки

    $('.js-form-pay-finance-edit .gloab').each(function (i, elem) {

        if (($(this).val() == '') || ($(this).val() == 0)) {
            $(this).parents('.input_2018').addClass('error_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            $(this).parents('.js-prs').addClass('error_textarea_2018');
            err++;
        } else {
            $(this).parents('.input_2018').removeClass('error_2018');
            $(this).parents('.list_2018').removeClass('required_in_2018');
            $(this).parents('.js-prs').removeClass('error_textarea_2018');

        }
    });


    if(err==0)
    {

        //изменить кнопку на загрузчик
        $('.js-edit-object-x').hide();

        $('.js-edit-object-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('object','edit','POST',0,'after_edit_object',0,'vino_xd_fiance_pay_edit');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */


/*
 * постфункция Добавление объекта
 */
function after_add_object(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Офис добавлен');



        var block_count=parseInt($('.js-count-office .smena_').text());
        block_count++;
        $('.js-count-office .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-office').after(data.blocks);

        var tytt=PadejNumber((block_count),'офис,офиса,офисов');
        $('.js-count-office .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.object_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-office .help_div').slideUp("slow");
        $('.js-cloud-office .js-count-office').slideDown("slow");

        clearInterval(timerId);
        $.arcticmodal('close');

    } else
    {

        $('.js-add-object-but-x').show();
        $('.js-form-add-office').parents('.box-modal').find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['name_office'];

            var err_name = ['некорректно заполнено - Название'];



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


/*
 * изменение объекта нажатие на кнопку в форме
 */
function edit_object_yes()
{

    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-edit-office .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-office-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните офис');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('object','edit','POST',0,'after_edit_object',0,'vino_xd_fiance_pay');


        $('.box-modal .js-edit-object-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}

