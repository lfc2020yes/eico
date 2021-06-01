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
