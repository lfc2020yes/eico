$(function (){

//добавление объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-add-assess-but-x',add_assess_yes);
//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-assess-x',edit_assess_yes);


//удалить объект с проверкой в форме
    $('.js-dell-assess-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('assess','dell','GET',data,'Afterdell_assess',for_id,0);


        $('.js-dell-assess-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
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
function Afterdell_assess(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Задача удалена');



        var block_count=parseInt($('.js-count-assess .smena_').text());
        block_count--;
        $('.js-count-assess .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-assess').after(data.blocks);

        var tytt=PadejNumber((block_count),'задача по оценке,задачи по оценке,задач по оценке');
        $('.js-count-assess .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-assess .help_div').slideDown("slow");
            $('.js-cloud-assess .js-count-assess').slideUp("slow");
        }



        $('.assess_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.assess_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_assess(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Задача изменена');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.assess_block_pass[op_rel=' + data.update + ']').addClass('remove-assess-x')
        $('.assess_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.assess_block_pass.remove-assess-x').remove();


        setTimeout ( function () { $('.assess_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        $('.js-edit-assess-x').show();
        $('.js-form-pay-finance-edit .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['kto','kogo','set','kto_kogo','eshe'];

            var err_name = ['некорректно заполнено - Кто оценивает','некорректно заполнен - некорректно заполнено - Кого оценивает','некорректно заполнено - Подборка','Поля кто и кого одинаковые','Уже есть такая неисполненная задача'];



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
 * постфункция Добавление объекта
 */
function after_add_assess_yes(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Задача по оценки добавлена');



        var block_count=parseInt($('.js-count-assess .smena_').text());
        block_count++;
        $('.js-count-assess .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-assess').after(data.blocks);

        var tytt=PadejNumber((block_count),'задача по оценке,задачи по оценке,задач по оценке');
        $('.js-count-assess .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.assess_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-assess .help_div').slideUp("slow");
        $('.js-cloud-assess .js-count-assess').slideDown("slow");


        clearInterval(timerId);
        $.arcticmodal('close');


    } else
    {
        $('.js-add-assess-but-x').show();
        $('.js-form-pay-finance .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['kto','kogo','set','kto_kogo','eshe'];

            var err_name = ['некорректно заполнено - Кто оценивает','некорректно заполнен - некорректно заполнено - Кого оценивает','некорректно заполнено - Подборка','Поля кто и кого одинаковые','Уже есть такая неисполненная задача'];



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
function edit_assess_yes()
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
        $('.js-edit-assess-x').hide();

        $('.js-edit-assess-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('assess','edit','POST',0,'after_edit_assess',0,'vino_xd_fiance_pay_edit');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */
function add_assess_yes()
{

    var err = 0;

    $('.js-form-pay-finance .gloab').each(function (i, elem) {

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
        $('.js-add-assess-but-x').hide();

        $('.js-add-assess-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('assess','add','POST',0,'after_add_assess_yes',0,'vino_xd_fiance_pay');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

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






$(function (){

//добавление объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-add-business-but-x',add_business_yes);
//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-business-x',edit_business_yes);


//удалить объект с проверкой в форме
    $('.js-dell-business-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('business','dell','GET',data,'Afterdell_business',for_id,0);


        $('.js-dell-business-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


});



/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */
function Afterdell_business(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Объект удален');



        var block_count=parseInt($('.js-count-business .smena_').text());
        block_count--;
        $('.js-count-business .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-business').after(data.blocks);

        var tytt=PadejNumber((block_count),'объект,объекта,объектов');
        $('.js-count-business .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-business .help_div').slideDown("slow");
            $('.js-cloud-business .js-count-business').slideUp("slow");
        }



        $('.business_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.business_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_business(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Объект изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.business_block_pass[op_rel=' + data.update + ']').addClass('remove-object-x')
        $('.business_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.business_block_pass.remove-object-x').remove();



        setTimeout ( function () { $('.business_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        $('.js-edit-business-x').show();
        $('.js-form-pay-finance-edit .b_loading_small').remove();

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
 * постфункция Добавление объекта
 */
function after_add_business_yes(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Объект добавлен');



        var block_count=parseInt($('.js-count-business .smena_').text());
        block_count++;
        $('.js-count-business .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-business').after(data.blocks);

        var tytt=PadejNumber((block_count),'объект,объекта,объектов');
        $('.js-count-business .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.business_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-business .help_div').slideUp("slow");
        $('.js-cloud-business .js-count-business').slideDown("slow");


        clearInterval(timerId);
        $.arcticmodal('close');


    } else
    {
        $('.js-add-business-but-x').show();
        $('.js-form-pay-finance .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['sum','sum1'];

            var err_name = ['некорректно заполнено - Название','некорректно заполнен - адрес'];



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
function edit_business_yes()
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
        $('.js-edit-business-x').hide();

        $('.js-edit-business-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('business','edit','POST',0,'after_edit_business',0,'vino_xd_fiance_pay_edit');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */
function add_business_yes()
{

    var err = 0;

    $('.js-form-pay-finance .gloab').each(function (i, elem) {

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
        $('.js-add-business-but-x').hide();

        $('.js-add-business-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('business','add','POST',0,'after_add_business_yes',0,'vino_xd_fiance_pay');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

$(function (){
//alert("!");
//добавление объекта с проверкой в форме
    //$('.box-modal').on("change keyup input click",'.js-add-devices-but-x',add_devices_yes);


    //получение списка отделов по определенному офису
    $('.box-modal').on("change",'.js-office-x',SelectOffice);
//редактирование объекта с проверкой в форме


//печать нажатие в форме далее

    $('.box-modal').on("change keyup input click",'.js-dell-person-devices-b',js_dell_person_devices_b);
//удалить объект с проверкой в форме


});


function js_dell_person_devices_b()
{

    var for_id=$('.gloab-cc').attr('for');


    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');

    AjaxClient('devices','dell_person','GET',data,'Afterdell_person_devices',for_id,0);





    $('.js-dell-person-devices-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
}


function js_dell_devices_b()
{
    var for_id=$('.gloab-cc').attr('for');

    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');

    AjaxClient('devices','dell','GET',data,'Afterdell_devices',for_id,0);

    $('.js-dell-devices-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
}


/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */


function js_print_akt_devices_x() {
    var box_active = $(this).closest('.box-modal');
    if(box_active.find('.active_task_cb').length!=0) {


        $('.js-form-print-akt-device').submit();
        //полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');
    } else
    {
        alert_message('error','Отметьте хотя бы 1 позицию');
    }
};


function Afterdell_devices(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Устройство удалено');



        var block_count=parseInt($('.js-count-devices .smena_').text());
        block_count--;
        $('.js-count-devices .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-devices').after(data.blocks);

        var tytt=PadejNumber((block_count),'Устройство,Устройства,Устройств');
        $('.js-count-devices .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-devices .help_div').slideDown("slow");
            $('.js-cloud-devices .js-count-devices').slideUp("slow");
        }



        $('.devices_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.devices_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}


/*
 * постфункцию получение информации по нажатию на вкладку об объекте
 * @param data
 * @param update
 * @constructor
 */
function AfterTabsInfodevices(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        //alert("!");
        $('.js-cloud-info-text').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        $('.js-tabs_docc').hide();
        $('.js-tabs_'+update).show();
        ToolTip();
        //NumberBlockFile();
        if((update==2)||(update==4))
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            $('#typesay').unbind('change', changesay);
            $('#typesay').bind('change', changesay);
            NumberBlockFile();

        }
    }
}


function Afterdell_person_devices(data,update)
{
    if (data.status=='ok') {
        alert_message('ok','Ответственный удален');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.js-devices-block[op_rel=' + data.update + ']').addClass('remove-devices-x')
        $('.js-devices-block[op_rel=' + data.update + ']').after(data.blocks);
        $('.js-devices-block.remove-devices-x').remove();


        setTimeout ( function () { $('.js-devices-block').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');
    }
}

function after_add_person_devices(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Ответственный добавлен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.js-devices-block[op_rel=' + data.update + ']').addClass('remove-devices-x')
        $('.js-devices-block[op_rel=' + data.update + ']').after(data.blocks);
        $('.js-devices-block.remove-devices-x').remove();


        setTimeout ( function () { $('.js-devices-block').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        var box = $('.box-modal:last');

        //box.find('.arcticmodal-close').click();


        box.find('.js-add-person-devices-x').show();


        box.find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');
        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();


        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['kto','no_person'];

            var err_name = ['некорректно заполнен - Ответственный','нет прав для добавления данного ответственного'];



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
 * постфункция изменение объекта
 */
function after_edit_devices(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Устройство изменено');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.js-devices-block[op_rel=' + data.update + ']').addClass('remove-devices-x')
        $('.js-devices-block[op_rel=' + data.update + ']').after(data.blocks);
        $('.js-devices-block.remove-devices-x').remove();


        setTimeout ( function () { $('.js-devices-block').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        var box = $('.box-modal:last');

        //box.find('.arcticmodal-close').click();


        box.find('.js-edit-devices-x').show();


        box.find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');
        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();


        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['inv','name_devices','inv_busy'];

            var err_name = ['некорректно заполнено - Инвентарный номер','некорректно заполнен - Название','Инвентарный номер занят'];



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

                if(numbers==2)
                {
                    alert_message('error','Следующий свободный инвертарный номер - '+data.nd);
                }
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
function AdddevicesX()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
   // alert("!!");
    $('.js-form-add-devices .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-devices-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('devices','add','POST',0,'after_add_devices',0,'vino_xd_fiance_pay');


        $('.box-modal .js-add-devices-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }


}

function SelectOffice()
{
    $('.js-load-select-section').empty().append('<div class="b_loading_small" style="position:relative; width: 40px;padding-bottom: 15px; margin-top:-15px; top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


    var data ='url='+window.location.href+'&id='+$(this).val();

    AjaxClient('devices','select_office','GET',data,'AfterSelectOffice',$(this).val(),0,1);




}


/*
 * изменение объекта нажатие на кнопку в форме
 */

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */


/*назначить ответственного*/
function add_person_devices_yes()
{

    var box_active = $(this).closest('.box-modal');

    var err = 0;

//alert($('.js-form-register .gloab').length);

    box_active.find('.js-form-add-person-items .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-devices-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=box_active.find('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('devices','add_person','POST',0,'after_add_person_devices',0,'vino_xd_fiance_pay_2');


        box_active.find('.js-add-person-devices-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



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
function edit_devices_yes()
{

    var box_active = $(this).closest('.box-modal');

    var err = 0;
//alert($('.js-form-register .gloab').length);
    box_active.find('.js-form-edit-devices .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-devices-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=box_active.find('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('devices','edit','POST',0,'after_edit_devices',0,'vino_xd_fiance_pay');


        box_active.find('.js-edit-devices-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}

function AfterSelectOffice(data,update)
{
    if (data.status == 'ok') {
        $('.js-load-select-section').empty().append(data.echo);

        Zindex();
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);

    } else
    {
        alert_message('error', 'Ошибка поиска устройств');
        $('.js-load-select-section').empty();
    }
}


//var FormsFlag = true;

//функция определения загружен ли скрипт forms.js
//она пустая но с помощью ее можно узнать определена она или нет в окнах
function forms_js_load()
{

}


function blank_no_cb(e)
{
	e.stopPropagation();
}



//Закрыть второе,третье.. окно которое открыто поверх какого-то
function js_exit_form_sel1()
{

	//$(this).closest('.box-modal');
	$( '.arcticmodal-close', $( this ).closest( '.box-modal' )).click();

}




/**
 * нажать на кнопку изменить в форме изменения сроков в туре
 */
function edit_srok_tt()
{

	var err = 0;

	//проверка ссылки
	$('.js-form-srok-trips .gloab').each(function(i,elem) {

		if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018'); $(this).parents('.list_2018').addClass('required_in_2018');
			$(this).parents('.js-prs').addClass('error_textarea_2018');
			err++; } else {$(this).parents('.input_2018').removeClass('error_2018'); $(this).parents('.list_2018').removeClass('required_in_2018');
			$(this).parents('.js-prs').removeClass('error_textarea_2018');

		}

		if(($(this).is('.js-proc-form-x'))&&($(this).val() > 100)) {$(this).parents('.input_2018').addClass('error_2018'); $(this).parents('.list_2018').addClass('required_in_2018');
			$(this).parents('.js-prs').addClass('error_textarea_2018');
			err++;}


	});

	if(err==0)
	{

		//изменить кнопку на загрузчик
		$('.js-edit-srok-trips-but-x').hide();

		$('.js-edit-srok-trips-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin:auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		AjaxClient('tours','edit_srok_trips','POST',0,'after_add_srok_trips_yes',0,'vino_xd_trips_srok_edit');


	}else
	{
		var text_bb22 = $('.js-add-buy-trips-but-x').text();
		$('.js-add-buy-trips-but-x').empty().append('Ошибка заполнения!');
		$('.js-add-buy-trips-but-x').addClass('new-say1');
		setTimeout ( function () { $('.js-add-buy-trips-but-x').removeClass('new-say1'); $('.js-add-buy-trips-but-x').empty().append(text_bb22);  }, 4000 );

	}
}


function js_but_srok()
{
	var temp=$('.js-temp-kk');
	var temp_html=temp.html();

	temp.before('<div class="flexx sroki-tabl">'+temp_html+'</div>');

	next_group=$('.js-temp-kk').prev();
	next_group.find('.active_in_2018').removeClass('active_in_2018');
	next_group.find('.required_in_2018').removeClass('required_in_2018');
	next_group.find('.error_2018').removeClass('error_2018');

	next_group.removeClass('yes-buy-y');
	next_group.find('input').val('');
	next_group.find('textarea').val('');
	next_group.find('input').removeAttr('readonly');

	$('.date_picker_xe').inputmask("datetime",{
		mask: "1.2.y",
		placeholder: "dd.mm.yyyy",
		separator: ".",
		alias: "dd.mm.yyyy"
	});

}


function js_vibor_date1(e)
{
	
	//2019-10-12
	var date_v=$(this).attr('tabi');
	$('#date_hidden_table_gr3301').val(date_v);
	
	var dateParts = date_v.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]); 

$('#date_table_gr221').datepicker({ dateFormat: 'yy-mm-dd' });		
$('#date_table_gr221').datepicker('setDate', realDate);	 	 
//$('#date_table_gr22').val(date_v);
input_2018();
	
$('#date_table_gr221').parents('.input_2018').removeClass('error_2018');
	
e.stopPropagation();
}

function js_vibor_date(e)
{
	//2019-10-12
	var date_v=$(this).attr('tabi');
	$('#date_hidden_table_gr3300').val(date_v);
	
	var dateParts = date_v.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]); 

$('#date_table_gr22').datepicker({ dateFormat: 'yy-mm-dd' });		
$('#date_table_gr22').datepicker('setDate', realDate);	 	 
//$('#date_table_gr22').val(date_v);
input_2018();
	
$('#date_table_gr22').parents('.input_2018').removeClass('error_2018');
	
e.stopPropagation();
}

function edit_comm_task(event)
{
	var form_move=$('.form'+event.data.key);
	
	var id= $(this).parents('.comm-task-block').attr('rel_notib');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_comm_task.php?id='+id,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	e.stopPropagation();	
}

function edit_say()
{
	
	var id= $(this).parents('.say_say_cb ').attr('rel_notib');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_say.php?id='+id,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	e.stopPropagation();
	
}




function edit_selection()
{
	
	var id= $(this).parents('.js-selection_cb ').attr('rel_notib');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_selection.php?id='+id,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	e.stopPropagation();
	
}



function del_selection()
{
	var del_id=$(this).parents('.js-selection_cb ').attr('rel_notib');
	var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for')+'&sel='+del_id;
	
	$('.js-selection_cb[rel_notib='+del_id+']').slideUp("slow");
	
	AjaxClient('clients','dell_sel','GET',data,'AfterDellSel',del_id,0);	
	
	
	
}



function del_comm_task(event)
{
	var form_move=$('.form'+event.data.key);
	
	var del_id=$(this).parents('.comm-task-block').attr('rel_notib');
	
	var data ='url='+window.location.href+'&tk='+form_move.find('.h111').attr('mor')+
					'&id='+form_move.find('.h111').attr('for')+'&sel='+del_id;
	
	$('.comm-task-block[rel_notib='+del_id+']').slideUp("slow");
	
	AjaxClient('task','dell_comm','GET',data,'AfterDellCommTask',del_id+','+event.data.key,0);	
	
	
	
}


function del_say()
{
	var del_id=$(this).parents('.say_say_cb').attr('rel_notib');
	var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for')+'&sel='+del_id;
	
	$('.say_say_cb[rel_notib='+del_id+']').slideUp("slow");
	
	AjaxClient('clients','dell_say','GET',data,'AfterDellSay',del_id,0);	
	
	
	
}

function js_exit_window_add_task()
{
	$( '.arcticmodal-close', $( this ).closest( '.box-modal' )).click();
}

function js_exit_form_sel1()
{

	//$(this).closest('.box-modal');
	$( '.arcticmodal-close', $( this ).closest( '.box-modal' )).click();
	
}

function js_exit_form_sel()
{
	$('.js-ssel').slideUp( "slow" );
	$('.js-add_sel_cbb').slideDown( "slow" );
}

function js_exit_form_say()
{
	
	$('.js-ssay').slideUp( "slow" );
	$('.js-add_say_cbb').slideDown( "slow" );
}

function js_exit_form_comm_task(event)
{
	var form_move=$('.form'+event.data.key);
	form_move.find('.js-ssay').slideUp( "slow" );
	form_move.find('.js-add-comment-task').slideDown( "slow" );
}

function js_exit_form_say_task()
{
	$('.js-ssay').slideUp( "slow" );
	$('.js-add_say_cbb').slideDown( "slow" );
	
	$('.js-add-say-task-yes').find('input').val(0);
	$('.js-add-say-task-yes').find('.choice-radio i').removeClass('active_task_cb');
}


function task_cb_head()
{
	var cb_h=$(this).find('input').val();
	if(cb_h==0)
		{
			  $(this).find('input').val(1);
			  $(this).find('.task_cb_radio i').addClass('active_task_cb');	
			  $(this).parents('.js-add-form-plus-task').find('.form-task-02').slideDown( "slow" );
		} else
			{
			  $(this).find('input').val(0);
			  $(this).find('.task_cb_radio i').removeClass('active_task_cb');	
			  $(this).parents('.js-add-form-plus-task').find('.form-task-02').slideUp( "slow" );
			}
}


function option_task_user()
{
	var cb_h=$(this).find('input').val();
	if(cb_h==0)
		{
			  $(this).find('input').val(1);
			  $(this).find('.choice-radio i').addClass('active_task_cb');
			
$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_choice_client.php?tabs=1&tabss=all&several=0&posta=choice_user_task&new=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');						
    },
    afterOpen: function(data, el) {
		$('.loader_ada_forms').hide();
		$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }
  });	
			
		} else
			{
			  $(this).find('input').val(0);
			  $(this).find('.choice-radio i').removeClass('active_task_cb');
				
	
	
	$('.js-id-client-task').val('');
	$('.js-client-type-task').val('');
	$('.js-sv-user-task span').empty();
	$('.js-sv-user-task').hide();			
			
				
			}
}


function potential_users()
{

	var cb_h=$(this).parents('.password_turs').find('input');
	if(cb_h.val()!=$(this).attr('id'))
	{
		cb_h.val($(this).attr('id'));

		$(this).parents('.password_turs').find('.choice-radio i').removeClass('active_task_cb');
		$(this).parents('.password_turs').find('.input-choice-click-pass').removeClass('active_pass');

		$(this).find('.choice-radio i').addClass('active_task_cb');
		$(this).addClass('active_pass');
	} else
	{
		$(this).parents('.password_turs').find('.choice-radio i').removeClass('active_task_cb');
		$(this).parents('.password_turs').find('.input-choice-click-pass').removeClass('active_pass');
		cb_h.val(0);
	}



	var cb_h=$(this).parents('.password_turs').find('input').val();
	//var cb_h=$(this).find('input').val();
	//alert(cb_h);
	if(cb_h==1)
		{
			 // $(this).find('input').val(1);
			 //$(this).find('.choice-radio i').addClass('active_task_cb');

			  $('.js-turist-hide').slideDown( "slow" );
			  $('.js-potential-hide').slideUp( "slow" );
		}

	if(cb_h==2)
	{
		// $(this).find('input').val(1);
		//$(this).find('.choice-radio i').addClass('active_task_cb');

		$('.js-potential-hide').slideDown( "slow" );
		$('.js-turist-hide').slideUp( "slow" );
	}

	if(cb_h==0)
			{
			  //$(this).find('input').val(0);
			 // $(this).find('.choice-radio i').removeClass('active_task_cb');
			  $('.js-turist-hide').slideDown( "slow" );
			  $('.js-potential-hide').slideDown( "slow" );
			}
}


function task_cb_head1()
{
	var cb_h=$(this).find('input').val();
	if(cb_h==0)
		{
			  $(this).find('input').val(1);
			  $(this).find('.task_cb_radio i').addClass('active_task_cb');	
			  $(this).parents('.js-add-form-plus-task').find('.form-task-02_form2').slideDown( "slow" );
		} else
			{
			  $(this).find('input').val(0);
			  $(this).find('.task_cb_radio i').removeClass('active_task_cb');	
			  $(this).parents('.js-add-form-plus-task').find('.form-task-02_form2').slideUp( "slow" );
			}
}

//нажатие на кнопку изменить цену по туру в форме изменения цен - проверка формы
function edit_price_trips_yes()
{

	var err = 0;

	//проверка ссылки
	$('.js-form-price-trips .gloab').each(function(i,elem) {

		if(($(this).val() == '')||($(this).val() == 0)||($(this).val() == 0.00))  { $(this).parents('.input_2018').addClass('error_2018'); $(this).parents('.list_2018').addClass('required_in_2018');
			$(this).parents('.js-prs').addClass('error_textarea_2018');
			err++; } else {$(this).parents('.input_2018').removeClass('error_2018'); $(this).parents('.list_2018').removeClass('required_in_2018');
			$(this).parents('.js-prs').removeClass('error_textarea_2018');

		}
	});

	//если указали стоимость оператора то обязательно должен быть курс
	var oper_v=$('.js-form-price-trips .js-upload-kurs1-p');
	if((oper_v.val() != '')&&(oper_v.val() != 0)&&(oper_v.val() != 0.00)&&($('.js-form-price-trips .js-upload-kurs2-p').length > 0))
	{
		var curs_v=$('.js-form-price-trips .js-upload-kurs2-p');

		if((curs_v.val() == '')||(curs_v.val() == 0)||(curs_v.val() == 0.00))  { curs_v.parents('.input_2018').addClass('error_2018'); curs_v.parents('.list_2018').addClass('required_in_2018');
			curs_v.parents('.js-prs').addClass('error_textarea_2018');
			err++; } else {curs_v.parents('.input_2018').removeClass('error_2018'); curs_v.parents('.list_2018').removeClass('required_in_2018');
			curs_v.parents('.js-prs').removeClass('error_textarea_2018');

		}


	}


	if(err==0)
	{

		//изменить кнопку на загрузчик
		$('.js-edit-price-trips-but-x').hide();

		$('.js-edit-price-trips-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		AjaxClient('tours','edit_price_trips','POST',0,'after_edit_price_trips_yes',0,'vino_xd_trips_price_edit');


	}else
	{
		var text_bb22 = $('.js-add-price-trips-but-x').text();
		$('.js-add-price-trips-but-x').empty().append('Ошибка заполнения!');
		$('.js-add-price-trips-but-x').addClass('new-say1');
		setTimeout ( function () { $('.js-add-price-trips-but-x').removeClass('new-say1'); $('.js-add-price-trips-but-x').empty().append(text_bb22);  }, 4000 );

	}
}

//нажатие на кнопку изменить планы в форме редактирования - финансы
function edit_price_plane_yes()
{

	var err = 0;

	//проверка ссылки
	$('.js-form-price-plane .gloab').each(function(i,elem) {

		if(($(this).val() == '')||($(this).val() == 0)||($(this).val() == 0.00))  { $(this).parents('.input_2018').addClass('error_2018'); $(this).parents('.list_2018').addClass('required_in_2018');
			$(this).parents('.js-prs').addClass('error_textarea_2018');
			err++; } else {$(this).parents('.input_2018').removeClass('error_2018'); $(this).parents('.list_2018').removeClass('required_in_2018');
			$(this).parents('.js-prs').removeClass('error_textarea_2018');

		}
	});



	if(err==0)
	{

		//изменить кнопку на загрузчик
		$('.js-edit-price-plane-but-x').hide();

		$('.js-edit-price-plane-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		AjaxClient('finance','edit_plane','POST',0,'after_edit_price_plane_yes',0,'vino_xd_plane_price_edit');


	}else
	{
		var text_bb22 = $('.js-add-price-trips-but-x').text();
		$('.js-add-price-trips-but-x').empty().append('Ошибка заполнения!');
		$('.js-add-price-trips-but-x').addClass('new-say1');
		setTimeout ( function () { $('.js-add-price-trips-but-x').removeClass('new-say1'); $('.js-add-price-trips-but-x').empty().append(text_bb22);  }, 4000 );

	}
}

//нажатие на кнопку изменить оплату по туру в форме оплата тура - проверка формы
function edit_buy_trips_yes()
{

	var err = 0;

	//проверка ссылки
	$('.js-form-pay-trips .gloab').each(function(i,elem) {

		if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018'); $(this).parents('.list_2018').addClass('required_in_2018');
			$(this).parents('.js-prs').addClass('error_textarea_2018');
			err++; } else {$(this).parents('.input_2018').removeClass('error_2018'); $(this).parents('.list_2018').removeClass('required_in_2018');
			$(this).parents('.js-prs').removeClass('error_textarea_2018');

		}
	});

	if(err==0)
	{

		//изменить кнопку на загрузчик
		$('.js-edit-buy-trips-but-x').hide();

		$('.js-edit-buy-trips-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		AjaxClient('tours','edit_pay_trips','POST',0,'after_edit_buy_trips_yes',0,'vino_xd_trips_pay_edit');


	}else
	{
		var text_bb22 = $('.js-add-buy-trips-but-x').text();
		$('.js-add-buy-trips-but-x').empty().append('Ошибка заполнения!');
		$('.js-add-buy-trips-but-x').addClass('new-say1');
		setTimeout ( function () { $('.js-add-buy-trips-but-x').removeClass('new-say1'); $('.js-add-buy-trips-but-x').empty().append(text_bb22);  }, 4000 );

	}
}



//нажатие на кнопку добавить оплату по туру в форме оплата тура - проверка формы
function add_buy_trips_yes()
{

	var err = 0;

	//проверка ссылки
	$('.js-form-pay-trips .gloab').each(function(i,elem) {

		if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018'); $(this).parents('.list_2018').addClass('required_in_2018');
			$(this).parents('.js-prs').addClass('error_textarea_2018');
			err++; } else {$(this).parents('.input_2018').removeClass('error_2018'); $(this).parents('.list_2018').removeClass('required_in_2018');
			$(this).parents('.js-prs').removeClass('error_textarea_2018');

		}
	});

	if(err==0)
	{

		//изменить кнопку на загрузчик
		$('.js-add-buy-trips-but-x').hide();

		$('.js-add-buy-trips-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		AjaxClient('tours','add_pay_trips','POST',0,'after_add_buy_trips_yes',0,'vino_xd_trips_pay');


	}else
	{
		var text_bb22 = $('.js-add-buy-trips-but-x').text();
		$('.js-add-buy-trips-but-x').empty().append('Ошибка заполнения!');
		$('.js-add-buy-trips-but-x').addClass('new-say1');
		setTimeout ( function () { $('.js-add-buy-trips-but-x').removeClass('new-say1'); $('.js-add-buy-trips-but-x').empty().append(text_bb22);  }, 4000 );

	}
}


//нажатие на кнопку добавить задачу проверка формы
function add_task_yes()
{

	var err = 0;
	
	//проверка ссылки
	$('.js-form-task .gloab').each(function(i,elem) {

	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});

	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
/*	
var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+'&id='+$('.h111').attr('for')+'&link='+ec($('[name=link_selection]').val())+'&comment='+ec($('#otziv_area_adaxx299').val())+'&date='+$('[name=date_sele_task]').val()+'&time='+$('[name=task_time]').val()+'&task='+$('[name=radio_task_select]').val();
*/
	//изменить кнопку на загрузчик
	$('.js-exit-window-add-task').hide();
		
	$('.js-add-task-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
	AjaxClient('task','add_task','POST',0,'after_add_task_yes',0,'vino_xd_task');		


	}else
			{
				var text_bb22 = $('.js-add-task-but-x').text();
				$('.js-add-task-but-x').empty().append('Ошибка заполнения!');
				$('.js-add-task-but-x').addClass('new-say1');
				setTimeout ( function () { $('.js-add-task-but-x').removeClass('new-say1'); $('.js-add-task-but-x').empty().append(text_bb22);  }, 4000 );
				
			}
}

//добавление общения в клиенте
function add_sel_yes()
{
//event.data.key
	
	
	var err = 0;
	
	//проверка ссылки
	$('.js-form-gll .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}
	});	
	
	//проверка задачи если есть активность
	if($('[name=radio_task_select]').val()==1)
		{
			
	$('.form-task-02 .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});
			
		} else
		{
	$('.form-task-02 .gloab').each(function(i,elem) {
	$(this).parents('.input_2018').removeClass('error_2018');
	$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																			
});			
		}
	//проверка задачи если есть активность
	
	
	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
	
var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+'&id='+$('.h111').attr('for')+'&link='+ec($('[name=link_selection]').val())+'&comment='+ec($('#otziv_area_adaxx299').val())+'&date='+$('[name=date_sele_task]').val()+'&time='+$('[name=task_time]').val()+'&task='+$('[name=radio_task_select]').val();

	//изменить кнопку на загрузчик
	$('.js-add-sel').hide();
		
	$('.js-exit-form-sel').hide();
	$('.js-add-task-butt').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
		

AjaxClient('clients','add_sel','GET',data,'AfterAddSel',1,0);	
	}else
			{
				var text_bb22 = $('.js-add-sel').text();
				$('.js-add-sel').empty().append('Ошибка заполнения!');
				$('.js-add-sel').addClass('new-say1');
				setTimeout ( function () { $('.js-add-sel').removeClass('new-say1'); $('.js-add-sel').empty().append(text_bb22);  }, 4000 );
				
			}
}


function edit_comm_task_yes(event)
{
var form_move=$('.form'+event.data.key);
	var err = 0;
	
	//проверка сообщения
	form_move.find('.div_textarea_say').removeClass('error_textarea_2018');

	    if(form_move.find('.js-comment-add-'+event.data.key).val() == '')
	{
		form_move.find(".div_textarea_say").addClass('error_textarea_2018');
		err=1;		
	}
	
	
	
	
	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
	
var data ='url='+window.location.href+'&tk='+form_move.find('.h111').attr('mor')+'&id='+form_move.find('.h111').attr('for')+'&text='+ec(form_move.find('.js-comment-add-'+event.data.key).val());

	//изменить кнопку на загрузчик
	$('.js-edit-comm-task-yes').hide();
		
	$('.js-exit-form-edit-comm-task').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
		

AjaxClient('task','edit_comm','GET',data,'AfterEditCommTask',form_move.find('.h111').attr('for')+','+event.data.key,0);	
	}else
			{
				var text_bb22 = form_move.find('.js-edit-comm-task-yes').text();
				form_move.find('.js-add-say1').empty().append('Ошибка заполнения!');
				form_move.find('.js-add-say1').addClass('new-say1');
				setTimeout ( function () { form_move.find('.js-add-say1').removeClass('new-say1'); form_move.find('.js-add-say1').empty().append(text_bb22);  }, 4000 );
				
			}
}


function add_say_yes1()
{

	//alert("!");
	
	var err = 0;
	
	//проверка сообщения
	$('.js-form-gll_form2 .div_textarea_say').removeClass('error_textarea_2018');

	    if($('.js-form-gll_form2 #otziv_area_say2020').val() == '')
	{
		$(".js-form-gll_form2 .div_textarea_say").addClass('error_textarea_2018');
		err=1;		
	}
	
	
	//проверка задачи если есть активность
	if($('[name=radio_task_select_form2]').val()==1)
		{
			
	$('.form-task-02_form2 .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});
			
		} else
		{
	$('.form-task-02_form2 .gloab').each(function(i,elem) {
	$(this).parents('.input_2018').removeClass('error_2018');
	$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																			
});			
		}
	
	
	
	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
	
var data ='url='+window.location.href+'&tk='+$('.js-form2').attr('mor')+'&id='+$('.js-form2').attr('for')+'&text='+ec($('#otziv_area_say2020').val())+'&type='+$('#typesay_form2').val()+'&comment='+ec($('#otziv_area_adaxx2991').val())+'&date='+$('[name=date_sele_task_form2]').val()+'&time='+$('[name=task_time_form2]').val()+'&task='+$('[name=radio_task_select_form2]').val();

	//изменить кнопку на загрузчик
	$('.js-add-say1').hide();
		
	$('.js-exit-form-say1').hide();
	$('.js-add-task-butt1').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
		

AjaxClient('clients','edit_say','GET',data,'AfterEditSay',$('.js-form2').attr('for'),0);	
	}else
			{
				var text_bb22 = $('.js-add-say1').text();
				$('.js-add-say1').empty().append('Ошибка заполнения!');
				$('.js-add-say1').addClass('new-say1');
				setTimeout ( function () { $('.js-add-say1').removeClass('new-say1'); $('.js-add-say1').empty().append(text_bb22);  }, 4000 );
				
			}
}


function add_sel_yes1()
{

	//alert("!");
	
	var err = 0;
	
	//проверка ссылки
	$('.js-form-gll_form2 .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}
	});	
	
	//проверка задачи если есть активность
	if($('[name=radio_task_select_form2]').val()==1)
		{
			
	$('.form-task-02_form2 .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});
			
		} else
		{
	$('.form-task-02_form2 .gloab').each(function(i,elem) {
	$(this).parents('.input_2018').removeClass('error_2018');
	$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																			
});			
		}
	
	
	
	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
	
var data ='url='+window.location.href+'&tk='+$('.js-form2').attr('mor')+'&id='+$('.js-form2').attr('for')+'&link='+ec($('[name=link_selection_form2]').val())+'&comment='+ec($('#otziv_area_adaxx2991').val())+'&date='+$('[name=date_sele_task_form2]').val()+'&time='+$('[name=task_time_form2]').val()+'&task='+$('[name=radio_task_select_form2]').val();

	//изменить кнопку на загрузчик
	$('.js-add-sel1').hide();
		
	$('.js-exit-form-sel1').hide();
	$('.js-add-task-butt1').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
		

AjaxClient('clients','edit_sel','GET',data,'AfterEditSel',$('.js-form2').attr('for'),0);	
	}else
			{
				var text_bb22 = $('.js-add-sel1').text();
				$('.js-add-sel1').empty().append('Ошибка заполнения!');
				$('.js-add-sel1').addClass('new-say1');
				setTimeout ( function () { $('.js-add-sel1').removeClass('new-say1'); $('.js-add-sel1').empty().append(text_bb22);  }, 4000 );
				
			}
}

//проверка добавления комментария к задаче и отправка данных для этого
function add_comment_yes_task(event)
{
	var err = 0;
	//alert("!");
	var form_move=$('.form'+event.data.key)
	//var form_move=$('.js-comment-add-'+event.data.key)
	
	form_move.find(".div_textarea_say").removeClass('error_textarea_2018');

	    if(form_move.find('.js-comment-add-'+event.data.key).val() == '')
	{
		form_move.find(".div_textarea_say").addClass('error_textarea_2018');
		err=1;		
	}
	
	
	
	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
	
var data ='url='+window.location.href+'&tk='+form_move.find('.h111').attr('mor')+
					'&id='+form_move.find('.h111').attr('for')+'&text='+ec(form_move.find('.js-comment-add-'+event.data.key).val());


	//изменить кнопку на загрузчик
	form_move.find('.js-add-comment-yes').hide();
		
	form_move.find('.js-exit-form-comm-task').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
AjaxClient('task','add_comment','GET',data,'AfterAddCommentTask',form_move.find('.h111').attr('for')+','+event.data.key,0);
		
		
	}else
			{
				var text_bb22 = $('.js-add-say').text();
				$('.js-add-say').empty().append('Ошибка заполнения!');
				$('.js-add-say').addClass('new-say1');
				setTimeout ( function () { $('.js-add-say').removeClass('new-say1'); $('.js-add-say').empty().append(text_bb22);  }, 4000 );
				
			}	
}


function add_say_yes()
{
	var err = 0;
	//alert("!");
	
	$(".div_textarea_say").removeClass('error_textarea_2018');

	    if($("#otziv_area_say").val() == '')
	{
		$(".div_textarea_say").addClass('error_textarea_2018');
		err=1;		
	}
	
	
	//проверка задачи если есть активность
	if($('[name=radio_task_select]').val()==1)
		{
			
	$('.form-task-02 .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});
			
		} else
		{
	$('.form-task-02 .gloab').each(function(i,elem) {
	$(this).parents('.input_2018').removeClass('error_2018');
	$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																			
});			
		}
	//проверка задачи если есть активность
	
	
	if(err==0)
	{

	
	//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	//$.arcticmodal('close');
	
var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for')+'&text='+ec($('#otziv_area_say').val())+'&type='+$('#typesay').val()+'&comment='+ec($('#otziv_area_adaxx299').val())+'&date='+$('[name=date_sele_task]').val()+'&time='+$('[name=task_time]').val()+'&task='+$('[name=radio_task_select]').val();


	//изменить кнопку на загрузчик
	$('.js-add-say-yes').hide();
		
	$('.js-exit-form-say').hide();
	$('.js-add-task-butt').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');	
		
AjaxClient('clients','add_say','GET',data,'AfterAddSay',$('.h111').attr('for'),0);
		
		
	}else
			{
				var text_bb22 = $('.js-add-say').text();
				$('.js-add-say').empty().append('Ошибка заполнения!');
				$('.js-add-say').addClass('new-say1');
				setTimeout ( function () { $('.js-add-say').removeClass('new-say1'); $('.js-add-say').empty().append(text_bb22);  }, 4000 );
				
			}
}


function AfterSearchClient(d,c){
	
$('.b_loading_small').remove();
$('.fox_dell').show();	
	
	if(d.status=="ok"){
	

	
if($(".fox_search_result").css("display")!="block"){$(".fox_search_result").show();var a=false;
																								 
$(document).bind("click.myEvent",function(f){if(!a&&$(f.target).closest(".fox_search_result").length==0){$(".fox_search_result").hide();

$(document).unbind("click.myEvent")}a=false})}
												   
$(".fox_search_result").empty().append(d.query);$(".fox_search_result").show()}else{$(".fox_search_result").hide()}}


//нажать на кнопку добавить комментарий в инфе о задаче
function add_comm_task(event)
{
	var form_move=$('.form'+event.data.key);
	
				  	form_move.find('.js-add-comment-task').slideUp("slow"); 
	form_move.find('.js-ssay').slideDown( "slow" );
	
	var cb_h=$(this).find('input').val();
	if(cb_h==0)
		{
			  $(this).find('input').val(1);
			  $(this).find('.choice-radio i').addClass('active_task_cb');
			
			

		} else
			{
			  $(this).find('input').val(0);
			  $(this).find('.choice-radio i').removeClass('active_task_cb');
				

			}	
		
}


function add_say_cbb()
{

				  	$('.js-add_say_cbb').slideUp("slow"); 
	$('.js-ssay').slideDown( "slow" );
	
	var cb_h=$(this).find('input').val();
	if(cb_h==0)
		{
			  $(this).find('input').val(1);
			  $(this).find('.choice-radio i').addClass('active_task_cb');
			
			

		} else
			{
			  $(this).find('input').val(0);
			  $(this).find('.choice-radio i').removeClass('active_task_cb');
				

			}	
	
}

function add_sel_cbb()
{
	$('.js-add_sel_cbb').slideUp("slow"); 
	$('.js-ssel').slideDown( "slow" );
}

function selection_cb()
{
	var hbb=$(window).width();
	if(hbb>1050)
		{
	var link = $(this).find('.h_cb span').text();
	var frr=$(this).find('.link_cb');
	
	if(frr.is('.active_cb'))
		{
			frr.slideUp( "slow" );
			frr.removeClass('active_cb');
		} else
			{
	frr.hide();
	frr.empty().append('<iframe src="'+link+'" width="1000px" height="500px" scrolling="yes" frameborder="0"> </iframe>');
	frr.slideDown( "slow" )
				frr.addClass('active_cb');
			}
		}
}


//выбор валюты
function exchange_rates()
{
	//$(this).val();
	$('.rates_value').slideDown("slow");	
	
	var hop=$('.val_rate').find('[rel='+$(this).val()+']').attr('value_e');
	
	$('.exchange_rates').val(hop).trigger('click');
	
}

//выбор связи с клиентом и задачей



//выбор ответственного за задачу
function taskkto()
{
	var vals=$(this).val();
	if((vals=='all')||(vals=='all_subor'))
	{
		//все менеджеры
		$('.js-task-option-blue').slideDown("slow"); 
	} else
	{
		$('.js-task-option-blue').slideUp("slow");	
	}
}


//выбор способа оплаты
function payment_method()
{
	var vals=$(this).val();
	var comm=$(this).parents('.zin_2019').find('[rel='+vals+']').attr('comm');
	if(comm==1)
	{
		$('.proc_bank').slideDown("slow");
		$('.proc_bank').find('.pp_bank').focus();
		
	}else
	{
		$('.proc_bank').slideUp("slow");
		$('.proc_bank').find('.pp_bank').val('');
	}
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


function changesay()  {
	
	$('.js-form_right_say').removeClass('form_say_1 form_say_2 form_say_3 form_say_4 form_say_5 form_say_6 form_say_7 form_say_8 form_say_9').addClass('form_say_'+$(this).val());
}
function changesay1()  {
	
	$('.js-form_right_say1').removeClass('form_say_1 form_say_2 form_say_3 form_say_4 form_say_5 form_say_6 form_say_7 form_say_8 form_say_9').addClass('form_say_'+$(this).val());
}


function radio_client()
{
	var val=$(this).val();
	if(val==0)
	{
		$('.two_client_box').slideUp("slow", function() {$('.one_client_box').slideDown(); });
	} else
		{
		$('.one_client_box').slideUp("slow", function() {$('.two_client_box').slideDown(); });	
		}
}

function radio_doc()
{
		var val=$(this).val();
	if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
	{
		$('#button_bron_booking').removeClass('greii_d');
	}
}

function radio_doc1()
{
		var val=$(this).val();
	if((val!='')&&(val!=0)&&(val!= undefined)&&($.isNumeric(val)))
	{
		$('#button_bron_booking_prepaid_end').removeClass('greii_d');
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
//ввод в поле по ТО
function exchange_rates2()
{
	var curss=$('.exchange_rates').val();
	var js_200=$(this).parents('.jj-l').find('.oper_name');
		
	   if((curss!='')&&(curss!=0)&&($(this).val()!='')&&($(this).val()!=0))
		{
				var char=$('.val_rate').find('[rel='+$('#exchange_rates').val()+']').attr('char');
				var curs=(parseFloat(ctrim($(this).val()))/parseFloat(curss));
				js_200.empty().append(char+' '+$.number(curs.toFixed(2), 2, '.', ' '));
		} else
		{
			 
			    var joi=js_200.attr('joi');
			    js_200.empty().append(joi);
		}
		
}
//ввод курса
function exchange_rates1()
{
	if(($(this).val()!='')&&($(this).val()!=0))
		{
	var wxxx=$(this).val();
	var char=$('.val_rate').find('[rel='+$('#exchange_rates').val()+']').attr('char');
			
	$('.jj-l').each(function(i,elem) {
	if(($(this).find('.gloab').val() != '')&&($(this).find('.gloab').val() != 0))  { 
	var curs=(parseFloat(ctrim($(this).find('.gloab').val()))/parseFloat(wxxx));
		//alert($(this).find('.gloab').val());
					$(this).find('.oper_name').empty().append(char+' '+$.number(curs.toFixed(2), 2, '.', ' '));
	
	} else {var joi=$(this).find('.oper_name').attr('joi');
					$(this).find('.oper_name').empty().append(joi);}		
});		
		} else
			{
				$('.jj-l').each(function(i,elem) {
					var joi=$(this).find('.oper_name').attr('joi');
					$(this).find('.oper_name').empty().append(joi);
				});	
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


function latin_exp()
{
    var st_latin=$(this).val();
	var a = st_latin.split(' ');
	if(a.length>1)
		{
	var st_end=TextToLat(a[0]+' '+a[1]);
		}
	else
		{
			var st_end=TextToLat(st_latin);
		}
	$('.latin_end').trigger('click');
	$('.latin_end').val(st_end);
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

//выбрать из найденного клиента
function string_res()
{
	var pp=$(this).attr('id');
	
	$('.fox_search_result').hide();
	$('[name=id_search_client]').val(pp);
	
	$('.end_search').find('.end_one').empty().append($(this).find(".name_search_x").html());
	$('.end_search').find('.end_two').empty().append($(this).find(".phone_search_x").html());
	$('.end_search').show();
	
}


//нажатие на материал в кошельке
/*
function wallet_checkbox()
{
	alert("22");
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
*/
function wallet_checkbox()
{
	
if($(this).parents('.cha_1').find('.sourse_b').attr('readonly')==undefined) { 	
	
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
			var numOpt=$(this).parents('.cha_77').find('.wallet_material');    
			  var input='';
			  var i=0;
			 
			  numOpt.each(function (index, value) { 
			  
			  if ( $(this).hasClass("active_wall") ) 
			   {
				  if(i==0)
				  { 
                    input=$(this).attr('wall_id');
					i++;
				  } else
				  {
					input=input+','+$(this).attr('wall_id');
					i++; 
				  }
			   }
			   
              });
				 
		//alert(input);
		$(this).parents('.cha_77').find('.sourse_b').val(input);
	
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
	    
	    var tr=$(this).parents('.xvg_material').find('.xvg_material_doc').val();
	
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

function avax()
{
	//alert("!");
	//$(this).val($(this).val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
	var Str=$(this).val();
	Str=Str.replace(/\s/g, '');

	
	var vvod=parseFloat(Str);
	var max=parseFloat($('.gop_cost').attr('max_summ'));
	if((vvod!=0)&&(vvod!='')&&($.isNumeric(vvod)))
	{
		var ost=max-vvod;
		$('.koldd_w').find('.gop_cost').empty().append($.number(ost, 2, '.', ' ')+'<span>₽</span>');
		$('.koldd_w').slideDown("slow");	
	} else
		{
			$('.koldd_w').slideUp("slow");
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

//подсчет итоговой сумму при добавлении счета
var itogprice_xvg = function() {

	
	var xvg=$('.xvg_material');
	$('#yes_soply11').show();
	$('#yes_soply12').show();
	var summ_xvg=0;
	xvg.each(function(i,elem) {
		
		$(this).find('.count_xvg_').removeClass('redaas');	  
		$(this).find('.price_xvg_').removeClass('redaas');
		
			var count= parseFloat($(this).find('.count_xvg_').val());
		    var count_max= parseFloat($(this).find('.count_xvg_').attr('max'));
	        var price= parseFloat($(this).find('.price_xvg_').val());
		    var price_max= parseFloat($(this).find('.price_xvg_').attr('max'));
		   // var max_count=parseFloat($('#count_work_'+id_trr).attr('max'));
		
		if(count>count_max)
		{
				//выделяем красным и открываем служебную записку
				$(this).find('.count_xvg_').addClass('redaas');
			    $('#yes_soply11').hide();
			    $('#yes_soply12').hide();
		} 
		if(price>price_max)
		{
				//выделяем красным и открываем служебную записку
				$(this).find('.price_xvg_').addClass('redaas');		
		}
		
		
		var value=(count*price).toFixed(2);
		
		if((value!=0)&&(value!='')&&($.isNumeric(value)))
	    {    
		    $(this).find('.all_price_count_xvg span').empty().append(value);
			summ_xvg=(parseFloat(summ_xvg)+parseFloat(value)).toFixed(2);
	    } else
		{
			$(this).find('.all_price_count_xvg span').empty().append('0');	
		}
		
		
	});
	
	
	$('.all_summa_xvg').find('span').empty().append(summ_xvg);
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

//показать в подборках кнопка еще
var js_eshe_selection = function()
{
	var pg=$(this).attr("pg");
	var start=$(this).attr("start");
	var all=$(this).attr("all");
	
	
			$('.cb_eshe_sel').empty().append('<div class="b_loading_small" style="position:relative; top: -5px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		
		
		var data ='url='+window.location.href+'&pg='+pg+'&start='+start+'&all='+all+
					'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for');
        AjaxClient('clients','tabs_sel_eshe','GET',data,'AfterSelEshe',1,0);	
}


//показать комментарии в задаче кнопка еще
var eshe_comm_task = function(event)
{
	var form_move=$('.form'+event.data.key);
	var pg=$(this).attr("pg");
	var start=$(this).attr("start");
	var all=$(this).attr("all");
	
	
			$(this).empty().append('<div class="b_loading_small" style="position:relative; top: -5px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		
		
		var data ='url='+window.location.href+'&pg='+pg+'&start='+start+'&all='+all+
					'&tk='+form_move.find('.h111').attr('mor')+
					'&id='+form_move.find('.h111').attr('for');
        AjaxClient('task','tabs_comm_eshe','GET',data,'AfterCommTaskEshe',1+','+event.data.key,0);	
}



//показать общение кнопка еще
var eshe_say = function()
{
	var pg=$(this).attr("pg");
	var start=$(this).attr("start");
	var all=$(this).attr("all");
	
	
			$('.cb_eshe').empty().append('<div class="b_loading_small" style="position:relative; top: -5px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		
		
		var data ='url='+window.location.href+'&pg='+pg+'&start='+start+'&all='+all+
					'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for');
        AjaxClient('clients','tabs_say_eshe','GET',data,'AfterSayEshe',1,0);	
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

var delay1 = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


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


//добавить офис в окне добавления



//оплата по туру изменение суммы  оплаты или курса
$('.js-form-pay-trips').on("change keyup input click",'.js-upload-kurs',upload_kurs);

//выбор типа операции в добавление оплате финансы
$('.js-form-pay-finance').on("change",'.js-type-finance',js_type_finance);
	$('.js-form-pay-finance-edit').on("change",'.js-type-finance',js_type_finance_edit);

//изменение цен по туру изменение суммы  оплаты или курса по клиенту
	$('.js-form-price-trips').on("change keyup input click",'.js-upload-kurs',upload_kurs);
//изменение цен по туру изменение суммы  оплаты или курса по оператору
	$('.js-form-price-trips').on("change keyup input click",'.js-upload-kurs-oper',upload_kurs_oper);


//оплата по туру изменение курса и пересчет остатка в рублях
	$('.js-form-pay-trips').on("change keyup input click",'.js-upload-kurs2',upload_kurs2);

//изменение нажатие на комиссию процент при оплате тура
$('.js-form-pay-trips').on("change keyup input click",'.js-comm-proc,.js-comm-rub',comm_proc);

//изменение нажатие на скидку процент при изменение стоимости тура
	$('.js-form-price-trips').on("change keyup input click",'.js-comm-proc,.js-comm-rub',comm_proc);

//при изменении суммы оплаты пересчитываем комиссии

$('.js-form-pay-trips').on("change keyup input click",'.js-upload-kurs1',CommiUpdate);


//выбор для кого задачи
$('#taskkto').bind('change', taskkto);

//выбор связи клиента с задачей	
//$('#taskusersv').bind('change', task_user_sv);	
	
$('#exchange_rates').bind('change', exchange_rates);		
$('#payment_method').bind('change', payment_method);	
$('.label_s').unbind("change keyup input click", label_show);	
$('.label_s').bind("change keyup input click", label_show);		
$('.box-modal').on("change keyup input click",'.option_xvg2',option_checkbox_xvg);
$('.box-modal').on("change keyup input click",'.exchange_rates',exchange_rates1);

$('.box-modal').on("change keyup input click",'.js-add-say-task-yes',add_say_cbb);
	
$('.box-modal').on("change keyup input click",'.js-add-task-but-x',add_task_yes); //добавление задачи с проверкой	




//туры
$('.box-modal').on("change keyup input click",'.js-add-buy-trips-but-x',add_buy_trips_yes); //добавление оплаты по туру с проверкой





$('.box-modal').on("change keyup input click",'.js-edit-buy-trips-but-x',edit_buy_trips_yes); //изменение оплаты по туру с проверкой

	$('.box-modal').on("change keyup input click",'.js-edit-price-trips-but-x',edit_price_trips_yes); //изменение цен по туру с проверкой


	$('.box-modal').on("change keyup input click",'.js-edit-price-plane-but-x',edit_price_plane_yes); //изменение планов на месяц

//подборки	
$('.box-modal').on("change keyup input click",'.js-selection_cb',selection_cb);
$('.box-modal').on("change keyup input click",'.add_sel_cbb',add_sel_cbb);
$('.box-modal').on("change keyup input click",'.js-eshe-selection',js_eshe_selection);		
$('.box-modal').on("change keyup input click",'.js-add-sel',add_sel_yes); //добавление с проверкой
$('.box-modal').on("change keyup input click",'.js-selection-del',del_selection);	
$('.box-modal').on("change keyup input click",'.js-selection-edit',edit_selection);
$('.box-modal').on("change keyup input click",'.js-exit-form-sel',js_exit_form_sel);  //кнока отмена 	
$('.box-modal').on("change keyup input click",'.js-exit-window-add-task',js_exit_window_add_task);  //кнока отмена добавление задачи


//удалить объект с проверкой в форме
	$('.js-dell-users-b').on( "click", function() {

		var for_id=$('.gloab-cc').attr('for');


		//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		//$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');
		AjaxClient('users','dell_users','GET',data,'Afterdell_users',for_id,0);


		$('.js-dell-users-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


	});


	
//общение
$('.box-modal').on("change keyup input click",'.cb_eshe',eshe_say);	
//$('.box-modal').on("change keyup input click",'.del_say_',del_say);
$('.box-modal').on("change keyup input click",'.add_say_cbb',add_say_cbb);
	

$('.box-modal').on("change keyup input click",'.js-cb_eshe_comm_task',{key: "003U"},eshe_comm_task);		
	
	
$('.box-modal').on("change keyup input click",'.js-add-comment-task',{key: "003U"},add_comm_task);
$('.box-modal').on("change keyup input click",'.js-add-comment-yes',{key: "003U"},add_comment_yes_task);	//добавление с проверкой	
$('.box-modal').on("change keyup input click",'.js-add-say-yes',add_say_yes);	//добавление с проверкой
$('.box-modal').on("change keyup input click",'.js-exit-form-say',js_exit_form_say);  //кнока отмена 
	
$('.box-modal').on("change keyup input click",'.js-exit-form-comm-task',{key: "003U"},js_exit_form_comm_task);  //кнока отмена 
	
$('.box-modal').on("change keyup input click",'.js-exit-form-say-task',js_exit_form_say_task);  //кнока отмена добавления общения при выполнении задачи
$('.box-modal').on("change keyup input click",'.js-say-del',del_say);	
$('.box-modal').on("change keyup input click",'.js-say-edit',edit_say);	
	
$('.box-modal').on("change keyup input click",'.js-com-task-del',{key: "003U"},del_comm_task);
$('.box-modal').on("change keyup input click",'.js-com-task-edit',{key: "003U"},edit_comm_task);	
	
//задачи в общение и подборках
$('.box-modal').on("change keyup input click",'.task_cb',task_cb_head);	
	
//добавление частного клиента
$('.box-modal').on("change keyup input click",'.js-potential-butt',potential_users);  //потенциальный клиент

//Связь с клиентом при добавлении задачи
$('.box-modal').on("change keyup input click",'.js-option-task-user',option_task_user); 
	
$('.box-modal').on("keyup",'.latin_start',latin_exp);	
	
$('.box-modal').on("change keyup input click",'.blank_no_cb',blank_no_cb);
	
$('.box-modal').on("change keyup input click",'.cost_to_1',exchange_rates2);



	$('.box-modal .js-form-srok-trips').on("change keyup input click",'.js-proc-form-x',sroki_yes);

	
$('.box-modal').on("change keyup input click",'.js-save-info-org-cb',save_info_org);	

	
$('.box-modal').on("change keyup input click",'.js-save-info-task-cb',{key: "003U"},save_info_task);
	
$('.box-modal').on("change keyup input click",'.js-save-info-client-cb',save_info_client);
$('.box-modal').on("change keyup input click",'.js-add-client-cb',add_info_client); //добавить частного клиента кнопка
$('.box-modal').on("change keyup input click",'.js-add-org-cb',add_info_org);	
	
$('.box-modal').on("change keyup input click",'.js-vibor-date span',js_vibor_date);

//добавить срок оплаты кнопка в форме
$('.box-modal').on("change keyup input click",'.js-butt-srok-add',js_but_srok);
$('.box-modal').on("change keyup input click",'.js-edit-srok-trips-but-x',edit_srok_tt);
	
	
$('.box-modal').on("change keyup input click",'.js-padej_woo',padej_woo);

	

	
	
$('.box-modal').on("change",'[name=client_new_search]',radio_client);	
	


	
	
	
$('.box-modal').on("change",'[name=radio_doc]',radio_doc);
$('.box-modal').on("change",'[name=radio_doc1]',radio_doc1);
	
$('.box-modal').on("change keyup input click",'.avax',avax);
	
$('.box-modal').on("click",'.del_org_',DellOrg);
$('.box-modal').on("click",'.del_clients_',DellClients);

$('.box-modal').on("click",'.js-dell-task',DellTask);	
	
$('.invoice_step_1').on("change",'.demo-5',option_demo);	
	
	
$('.print_stocks').on("change",'#stock_town_',stock_town_x);	
$('.print_stocks').on("change",'#stock_kvartal_',stock_kvartal_x);	

	
$('.fox_search_result').on("change keyup input click",'.string_res',string_res);

$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);
	
$('.bill_wallet').on("change keyup input click",'.summ_input_ww',EditSummWall);		
	
$(".cal_223").bind('click', function() { $(this).prev('.calendar_t').trigger('focus');});	
	
	

			
	
	
//проверка есть ли такой телефон в базе
	
var search_min2_phone = 18;  //мин количество символов для быстрого поиска
var search_deley2_phone=100;	//задержка между вводами символов - начало поиска телефона в базе
var search_input2_phone=$('.js-true-phone');			
search_input2_phone.keyup(function() {
	//обнуляем выбор
	search_input2_phone.parents('.input_2018').find('.js-true-search-phone').val(0);
	$(".js-open-phone").hide(); $('.js-true-phone').parents('.input_2018').removeClass('error_2018');
		
	
	
    delays(function(){
		
		if(jQuery.trim(search_input2_phone.val().length) >= search_min2_phone)
		{
                var data ='url='+window.location.href+
					'&search='+encodeURIComponent(search_input2_phone.val());	
			//$('.fox_dell1').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('clients','true_phone','GET',data,'AfterTruePhone',1,0);		
		}
    }, search_deley2_phone);
});	
		
	
	
//$('.img_ssoply').on("click",'.del_icon_blockbb',DellImageSupply);
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
	


var search_min = 3;  //мин количество символов для быстрого поиска
var search_deley=800;	//задержка между вводами символов - начало поиска
var search_input=$('#fox_search_client_i');
	
//крестик, удалить все символы в поиске	
$('.fox_dell').on('click',function(){
	search_input.val('');
	$('.fox_dell').hide();
	$('.div_result').hide();
	$('.end_search').hide();
	$('[name=id_search_client]').val(0);
});


//при вводе поиска в клиенте	
search_input.keyup(function() {
	if(jQuery.trim(search_input.val().length) >= 1)
		{
		  $('.fox_dell').show();	
		} else
		{
			$('.fox_dell').hide();
		}
    delay1(function(){
		
		if(jQuery.trim(search_input.val().length) >= search_min)
		{
                var data ='url='+window.location.href+
					'&search='+encodeURIComponent(search_input.val())+
					'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for');	
			$('.fox_dell').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('booking','search_client','GET',data,'AfterSearchClient',1,0);		
		}
    }, search_deley );
});
	
	
	
	
$('#button_bron_booking_prepaid1_x').on( "click", function() {
	
	
	var select=$('[name=radio_b_op]').val();
	var for_id=$('.h111').attr('for');
	if(select==1)
	{
			clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	        $.arcticmodal('close');	
		
		$.arcticmodal({
    type: 'ajax',
    //url: 'forms/form_bron_booking_end_all.php?id='+for_id,
	url: 'forms/form_bron_booking_end_all_client.php?id='+for_id+'&options=0',		
    afterLoading: function(data, el) {
        //alert('afterLoading');
		
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
		$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
		
		
	} else
	{
	//открываем форму частичной оплаты первый раз
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	        $.arcticmodal('close');	
		
		$.arcticmodal({
    type: 'ajax',
    //url: 'forms/form_bron_booking_end_avans.php?id='+for_id,
	url: 'forms/form_bron_booking_end_all_client.php?id='+for_id+'&options=1',		
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
			$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });		
		
	}
});		

	
$('#button_bron_booking_prepaid_end').on( "click", function() {

	if(!$(this).is('.greii_d'))
	{	

	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	if(err==0)
		{
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_booking_avans_end','POST',0,'Afteryes_booking',0,'vino_xd');
		}
	
}
});			
	

$('#button_dell_booking_dis').on( "click", function() {
	

	var for_id=$('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	
    AjaxClient('booking','disable_booking','GET',data,'Afteryes_booking',for_id,0);	
	
	
});		
	
$('#button_bron_booking_prepaid').on( "click", function() {

	

	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	if(err==0)
		{
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_booking_avans','POST',0,'Afteryes_booking',0,'vino_xd');
		}
});		
	
	
$('#button_bron_booking_avaa1').on( "click", function() {
	
	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	
		$('#vino_xd .gloab1').each(function(i,elem) {
	if($(this).val() == '')  { $(this).parents('.select').addClass('error_2018'); err++; } else {$(this).parents('.select').removeClass('error_2018');}		
});		
	
	
	var Str=$('.avax').val();
	Str=Str.replace(/\s/g, '');

	
	var vvod=parseFloat(Str);
	var max=parseFloat($('.gop_cost').attr('max_summ'));
	if((vvod!=0)&&(vvod!='')&&($.isNumeric(vvod)))
	{
		var ost=max-vvod;	
	    if(ost<0)
			{
				
				$('.avax').parents('.input_2018').addClass('error_2018'); err++;
				
			}
	}
	if(err==0)
		{
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_avans_two','POST',0,'Afteryes_booking',0,'vino_xd');
		}	
	
});	
	
	
$('#button_bron_booking_avaa').on( "click", function() {
	
	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	
		$('#vino_xd .gloab1').each(function(i,elem) {
	if($(this).val() == '')  { $(this).parents('.select').addClass('error_2018'); err++; } else {$(this).parents('.select').removeClass('error_2018');}		
});	
	
	if(err==0)
		{
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_avans_one','POST',0,'Afteryes_booking',0,'vino_xd');
		}	
	
});

$('#fly_booking_button1').on( "click", function() {

	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	
		if(err==0)
		{
			
    clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','fly_edit','POST',0,'Afterfly_edit1',0,'vino_xd');
		
		}
	
});
	
$('#save_comment_button_x').on( "click", function() {
		var err=0;
	var for_id=$('.h111').attr('for');
	var name=$('#otziv_area_adaxx2').val();
	
		if((name=='')||(name==0))
	    {
		  $('#otziv_area_adaxx2').addClass('error_formi');
		  err=1;
	    }
	if(err==0)
		{
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&answer='+$('#otziv_area_adaxx2').val();
    AjaxClient('booking','add_comment','GET',data,'Afteradd_comment',for_id,0);
		}
});

//сохранение новых дат вылетов по туру
$('#fly_booking_button_trips').on( "click", function() {

		var err = 0;
		$('#vino_xd .gloab').each(function(i,elem) {
			if ($(this).hasClass("stop")) {	}
			if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}
		});

		if(err==0)
		{

			clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
			$.arcticmodal('close');
			AjaxClient('tours','fly_edit','POST',0,'Afterfly_edit_trips',0,'vino_xd');

		}

	});
	
$('#fly_booking_button').on( "click", function() {

	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	
		if(err==0)
		{
			
    clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','fly_edit','POST',0,'Afterfly_edit',0,'vino_xd');
		
		}
	
});

$('#button_bron_booking').on( "click", function() {

	if(!$(this).is('.greii_d'))
	{

	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
		
	$('#vino_xd .gloab1').each(function(i,elem) {
	if($(this).val() == '')  { $(this).parents('.select').addClass('error_2018'); err++; } else {$(this).parents('.select').removeClass('error_2018');}		
});	
		
	var to_1 = $('.to_1').val();
	var to_2 = $('.to_2').val();	
	var to_3 = $('.to_3').val();	
	if(to_1==0) { $('.to_1').parents('.input_2018').addClass('error_2018'); err++;}
	if(to_3==0) { $('.to_3').parents('.input_2018').addClass('error_2018'); err++;}
	/*
	if(to_3<to_1) { $('.to_3').parents('.input_2018').addClass('error_2018'); $('.to_1').parents('.input_2018').addClass('error_2018'); err++;  }
	*/	
	var pp_hhp=$('#payment_method').val();
	var comm=$('#payment_method').parents('.zin_2019').find('[rel='+pp_hhp+']').attr('comm');
	
	if((comm==1)&&($('.pp_bank').val()=='')) {  $('.pp_bank').parents('.input_2018').addClass('error_2018'); err++;  } else { $('.pp_bank').parents('.input_2018').removeClass('error_2018'); }	
		
		
		
	if(err==0)
		{
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_booking','POST',0,'Afteryes_booking',0,'vino_xd');
		}
		
	}
});	

function add_info_org()
{
	var err = 0;
	$('#vino_xd_cb .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	if(err==0)
		{
			$('.js-add-org-cb').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		AjaxClient('clients','add_org','POST',0,'Afteradd_info_org',0,'vino_xd_cb');	
			
		} else
			{
				var text_bb22 = $('.js-add-org-cb').text();
				$('.js-add-org-cb').empty().append('Ошибка заполнения!');
				$('.js-add-org-cb').addClass('new-say1');
				setTimeout ( function () { $('.js-add-org-cb').removeClass('new-say1'); $('.js-add-org-cb').empty().append(text_bb22);  }, 4000 );
				
			}
}

//функция изменения комиссии в процентах в форме оплата тура
//  |
// \/
function comm_proc()
{
	$('.js-active-label').removeClass('active-commi-buy');
	$(this).addClass('active-commi-buy');
	$('.js-active-label').parents('.input_2018').removeClass('active-commi-buy1');
	$(this).parents('.input_2018').addClass('active-commi-buy1');

	CommiUpdate();
}

	/**
	 *
	 * Пересчет комиссии при оплате тура
	 * @constructor
	 */
	function CommiUpdate()
{
	var c_rub=0;
	var c_pro=0;

	var active_commi=$('.active-commi-buy');
	var summa_trips=$('.js-upload-kurs1');
	if((summa_trips.val()!=0)&&(summa_trips.val()!='')&&($('.active-commi-buy').length!=0)) {
		if ((active_commi.is('.js-comm-proc'))) {
			//комиссия в процентах в приоритете. в зависимости от их данных рассчитываем все остальное
			c_pro = parseFloat(ctrim(active_commi.val()));

			c_rub = parseFloat(ctrim(summa_trips.val()))* c_pro / 100;
			c_rub = c_rub.toFixed(2);
			$('.js-comm-rub').val(c_rub);
			input_2018();
		} else {
			//комиссия в рублях в приоритете
			c_rub = parseFloat(ctrim(active_commi.val()));
			c_pro = 100 * c_rub / parseFloat(ctrim(summa_trips.val()));
			c_pro = c_pro.toFixed(2);
			$('.js-comm-proc').val(c_pro);
			input_2018();
		}
	}
}


//функция пересчета остатка при изменение курса в форме оплата тура
//  |
// \/
	function  upload_kurs2() {

		var curss=$(this).val();

		//alert_message('error',curss);

		if((curss!='')&&(curss!=0)&&($('.cost_all_trips_kop').length!=0))
		{
			//alert($('.cost_all_trips_kop').length);
			$('.cost_all_trips_kop').each(function(i,elem) {
				if (($(this).attr("xvost")!='')&&($(this).attr("xvost")!=0))
				{
					var xvost= $(this).attr("xvost");
					var ost=(parseFloat(ctrim(xvost))*parseFloat(curss));
					$(this).find('span').empty().append('→ '+$.number(ost.toFixed(2), 2, '.', ' '));
					$(this).slideDown( "slow" );
				}
			});

		} else
		{
			$('.cost_all_trips_kop').each(function(i,elem) {
				$(this).find('span').empty();
				$(this).slideUp("slow");
			});
		}

	}

//функция пересчета стоимости в валюте при изменение самой стоимости в рублях или курса в форме оплата тура
//  |
// \/
function  upload_kurs() {

	var curss=$('.js-upload-kurs2').val();
	var js_200=$('.js-upload-kurs1').parents('.jj-l2').find('.oper_name');

	//alert_message('error',curss);

	if((curss!='')&&(curss!=0)&&($('.js-upload-kurs1').val()!='')&&($('.js-upload-kurs1').val()!=0)&&($('.js-upload-kurs2').length!=0))
	{
		var char=$('.js-upload-kurs2').attr('char');

		var curs=(parseFloat(ctrim($('.js-upload-kurs1').val()))/parseFloat(curss));
		js_200.empty().append(char+' '+$.number(curs.toFixed(2), 2, '.', ' '));
	} else
	{
		var joi=js_200.attr('joi');
		js_200.empty().append(joi);
	}

}



//функция пересчета стоимости в валюте при изменение самой стоимости в рублях или курса в форме оплата тура
//  |
// \/
	function  upload_kurs_oper() {

		var curss=$('.js-upload-kurs2-p').val();
		var js_200=$('.js-upload-kurs1-p').parents('.jj-l2').find('.oper_name');

		//alert_message('error',curss);

		if((curss!='')&&(curss!=0)&&($('.js-upload-kurs1-p').val()!='')&&($('.js-upload-kurs1-p').val()!=0)&&($('.js-upload-kurs2-p').length!=0))
		{
			var char=$('.js-upload-kurs2-p').attr('char');

			var curs=(parseFloat(ctrim($('.js-upload-kurs1-p').val()))/parseFloat(curss));
			js_200.empty().append(char+' '+$.number(curs.toFixed(2), 2, '.', ' '));
		} else
		{
			var joi=js_200.attr('joi');
			js_200.empty().append(joi);
		}

	}
	
	
function add_info_client()
{
	var err = 0;
	
	//проверяем добавлять потенциального или нет
	if($('[name=radio_potential]').val()==0)
		{
	//Обычный клиент
	$('#vino_xd_cb .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
		}
	if($('[name=radio_potential]').val()==1)
		{
	//потенциальный клиент
		$('#vino_xd_cb .gloab_potential').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});			
		}
	if($('[name=radio_potential]').val()==2)
	{
		//турист летит с покупателем
		$('#vino_xd_cb .gloab_turist').each(function(i,elem) {
			if ($(this).hasClass("stop")) {	}
			if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}
		});
	}
	
	if($('.js-true-search-phone').val()==1)
	{
			$(".js-open-phone").show(); $('.js-true-phone').parents('.input_2018').addClass('error_2018');
		err++;
	}
	
	
	
	if(err==0)
		{
			$('.js-add-client-cb').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		AjaxClient('clients','add_clients','POST',0,'Afteradd_info_client',0,'vino_xd_cb');	
			
		} else
			{
				var text_bb22 = $('.js-add-client-cb').text();
				$('.js-add-client-cb').empty().append('Ошибка заполнения!');
				$('.js-add-client-cb').addClass('new-say1');
				setTimeout ( function () { $('.js-add-client-cb').removeClass('new-say1'); $('.js-add-client-cb').empty().append(text_bb22);  }, 4000 );
				
			}
}	

function save_info_org()
{
	var err = 0;
	$('#vino_xd_cb .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	if(err==0)
		{
			$('.js-save-info-org-cb').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		AjaxClient('clients','save_org','POST',0,'Aftersave_info_org',0,'vino_xd_cb');	
			
		}else
			{
				var text_bb22 = $('.js-save-info-org-cb').text();
				$('.js-save-info-org-cb').empty().append('Ошибка заполнения!');
				$('.js-save-info-org-cb').addClass('new-say1');
				setTimeout ( function () { $('.js-save-info-org-cb').removeClass('new-say1'); $('.js-save-info-org-cb').empty().append(text_bb22);  }, 4000 );
				
			}
}	

//сохранить изменения в редактировании задачи	
function save_info_task(event)
{
	var err = 0;
	

	var form_move=$('.form'+event.data.key);
	var err = 0;
	
	//проверка сообщения
	form_move.find('.div_textarea_say_task').removeClass('error_textarea_2018');

	if(form_move.find('.js-edit-task-f-'+event.data.key).val() == '')
	{
	  form_move.find(".div_textarea_say_task").addClass('error_textarea_2018');
	  err=1;		
	}
	
	
	if(err==0)
		{
			$('.js-save-info-task-cb').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
			
	var data ='url='+window.location.href+'&tk='+form_move.find('.h111').attr('mor')+
					'&id='+form_move.find('.h111').attr('for')+'&text='+ec(form_move.find('.js-edit-task-f-'+event.data.key).val());


		
AjaxClient('task','save_task','GET',data,'AfterEditInfoTask',form_move.find('.h111').attr('for')+','+event.data.key,0);	
			
			
			
		//AjaxClient('task','save_task','POST',0,'Aftersave_info_task',0,'vino_xd_cb');	
			
		}else
			{
				var text_bb22 = $('.js-save-info-task-cb').text();
				$('.js-save-info-task-cb').empty().append('Ошибка заполнения!');
				$('.js-save-info-task-cb').addClass('new-say1');
				setTimeout ( function () { $('.js-save-info-task-cb').removeClass('new-say1'); $('.js-save-info-task-cb').empty().append(text_bb22);  }, 4000 );
				
			}
}	
	
function save_info_client()
{
	var err = 0;
	
	if($('[name=radio_potential]').val()==0)
		{
	
	$('#vino_xd_cb .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
		}
	if($('[name=radio_potential]').val()==1)
{
	$('#vino_xd_cb .gloab_potential').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});	
}

	if($('[name=radio_potential]').val()==2)
	{
		//турист летит с покупателем
		$('#vino_xd_cb .gloab_turist').each(function(i,elem) {
			if ($(this).hasClass("stop")) {	}
			if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}
		});
	}

		if($('.js-true-search-phone').val()==1)
	{
			$(".js-open-phone").show(); $('.js-true-phone').parents('.input_2018').addClass('error_2018');
		err++;
	}
	
	
	if(err==0)
		{
			$('.js-save-info-client-cb').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		AjaxClient('clients','save_clients','POST',0,'Aftersave_info_client',0,'vino_xd_cb');	
			
		}else
			{
				var text_bb22 = $('.js-save-info-client-cb').text();
				$('.js-save-info-client-cb').empty().append('Ошибка заполнения!');
				$('.js-save-info-client-cb').addClass('new-say1');
				setTimeout ( function () { $('.js-save-info-client-cb').removeClass('new-say1'); $('.js-save-info-client-cb').empty().append(text_bb22);  }, 4000 );
				
			}
}
	
$('#button_bron_booking_client').on( "click", function() {
if($('[name=client_new_search]').val()==0)
	{

	var err = 0;
	$('#vino_xd .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if($(this).val() == '')  { $(this).parents('.input_2018').addClass('error_2018'); err++; } else {$(this).parents('.input_2018').removeClass('error_2018');}		
});
	if(err==0)
		{
clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_booking_client','POST',0,'Afteryes_booking_client',0,'vino_xd');
		}
		
	} else
		{
			//проверяем выбран ли он из поиска
			if($('[name=id_search_client]').val()==0)
	        {
				$('#fox_search_client_i').addClass('error_2019_in');
			} else
		    {
			    $('#fox_search_client_i').removeClass('error_2019_in');
				clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
    AjaxClient('booking','yes_booking_client','POST',0,'Afteryes_booking_client',0,'vino_xd');
		    }
			
		}
});		
	
//прокрутить до заявок
$('#button_bron_offers').on( "click", function() {
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
  	//$.fn.fullpage.moveTo(3);
	jQuery.scrollTo('#section3', {offset:-100});
});

//перезвонить по заявке
$('#button_call_booking').on( "click", function() {
	var for_id=$('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&date='+$('#date_hidden_table_gr33').val()+'&time='+$('#date_124').val();
	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	
    AjaxClient('booking','call_booking','GET',data,'Afterno_booking',for_id,0);
});
	
//отказались от заявки	
$('#button_no_offers').on( "click", function() {		

	var for_id=$('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&com='+$('#otziv_area_adaxx2').val();
	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	
    AjaxClient('booking','no_booking','GET',data,'Afterno_booking',for_id,0);
	
	//$('.button_yes_no').hide(); $('.save_booking').show();
});		
	
//пометить предложение как выбранное клиентом
$('#button_select_offers').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('booking','select_offers','GET',data,'Afterselect_offers',for_id,0);
	
	//$('.button_yes_no').hide(); $('.save_booking').show();
});	


	//отметить задачу с комментарием как выполнена
$('#button_yes_task_comment').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

			var err=0;
	var for_id=$('.h111').attr('for');
	var name=$('#otziv_area_adaxx2').val();
	
		if((name=='')||(name==0))
	    {
		  $('#otziv_area_adaxx2').addClass('error_formi');
		  err=1;
	    }
	if(err==0)
		{
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&answer='+$('#otziv_area_adaxx2').val();
    AjaxClient('task','task_yes_comment','GET',data,'Afteryes_task',for_id,0);
	
		}
	//$('.button_yes_no').hide(); $('.save_booking').show();
});		

	
	//Закрыть задачу
$('#button_yes_task_close').on( "click", function() {	
	
	
	

	
		var err = 0;
	//alert("!");
	
	//общий комментарий
	$(".div_textarea_say_task").removeClass('error_textarea_2018');
$(".div_textarea_say").removeClass('error_textarea_2018');
	
	    if($("#comment_yes_task").val() == '')
	{
		$(".div_textarea_say_task").addClass('error_textarea_2018');
		err=1;		
	}
	
	//проверка ссылки
	$('.js-form-task-close .gloab').each(function(i,elem) {

	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');	 $(this).parents('.zin_2019').addClass('error_2018');			  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
														$(this).parents('.zin_2019').removeClass('error_2018');			
																	}		
});	
	
	
	if(err==0)
	{
	
		
		
    var id_task=$(this).parents('.form003U').find('.h111').attr('for');
	
		
    AjaxClient('task','task_close','POST',0,'AfterTaskClose',id_task,'vino_xd_cb');

	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');		
		
	} else
			{
				
				var text_bb22 = $('#button_yes_task_close').html();
				$('#button_yes_task_close').empty().append('Ошибка заполнения!');
				$('#button_yes_task_close').addClass('new-say2');
				setTimeout ( function () { $('#button_yes_task_close').removeClass('new-say2'); $('#button_yes_task_close').empty().append(text_bb22);  }, 4000 );
				
			}
	//$('.button_yes_no').hide(); $('.save_booking').show();
});	
	
	//передать задачу на другого
$('#button_yes_task_send').on( "click", function() {	
	
	
	

	
		var err = 0;
	//alert("!");
	
	//общий комментарий
	$(".div_textarea_say_task").removeClass('error_textarea_2018');
$(".div_textarea_say").removeClass('error_textarea_2018');
	
	    if($("#comment_yes_task").val() == '')
	{
		$(".div_textarea_say_task").addClass('error_textarea_2018');
		err=1;		
	}
	
	//проверка ссылки
	$('.js-form-send-task .gloab').each(function(i,elem) {

	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');	 $(this).parents('.zin_2019').addClass('error_2018');			  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
														$(this).parents('.zin_2019').removeClass('error_2018');			
																	}		
});	
	
	
	if(err==0)
	{
	
		
		

	var id_task=$(this).parents('.form003U').find('.h111').attr('for');
		
    AjaxClient('task','task_send','POST',0,'AfterTaskSend',id_task,'vino_xd_cb');

	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');		
		
	} else
			{
				
				var text_bb22 = $('#button_yes_task_send').html();
				$('#button_yes_task_send').empty().append('Ошибка заполнения!');
				$('#button_yes_task_send').addClass('new-say2');
				setTimeout ( function () { $('#button_yes_task_send').removeClass('new-say2'); $('#button_yes_task_send').empty().append(text_bb22);  }, 4000 );
				
			}
	//$('.button_yes_no').hide(); $('.save_booking').show();
});		
	
	//перенести задачу на другую дату
$('#button_yes_task_date').on( "click", function() {	
	
	
	

	
		var err = 0;
	//alert("!");
	
	//общий комментарий
	$(".div_textarea_say_task").removeClass('error_textarea_2018');
$(".div_textarea_say").removeClass('error_textarea_2018');
	
	    if($("#comment_yes_task").val() == '')
	{
		$(".div_textarea_say_task").addClass('error_textarea_2018');
		err=1;		
	}
	
	//проверка ссылки
	$('.js-form-task-date .gloab').each(function(i,elem) {

	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});	
	
	
	if(err==0)
	{
	
		
		

	var id_task=$(this).parents('.form003U').find('.h111').attr('for');
		
    AjaxClient('task','task_date_new','POST',0,'AfterTaskNewDate',id_task,'vino_xd_cb');

	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');		
		
	} else
			{
				
				var text_bb22 = $('#button_yes_task_date').html();
				$('#button_yes_task_date').empty().append('Ошибка заполнения!');
				$('#button_yes_task_date').addClass('new-say2');
				setTimeout ( function () { $('#button_yes_task_date').removeClass('new-say2'); $('#button_yes_task_date').empty().append(text_bb22);  }, 4000 );
				
			}
	//$('.button_yes_no').hide(); $('.save_booking').show();
});	
	
	//отметить задачу как выполнена как выполнена
$('#button_yes_task').on( "click", function() {	
	
	
	

	
		var err = 0;
	//alert("!");
	
	//общий комментарий
	$(".div_textarea_say_task").removeClass('error_textarea_2018');
$(".div_textarea_say").removeClass('error_textarea_2018');
	
	    if($("#comment_yes_task").val() == '')
	{
		$(".div_textarea_say_task").addClass('error_textarea_2018');
		err=1;		
	}
	
	if($('#task_plus_say').val()==1)
		{
	//знчит сразу хочет и общение с клиентом вставить
			
	 if($("#otziv_area_say").val() == '')
	{
		$(".div_textarea_say").addClass('error_textarea_2018');
		err=1;		
	}
			
			
	//проверка задачи если есть активность
	if($('[name=radio_task_select]').val()==1)
		{
			
	$('.form-task-02 .gloab').each(function(i,elem) {
	if ($(this).hasClass("stop")) {	}
	if(($(this).val() == '')||($(this).val() == 0))  { $(this).parents('.input_2018').addClass('error_2018');
	$(this).parents('.js-prs').addClass('error_textarea_2018');				  
													  err++; } else {$(this).parents('.input_2018').removeClass('error_2018');
														$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																	}		
});
			
		} else
		{
	$('.form-task-02 .gloab').each(function(i,elem) {
	$(this).parents('.input_2018').removeClass('error_2018');
	$(this).parents('.js-prs').removeClass('error_textarea_2018');			
																	
																			
});			
		}
			
		}
	//проверка задачи если есть активность
	
	
	if(err==0)
	{
	
	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

		
	var for_id=$('.h111').attr('for');
		
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&say='+$('#task_plus_say').val()+'&.comment_end='+$('#comment_yes_task').val()+'&.text='+$('#otziv_area_say').val()+'&type='+$('#typesay').val()+'&.comment='+$('#otziv_area_adaxx299').val()+'&date='+$('[name=date_sele_task]').val()+'&time='+$('[name=task_time]').val()+'&task='+$('[name=radio_task_select]').val();

		create_post_form(data,'form_body_action');
		AjaxClient('task','task_yes_comment','POST',0,'Afteryes_task',for_id,'form_body_action',1);
		$('#form_body_action').remove();

    //AjaxClient('task','task_yes_comment','GET',data,'Afteryes_task',for_id,0);
	
	} else
			{
				
				var text_bb22 = $('#button_yes_task').html();
				$('#button_yes_task').empty().append('Ошибка заполнения!');
				$('#button_yes_task').addClass('new-say2');
				setTimeout ( function () { $('#button_yes_task').removeClass('new-say2'); $('#button_yes_task').empty().append(text_bb22);  }, 4000 );
				
			}
	//$('.button_yes_no').hide(); $('.save_booking').show();
});		
	
//удалить заявку
$('#button_dell_booking').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('booking','dell_booking','GET',data,'Afterdell_booking',for_id,0);
	
	//$('.button_yes_no').hide(); $('.save_booking').show();
});
	
//удалить клиента
$('#button_dell_clients').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('clients','dell_clients','GET',data,'Afterdell_clients',for_id,0);
	
	//$('.button_yes_no').hide(); $('.save_booking').show();
});	
	
$('#button_dell_org').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('clients','dell_org','GET',data,'Afterdell_org',for_id,0);
	
	//$('.button_yes_no').hide(); $('.save_booking').show();
});	
	
	
	
	
$('#button_dell_users').on( "click", function() {	

	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('users','dell_users','GET',data,'Afterdell_users',for_id,0);
	
});	
	
$('#button_add_answer').on( "click", function() {
	var err=0;
	var for_id=$('.h111').attr('for');
	var name=$('#otziv_area_adaxx2').val();
	
		if((name=='')||(name==0))
	    {
		  $('#otziv_area_adaxx2').addClass('error_formi');
		  err=1;
	    }
	if(err==0)
		{
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&answer='+$('#otziv_area_adaxx2').val();
    AjaxClient('reports','add_answer','GET',data,'Afteradd_answer',for_id,0);
		}
});
	
$('#button_dell_reports').on( "click", function() {
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('reports','dell_reports','GET',data,'Afterdell_reports',for_id,0);
	
});	
	

$('#button_dell_operator').on( "click", function() {	

	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('booking','dell_operator','GET',data,'Afterdell_operator',for_id,0);
	
});

$('#button_edit_answer').on( "click", function() {	
	var err=0;
	var for_id=$('.h111').attr('for');
	var name=$('#otziv_area_adaxx2').val();
	
		if((name=='')||(name==0))
	    {
		  $('#otziv_area_adaxx2').addClass('error_formi');
		  err=1;
	    }
	if(err==0)
		{
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&answer='+$('#otziv_area_adaxx2').val();
    AjaxClient('reports','edit_answer','GET',data,'Afteredit_answer',for_id,0);
		}
});	
	
$('#button_dell_answer').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('reports','dell_answer','GET',data,'Afterdell_answer',for_id,0);
	
	$('.button_yes_no').hide(); $('.save_booking').show();
});



//удалить платежку кнопка в форме удалить
	$('#button_dell_buy').on( "click", function() {

		var for_id=$('.h111').attr('for');


		//clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
		//$.arcticmodal('close');

		var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
		AjaxClient('tours','dell_buy','GET',data,'Afterdell_buy',for_id,0);


		$('.js-dell-buy-trips-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
	});

	
	
//удалить предложение
$('#button_dell_offers').on( "click", function() {	
	
	var for_id=$('.h111').attr('for');

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
    AjaxClient('booking','dell_offers','GET',data,'Afterdell_offers',for_id,0);

	$('.button_yes_no').hide(); $('.save_booking').show();
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
	
	
$('#yes1').on( "click", function() {


  //ñìîòðèì çàïîëíåíû ëè îáÿçàòåëüíûå ïîëÿ
   var email = $("#email_formi").val();
   var err = [0,0];
  
   $("#email_formi").removeClass('error_formi');
   $("#password_formi").removeClass('error_formi');
  
    if(email != '')
    {
		/*
    if(isValidEmailAddress(email))
    {  
	
	
	} else
	{
		$("#email_formi").addClass('error_formi');
		err[0]=1;
	}
	*/
	} else
	{
		$("#email_formi").addClass('error_formi');
		err[0]=1;		
	}
	if(($("#password_formi").val()=='')||($("#password_formi").val()==0))
	{
		$("#password_formi").addClass('error_formi');
		err[1]=1;
	}
	
	if((err[0]==0)&&(err[1]==0))
	{
	   $('#pod_form').submit();	
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
	
//добавить раздел в себестоимости
$('#yes_ra').on( "click", function() {
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
	$('#yes_ra').hide().after('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');	
		
		

AjaxClient('prime','add_razdel','GET',data,'AfterRA',for_id,0);		
	}
});	

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
	
//удалить раздел в себестоимости	
$('#yes_rd').on( "click", function() {

	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	var for_id=$('.h111').attr('for');	
var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');



AjaxClient('prime','dell_razdel','GET',data,'AfterRD',for_id,0);		
	
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

//кнопка редактировать задачи
$('#no_rdx_task').on( "click", function() {
	var form_move=$('.form003U');
	
	
	form_move.find('.js-tabs_0').hide();
	form_move.find('.jipp_fll').slideDown( "slow" );
	form_move.find('.jipp_fll_start').slideUp( "slow" );
	form_move.find('.js-edit-task-f-003U').trigger('keyup');
	 ToolTip();
	
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


	
$('.del_basket_joo').bind("change keyup input click", del_basket_joo);		
$('.del_basket_joo1').bind("change keyup input click", del_basket_joo1);	
	
//делаем поля с классом только целыми числами
$('.count_mask_cel').bind("change keyup input click", validate_cel);	



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

$('.price_xvg_,.count_xvg_').bind("change keyup input click", itogprice_xvg);	
	
	
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




function js_type_finance_edit()
{
	if($(this).val()==3)
	{
		$('.js-vid-oper').slideUp("slow");
		$('.js-form-pay-finance-edit .password_turs').slideUp("slow");
	} else
	{
		$('.js-vid-oper').slideDown("slow");
		$('.js-form-pay-finance-edit .password_turs').slideDown("slow");
	}

}

function js_type_finance()
{
	if($(this).val()==3)
	{
$('.js-vid-oper').slideUp("slow");
$('.js-form-pay-finance .password_turs').slideUp("slow");
	} else
	{
		$('.js-vid-oper').slideDown("slow");
		$('.js-form-pay-finance .password_turs').slideDown("slow");
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

function AfterAddCommentTask(data,update)
{
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }	
	
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
		var form_move=$('.form'+update[1]);
		
	   form_move.find('.js-add-comment-yes').show();
		form_move.find('.js-exit-form-comm-task').show();
		
		
	   form_move.find('.b_loading_small').remove();
		
		
	   
	   form_move.find('.js-ssay').slideUp( "slow" );
	   form_move.find('.js-add-comment-task').slideDown( "slow" );
		
		
	   form_move.find('.js-comment-add-'+update[1]).val('');
		
	   form_move.find('.js-ssay').after(data.echo);	
		setTimeout ( function () { form_move.find( '.new-say ' ).removeClass('new-say '); }, 4000 );
		ToolTip();
		
		form_move.find('.js-message-com-t').slideUp("slow");
	}
}


function Afterdell_users(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{


		alert_message('ok','Пользователь удален');



		var block_count=parseInt($('.js-count-users .smena_').text());
		block_count--;
		$('.js-count-users .smena_').empty().append(block_count);
		//alert(data.blocks);
		$('.js-count-users').after(data.blocks);

		var tytt=PadejNumber((block_count),'Пользователь,Пользователя,Пользователей');
		$('.js-count-users .smena_1').empty().append(tytt);

		if(block_count==0)
		{
			$('.js-cloud-users .help_div').slideDown("slow");
			$('.js-cloud-users .js-count-users').slideUp("slow");
		}



		$('.users_block[op_rel='+update+']').slideUp("slow", function() {
			$('.users_block[op_rel=' + update + ']').remove();
		});

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
		clearInterval(timerId);
		$.arcticmodal('close');


	}
}


function AfterAddSay(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
	   $('.add_say_yes').find('.js-add-say-yes').show();
		$('.add_say_yes').find('.js-exit-form-say').show();
		$('.add_say_yes').find('.js-add-task-butt').show();
		
		
	   $('.add_say_yes').find('.b_loading_small').remove();
		
	   $('[name=task_time]').val('');
		$('[name=task_date]').val('');
		$('[name=radio_task_select]').val('0');
		$('.task_cb').find('i').removeClass('active_task_cb');
		$('.form-task-02').hide();
		$('[name=date_sele_task]').val('');
		
	   
	   $('.js-ssay').slideUp( "slow" );
	   $('.js-add_say_cbb').slideDown( "slow" );
		
		
	   $('#otziv_area_say').val('');
		
	   $('.js-ssay').after(data.echo);	
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say '); }, 4000 );
		ToolTip();
		
		$('.js-message-say').slideUp("slow");
		UpdateGlobal(update,'0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');
	}
}


function AfterEditCommTask(data,update)
{
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }	
	
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
		//alert(update[1]);
	    $('.comm-task-block[rel_notib="'+update[0]+'"]').after(data.echo);	
		
		$('.new-say').prev('.comm-task-block').remove();
		
		
		
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say'); }, 4000 );
		
		
		$('.js-message-com-t').slideUp("slow");
		

		
		
		
		$( '.arcticmodal-close', $('.form'+update[1])).click();
		
		
						if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
				update=$('.comm-task-block[rel_notib="'+update[0]+'"]').parents('.form003U').find('.h111').attr('for');
			   UpdateTaskBi(update);
			}
	}
}

function AfterEditSay(data,update)
{
			if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
	    $('.say_say_cb[rel_notib='+update+']').after(data.echo);	
		
		$('.new-say').prev('.say_say_cb').remove();
		
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say'); }, 4000 );
		
		$('.js-message-say').slideUp("slow");
		$( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();
		UpdateGlobal(data.id_cl,'0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');
	}
}

function AfterEditSel(data,update)
{
			if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
	    $('.js-selection_cb[rel_notib='+update+']').after(data.echo);	
		
		$('.new-say').prev('.js-selection_cb').remove();
		
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say'); }, 4000 );
		
		$('.js-message-selection').slideUp("slow");
		$( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();
	}
}


function AfterAddSel(data,update)
{
	/*
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }
	*/
	//alert(update[1]);
	
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
		 
		
	   $('.add_sel_yes').find('.js-add-sel').show();
		$('.js-add-task-butt').show();
		$('.js-exit-form-sel').show();
		
	   $('.add_sel_yes').find('.b_loading_small').remove();
	   
	   $('.js-ssel').slideUp("slow"); 
	   $('.js-add_sel_cbb').slideDown("slow"); 
	   $('#otziv_area_adaxx299').val('');
	   $('[name=link_selection]').val('');
		
		$('[name=task_time]').val('');
		$('[name=task_date]').val('');
		$('[name=radio_task_select]').val('0');
		$('.task_cb').find('i').removeClass('active_task_cb');
		$('.form-task-02').hide();
		$('[name=date_sele_task]').val('');
		
	   $('.js-ssel').after(data.echo);	
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say '); }, 4000 );
		ToolTip();
		
		$('.js-message-selection').slideUp("slow");
		
	}
}


//постфункция получения еще комментариев по задаче
function AfterCommTaskEshe(data,update)
{
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }		
	
	var form_move=$('.form'+update[1]);
	
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
		form_move.find('.js-cb_eshe_comm_task').before(data.echo);
		if(data.eshe==1)
			{
		       
				form_move.find('.js-cb_eshe_comm_task').attr('pg',data.pg).empty().append('<span>показать еще</span>');
			} else
			{
				form_move.find('.js-cb_eshe_comm_task').hide();	
			}
		ToolTip();
	}
}

function AfterSayEshe(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
		$('.cb_eshe').before(data.echo);
		if(data.eshe==1)
			{
		       
				$('.cb_eshe').attr('pg',data.pg).empty().append('<span>показать еще</span>');
			} else
			{
				$('.cb_eshe').hide();	
			}
		ToolTip();
	}
}

function AfterSelEshe(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='ok' )
    {
		$('.cb_eshe_sel').before(data.echo);
		if(data.eshe==1)
			{
		       
				$('.cb_eshe_sel').attr('pg',data.pg).empty().append('<span>показать еще</span>');
			} else
			{
				$('.cb_eshe_sel').hide();	
			}
		ToolTip();
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

//постфункция добавления задачи
function after_add_task_yes(d,u)
{
	if ( d.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( d.status=='ok' )
    {
		 clearInterval(timerId); 
	      $.arcticmodal('close');
		
			if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
			   UpdateTaskBiAdd(d.new);
				//$('.js-global-task-link')
				jQuery.scrollTo('.js-global-task-link', {offset:-100});
			}
		
	}
	if(d.status=='error')
    {
	$('.js-exit-window-add-task').show();
		
	$('.js-add-task-but-x').show()
	$('.js-add-task-but-x').next().remove();
	var text_bb22 = $('.js-add-task-but-x').text();
				$('.js-add-task-but-x').empty().append('Ошибка заполнения!');
				$('.js-add-task-but-x').addClass('new-say1');
				setTimeout ( function () { $('.js-add-task-but-x').removeClass('new-say1'); $('.js-add-task-but-x').empty().append(text_bb22);  }, 4000 );
	
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

//постфункция добавление нового счета
function AfterAACC(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		
	   //удалить все из кукки по этому счету и убрать все выделения
		var iu=$('.content_block').attr('iu');
		
		//пройтись по кукка этого счета и добавить иконки о новом счете в нужные места
		
			var cc = $.cookie('basket_supply_'+iu).split('.');
	for ( var t = 0; t < cc.length; t++ ) 
	{ 	
		$('[supply_id='+cc[t]+']').find('.scope_scope').append('<div rel_score="'+data.ty+'" class="menu_click score_a"><i>'+cc.length+'</i><span>№'+update+'</span><strong><label>'+data.summa+'</label></strong></div><div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left: -50px; top: 5px; transform: scaleY(0);"><li><a href="javascript:void(0);" rel="1">Открыть</a></li><li><a href="javascript:void(0);" rel="2">Сделать текущим</a></li><li><a href="javascript:void(0);" rel="3">Согласовать</a></li><li><a href="javascript:void(0);" rel="4">Удалить</a></li></ul><input rel="x" name="vall" class="option_score1" value="0" type="hidden"></div>');
		
		var hf=$('[supply_id='+cc[t]+']').attr('supply_stock');
		var hf1=hf.split('_');
		//alert(hf1);
		UpdateStatusADA(hf1[0]);
		
	}
		
	    $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
	    $('.checher_supply').removeClass('checher_supply');
		basket_supply();  
		
       //показать панель для загрузки фото к договору
		$('.new_qqe').empty().append('Счет №'+update);
		$('.soply_step_1').hide();
		$('.img_ssoply').show();
		$('.hop_lalala').find(".loader_inter").before('<div id_upload="'+data.ty+'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'+data.ty+'" id_sc="'+data.ty+'" name="upload'+data.ty+'"><input class="sc_sc_loo11" type="file" name="myfile'+data.ty+'"></form><div class="loaderr_scan scap_load_'+data.ty+'" style="width:100%"><div class="scap_load__" style="width: 0%;"></div></div>');
		
		$('.hop_lalala').find(".loader_inter").remove();
		
	}
	
	if(data.status=='error')
    {
	$('.hop_lalala').find(".loader_inter").remove();
		
	$('#no_rd').show();
	//$('.box-soply').find('._50_x').show();
	}
}

function AfterDellSel(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		$('.js-selection_cb[rel_notib='+update+']').remove();
	} else
		{
			$('.js-selection_cb[rel_notib='+update+']').show();
		}
}

function AfterDellSay(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		$('.say_say_cb[rel_notib='+update+']').remove();
		
		UpdateGlobal(data.id_cl,'0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');
	} else
		{
			$('.say_say_cb[rel_notib='+update+']').show();
		}
}


function Afteradd_info_org(data,update)
{
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {

		
	var for_id=data.id;
	
	if($('.box-modal [name=posta]').length > 0)
		{
		//обычного пользователя значит
			
					var fun= $('.box-modal [name=posta]').val();
                    $.globalEval(fun+'_uma(2,'+for_id+')');	
		
		} else
		{	
			
			
		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');			
		
		
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_org.php?id='+for_id+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	
	$('.add-next-org').after(data.temp);	
		setTimeout ( function () { $( '.new-block ' ).removeClass('new-block '); }, 4000 );	
		
		}
	}
}


function Afteradd_info_client(data,update)
{
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	var for_id=data.id;	
		//проверяем добавлять потенциального или нет
	if(($('[name=radio_potential]').val()==0)&&($('.box-modal [name=posta]').length > 0))
		{
		//обычного пользователя значит
			
					var fun= $('.box-modal [name=posta]').val();
                    $.globalEval(fun+'_uma(1,'+for_id+')');	
		
		} else
			{
		
			if($('.box-modal [name=posta]').length > 0)
			{
					clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
			} else
				{
				
		
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
		
	
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_user.php?id='+for_id+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
	    if (($('.add-next-user').length > 0)&&(data.poten==0))
			   {
			   $('.add-next-user').after(data.temp);
			   }
			    if (($('.add-next-poten').length > 0)&&(data.poten==1))
			   {
			   $('.add-next-poten').after(data.temp);
			   }

		setTimeout ( function () { $( '.new-block ' ).removeClass('new-block '); }, 4000 );		
	  }
			}
	}
}




function Aftersave_info_org(data,update)
{
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
		
	var for_id=data.id;
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_org.php?id='+for_id+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
		
			if($('.js-buy-my-tours').length > 0) 
		{
			//значит это внутренность или добавление нового тура
		   UpdateGlobalO(for_id,'1,0,0,1,1,1,1,1,1,1,1,1,1');
		} else
		{	
		
	UpdateGlobalO(for_id,'1,1,1,0,0,0,0,0,0,0,0,0,0');	
		}
		
	}
}

function AfterEditInfoTask(data,update)
{
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }	
	
	
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	var for_id=update[0];	
	var form_move=$('.form'+update[1]);	
		
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
		
	//var for_id=update[0];
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_task.php?id='+for_id+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
	
	//обновить информацию на общем экране если есть такой вывод
	//UpdateUserGlobal(for_id);	
		
		
		if($('.js-buy-my-tours').length > 0) 
		{
			//значит это внутренность или добавление нового тура
		   UpdateGlobal(for_id,'1,1,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1');
		} else
		{
		   UpdateGlobal(for_id,'1,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0');
		}
		
				if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
			   UpdateTaskBi(for_id);
			}
		
		
	}
}

function Aftersave_info_client(data,update)
{
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');	
		
	var for_id=data.id;
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_user.php?id='+for_id+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
	
	//обновить информацию на общем экране если есть такой вывод
	//UpdateUserGlobal(for_id);	
		
		
		if($('.js-buy-my-tours').length > 0) 
		{
			//значит это внутренность или добавление нового тура
		   UpdateGlobal(for_id,'1,1,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1');
		} else
		{
		   UpdateGlobal(for_id,'1,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0');
		}
		
		
	}
}

function AfterTabsInfoAdd(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	    $('.client_window .px_bg').empty().append(data.query);
		
		$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);
		
		$('.js-tabs_docc').hide();
		$('.js-tabs_'+update).show();
		ToolTip();
		
		input_2018();

	}
}

function AfterTabsInfoOrg(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	    $('.client_window .px_bg').empty().append(data.query);
		
		$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);
		
		$('.js-tabs_docc').hide();
		$('.js-tabs_'+update).show();
		ToolTip();
		NumberBlockFile();
	}
}



//постфункция вкладки в форме о задаче
function AfterTabsInfoTask(data,update)
{
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }	
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
	    $('.form'+update[1]+' .px_bg').empty().append(data.query);
		
		$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);
		
		$('.form'+update[1]+' .js-tabs_docc').hide();
		$('.form'+update[1]+' .js-tabs_'+update[0]).show();
		ToolTip();
				if((update[0]==3)||(update[0]==4))
			{
						$(".slct").unbind('click.sys');
		$(".slct").bind('click.sys', slctclick);
		$(".drop").find("li").unbind('click');
		$(".drop").find("li").bind('click', dropli);
			 $('#typesay').unbind('change', changesay);
	 $('#typesay').bind('change', changesay);
				//alert("!");
				
			}
		
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
			OLD("#table_freez_"+$('#frezezz').val()).freezeHeader({'offset' : '67px'});		
			
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

//постфункция добавление раздела в себестоимость
function AfterRA(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
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
		
	}
	if ( data.status=='number' )
    {	
	   $('#yes_ra').show();	
	   $('.loader_inter').remove();
	   $("#number_r").addClass('error_formi');
		$('#yes_ra').after('<div class="error_text">Такой номер раздела уже существует</div>');
		$("#number_r").focus();
		setTimeout ( function () { $('.error_text').remove (); }, 7000 );
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

//постфункция удаление раздела в себестоимость
function AfterRD(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		$('.block_i[rel="'+update+'"]').remove();
		//обновляем итоговую сумму последнюю
		//обновление общей итоговых сумм по дому
	    update_itog_seb();
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

//постфункция изменение оплаты по туру формы
function after_edit_buy_trips_yes(data,update)
{
	if (data.status=='ok')
	{
		// $('.js-form-tender-new').remove();

		alert_message('ok','Оплата изменена');
		//$('.js-next-step').submit();
		clearInterval(timerId);
		$.arcticmodal('close');
		UpdateTripsA(data.for_id,'buy',1);
	} else
	{
		$('.js-edit-buy-trips-but-x').show();
		$('.js-form-pay-trips .b_loading_small').remove();

		//alert_message('error','Ошибка! Заполните все поля');

		//$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['curs','sum','method','buy_date','vse_vipl_kl','no_nall','no_vozv','vse_vipl_oper','no_vozv_oper'];

			var err_name = ['некорректно заполнено - Курс ТО','некорректно заполнено - Сумма','некорректно заполнено - Способ оплаты','некорректно заполнено - Дата оплаты','Клиент уже все выплатил','Оплата только наличными','Клиенту нечего вызвращать','Оператору уже все выплатили','Оператору нечего возвращать'];



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

//постфункция изменение планов по финансам
function after_edit_price_plane_yes(data,update)
{
	if (data.status=='ok')
	{
		// $('.js-form-tender-new').remove();

		alert_message('ok','Планы изменены');
		//$('.js-next-step').submit();
		clearInterval(timerId);
		$.arcticmodal('close');
		UpdateFinance('1,0,0,0');
	} else
	{
		$('.js-edit-price-plane-but-x').show();
		$('.js-form-price-plane .b_loading_small').remove();

		//alert_message('error','Ошибка! Заполните все поля');

		//$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['sum','sum1'];

			var err_name = ['некорректно заполнено - план по доходам','некорректно заполнено - план по расходам'];



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

//постфункция изменение цен по туру формы
function after_edit_price_trips_yes(data,update)
{
	if (data.status=='ok')
	{
		// $('.js-form-tender-new').remove();

		alert_message('ok','Цены по туру изменены');
		//$('.js-next-step').submit();
		clearInterval(timerId);
		$.arcticmodal('close');
		UpdateTripsA(data.for_id,'buy',1);
	} else
	{
		$('.js-edit-price-trips-but-x').show();
		$('.js-form-price-trips .b_loading_small').remove();

		//alert_message('error','Ошибка! Заполните все поля');

		//$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['curs','sum','curs1'];

			var err_name = ['некорректно заполнено - Курс Валюты для клиента','некорректно заполнено - Сумма клиента','некорректно заполнено - Курс ТО'];



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

//постфункция изменение сроков оплаты
function after_add_srok_trips_yes(data,update)
{
	if (data.status=='ok')
	{
		// $('.js-form-tender-new').remove();

		alert_message('ok','Сроки изменены');
		//$('.js-next-step').submit();
		clearInterval(timerId);
		$.arcticmodal('close');
		UpdateTripsA(data.for_id,'buy',1);
	} else
	{
		$('.js-edit-srok-trips-but-x').show();
		$('.js-form-srok-trips .b_loading_small').remove();

		//alert_message('error','Ошибка! Заполните все поля');

		//$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['proc','date'];

			var err_name = ['некорректно заполнено - процент оплаты','некорректно заполнено - дата оплаты'];



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



//постфункция оплата по туру форма
function after_add_buy_trips_yes(data,update)
{
	if (data.status=='ok')
	{
		// $('.js-form-tender-new').remove();

		alert_message('ok','Оплата проведена');
		//$('.js-next-step').submit();
		clearInterval(timerId);
		$.arcticmodal('close');
		UpdateTripsA(data.for_id,'buy');
	} else
	{
		$('.js-add-buy-trips-but-x').show();
		$('.js-form-pay-trips .b_loading_small').remove();

		//alert_message('error','Ошибка! Заполните все поля');

		//$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['curs','sum','method','buy_date','vse_vipl_kl','no_nall','no_vozv','vse_vipl_oper','no_vozv_oper'];

			var err_name = ['некорректно заполнено - Курс ТО','некорректно заполнено - Сумма','некорректно заполнено - Способ оплаты','некорректно заполнено - Дата оплаты','Клиент уже все выплатил','Оплата только наличными','Клиенту нечего вызвращать','Оператору уже все выплатили','Оператору нечего возвращать'];



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

//постфункция изменение статуса у предложения
function Afterselect_offers(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	   if ( data.count==2 )
       {
		  $('[id_offers='+update+']').find('.span-44').addClass('active-44');
		   $('[id_offers='+update+']').find('.span-44').attr('data-tooltip','выбор клиента');
		   ToolTip();
		   
		   
	   } else
	   {
		  $('[id_offers='+update+']').find('.span-44').removeClass('active-44');
		   $('[id_offers='+update+']').find('.span-44').removeAttr('data-tooltip');
		
	   }
		
		
		
		
		
		
	}
}

function Afteryes_booking_client(data,update)
{
	//var for_id=$('.h111').attr('for');
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
			clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	       // $.arcticmodal('close');
		
	
		
		
		
	$.arcticmodal({
    type: 'ajax',
    //url: 'forms/form_bron_booking_end_all.php?id='+for_id,
	url: 'forms/form_bron_booking_end_all.php?id='+data.for_id+'&options='+data.options,		
    afterLoading: function(data, el) {
        //alert('afterLoading');
		
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
		$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
		
	}
	/*
	if(data.status=='name_yest')
	{
		$('.sk_error').empty().append('Наименование с таким названием уже есть на складе').show();
		$('#yes_add_stock').show();
		$('.loader_inter').remove();
		$('.no_add_sss').show();
	}
	*/
}

function Afterfly_edit1(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
		//alert(update);
		var as_ss = data.start.split(' ');
		$('[id_fly='+data.id+'] .c_start').find('span').empty().append(as_ss[0]+' <strong>'+as_ss[1]+'</strong>');
		
		var as_ss = data.end.split(' ');
		$('[id_fly='+data.id+'] .c_end').find('span').empty().append(as_ss[0]+' <strong>'+as_ss[1]+'</strong>');		
	}
}

function Afterfly_edit(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
		//alert(update);
		$('[id_offers='+data.id+']').find('.js-mi-x1').val(data.start);
		$('[id_offers='+data.id+']').find('.js-mi-x2').val(data.end);		
	}
}


function Afterfly_edit_trips(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		//alert(update);
		$('.trips_block_global[id_trips='+data.id+']').find('.js-mi-x1').empty().append(data.start);
		$('.trips_block_global[id_trips='+data.id+']').find('.js-mi-x2').empty().append(data.end);
		$('.trips_block_global[id_trips='+data.id+']').find('.js-mi-x1,.js-mi-x2').parents('.top_mi_n_m').slideDown("slow");



	}
}

function Afteryes_booking(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		if(data.options==0)
		{
				
		
		
		autoReload();	
		} else
			{
			
					$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_bron_booking_end_avans.php?id='+data.for_id,	
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
			$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
				
			}
	}
}

//постфункция отказались от заявки
function Afterno_booking(data,update)
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
function AfterTaskNewDate(data,update)
{
	if ( data.status=='ok' )
    {	
		
				if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
			   UpdateTaskBi(update);
			}
		
		
	}
}
function AfterTaskSend(data,update)
{
	if ( data.status=='ok' )
    {	
		
				if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
			   UpdateTaskBi(update);
			}
		
		
	}
}
function AfterTaskClose(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
		
				if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
			   UpdateTaskBi(update);
			}
		
		
	}
}
function Afteryes_task(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
//удаляем эту напоминалку
		
		$('.task_clock_selection[id_task="'+update+'"]').slideUp("slow", function() {$('.task_clock_selection[id_task="'+update+'"]').remove();});
		
		if($('.js-global-task-link').length>0)
			{
			   //значит надо обновить вид задачи
			   UpdateTaskBi(update);
				
			   if(data.new!=0)
			   {
					 UpdateTaskBiAdd(data.new);   
			   }
				
				
			}
		
		
	}
}

function Afteradd_comment(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
		if ($('.add_cff').length > 0) {
			$('[id_offers='+update+']').find('.add_cff').remove();
			$('[id_offers='+update+']').removeClass('grey_coi');
		} else
			{
		
	  $('[id_offers='+update+']').find('.comment_offers').empty().append(data.commm);			
			}
		
	  ToolTip();		  
	}
}

function Afteradd_answer(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
	  $('.add_sourse_reports').before(data.echo);	
		
		
	  var count_offers= $("[op_rel]").length;																
	  $('.smena_').empty().append(count_offers);
	  
      var tytt=PadejNumber((count_offers),'вопрос к отчету,вопроса к отчету,вопросов к отчету');													
	  $('.smena_1').empty().append(tytt);			
	  
		
	  ToolTip();	
	  
	}
}

function Afterdell_org(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('[op_rel='+update+']').slideUp("slow", function() {$('[op_rel='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
															
															
      var count_offers= parseInt($(".yop_booking").find('i').text());
		count_offers=count_offers-1;													
	  $('.yop_booking i').empty().append(count_offers);
	  
      var tytt=PadejNumber(count_offer,'найденная организация,найденных организации,найденных организаций');													
	  $('.yop_booking span').empty().append(tytt);														   
    });
	
		
		
		
	}
}

function Afterdell_clients(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('[op_rel='+update+']').slideUp("slow", function() {$('[op_rel='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
															
															
      var count_offers= parseInt($(".yop_booking").find('i').text());
		count_offers=count_offers-1;													
	  $('.yop_booking i').empty().append(count_offers);
	  
      var tytt=PadejNumber(count_offer,'найденный клиент,найденных клиента,найденных клиентов');													
	  $('.yop_booking span').empty().append(tytt);														   
    });
	
		
		
		
	}
}

function Afterdell_booking(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('[rel_notib='+update+']').slideUp("slow", function() {$('[rel_notib='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
															
															
      var count_offers= parseInt($(".yop_booking").find('i').text());
		count_offers=count_offers-1;													
	  $('.yop_booking i').empty().append(count_offers);
	  
      var tytt=PadejNumber(count_offer,'найденная заявка,найденные заявки,найденных заявок');													
	  $('.yop_booking span').empty().append(tytt);														   
    });
	
		
		
		
	}
}

function Afterdell_reports(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('.reports_block[op_rel='+update+']').slideUp("slow", function() {$('.reports_block[op_rel='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
      var count_offers= $(".reports_block").length;	
																
	  $('.smena_').empty().append(count_offers);
	  
      var tytt=PadejNumber((count_offers),'отчет,отчета,отчетов');													
	  $('.smena_1').empty().append(tytt);														   
    });
	
		
		
		
	}
}



/*
function Afterdell_users(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('.users_block[op_rel='+update+']').slideUp("slow", function() {$('.users_block[op_rel='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
      var count_offers= $(".users_block").length;	
																
	  $('.smena_').empty().append(count_offers);
	  
      var tytt=PadejNumber((count_offers),'работник,работника,работников');													
	  $('.smena_1').empty().append(tytt);														   
    });
	
		
		
		
	}
}
*/
function Afterdell_operator(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('.operator_block[op_rel='+update+']').slideUp("slow", function() {$('.operator_block[op_rel='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
      var count_offers= $(".operator_block").length;	
																
	  $('.smena_').empty().append(count_offers);
	  
      var tytt=PadejNumber((count_offers),'туроператор,туроператора,туроператоров');													
	  $('.smena_1').empty().append(tytt);														   
    });
	
		
		
		
	}
}

function Afteredit_answer(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('[op_rel='+update+']').find('.h57 span').empty().append(data.echo);
															   
	
	
		
		
		
	}
}

function Afterdell_answer(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('[op_rel='+update+']').slideUp("slow", function() {$('[op_rel='+update+']').remove(); 
															   
		

      var count_offers= $("[op_rel]").length;																
	  $('.smena_').empty().append(count_offers);
	  
      var tytt=PadejNumber((count_offers),'вопрос к отчету,вопроса к отчету,вопросов к отчету');													
	  $('.smena_1').empty().append(tytt);																	 
															 
    });
	
		
		
		
	}
}


//постфункция удаления операции по оплате в туре
function Afterdell_buy(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{

var for_id=$('.buy_block_global[id_buy='+update+']').parents('.trips_block_global').attr('id_trips');
		$('.buy_block_global[id_buy='+update+']').slideUp("slow", function() {
			$('.buy_block_global[id_buy=' + update + ']').remove();
		});

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
			alert_message('ok','Оплата удалена');
			//$('.js-next-step').submit();
			clearInterval(timerId);
			$.arcticmodal('close');
			UpdateTripsA(for_id,'buy');


	}
}

//постфункция удаления операции по оплате
function Afterdell_offers(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
	
		$('[id_offers='+update+']').slideUp("slow", function() {$('[id_offers='+update+']').remove(); 
															   
		
//пересчитываем общее количество предложений
      var count_offers= $("[id_offers]").length;																
	  $('.count_offers_ajax').empty().append(count_offers-1);
	  
      var tytt=PadejNumber((count_offers-1),'предложение,предложения,предложений');													
	  $('.padej_offers').empty().append(tytt);														   
    });
	
		
		
		
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

//постфункция редактирование раздела в себестоимости
function AfterRE(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	if ( data.status=='number' )
    {	
	   $('#yes_re').show();	
	   $('.loader_inter').remove();
	   $("#number_r").addClass('error_formi');
		$('#yes_re').after('<div class="error_text">Такой номер раздела уже существует</div>');
		$("#number_r").focus();
		setTimeout ( function () { $('.error_text').remove (); }, 7000 );
	}	
	if ( data.status=='ok' )
    {
		
		$('.block_i[rel="'+update+'"]').find('.top_bl').find('h2').empty().append(data.echo);
		clearInterval(timerId); 
	    $.arcticmodal('close');
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
		  $.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
		  $.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false});
		  $.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false});
		
		$('.current_score').find('.number_score').empty();
		$('.current_score').find('.count_numb_score').empty();
		$('.current_score').hide();
		$('.more_supply2').hide();
		
		$('.checher_supply').removeClass('checher_supply');
		$('.score_active').removeClass('score_active');
	  }
		
	}
	if ( data.status=='error' )
    {
		
	}
}

//меню выбора исполнителя при добавлении работы 	
window.yesform=1;









$(function (){

//добавление объекта с проверкой в форме
    //$('.box-modal').on("change keyup input click",'.js-add-invoice-but-x',add_invoice_yes);

    $('.box-modal').on("click",'.js-add-invoice-but-x',AddinvoiceX);



//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-invoice-x',edit_invoice_yes);


//удалить объект с проверкой в форме
    $('.js-dell-invoice-b').on( "click", function() {

        var for_id=$('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');

        AjaxClient('invoice','dell','GET',data,'Afterdell_invoice',for_id,0);





        $('.js-dell-invoice-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


});



/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */
function Afterdell_invoice(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Счет удален');



        var block_count=parseInt($('.js-count-invoice .smena_').text());
        block_count--;
        $('.js-count-invoice .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-invoice').after(data.blocks);

        var tytt=PadejNumber((block_count),'счет,счета,счетов');
        $('.js-count-invoice .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-invoice .help_div').slideDown("slow");
            $('.js-cloud-invoice .js-count-invoice').slideUp("slow");
        }



        $('.invoice_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.invoice_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}


/*
 * постфункцию получение информации по нажатию на вкладку об объекте
 * @param data
 * @param update
 * @constructor
 */
function AfterTabsInfoinvoice(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        //alert("!");
        $('.js-cloud-info-text').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        $('.js-tabs_docc').hide();
        $('.js-tabs_'+update).show();
        ToolTip();
        //NumberBlockFile();
        if(update==2)
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            $('#typesay').unbind('change', changesay);
            $('#typesay').bind('change', changesay);
            NumberBlockFile();

        }
    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_invoice(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Счет изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.invoice_block_pass[op_rel=' + data.update + ']').addClass('remove-invoice-x')
        $('.invoice_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.invoice_block_pass.remove-invoice-x').remove();


        setTimeout ( function () { $('.invoice_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

        var arrs=data.arr.join('.');
        UpdateItems(arrs);



    } else
    {
        $('.js-edit-invoice-x').show();
        $('.js-form-edit-invoice').parents('.box-modal').find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['number_i','office','date_i'];

            var err_name = ['некорректно заполнен - Номер счета','некорректно заполнен - офис','некорректно заполнена - Дата в счете'];

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
function AddinvoiceX()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
   // alert("!!");
    $('.js-form-add-invoice .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-invoice-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('invoice','add','POST',0,'after_add_invoice',0,'vino_xd_fiance_pay');


        $('.box-modal .js-add-invoice-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



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

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */


/*
 * постфункция Добавление объекта
 */
function after_add_invoice(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Счет добавлен');



        var block_count=parseInt($('.js-count-invoice .smena_').text());
        block_count++;
        $('.js-count-invoice .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-invoice').after(data.blocks);

        var tytt=PadejNumber((block_count),'Счет,Счета,Счетов');
        $('.js-count-invoice .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.invoice_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-invoice .help_div').slideUp("slow");
        $('.js-cloud-invoice .js-count-invoice').slideDown("slow");

        clearInterval(timerId);
        $.arcticmodal('close');

    } else
    {

        $('.js-add-invoice-but-x').show();
        $('.js-form-add-invoice').parents('.box-modal').find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['number_i','office','date_i'];

            var err_name = ['некорректно заполнен - Номер счета','некорректно заполнен - офис','некорректно заполнена - Дата в счете'];



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
function edit_invoice_yes()
{

    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-edit-invoice .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-invoice-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('invoice','edit','POST',0,'after_edit_invoice',0,'vino_xd_fiance_pay');


        $('.box-modal .js-edit-invoice-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}



$(function (){


});
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


$(function (){

//добавление объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-add-pass-but-x',add_pass_yes);
//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-pass-but-x',edit_pass_yes);



//открыть доступ по пропуску нажатие кнопки в форме
    $('.js-noblock-pass-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('pass','noblock','GET',data,'Afternoblock_pass',for_id,0);


        $('.js-noblock-pass-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });
//заблокировать пропуск нажатие кнопки в форме
    $('.js-block-pass-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('pass','block','GET',data,'Afterblock_pass',for_id,0);


        $('.js-block-pass-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });

//печать нажатие в форме далее
    $('.js-print-pass-b').on( "click", function() {

        $('.js-form-pay-print').submit();
        //полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');

    });


//утверждение нажатие кнопки в форме
    $('.js-yes-pass-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('pass','yes','GET',data,'Afteryes_pass',for_id,0);


        $('.js-yes-pass-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });

    //отправить на продление на кнопку в форме продления
    $('.js-extend-pass-b').on( "click", function() {

        var for_id=$('.h111').attr('for');



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
            var start_y=$('.js-form-pay-finance-edit').find('[name=start]').val();
            var end_y=$('.js-form-pay-finance-edit').find('[name=end]').val();

            //изменить кнопку на загрузчик
            var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&start='+start_y+'&end='+end_y;
            AjaxClient('pass','extend','GET',data,'Afterextend_pass',for_id,0);


            $('.js-extend-pass-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        }else
        {

            alert_message('error','Ошибка. Не все поля заполнены!');

        }

        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');


    });

//отправить на утверждение нажатие кнопки в форме
    $('.js-send-pass-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('pass','send','GET',data,'Aftersend_pass',for_id,0);


        $('.js-send-pass-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


//удалить объект с проверкой в форме
    $('.js-dell-pass-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('pass','dell','GET',data,'Afterdell_pass',for_id,0);


        $('.js-dell-pass-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


});




/*
 * постфункция продления пропуска
 * @param data
 * @param update
 * @constructor
 */
function Afterextend_pass(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        alert_message('ok','Пропуск продлен');

        $('.block_pass[pass_rel=' + data.update + ']').addClass('remove-object-x')


        $('.block_pass[pass_rel=' + data.update + ']').after(data.blocks);
        $('.block_pass.remove-object-x').remove();
        setTimeout ( function () { $('.block_pass').removeClass('new-say'); }, 4000 );

        animation_teps();


//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');
    }
    if( data.status=='error' )
    {
        $('.js-extend-pass-b').show();
        $('.box-modal .b_loading_small').remove();
    }
}

/*
 * постфункция открытия блокировки пропуска
 * @param data
 * @param update
 * @constructor
 */
function Afternoblock_pass(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Доступ по пропуску восстановлен');

        $('.block_pass[pass_rel=' + data.update + ']').addClass('remove-object-x')


        $('.block_pass[pass_rel=' + data.update + ']').after(data.blocks);
        $('.block_pass.remove-object-x').remove();
        setTimeout ( function () { $('.block_pass').removeClass('new-say'); }, 4000 );

        animation_teps();


//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
    if( data.status=='error' )
    {
        $('.js-noblock-pass-b').show();
        $('.box-modal .b_loading_small').remove();
    }
}

/*
 * постфункция блокировки пропуска
 * @param data
 * @param update
 * @constructor
 */
function Afterblock_pass(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Пропуск заблокирован');

        $('.block_pass[pass_rel=' + data.update + ']').addClass('remove-object-x')


        $('.block_pass[pass_rel=' + data.update + ']').after(data.blocks);
        $('.block_pass.remove-object-x').remove();
        setTimeout ( function () { $('.block_pass').removeClass('new-say'); }, 4000 );

        animation_teps();


//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
    if( data.status=='error' )
    {
        $('.js-block-pass-b').show();
        $('.box-modal .b_loading_small').remove();
    }
}

/*
 * постфункция пропуска утверждение
 * @param data
 * @param update
 * @constructor
 */
function Afteryes_pass(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Пропуск утверждение');

        $('.block_pass[pass_rel=' + data.update + ']').addClass('remove-object-x')


        $('.block_pass[pass_rel=' + data.update + ']').after(data.blocks);
        $('.block_pass.remove-object-x').remove();
        setTimeout ( function () { $('.block_pass').removeClass('new-say'); }, 4000 );

        animation_teps();


//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
    if( data.status=='error' )
    {
        $('.js-yes-pass-b').show();
        $('.box-modal .b_loading_small').remove();
    }
}

/*
 * постфункция отпавки пропуска на утверждение
 * @param data
 * @param update
 * @constructor
 */
function Aftersend_pass(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Пропуск отправлен на утверждение');

        $('.block_pass[pass_rel=' + data.update + ']').addClass('remove-object-x')


        $('.block_pass[pass_rel=' + data.update + ']').after(data.blocks);
        $('.block_pass.remove-object-x').remove();
        setTimeout ( function () { $('.block_pass').removeClass('new-say'); }, 4000 );

        animation_teps();


//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
    if( data.status=='error' )
    {
        $('.js-send-pass-b').show();
        $('.box-modal .b_loading_small').remove();
    }
}



/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */
function Afterdell_pass(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Пропуск удален');



        var block_count=parseInt($('.js-count-pass .smena_').text());
        block_count--;
        $('.js-count-pass .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-pass').after(data.blocks);

        var tytt=PadejNumber((block_count),'пропуск,пропуска,пропусков');
        $('.js-count-pass .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-pass .help_div').slideDown("slow");
            $('.js-cloud-pass .js-count-pass').slideUp("slow");
        }



        $('.block_pass[pass_rel='+update+']').slideUp("slow", function() {
            $('.block_pass[pass_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
    if( data.status=='error' )
    {
        $('.js-dell-pass-b').show();
        $('.box-modal .b_loading_small').remove();
    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_pass(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Пропуск изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.block_pass[pass_rel=' + data.update + ']').addClass('remove-object-x')
        $('.block_pass[pass_rel=' + data.update + ']').after(data.blocks);
        $('.block_pass.remove-object-x').remove();

/*
        $('.block_pass[pass_rel=' + data.update + ']').remove();

        $('.js-count-pass').after(data.blocks);
    */
        setTimeout ( function () { $('.block_pass').removeClass('new-say'); }, 4000 );

        clearInterval(timerId);
        $.arcticmodal('close');
        animation_teps();
    } else
    {
        $('.js-edit-pass-but-x').show();
        $('.js-form-pay-finance-edit .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


          var err = ['name','img','start','end','org','object','role','phone'];

          var err_name = ['некорректно заполнено - ФИО','не загружена фотография', 'некорректно заполнена - дата начала', 'некорректно заполнена - дата окончания','некорректно заполнена - организация','некорректно заполнен - объект','некорректно заполнена - должность','некорректно заполнен - телефон'];




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
 * постфункция Добавление объекта
 */
function after_add_pass_yes(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Пропуск добавлен');



        var block_count=parseInt($('.js-count-pass .smena_').text());
        block_count++;
        $('.js-count-pass .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-pass').after(data.blocks);

        var tytt=PadejNumber((block_count),'пропуск,пропуска,пропусков');
        $('.js-count-pass .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-pass .help_div').slideUp("slow");
        $('.js-cloud-pass .js-count-pass').slideDown("slow");


        clearInterval(timerId);
        $.arcticmodal('close');


    } else
    {
        $('.js-add-pass-but-x').show();
        $('.js-form-pay-finance .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['name','img','start','end','org','object','role','phone'];

            var err_name = ['некорректно заполнено - ФИО','не загружена фотография', 'некорректно заполнена - дата начала', 'некорректно заполнена - дата окончания','некорректно заполнена - организация','некорректно заполнен - объект','некорректно заполнена - должность','некорректно заполнен - телефон'];



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
function edit_pass_yes()
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
    var photo=$('.js-hidden-kod-img');
    if ((photo.val() == '') || (photo.val() == 0)) {
        $('.upload_img_pass .cover--2').addClass('error-photo');
        err++;
    } else {
        $('.upload_img_pass .cover--2').removeClass('error-photo');
    }


    if(err==0)
    {

        //изменить кнопку на загрузчик
        $('.js-edit-pass-but-x').hide();

        $('.js-edit-pass-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('pass','edit','POST',0,'after_edit_pass',0,'vino_xd_fiance_pay_edit');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */
function add_pass_yes()
{

    var err = 0;

    $('.js-form-pay-finance .gloab').each(function (i, elem) {

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

    var photo=$('.js-hidden-kod-img');
    if ((photo.val() == '') || (photo.val() == 0)) {
    $('.upload_img_pass .cover--2').addClass('error-photo');
        err++;
    } else {
        $('.upload_img_pass .cover--2').removeClass('error-photo');
    }


    if(err==0)
    {

        //изменить кнопку на загрузчик
        $('.js-add-pass-but-x').hide();

        $('.js-add-pass-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('pass','add','POST',0,'after_add_pass_yes',0,'vino_xd_fiance_pay');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

$(function (){

//добавление объекта с проверкой в форме
    //$('.box-modal').on("change keyup input click",'.js-add-person-but-x',add_person_yes);

    $('.box-modal').on("click",'.js-add-person-but-x',AddPersonX);


    //получение списка отделов по определенному офису
    $('.box-modal').on("change",'.js-office-x',SelectOffice);

//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-person-x',edit_person_yes);


//удалить объект с проверкой в форме
    $('.js-dell-person-b').on( "click", function() {

        var for_id=$('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');

        AjaxClient('person','dell','GET',data,'Afterdell_person',for_id,0);





        $('.js-dell-person-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


});



/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */
function Afterdell_person(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Ответственный удален');



        var block_count=parseInt($('.js-count-person .smena_').text());
        block_count--;
        $('.js-count-person .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-person').after(data.blocks);

        var tytt=PadejNumber((block_count),'ответственный,ответственных,ответственных');
        $('.js-count-person .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-person .help_div').slideDown("slow");
            $('.js-cloud-person .js-count-person').slideUp("slow");
        }



        $('.person_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.person_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}


/*
 * постфункцию получение информации по нажатию на вкладку об объекте
 * @param data
 * @param update
 * @constructor
 */
function AfterTabsInfoPerson(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        //alert("!");
        $('.js-cloud-info-text').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        $('.js-tabs_docc').hide();
        $('.js-tabs_'+update).show();
        ToolTip();
        //NumberBlockFile();
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
 * постфункция изменение объекта
 */
function after_edit_person(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Ответственный изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.person_block_pass[op_rel=' + data.update + ']').addClass('remove-person-x')
        $('.person_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.person_block_pass.remove-person-x').remove();


        setTimeout ( function () { $('.person_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        $('.js-edit-person-x').show();
        $('.js-form-edit-person').parents('.box-modal').find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['name_person','office','section','floor','number_room'];

            var err_name = ['некорректно заполнено - Фио','некорректно заполнен - офис','некорректно заполнен - отдел','некорректно заполнен - этаж','некорректно заполнен - номер комнаты'];

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
function AddPersonX()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
   // alert("!!");
    $('.js-form-add-person .gloab').each(function(i,elem) {
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

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('person','add','POST',0,'after_add_person',0,'vino_xd_fiance_pay');


        $('.box-modal .js-add-person-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }


}

function SelectOffice()
{
    $('.js-load-select-section').empty().append('<div class="b_loading_small" style="position:relative; width: 40px;padding-bottom: 15px; margin-top:-15px; top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


    var data ='url='+window.location.href+'&id='+$(this).val();

    AjaxClient('person','select_office','GET',data,'AfterSelectOffice',$(this).val(),0,1);




}


/*
 * изменение объекта нажатие на кнопку в форме
 */

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */


/*
 * постфункция Добавление объекта
 */
function after_add_person(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Ответственный добавлен');



        var block_count=parseInt($('.js-count-person .smena_').text());
        block_count++;
        $('.js-count-person .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-person').after(data.blocks);

        var tytt=PadejNumber((block_count),'Ответственный,Ответственных,Ответственных');
        $('.js-count-person .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.person_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-person .help_div').slideUp("slow");
        $('.js-cloud-person .js-count-person').slideDown("slow");

        clearInterval(timerId);
        $.arcticmodal('close');

    } else
    {

        $('.js-add-person-but-x').show();
        $('.js-form-add-person').parents('.box-modal').find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['name_person','office','section','floor','number_room'];

            var err_name = ['некорректно заполнено - Фио','некорректно заполнен - офис','некорректно заполнен - отдел','некорректно заполнен - этаж','некорректно заполнен - номер комнаты'];



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
function edit_person_yes()
{

    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-edit-person .gloab').each(function(i,elem) {
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

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('person','edit','POST',0,'after_edit_person',0,'vino_xd_fiance_pay');


        $('.box-modal .js-edit-person-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}

function AfterSelectOffice(data,update)
{
    if (data.status == 'ok') {
        $('.js-load-select-section').empty().append(data.echo);

        Zindex();
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);

    } else
    {
        alert_message('error', 'Ошибка поиска отделов');
        $('.js-load-select-section').empty();
    }
}


$(function (){

//добавление объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-add-question-but-x',add_question_yes);
//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-question-x',edit_question_yes);


//удалить объект с проверкой в форме
    $('.js-dell-question-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('question','dell','GET',data,'Afterdell_question',for_id,0);


        $('.js-dell-question-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
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
function Afterdell_question(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Вопрос удален');



        var block_count=parseInt($('.js-count-question .smena_').text());
        block_count--;
        $('.js-count-question .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-question').after(data.blocks);

        var tytt=PadejNumber((block_count),'вопрос,вопроса,вопросов');
        $('.js-count-question .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-question .help_div').slideDown("slow");
            $('.js-cloud-question .js-count-question').slideUp("slow");
        }



        $('.question_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.question_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_question(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Вопрос изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.question_block_pass[op_rel=' + data.update + ']').addClass('remove-question-x')
        $('.question_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.question_block_pass.remove-question-x').remove();


        setTimeout ( function () { $('.question_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        $('.js-edit-question-x').show();
        $('.js-form-pay-finance-edit .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['question','ans1','ans2','ans3','ans4'];

            var err_name = ['некорректно заполнен - Вопрос','некорректно заполнен - ответ (1 балл)','некорректно заполнен - ответ (2 балла)','некорректно заполнен - ответ (3 балла)','некорректно заполнен - ответ (4 балла)'];



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
 * постфункция Добавление объекта
 */
function after_add_question_yes(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Вопрос добавлен');



        var block_count=parseInt($('.js-count-question .smena_').text());
        block_count++;
        $('.js-count-question .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-question').after(data.blocks);

        var tytt=PadejNumber((block_count),'вопрос,вопроса,вопросов');
        $('.js-count-question .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.question_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-question .help_div').slideUp("slow");
        $('.js-cloud-question .js-count-question').slideDown("slow");


        clearInterval(timerId);
        $.arcticmodal('close');


    } else
    {
        $('.js-add-question-but-x').show();
        $('.js-form-pay-finance .b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['question','ans1','ans2','ans3','ans4'];

            var err_name = ['некорректно заполнен - Вопрос','некорректно заполнен - ответ (1 балл)','некорректно заполнен - ответ (2 балла)','некорректно заполнен - ответ (3 балла)','некорректно заполнен - ответ (4 балла)'];



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
function edit_question_yes()
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
        $('.js-edit-question-x').hide();

        $('.js-edit-question-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('question','edit','POST',0,'after_edit_question',0,'vino_xd_fiance_pay_edit');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */
function add_question_yes()
{

    var err = 0;

    $('.js-form-pay-finance .gloab').each(function (i, elem) {

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
        $('.js-add-question-but-x').hide();

        $('.js-add-question-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; margin: 0 auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        AjaxClient('question','add','POST',0,'after_add_question_yes',0,'vino_xd_fiance_pay');


    }else
    {

        alert_message('error','Ошибка. Не все поля заполнены!');

    }
}

$(function (){

//добавление объекта с проверкой в форме
    //$('.box-modal').on("change keyup input click",'.js-add-section-but-x',add_section_yes);

    $('.box-modal').on("click",'.js-add-section-but-x',AddSectionX);

//редактирование объекта с проверкой в форме
    $('.box-modal').on("change keyup input click",'.js-edit-section-x',edit_section_yes);


//удалить объект с проверкой в форме
    $('.js-dell-section-b').on( "click", function() {

        var for_id=$('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.gloab-cc').attr('mor');

        AjaxClient('section','dell','GET',data,'Afterdell_section',for_id,0);





        $('.js-dell-section-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
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
function Afterdell_section(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Отдел удален');



        var block_count=parseInt($('.js-count-section .smena_').text());
        block_count--;
        $('.js-count-section .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-section').after(data.blocks);

        var tytt=PadejNumber((block_count),'отдел,отдела,отделов');
        $('.js-count-section .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-cloud-section .help_div').slideDown("slow");
            $('.js-cloud-section .js-count-section').slideUp("slow");
        }



        $('.section_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.section_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}

/*
 * постфункция изменение объекта
 */
function after_edit_section(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Отдел изменен');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('.section_block_pass[op_rel=' + data.update + ']').addClass('remove-section-x')
        $('.section_block_pass[op_rel=' + data.update + ']').after(data.blocks);
        $('.section_block_pass.remove-section-x').remove();


        setTimeout ( function () { $('.section_block_pass').removeClass('new-say');  }, 4000 );



        clearInterval(timerId);
        $.arcticmodal('close');

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        $('.js-edit-section-x').show();
        $('.js-form-edit-section').parents('.box-modal').find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['name_section','office'];
            var err_name = ['некорректно заполнено - Название','некорректно заполнен - Офис'];

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
function AddSectionX()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-add-section .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-section-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('section','add','POST',0,'after_add_section',0,'vino_xd_fiance_pay');


        $('.box-modal .js-add-section-but-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



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

/*
 * нажатие на кнопку добавить в форме добавление объекта
 */


/*
 * постфункция Добавление объекта
 */
function after_add_section(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Отдел добавлен');



        var block_count=parseInt($('.js-count-section .smena_').text());
        block_count++;
        $('.js-count-section .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-section').after(data.blocks);

        var tytt=PadejNumber((block_count),'Отдел,Отдела,Отделов');
        $('.js-count-section .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.section_block_pass').removeClass('new-say');  }, 4000 );

        $('.js-cloud-section .help_div').slideUp("slow");
        $('.js-cloud-section .js-count-section').slideDown("slow");

        clearInterval(timerId);
        $.arcticmodal('close');

    } else
    {

        $('.js-add-section-but-x').show();
        $('.js-form-add-section').parents('.box-modal').find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['name_section','office'];

            var err_name = ['некорректно заполнено - Название','некорректно заполнен - офис'];



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
function edit_section_yes()
{

    var err = 0;
//alert($('.js-form-register .gloab').length);
    $('.js-form-edit-section .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-section-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        var for_id=$('.box-modal .gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('section','edit','POST',0,'after_edit_section',0,'vino_xd_fiance_pay');


        $('.box-modal .js-edit-section-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}


$(function (){


//удалить объект с проверкой в форме
    $('.js-dell-set-b').on( "click", function() {

        var for_id=$('.h111').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor');
        AjaxClient('set','dell','GET',data,'Afterdell_set',for_id,0);


        $('.js-dell-set-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
    });


});


/*
 * постфункция удаления объекта
 * @param data
 * @param update
 * @constructor
 */
function Afterdell_set(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {


        alert_message('ok','Подборка удалена');



        var block_count=parseInt($('.js-count-set .smena_').text());
        block_count--;
        $('.js-count-set .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-set').after(data.blocks);

        var tytt=PadejNumber((block_count),'подборка,подборки,подборок');
        $('.js-count-set .smena_1').empty().append(tytt);

        if(block_count==0)
        {
            $('.js-count-set .help_div').slideDown("slow");
            $('.js-cloud-set .js-count-set').slideUp("slow");
        }



        $('.set_block_pass[op_rel='+update+']').slideUp("slow", function() {
            $('.set_block_pass[op_rel=' + update + ']').remove();
        });

//полностью обновить панель тура потому что суммы изменились и все комиссии и тогдалее.
        clearInterval(timerId);
        $.arcticmodal('close');


    }
}

