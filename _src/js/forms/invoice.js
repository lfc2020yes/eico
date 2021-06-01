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


