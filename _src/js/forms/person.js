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

