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

