$(function (){

    //изменить объект
    //$('body').on("change keyup input click",'.js-pass-edit',js_edit_pass);

    //удалить объект
    $('body').on("change keyup input click",'.js-next-step-exam',js_next_step);


});
var timeouts = {};
var timeeven = {};

//счетчик времени до начала аукциона.
function TimerTenderS(id,action)
{
    //создаем скорость таймера, счетчик итераций и задаем временной штамп для начала отсчета
    var speed = 1000,
        counter = 0,
        start = new Date().getTime();

    //var DateClient = Math.floor(start / 1000);
    var DateClient = $('[name=second]').val();

    //отталкиваемся на время клиента с учетом его разницы с сервером
    var seconds = DateClient;	//



    //var seconds = (DateEnd-DateServer);
    //alert(seconds);
        var minutes = seconds/60; //определяем количество минут до истечения таймера
        var hours = minutes/60; //определяем количество часов до истечения таймера
        //alert(hours);
       // minutes = (hours - Math.floor(hours)) * 60; //подсчитываем кол-во оставшихся минут в текущем часе
        hours = Math.floor(hours); //целое количество часов до истечения таймера
        //seconds = Math.floor((minutes - Math.floor(minutes)) * 60); //подсчитываем кол-во оставшихся секунд в текущей минуте
    if(minutes>=60)
    {
        minutes = Math.floor(minutes%60); //округляем до целого кол-во оставшихся минут в текущем часе
    } else {
        minutes = Math.floor(minutes); //округляем до целого кол-во оставшихся минут в текущем часе
    }

    var secondss = seconds%60; //подсчитываем кол-во оставшихся секунд в текущей минуте

        setTimeTender(hours,minutes,secondss,id,action); // выставляем начальные значения таймера

        $('.js-status-auc').addClass('run-auc');
        $('.js-status-auc').find('span').empty().append('online');
        $('.js-step-menu').slideDown("slow");
        $('.clock-auc').slideDown("slow");


        //пример таймера
        function instance()
        {
            /*
            if(action=='end')
            {

                $('.up-t-tt-'+id).slideUp("slow");
                //TimesCorrect('end');
                window.clearTimeout(timeouts[action]);



                return;
            }
*/


            if (seconds == 0) { // если секунду закончились то

                      //  ColorFlash($('.clock-auc'),'#fec048',1350);
                seconds++;
            }
            else {
                seconds++; // уменьшаем кол-во секунд
            }

            $('[name=second]').val(seconds);

            var minutes = seconds/60; //определяем количество минут до истечения таймера
            var hours = minutes/60; //определяем количество часов до истечения таймера
            hours = Math.floor(hours); //целое количество часов до истечения таймера
            //seconds = Math.floor((minutes - Math.floor(minutes)) * 60); //подсчитываем кол-во оставшихся секунд в текущей минуте

            if(minutes>=60)
            {
                minutes = Math.floor(minutes%60); //округляем до целого кол-во оставшихся минут в текущем часе
            } else {
                minutes = Math.floor(minutes); //округляем до целого кол-во оставшихся минут в текущем часе
            }


            var secondss = seconds%60;

            setTimeTender(hours,minutes,secondss,id,action); // обновляем значения таймера на странице

            //вычисляем идеальное и реальное время работы таймера
            //судя по всему, в оригинале, автор изменил названия переменных, чтобы идентифицировать свой код при перепосте.
            var real = (counter * speed),
                ideal = (new Date().getTime() - start);

            //увеличиваем счетчик
            counter++;
            //вычисляем и отображаем разницу
            var diff = (ideal - real);
            //если флаг adjust == true, будем вычитать разницу перед последующим вызовом (тем самым реализовав необходимое упреждение)
            timeouts[action] = window.setTimeout(function() { instance(); }, (speed - diff));

        };

        //далее, просто отбрасываем все прочь в случае обычного таймера
        timeouts[action] = window.setTimeout(function() { instance(); }, speed);



}


function setTimeTender(h,m,s,id,action) { // функция выставления таймера на странице
//ColorFlash($('.up-t-s-'+id),'#fec048',1350);

    if(m<10){ m='0'+m;}
    if(s<10){ s='0'+s;}

    if(action=='start')
    {
        $('.up-t-tt-'+id).removeClass('none');
        h1=h;
        if(h<10){ h1='0'+h;}
        if(h!=0)
        {

            $('.up-t-tt-'+id).empty().append('('+h1+':'+m+':'+s+')');

        }
        else
        {
            $('.up-t-tt-'+id).empty().append('('+m+':'+s+')');
        }

    }
}







function after_next_step(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();
        if($('[name=test]').val()==0) {
            alert_message('ok', 'Ответ принят');
        }

        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

        $('[name=test]').val(0);
        $('[name=my_yes]').val('');
        $('.js-count-xx-v').empty().append(data.title_vv);
        $('.js-info-hh').slideUp("slow");
        $('.place__title').slideUp("slow",function () {

            $('.place__title').empty().append(data.wop);
            $('.place__title').slideDown("slow");

            $('.js-otv-block').slideUp("slow",function () {

                $('.js-otv-block').empty().append(data.otv);
                $('.js-otv-block').slideDown("slow");
                $('.js-next-step-exam').show();
                $('#vino_xd_fiance_pay').find('.b_loading_small').remove();
                if(parseInt(data.starts)==2)
                {
                    $('.js-next-step-exam').hide();
                    $('.js-next-step-end').removeClass('none');
                    //TimerTenderS(update,'end');
                    window.clearTimeout(timeouts['start']);
                    $('.up-t-tt-'+update).slideUp("slow");
                }
            });

        });
        $('[name=question]').val(data.wop_id);


        if (parseInt(data.starts)==1)
        {
            //начинаем таймер
            TimerTenderS(update,'start');

        }

$('.teps').css("width", data.proc+"%");



    } else
    {
        $('.js-next-step-exam').show();
        $('#vino_xd_fiance_pay').find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['no_test','question'];

            var err_name = ['Ошибка по заданию - Попробуйте еще раз','Ошибка по вопросу - Попробуйте еще раз'];



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


function js_next_step()
{
    //alert("33");
    $(this).hide();
    $(this).before('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 27px;top: auto;left: 10px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    var err = 0;
//смотрим это не первый ли шаг. если нет то проверяем выбран ли ответ

    if($('[name=test]').val()==0)
    {
        if(($('[name=my_yes]').val()=='')||($('.answer_exam[key='+$('[name=my_yes]').val()+']').length==0))
        {
            err++;
            alert_message('error','Выберите один из ответов');
        }
    }


    //if($("#name_b").val() == '')  {alert_message('error','Заполните Название подборки'); err++;	}


    if(err!=0)
    {
        $(this).show();
        $('#vino_xd_fiance_pay').find('.b_loading_small').remove();
        //alert_message('error','Не все поля заполнены');
        /*
    $('.error_text_add-09').empty().append('Не все поля заполнены').show();
    setTimeout ( function () { $('.error_text_add-09').hide(); }, 7000 );
        */

    } else
    {
        //$('#lalala_save_form').submit();
        AjaxClient('exam','next','POST',0,'after_next_step',$('[name=id]').val(),'vino_xd_fiance_pay',1);

    }
}