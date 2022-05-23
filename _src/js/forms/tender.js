


//сохранить изменения в форме редактирование счета
function js_edit_save_tender_x() {
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.gloab').each(function (i, elem) {
        if ($(this).val() == '') {
            $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {
            $(this).parents('.input_2021').removeClass('required_in_2021');
            $(this).parents('.list_2021').removeClass('required_in_2021');
        }
    });

    var contractor_new = box_active.find('.js-type-soft-view1').val();


    if (contractor_new == 0) {
        box_active.find('.js-form-prime .gloab2').each(function (i, elem) {
            if ($(this).val() == '') {
                $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {
                $(this).parents('.input_2021').removeClass('required_in_2021');
                $(this).parents('.list_2021').removeClass('required_in_2021');
            }
        });
    } else {
        box_active.find('.js-form-prime .gloab1').each(function (i, elem) {
            if ($(this).val() == '') {
                $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {
                $(this).parents('.input_2021').removeClass('required_in_2021');
                $(this).parents('.list_2021').removeClass('required_in_2021');
            }
        });
    }


    if (err == 0) {
        var for_id = box_active.find('.gloab-cc').attr('for');


        AjaxClient('tender', 'edit_tender', 'POST', 0, 'AfterEdittender', for_id, 'form_tender_edit_block');


        box_active.find('.js-edit-save-tender-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


    } else {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error', 'Не все поля заполнены');


    }
}


function AfterEdittender(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        //обновляем вывод
        alert_message('ok','Данные сохранены');
        $('.js-tender-name-top').empty().append(data.name);
        $('.new-tender-block-2021[id_pre='+update+']').addClass('js-remove-block');


        $('.new-tender-block-2021[id_pre='+update+']').after(data.block);
        $('.js-remove-block').remove();
        //$('.new-tender-block-2021[id_pre='+update+']:first').remove();

        var box = $('.box-modal:last');
        clearInterval(timerId);
        box.find('.arcticmodal-close').click();

        return;
    }

    var box = $('.box-modal:last');
    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-save-tender-x').show();
    box.find('.b_loading_small').remove();


}


//удалить раздел в себестоимости
//  |
// \/
function js_dell_tender_x()
{
    var box_active = $(this).closest('.box-modal');
    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');
    var for_id=box_active.find('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor');



    AjaxClient('prime','dell_razdel','GET',data,'AfterRD',for_id,0);

    box_active.find('.js-dell-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


}


//добавление нового счета проверка в форме добавления
//  |
// \/
function js_add_tender_x()
{
    var box_active = $(this).closest('.box-modal');
var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-prime .gloab').each(function(i,elem) {
    if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
        $(this).parents('.list_2021').addClass('required_in_2021');
        err++;
        //alert($(this).attr('name'));
    } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
});


       box_active.find('.js-form-prime .gloab2').each(function(i,elem) {
           if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
               $(this).parents('.list_2021').addClass('required_in_2021');
               err++;
               //alert($(this).attr('name'));
           } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
       });



   // js-type-soft-view1 0 1
    var iu=$('.content_block').attr('iu');


if(err==0)
{

    var for_id=box_active.find('.gloab-cc').attr('for');


//alert(files);





        var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor')+'&object='+box_active.find("[name=forward_id]").val()+'&name='+box_active.find("[name=number_soply1]").val()+'&link='+encodeURIComponent(box_active.find("[name=link_soply1]").val())+'&summa='+box_active.find("[name=summa_soply]").val()+'&place='+box_active.find("[name=place_id]").val()+'&com='+box_active.find("[name=text_comment]").val();


    AjaxClient('tender','add_tender','GET',data,'AfterAtender',$(".js-number-tender-new").val(),0);


    box_active.find('.js-add-tender-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

} else
{
    //найдем самый верхнюю ошибку и пролестнем к ней
    //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
    //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
    alert_message('error','Не все поля заполнены');


}
}


//постфункция добавление нового счета
function AfterAtender(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {

        //удалить все из кукки по этому счету и убрать все выделения
        var iu=$('.content_block').attr('iu');

        //пройтись по кукка этого счета и добавить иконки о новом счете в нужные места

        //перейти в договор внутрь
$('.js-open-tenders').remove();
        $('body').append('<form class="none js-open-tenders" action="tender/'+data.ty+'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data"><input name="a" value="open" type="hidden"></form>');
$('.js-open-tenders').submit();
        /*
        //показать панель для загрузки фото к договору
        $('.new_qqe').empty().append('Счет №'+update);
        $('.soply_step_1').hide();
        $('.img_ssoply').show();
        $('.hop_lalala').find(".loader_inter").before('<div id_upload="'+data.ty+'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'+data.ty+'" id_sc="'+data.ty+'" name="upload'+data.ty+'"><input class="sc_sc_loo11" type="file" name="myfile'+data.ty+'"></form><div class="loaderr_scan scap_load_'+data.ty+'" style="width:100%"><div class="scap_load__" style="width: 0%;"></div></div>');

        $('.hop_lalala').find(".loader_inter").remove();
*/


        return;
    }

    var box = $('.box-modal:last');
    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}

//редактирование раздела в себестоимость
//  |
// \/
function js_edit_tender_x()
{
    var box_active = $(this).closest('.box-modal');
    var err = 0;
//alert($('.js-form-register .gloab').length);
// alert("!!");
    box_active.find('.js-form-prime .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    if(err==0)
    {

        var for_id=box_active.find('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('prime','edit_razdel','POST',0,'AfterRE',for_id,'form_prime_edit_block');



        //AjaxClient('prime','add_razdel','GET',data,'AfterRA',for_id,0);


        box_active.find('.js-edit-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}


//удалить мат их счета
//  |
// \/
function js_dell_tender_mat()
{
    var box_active = $(this).closest('.box-modal');
    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');
    var for_id=box_active.find('.h111').attr('for');
    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.h111').attr('mor');



    AjaxClient('tender','dell_tender_material','GET',data,'AfterDMa',for_id,0);

    box_active.find('.js-dell-prime-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


}

//постфункция удаление материл из счета
function AfterDMa(data,update)
{
    var box = $('.box-modal:last');
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' )
    {

        var title_url=$(document).attr('title');
        var url=window.location.href;
        url=url+'dell/';
        History.pushState('', title_url, url);

        autoReloadHak();
        clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        $.arcticmodal('close');


        $('[yi_sopp_='+update+']').slideUp("slow");


        return;
    }

    //в случае если что-то пошло не так чтобы не висло
    box.find('.js-edit-prime-block-x').show();
    box.find('.b_loading_small').remove();
}
