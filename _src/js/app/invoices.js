$(function (){

    //нажатие на кнопку добавить накладную
    //$(".add_invoicess").bind('click', save_invoicess);
    $('body').on("change keyup input click",'.add_invoicess',save_invoicess);

    $('body').on("change keyup input click",'.add_material_invoice',AddInvoiceMaterial);

    $('body').on("change keyup input click",'.js-type-stock-view',view_stock);

    $('body').on("change keyup input click",'.del_invoice_material', dell_invoice_material);
    $('body').on("change keyup input click",'.del_invoice_material_prime', dell_invoice_material_prime);

    $('body').on("change keyup input click",'.js-ispol_type_invoice',nds_invoice);


    $('body').on("change keyup input click",'.price_nds_in_,.price_in_,.count_in_,.count_defect_in_,.del_invoice_akt,.material_defect', itog_invoice);
    $('body').on("change keyup input click",'.checkbox_cost_inv', change_option_invoice);


    $('body').on("change keyup input click",'.material_defect', material_defect);

    $('body').on("change keyup input click",'.del_invoice_akt', material_defect_dell);


    $('body').on("click",'.mild_mild', mild_div);

    $('body').on("click",'.mild_mild_dav', mild_div_dav);

    $('body').on("click",'.mild_mild_tra', mild_tra);

    //нажатие на кнопку сохранить накладную
    $('body').on("change keyup input click",'.add_invoicess1', save_invoicess1);

    $('body').on("change keyup input click",'.price_nds_in_,.price_in_,.count_in_,.slct_box,#date_table,[name=number_invoices],[name=ispol_work],.js-ispol_type_invoice,.upload-but-2022,.upload-but-2021,.js-dell-image,.del_image_invoice,.del_invoice_material,.add_material_invoice,.count_defect_in_,.text_zayva_message_,.material_defect,.del_invoice_akt,.checkbox_cost_inv,.mild_mild,.mild_mild_dav,.mild_mild_nds',function(){  $('.transfer_invoicess').hide(); $('.add_invoicess1').show();   });


    $('body').on("click",'.mild_mild_nds',mild_nds);

});


function mild_nds()
{
    if($(this).parents('.mild-nds').is(".chechers")) {
        $('.mild-nds').removeClass("chechers");
        $('.cost-bottom-js-x').removeClass('yes-nds');
        $('.js-nds-cost-material').val(1);


    } else
    {
        $(this).parents('.mild-nds').addClass("chechers");
        $('.cost-bottom-js-x').addClass('yes-nds');
        $('.js-nds-cost-material').val(0);


    }

    itog_invoice();

}


function mild_div()
{
    if($(this).parents('.mild').is(".chechers")) {
        $(this).parents('.mild').removeClass("chechers");
        $(this).parents('[invoice_material]').find('.mild_inp').val(0);

       var nds=$('.js-ispol_type_invoice').val();
        if(nds!=1) {
         //   $('.cost-bottom-js-x').removeClass('nono-checker');
         //   $('.cost-bottom-js-x').find('.mild-nds').show();
        }

        if(!$('.js-number-invoice-x').is('[readonly]')) {

            $(this).parents('[invoice_material]').find('.price_in_').prop('readonly', false).removeClass('grey_edit');
        }

    } else
    {
        $(this).parents('.mild').addClass("chechers");
        $(this).parents('[invoice_material]').find('.mild_inp').val(1);

      //  $('.cost-bottom-js-x').addClass('nono-checker');
      //  $('.cost-bottom-js-x').find('.mild-nds').hide();


       // $(this).parents('[invoice_material]').find('.price_nds_in_').removeAttr('readonly').removeClass('grey_edit');
       // $(this).parents('[invoice_material]').find('.price_nds_in_').prop('readonly',true).addClass('grey_edit');
       // $(this).parents('[invoice_material]').find('.price_nds_in_').val(0);
        $(this).parents('[invoice_material]').find('.price_in_').val(0);
        $(this).parents('[invoice_material]').find('.price_in_').prop('readonly',true).addClass('grey_edit');


    }
    itog_invoice();


}

function mild_tra()
{
    var id_dom=$('.users_rule').attr('iu');
    //alert(id_dom);


    //если это первое нажатие чтобы не путать очистить корзину вдруг туда было что-то добавлено
    if($('.transfer_check_val').val()==0)
    {

        $.cookie("material"+id_dom+"_"+id_dom, null, {path:'/',domain: window.is_session,secure: false});
        $('.transfer_check_val').val(1);
    }

    if($(this).parents('.mild_tra').is(".chechers")) {


        var stock_hj=$(this).parents('[invoice_material]').find('.stock_inp').val();
        $('.stock_inp[value='+stock_hj+']').parents('[invoice_material]').find('.mild_mild_tra').each(function(i,elem) {
            $(this).parents('.mild_tra').removeClass("chechers");
            $(this).parents('.transfer_check').removeClass("chechersx");
        });


        //удалить из корзины
        CookieListS("material"+id_dom+"_"+id_dom,$(this).parents('[invoice_material]').find('.stock_inp_mater').val(),'del','sort',',');
    } else
    {
        //$(this).parents('.mild_tra').addClass("chechers");

        var stock_hj=$(this).parents('[invoice_material]').find('.stock_inp').val();
        $('.stock_inp[value='+stock_hj+']').parents('[invoice_material]').find('.mild_mild_tra').each(function(i,elem) {
            $(this).parents('.mild_tra').addClass("chechers");
            $(this).parents('.transfer_check').addClass("chechersx");
        });



        //добавить в корзину
        CookieListS("material"+id_dom+"_"+id_dom,$(this).parents('[invoice_material]').find('.stock_inp_mater').val(),'add','sort',',');
    }

    //вдруг в накладной несколько одинаковых материалов с одним id_stock тогда их все выделить или убрать выделение со всех



    //если в корзине еще что-то есть показать корзину

    var cookiex = $.cookie("material"+id_dom+"_"+id_dom);
    //alert(window.b_co);
    if(cookiex!=null)
    {
        var cc = cookiex.split('.');
        var counts = cc.length;
        console.log(counts);
        if (counts != 0) {
            $('.transfer_invoicess_2022').show();
        } else {
            $('.transfer_invoicess_2022').hide();
        }
    } else
    {
        $('.transfer_invoicess_2022').hide();
    }

}


function mild_div_dav()
{
    if($(this).parents('.mild_dav').is(".chechers")) {
        $(this).parents('.mild_dav').removeClass("chechers");
        $(this).parents('[invoice_material]').find('.alien_inp').val(0);
        $(this).parents('[invoice_material]').find('.name_invoice_dava').removeClass("dava");
        $(this).parents('[invoice_material]').find('.chat_kk').remove();

    } else
    {
        $(this).parents('.mild_dav').addClass("chechers");
        $(this).parents('[invoice_material]').find('.alien_inp').val(1);
        $(this).parents('[invoice_material]').find('.name_invoice_dava').addClass("dava");
        $(this).parents('[invoice_material]').find('.name_invoice_dava').after('<div class="chat_kk" data-tooltip="давальческий материал"></div>');
    }



}


function save_invoicess1()
{
    var error=0;

    $('.save__s').removeClass('error_formi');
    $('.akt_ss').removeClass('redaas_invcoice');

    if($('#ispol').val()==0)
    {
        $('#ispol').prev().prev().addClass('error_formi');
        error=1;
    }
    if($('#date_hidden_table').val()=='')
    {
        $('#date_hidden_table').next('.save__s').addClass('error_formi');
        error=1;
    }
    if($('#number_invoice').val()=='')
    {
        $('#number_invoice').addClass('error_formi');
        error=1;
    }


    $('.messa_invoice:visible').each(function(i,elem) {
        var id=$(this).attr('invoices_messa');


        var count=parseFloat($('[invoice_material='+id+']').find('.count_in_').val());
        var count_akt=parseFloat($('[invoices_messa='+id+']').find('.count_defect_in_').val());
        var comment=$('[invoices_messa='+id+']').find('.text_zayva_message_').val();
        //alert(id);

        if((count_akt=='')||(count_akt>count)||(count_akt==0))
        {
            error=1;
            alert_message('error','Заполните количество брака');
        }

        var akt_photo=$('[invoices_messa='+id+']').find('.photo-akt-invoice .li-image').length;

        if(akt_photo==0)
        {
            error=1;
            alert_message('error','Подгрузити файл акта на отбраковку');
        }

        if((comment==''))
        {
            error=1;
            alert_message('error','Заполните комментарий по браку');
        }




    });


    if(error==1)
    {
/*
        $('.error_text_add').empty().append('Не все поля заполнены для сохранения').show();
        setTimeout ( function () { $('.error_text_add').hide(); }, 7000 );
*/
        alert_message('error','Не все поля заполнены');
    } else
    {
        $('#lalala_add_form').submit();
    }



}

//убрать акт на брак
function material_defect_dell()
{
    var attr=$(this).attr('id_rel');
    $('[invoice_material='+attr+']').find('.defect_inp').val('0');
    $('[invoice_material='+attr+']').next().hide();
    $('[invoices_messa='+attr+']').find('.count_defect_in_').val('');
    $('[invoices_messa='+attr+']').find('.text_zayva_message_').val('');
}


//добавить - убрать акт на брак
function material_defect()
{
    var attr=$(this).attr('id_rel');
    var defect=$('[invoice_material='+attr+']').find('.defect_inp').val();

    if(defect==0)
    {
        $('[invoice_material='+attr+']').find('.defect_inp').val('1');
        $('[invoice_material='+attr+']').next().show();
    } else
    {
        $('[invoice_material='+attr+']').find('.defect_inp').val('0');
        $('[invoice_material='+attr+']').next().hide();
        $('[invoices_messa='+attr+']').find('.count_defect_in_').val('');
        $('[invoices_messa='+attr+']').find('.text_zayva_message_').val('');
    }
}

function change_option_invoice()
{
    var nds_x=$('[name=nds_ff]').val();
    $('.price_in_,.price_nds_in_').val(0);

    var nds=$('.js-ispol_type_invoice').val();
    var nds_budet=0;
    if(nds==0)
    {
        nds_budet=1;
    }
    $('.js-ispol_type_invoice').prev('ul').find('a[rel='+nds_budet+']').trigger('click');



    if(nds_x==0)
    {
        $('[name=nds_ff]').val('1');
        $('.yes_nds').parents('th').removeClass('active_n_ac');
        $('.no_nds').parents('th').addClass('active_n_ac');
    } else
    {
        $('[name=nds_ff]').val('0');
        $('.no_nds').parents('th').removeClass('active_n_ac');
        $('.yes_nds').parents('th').addClass('active_n_ac');
    }
    nds_invoice();
}

function cost_mild()
{
    //пробежаться по всем материалом накладной и если она мягкая заморозить все цены
    $('[invoice_material]').each(function(i,elem) {
 var mild =$(this).find('.mild_inp').val();
if(mild==1)
{
    $(this).find('.price_nds_in_').prop('readonly',true).addClass('grey_edit');
    $(this).find('.price_nds_in_').val(0);
    $(this).find('.price_in_').val(0);
    $(this).find('.price_in_').prop('readonly',true).addClass('grey_edit');
}

    });


}


function nds_invoice()
{
    var nds=$('.js-ispol_type_invoice').val();
    var nds_material=$('.js-nds-cost-material').val();

    if($('.js-number-invoice-x').is('[readonly]'))
    {
        $('.price_in_,.price_nds_in_').attr('readonly','true').addClass('grey_edit');
    }
    $('[name=nds_ff]').val(nds);


    if(nds_material==0)
    {
        //выделяем цену как было указано
        $('.mild-nds').addClass("chechers");
        $('.mild-nds').parents('.cost-bottom-js-x').addClass('yes-nds');
    }



    if(nds==1)
    {
        //без ндс
        //->недоступно галка выбора какая цена указана
        //$('.price_nds_in_').prop('readonly',true).addClass('grey_edit');
        //$('.cosy_title').empty().append('Цена');
        $('.cost-bottom-js-x').find('.mild-nds').hide();
        $('.cost-bottom-js-x').addClass('nono-checker');

        //$('.price_in_').prev('label').empty().append('ЦЕНА');
        //$('.price_nds_in_').val(0);
        //$('.title_itog_invoice').empty().append('Итого сумма');

        //$('.checkbox_cost_inv').hide();

    } else
    {

        //if(!$('.mild').is(".chechers")) {
            //с ндс
            $('.cost-bottom-js-x').find('.mild-nds').show();
            $('.cost-bottom-js-x').removeClass('nono-checker');
        //}

/*
        $('.checkbox_cost_inv').show();
        $('.cosy_title').empty().append('Цена без Ндс<div class="checkbox_cost_inv no_nds"><i></i></div>');

        if($('.yes_nds').length==0)
        {
            $('.checkbox_cost_inv').remove();
        }

        $('.price_in_').prev('label').empty().append('ЦЕНА БЕЗ НДС');

        var nds_x=$('[name=nds_ff]').val();
        var mojno= $('.js-number-invoice-x').is('.grey_edit');
        if(!$('.js-number-invoice-x').is('.grey_edit'))
        {

            if((nds_x==0))
            {

                $('.price_nds_in_').removeAttr('readonly').removeClass('grey_edit');
                $('.price_in_').val(0);
                $('.price_in_').prop('readonly',true).addClass('grey_edit');
            } else
            {
                $('.price_in_').removeAttr('readonly').removeClass('grey_edit');
                $('.price_nds_in_').val(0);
                $('.price_nds_in_').prop('readonly',true).addClass('grey_edit');
            }
        }
        $('.title_itog_invoice').empty().append('Итого сумма с ндс');


        var nds_x=$('[name=nds_ff]').val();
        $('.yes_nds,.no_nds').parents('th').removeClass('active_n_ac');
        if(nds_x==0)
        {
            $('.yes_nds').parents('th').addClass('active_n_ac');
        } else
        {
            $('.no_nds').parents('th').addClass('active_n_ac');
        }
*/
    }




    //пересчитать сумму накладной
    itog_invoice();
    //cosy_title
}

//вывод итоговых строчек
function itog_invoice()
{
    //alert("!");
    var nds=$('.js-ispol_type_invoice').val();  //есть ли ндс в счете
    var nds_material=$('.js-nds-cost-material').val(); //как указана цена

    //alert(nds);
    var xvg=$('[invoice_material]');
    var summ_xvg=0;
    var summ_defect=0;
    xvg.each(function(i,elem) {


        var count= parseFloat($(this).find('.count_in_').val());
        var price= parseFloat($(this).find('.price_in_').val());
      //  var price_nds= parseFloat($(this).find('.price_nds_in_').val());
        var defect_in=parseFloat($(this).find('.defect_inp').val());
/*
        if(nds==0)
        {
            //с ндс в счете

            //если указана цена с ндс то просто умножаем на количество

            var nds_x=$('[name=nds_ff]').val();


            //alert(price_nds);
            if((price_nds!=0)&&(price_nds!='')&&($.isNumeric(price_nds))&&(nds_x==0))
            {
                var value=(count*price_nds).toFixed(2);
                $(this).find('.price_in_').val(((price_nds*100)/118).toFixed(2));
                if(price_nds==0)
                {
                    //$(this).val(0);
                }


                if(defect_in!=0)
                {
                    var count_defff=$(this).next().find('.count_defect_in_').val();
                    if(($.isNumeric(count_defff))&&(count_defff!=''))
                    {
                        summ_defect=(summ_defect+(count_defff*price_nds));
                    }
                }

            } else
            {
                //если цена с ндс пусто то обычную цену +18% ндс
                if((nds_x==1)&&($.isNumeric(price))&&(price!=''))
                {
                    var value=(count*(price*1.18)).toFixed(2);
                    $(this).find('.price_nds_in_').val((price*1.18).toFixed(2));
                }


                if(defect_in!=0)
                {
                    var count_defff=$(this).next().find('.count_defect_in_').val();
                    if(($.isNumeric(count_defff))&&(count_defff!=''))
                    {
                        summ_defect=(summ_defect+(count_defff*(price*1.18)));
                    }
                }


            }
        } else
        {*/
            //без ндс

            //просто умножаем количество на стоимость
            var value=(count*price).toFixed(2);

            if(defect_in!=0)
            {
                var count_defff=$(this).next().find('.count_defect_in_').val();
                if(($.isNumeric(count_defff))&&(count_defff!=''))
                {
                    summ_defect=(summ_defect+(count_defff*price));
                }
            }

       // }


        if((value!=0)&&(value!='')&&($.isNumeric(value)))
        {
            $(this).find('.summa_ii').empty().append(value);
            summ_xvg=(parseFloat(summ_xvg)+parseFloat(value)).toFixed(2);
        } else
        {
            $(this).find('.summa_ii').empty().append('0');
        }


    });


    //вывод по дефектам
    if((summ_defect!=0)&&(summ_defect!='')&&($.isNumeric(summ_defect)))
    {
        $('.itogss_defect').show();
        $('.itog_invoice_defect').empty().append(summ_defect.toFixed(2));

    } else
    {
        $('.itogss_defect').hide();
        $('.itog_invoice_defect').empty().append('0');
    }




    $('.js-itog-all-text').empty().append(summ_xvg);


    $('.js-itog-nds-all').hide();
    $('.js-itog-vnds-all').hide();
    $('.js-itog-snds-all').hide();

    if(summ_xvg!=0)
    {
        if(nds==1)
        {
            //без ндс в счете

        } else
        {
            //с ндс в счете
            if(nds_material==1)
            {
                //цена за материал указана без ндс в счете
                var summ_xvg_nds=(summ_xvg*0.2).toFixed(2);
                $('.js-itog-nds-text').empty().append(summ_xvg_nds);
                $('.js-itog-nds-all').show();

                var all_ssd=(parseFloat(summ_xvg_nds)+parseFloat(summ_xvg)).toFixed(2);
                $('.js-itog-snds-text').empty().append(all_ssd);
                $('.js-itog-snds-all').show();

            } else
            {
                //цена за материал указана с ндс в счете
                var summ_xvg_nds=((summ_xvg*0.2)/1.2).toFixed(2);

                $('.js-itog-vnds-text').empty().append(summ_xvg_nds);
                $('.js-itog-vnds-all').show();
            }


        }


    }


/*
    if((summ_xvg!=0)&&(nds==0))
    {
        var summ_xvg_nds=(summ_xvg/1.18*0.18).toFixed(2);
        $('.itog_invoice_nds').empty().append(summ_xvg_nds);
        $('.itogss_nds').show();
    } else
    {
        $('.itog_invoice_nds').empty();
        $('.itogss_nds').hide();
    }
*/



}


function dell_invoice_material_prime()
{
    var attr=$(this).attr('id_rel');


    var id_dom=$('[name=dom]').val();

    CookieList(window.b_cm+"_"+id_dom,attr,'del','sort');
alert(window.b_cm+"_"+id_dom);

    $('[invoice_material='+attr+']').remove();
    $('[invoices_messa='+attr+']').next().remove();
    $('[invoices_messa='+attr+']').remove();


    itog_invoice();

}

function dell_invoice_material()
{
    var attr=$(this).attr('id_rel');
    $('[invoice_material='+attr+']').hide();
    $('[invoices_messa='+attr+']').hide();

    var data ='url='+window.location.href+'&id='+attr;
    AjaxClient('invoices','dell_material','GET',data,'AfterDellMaterialInvoice',attr,0);

}

function view_stock()
{
//alert("!");
    var t_soft=$('.js-type-stock-view1').val();
    if(t_soft==1)
    {
        $('.js-options-invoice-1').slideDown("slow"); //показать
        $('.js-options-invoice-0').slideUp("slow"); //скрыть
        $('.no_bill_material').hide();
        $('.search_bill').hide();

    } else
    {
        $('.js-options-invoice-0').slideDown("slow");
        $('.js-options-invoice-1').slideUp("slow");
    }
}

//добавить материал в накладной
function AddInvoiceMaterial()
{
    if ( $(this).is("[for]") )
    {
        if($.isNumeric($(this).attr("for")))
        {
            $.arcticmodal({
                type: 'ajax',
                url: 'forms/form_add_material_invoice_2021.php?id='+$(this).attr("for")+'&col='+$(this).attr("col"),
                beforeOpen: function (data, el) {
                    //во время загрузки формы с ajax загрузчик
                    $('.loader_ada_forms').show();
                    $('.loader_ada1_forms').addClass('select_ada');
                },
                afterLoading: function (data, el) {
                    //после загрузки формы с ajax
                    data.body.parents('.arcticmodal-container').addClass('yoi');
                    $('.loader_ada_forms').hide();
                    $('.loader_ada1_forms').removeClass('select_ada');
                },
                beforeClose: function (data, el) { // после закрытия окна ArcticModal
                    if (typeof timerId !== "undefined") {
                        clearInterval(timerId);
                    }
                    BodyScrool();
                }

            });
        }
    }

    return false;
}

//сохранить накладную первый этап
function save_invoicess()
{
    //alert("!");
    var err = 0;
    $('.js-save-form-invoices').find('.gloab').each(function(i,elem) {
        if(($(this).val() == '')||($(this).val() == '0')) { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    var new_firm_fns=$('.js-save-form-invoices').find('.js-type-soft-view1').val();
    if(new_firm_fns==0)
    {
        $('.js-save-form-invoices').find('.gloab2').each(function(i,elem) {
            if(($(this).val() == '')||($(this).val() == '0')) { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    } else
    {
        $('.js-save-form-invoices').find('.gloab1').each(function(i,elem) {
            if(($(this).val() == '')||($(this).val() == '0')) { $(this).parents('.input_2021').addClass('required_in_2021');
                $(this).parents('.list_2021').addClass('required_in_2021');
                err++;
                //alert($(this).attr('name'));
            } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
        });
    }

    if(err==0) {

        $('.js-save-form-invoices').submit();

    } else
    {
        alert_message('error','Не все поля заполнены');
    }



}