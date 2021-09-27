$(function () {
    $('body').on("change keyup input click",'.js-zame-tours',form_doc_rate);
    $('body').on("change keyup input click",'.js-ok-rate-chat-left',ok_rate_form_chat_left);
});

function form_doc_rate() {

    if (!$(this).parents('.plus_comm_vot').find('.form-rate-ok1').is(".show-form-rate1")) {
        //alert("!!");


        if ($(this).parents('.plus_comm_vot').find('.form-rate-ok1').length != 0) {
            $('.form-rate-ok1').removeClass('show-form-rate1');
            $(this).parents('.plus_comm_vot').find('.form-rate-ok1').addClass('show-form-rate1');
            $(this).parents('.plus_comm_vot').find('.form-rate-ok1 .tyyo1').focus();


        }

        //input_2018();

    }
}

/**
 * туры - ок после ввода Впечатления по туру
 *
 */
function ok_rate_form_chat_left(event)
{
    //проверяем что введен курс
    var rate_b= $(this).parents('.form-rate-ok1').find('.tyyo1').val();
    //lert(rate_b);
    if(jQuery.trim(rate_b)!='')
    {
        //Все ок рассчитываем и скрываем эту форму
        $(this).parents('.form-rate-ok1').removeClass('show-form-rate1');
        //console.log("Обработчик параграфа.");

        $(this).parents('td').find('.zame_kk').addClass('yes-note');

        $(this).parents('td').find('.commun').empty().append(rate_b);
        $(this).parents('td').find('.commun_hide').val(1);
        //создать post formu

        event.stopPropagation();
    } else
    {
        $(this).parents('.form-rate-ok1').removeClass('show-form-rate1');
        //console.log("Обработчик параграфа.");

        $(this).parents('td').find('.zame_kk').removeClass('yes-note');
        $(this).parents('td').find('.commun').empty();

        $(this).parents('td').find('.commun_hide').val(0);

        event.stopPropagation();
    }
}