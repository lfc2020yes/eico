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

