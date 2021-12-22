$(function () {

    $('body').on("change keyup input click",'.js-add_nar',save_naryad);
   // $(".add_nar").bind('click', save_naryad);
});



//сохранить наряд
function save_naryad()
{
    var error=0;

    $('.messa:visible').find('.text_finery_message_').removeClass('error_formi');
    $('.messa:visible').find('.text_finery_message_').each(function(i,elem) {

        var text=$(this).val();
        if(text=='')
        {
            error=1;
            $(this).addClass('error_formi');
        }
    });
    $('.work__s').find('.price_finery_').removeClass('error_formi');
    $('.work__s').find('.count_finery_').removeClass('error_formi');
    $('.mat').find('.price_finery_mater_').removeClass('error_formi');
    $('.mat').find('.count_finery_mater_').removeClass('error_formi');

    $('.messa:visible').each(function(i,elem) {
        var id_work=$(this).attr('id_mes');
        //проверим что все поля для каждой служебной записки заполнены


        //определим отностимся записка к работе или материалу
        var aa = id_work.split('_');
        if(aa.length==1)
        {
            //это работа
        } else
        {
            //материал
        }
        id_work=aa[0];

        var count=$('.work__s[rel_id='+id_work+']').find('.count_finery_').val();
        var price=$('.work__s[rel_id='+id_work+']').find('.price_finery_').val();
        $('.work__s[rel_id='+id_work+']').find('.price_finery_').removeClass('error_formi');
        $('.work__s[rel_id='+id_work+']').find('.count_finery_').removeClass('error_formi');
        if((count==0)||(count=='')||(!$.isNumeric(count)))
        {
            $('.work__s[rel_id='+id_work+']').find('.count_finery_').addClass('error_formi');
            error=1;
        }
        if((price==0)||(price=='')||(!$.isNumeric(price)))
        {
            $('.work__s[rel_id='+id_work+']').find('.price_finery_').addClass('error_formi');
            error=1;
        }


        $('.mat[rel_w='+id_work+']').each(function(i,elem) {
            var count=$(this).find('.count_finery_mater_').val();
            var price=$(this).find('.price_finery_mater_').val();
            $(this).find('.price_finery_mater_').removeClass('error_formi');
            $(this).find('.count_finery_mater_').removeClass('error_formi');
            //if((count==0)||(count=='')||(!$.isNumeric(count)))

            if((count=='')||(!$.isNumeric(count)))
            {
                $(this).find('.count_finery_mater_').addClass('error_formi');
                error=1;
            }
            /*
            if((price==0)||(price=='')||(!$.isNumeric(price)))
            {
                $(this).find('.price_finery_mater_').addClass('error_formi');
                error=1;
            }
            */

        });


    });

    $('.js-add-worder-material .gloab2').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            error++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });
    if(error!=0)
    {

        alert_message('error','Не все поля заполнены');

    } else
    {
        $('#lalala_add_form').submit();
    }



}
