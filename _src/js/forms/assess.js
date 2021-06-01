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
