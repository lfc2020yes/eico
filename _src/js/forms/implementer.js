function js_add_implementer_x()
{

    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-add-works .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });


    if(err==0)
    {
        var for_id=box_active.find('.gloab-cc').attr('for');
/*
        var for_id=$('.h111').attr('for');
        var data='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&names='+$('#otziv_area_ppp').val()+'&name='+$('#otziv_area11').val()+'&fio='+$('#otziv_area').val()+'&fio1='+$('#otziv_area_p').val()+'&tel='+$('#otziv_area12').val();
        AjaxClient('implementer','add_implementer','GET',data,'AfterUP_IMP_ADD',for_id,0);
   */

       // AjaxClient('prime','add_work','GET',0,'AfterWA',for_id,'form_prime_add_work_new');

         AjaxClient('implementer','add_implementer','POST',0,'AfterUP_IMP_ADD',for_id,'form_prime_add_work_new');

        box_active.find('.js-add-implementer-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');
    }



}
