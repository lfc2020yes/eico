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
