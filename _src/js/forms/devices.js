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

