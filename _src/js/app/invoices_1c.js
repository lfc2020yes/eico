$(function () {
    $('body').on("change keyup input click",'.js-status-1c-mat',StatusMC);

   // $('body').on("change keyup input click",'.mild-1c',ClickPosa);
   // $('body').on("change keyup input click",'.mild-1c',CheckboxGroup);
   $('body').on("change keyup input click",'.js-matic-ko',mild_matic);

    $('body').on("change keyup input click",'.js-acc-ko',acc_matic);

    $('body').on("change keyup input click",'.js-1c-matic',view_matic);

    $('body').on("change keyup input click",'.js-rout-unit',rout_matic);


    $('body').on("change keyup input click",'.js-load-click-1c',acc_1c_matic);


    $('body').on("change keyup input click",'.js-i-remove-meta',remove_meta);

    $('body').on("change keyup input click",'.js-add_invoicess112',add_meta_mm);


});

function add_meta_mm()
{
    $('#lalala_add_form').submit();
}


function remove_meta()
{
    var box = $('.box-modal:last');

    $(this).parents('.meta_units_1c').remove();
    box.find('.js-form2').attr('cor','');
}


function load_basket_1c(keyy)
{
    var box = $('.box-modal:last');

    var line_mati=$('.material-1c[id_key='+keyy+']');


var odni=0;


    if(line_mati.find('[name="mat[cor_unit][]"]').val()!='') {
        var sso='';
        var mass_sso=line_mati.find('[name="mat[cor_unit][]"]').val().split(";");
        var sso='1 '+mass_sso[0]+' = '+mass_sso[2]+' '+mass_sso[1];
        //выводим и соотношение единиц которые он вбил
        box.find('.vsego-1c-zero i').empty().append(sso);

    } else
    {
        box.find('.vsego-1c-zero').hide();
        odni=1;
    }

    var count_mm=parseFloat($.trim(line_mati.find('.js-col-1c').text()));
    var all_mm=count_mm;
    count_mm=$.number(count_mm.toFixed(3), 3, '.', ' ');
    count_mm = count_mm.replace(/(\d+)([.,]0+)/, "$1");
    box.find('.vsego-1c-one i').empty().append(count_mm);
    box.find('.vsego-1c-one span').empty().append(' '+line_mati.find('.js-ed-1c').text());

    if(odni==1)
    {
        box.find('.vsego-1c-two i').empty().append(count_mm);
        box.find('.vsego-1c-two').attr('all',all_mm);

        box.find('.vsego-1c-two span').empty().append(' '+line_mati.find('.js-ed-1c').text());
    } else
    {
        //пересчет сколько необходимо в зависимости от соответствия единиц
        if(mass_sso[0].toLowerCase()==line_mati.find('.js-ed-1c').text().toLowerCase())
        {
            var count_type=(parseFloat($.trim(mass_sso[2]))*count_mm);
            var all_mm=count_type;
            count_type=$.number(count_type.toFixed(3), 3, '.', ' ');
            count_type = count_type.replace(/[,.]?0+$/, '');
            box.find('.vsego-1c-two i').empty().append(count_type);
            box.find('.vsego-1c-two').attr('all',all_mm);
            box.find('.vsego-1c-two span').empty().append(' '+mass_sso[1]);
        } else
        {

            var count_type=(count_mm/parseFloat($.trim(mass_sso[2])));
            //console.log(count_type);
            var all_mm=count_type;
            count_type=$.number(count_type.toFixed(4), 4, '.', ' ');
            //console.log(count_type);
            count_type = count_type.replace(/[,.]?0+$/, '');
            //console.log(count_type);
            box.find('.vsego-1c-two i').empty().append(count_type);
            box.find('.vsego-1c-two').attr('all',all_mm);
            box.find('.vsego-1c-two span').empty().append(' '+mass_sso[0]);

        }


    }



    //вдруг до этого он что то уже выбирал
    //сделаем эмуляцию нажатий его до
    var uop=line_mati.find('[name="mat[acc][]"]').val();

    if(uop!='') {

        var cor_mass = uop.split(',');

        for (var t = 0; t < cor_mass.length; t++) {
            //console.log()
            $('.material-1c-vibor[id_key='+cor_mass[t]+']').find('.js-acc-ko').trigger('click');
        }
    }
}


function animation_teps_1c()
{
    $('.teps_1c').each(function(i,elem) {
        $(this).animate({width: $(this).attr('rel_w')+"%"}, 1000, function() {  });
    });
}

function acc_1c_matic()
{
    var id_stock=$(this).parents('.material-1c').find('[name="mat[id_stock][]"]').val();
    var cont=$('.ca-1c').val();
    var keyy=$(this).parents('.material-1c').attr('id_key');

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_acc_invoice_1c.php?id_stock='+id_stock+'&cont='+cont+'&key='+keyy,
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


function rout_matic()
{
    var box = $('.box-modal:last');
    var label=box.find('.search_bill_ed_34 label i');
var poll=label.first().text();
    label.first().empty().append(label.last().text());
    label.last().empty().append(poll);
}


//сохранить что выбрали
//  |
// \/
function js_edit_matic_mat_stock()
{

    var box = $('.box-modal:last');
    var box_active = $(this).closest('.box-modal');
    var err = 0;

var id_stock=0;
var new_stock=0;
var unit_stock='';
var usd=[];
    usd['new']=0;
    box_active.find('.js-edit-matic-block-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


    if(box_active.find('.matic-op').val()==1)
    {

        //новый. тогда просто ничего больше не делаем
        new_stock=1;
        usd['new']=1;
    } else
    {
        //ищем какой id_stock он выбрал и выбрал ли вообше
        box_active.find('.js-matic-ko').each(function(i,elem) {

            if($(this).find('input').last().val()==1)
            {

                id_stock=$(this).find('input').first().val();
                unit_stock=$(this).find('input').eq(1).val();
                usd['id_stock']=id_stock;
                usd['units']=unit_stock;
                usd['name']=$(this).parents('.material-1c-vibor').find('.nm').text();
                usd['cor']=box_active.find('.js-form-save-1c').attr('cor');

                return false;

            }

        });

        if(new_stock==0)
        {
            //смотрим выбрал ли он вообще
            if(box_active.find('.js-hidden-search').val()!='')
            {
                id_stock=box_active.find('.js-hidden-search').val();
                unit_stock=box_active.find('.js-hidden-unit').val();
                usd['id_stock']=id_stock;
                usd['units']=unit_stock;
                usd['cor']=box_active.find('.js-form-save-1c').attr('cor');

                usd['name']=box_active.find('.js-hidden-name-m').val();
            }
        }
    }
    if((new_stock==0)&&(id_stock==0))
    {
        alert_message('error','Выберите соответствие или отметьте как новый');
        box.find('.js-edit-matic-block-x').show();
        box.find('.b_loading_small').remove();

    } else
    {
        //смотрим соответствие типов если не новый или просто закрываем окно с сохранением что выбрал
        if(new_stock==0)
        {

            unit_stock=unit_stock.toLowerCase();
            unit_invoice=$('.unit-opa').text().toLowerCase();

            var corr=box_active.find('.js-form-save-1c').attr('cor');

            if((unit_stock==unit_invoice)||(corr!=''))
            {
                //типы одинаковые просто сохраняем что выбрал и все
                alert_message('ok','Сохранено');
                usd['cor']=box_active.find('.js-form-save-1c').attr('cor');
                saveStock1c($(this),usd);

                clearInterval(timerId);
                box.find('.arcticmodal-close').click();


            } else
            {
                box.find('.js-edit-matic-block-x').show();
                box.find('.b_loading_small').remove();


                var unit1 = unit_stock;
                var unit2=unit_invoice;
                $.arcticmodal({
                    type: 'ajax',
                    url: 'forms/form_units_invoice.php?u='+unit1+'&u1='+unit2,
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



        } else
        {

            //типы одинаковые просто сохраняем что выбрал и все
            alert_message('ok','Сохранено');
            saveStock1c($(this),usd);

            clearInterval(timerId);
            box.find('.arcticmodal-close').click();


        }



    }


}


function js_edit_matic_mat_stock_acc()
{

    var box = $('.box-modal:last');
    var box_active = $(this).closest('.box-modal');
    var err = 0;

    var acc=box_active.find('.js-form2').attr('acc');
    var id_key=box_active.find('.js-form2').attr('keyss');
    //if(acc!='')
   // {

        box_active.find('.js-edit-matic-block-xxx').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        alert_message('ok','Сохранено');
        clearInterval(timerId);
        box.find('.arcticmodal-close').click();

        $('.material-1c[id_key='+id_key+']').find('[name="mat[acc][]"]').val(acc);

        if(acc!='') {

            $('.material-1c[id_key=' + id_key + ']').find('.js-load-click-1c').addClass('green_1c');
        } else
        {
            $('.material-1c[id_key=' + id_key + ']').find('.js-load-click-1c').removeClass('green_1c');
        }
/*
    } else
    {
        alert_message('error','Выберите необходимые позиции в счетах');
        box.find('.js-edit-matic-block-xxx').show();
        box.find('.b_loading_small').remove();
    }
*/





}

function js_edit_matic_mat_stock_ed()
{

    var box = $('.box-modal:last');
    var box_active = $(this).closest('.box-modal');
    var error = 0;



    box.find('.gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            error++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });


    if(error!=0)
    {

        alert_message('error','Не все поля заполнены');

    } else
    {
        var label=box.find('.search_bill_ed_34 label i');
        var cor_new='';

        box.find('.input_2021').each(function(i,elem) {
if(cor_new=='')
{
    cor_new=''+$(this).find('label i').text();
} else
{
    cor_new=cor_new+';'+$(this).find('label i').text()+';'+$(this).find('input').val().replace(/\s+/g, '');
}

        });
        //alert(cor_new);


        clearInterval(timerId);
        box.find('.arcticmodal-close').click();
        var box = $('.box-modal:last');

        box.find('.js-form-save-1c').attr('cor',cor_new);
        box.find('.js-edit-matic-block-x').trigger('click');

        //закрываем форму
        //закрываем и вторую форму но сохраняем соотношение
    }

}

//загрузить изменения по этому материалу которые были выбраны до этого
function LoadSave1c(keyy)
{
    //alert(keyy);
    var box_active = $('.box-modal:last');
    var line_mati=$('.material-1c[id_key='+keyy+']');
    var dal=0;
    if(line_mati.find('[name="mat[edit][]"]').val()==1)
    {
        //были какие то заполнения
        //автозаполняем их

        if($('.js-matic-ko').length!=0)
        {
            //возможно что-то выбрано из предложенных
            $('.js-matic-ko').find('input[name="pro[type][]"]').val()
            box_active.find('.js-matic-ko').each(function(i,elem) {

                if($(this).find('input[name="pro[type][]"]').val()==line_mati.find('[name="mat[id_stock][]"]').val())
                {

                    $(this).trigger('click');
                    dal=1;

if(line_mati.find('[name="mat[cor_unit][]"]').val()!='') {
    var sso='';
    var mass_sso=line_mati.find('[name="mat[cor_unit][]"]').val().split(";");
    var sso='1 '+mass_sso[0]+' = '+mass_sso[2]+' '+mass_sso[1];
    //выводим и соотношение единиц которые он вбил
    $(this).parents('.material-1c-vibor').find('.nm').after('<span class="meta_units_1c">' + sso + '<i class="js-i-remove-meta closa-meta"></i></span>');


    box_active.find('.js-form-save-1c').attr('cor',line_mati.find('[name="mat[cor_unit][]"]').val());
}

                    return false;
                }

            });

        }
        if(dal==0)
        {
            if(line_mati.find('[name="mat[new][]"]').val()==1)
            {
                //отмечаем как новый
                box_active.find('.js-1c-matic[id=1]').trigger('click');
            } else
            {
                //было что-то выбрано в поиске материалов на складе
                box_active.find('.js-1c-matic[id=0]').trigger('click');
                box_active.find('.js-mat-inv-posta10').val(line_mati.find('[name="mat[id_stock][]"]').val());
                box_active.find('.js-hidden-unit').val(line_mati.find('[name="mat[unit][]"]').val());
                box_active.find('.js-hidden-name-m').val(line_mati.find('.stock_name_mat').text());

                box_active.find('.js-keyup-search').val(line_mati.find('.stock_name_mat').text());
                //возможно показывать еще соотношения единиц если они разные
                if(line_mati.find('[name="mat[cor_unit][]"]').val()!=0)
                {

                }


            }
        }

    }
}


function saveStock1c(thiss,usd)
{
    var keyss=$('.js-form-save-1c').attr('keyss');
    var line_mat_c=$('.material-1c[id_key='+keyss+']');

    line_mat_c.find('[name="mat[edit][]"]').val(1);
    line_mat_c.find('[name="mat[new][]"]').val(usd["new"]);
    line_mat_c.find('[name="mat[id_stock][]"]').val(usd["id_stock"]);
    line_mat_c.find('[name="mat[unit][]"]').val(usd["units"]);
    line_mat_c.find('[name="mat[cor_unit][]"]').val(usd["cor"]);

    //соотношение единиц если разные или равно 0
    //line_mat_c.find('[name="mat[cor_unit]"]').val(0);
if(usd["new"]==1)
{
    line_mat_c.find('.js-status-1c-mat').after('<span id_status="' + keyss + '" data-tooltip="Новая позиция на складе" class="stock_name_mat js-status-1c-mat">Новая позиция на складе</span>').remove();
} else {
    line_mat_c.find('.js-status-1c-mat').after('<span id_status="' + keyss + '" data-tooltip="название товара на складе" class="stock_name_mat js-status-1c-mat">' + usd["name"] + '</span>').remove();
}

  //поиск счетов по базе
    SearchBill1c( keyss,usd);

    ToolTip();
}

function SearchBill1c( keyss,usd)
{
    var id_file=$('.id-file').val();
    $('.material-1c[id_key='+keyss+']').find('.js-load-click-1c').hide();

    var data = 'url=' + window.location.href + '&id_stock=' + usd["id_stock"] +
        '&file=' + id_file+'&key='+ keyss;
    //alert(data);
    AjaxClient('invoices','search_bill_1c','GET',data,'AfterSearchBill1c',keyss,0,1);


}


//постфункция вкладки в обращениях
function AfterSearchBill1c(data,update) {

    if (data.status == 'reg') {
        WindowLogin();
    }

    if (data.status == 'ok') {

        $('.material-1c[id_key='+update+']').find('.js-load-click-1c').show();

    }
    if (data.status == 'no') {

        $('.material-1c[id_key='+update+']').find('.js-load-click-1c').hide();

    }
}

function acc_matic() {

    if(!$(this).is('.no_active_check')) {
        var per_acc = '';

        var box_active = $('.box-modal:last');
        var cor_acc = box_active.find('.js-form2').attr('acc');

        var all_mat = box_active.find('.vsego-1c-two').attr('all');
        var ost_mat = parseFloat(all_mat);

        if (cor_acc != '') {
            var cor_mass = cor_acc.split(',');
        } else {
            var cor_mass = [];
        }


        if ($('.js-acc-ko').length != 0) {
            //возможно что-то выбрано из предложенных


            var active = $(this).find('input').last().val();
            var id_active = $(this).find('input').first().val();

            //убрать из выбранного
            if (active == 0) {

                i = cor_mass.indexOf(id_active);
                if (i >= 0) {
                    cor_mass.splice(i, 1);

                    //удаляем все неактивные chekc чтобы пересчитать заново все
                    box_active.find('.js-acc-ko').removeClass('no_active_check');


                }

            } else {
                cor_mass.push(id_active);

            }
            //  console.log(cor_mass);

            var new_cor_acc = cor_mass.join(',');

            box_active.find('.js-form2').attr('acc', new_cor_acc);

//alert(new_cor_acc);

            //  console.log(new_cor_acc);

            /*
            box_active.find('.js-acc-ko').each(function (i, elem) {

                var count_this = $(this).find('input').eq(1).val();

            });
*/
            //восстанавливаем как будто все не выбрано
            //box_active.find('.teps_1c').attr('rel_w', box_active.find('.teps_1c').attr('rel_all'));

            box_active.find('.teps_1c').each(function (i, elem) {

               $(this).attr('rel_w', $(this).attr('rel_all'));

            });


            //идем по массиву и изменяем выбранное и смотрим сколько осталось

            for (var t = 0; t < cor_mass.length; t++) {

                var line_mi = $('.material-1c-vibor[id_key="' + cor_mass[t] + '"]');
                var count = parseFloat(line_mi.find('.js-acc-ko input').eq(1).val());
                console.log('количество которое надо-'+count);
                if (count <= ost_mat) {
                    line_mi.find('.teps_1c').attr('rel_w', '100');
                } else {
                    //значит этот материал не полностью придет по этой накладной
                    //надо подсчитать сколько процентов придет
                    var ty1 = parseFloat(line_mi.find('.teps_1c').attr('all_acc'));
                    var ty2 = parseFloat(line_mi.find('.teps_1c').attr('all_inv'));
                    var teper = ty2 + ost_mat;

                    var new_pr = teper * 100 / ty1;
//console.log('teper='+teper);
                   // console.log(new_pr);
                    line_mi.find('.teps_1c').attr('rel_w', Math.floor(new_pr));

                }
                ost_mat = ost_mat - count;
            }
            //console.log('ost_mat'+ost_mat);

            if (ost_mat < 0) {
                ost_mat = 0;
            }

            //изменяем значение сколько осталось
            box_active.find('.vsego-1c-two i').empty().append(ost_mat);

            if (ost_mat == 0) {
                //больше ничего нельзя выбирать делаем остальные инпуты залки которые не выбраны невизимыми
                //.no_active_check
                box_active.find('.material-1c-vibor').each(function (i, elem) {

                    //поиск в массиве
                    i = cor_mass.indexOf($(this).attr('id_key'));
                    if (i >= 0) {} else
                    {
                        $(this).find('.js-acc-ko').addClass('no_active_check');
                    }


                });


            }


        }
        //пересчитать что изменилось
        //изменить trep
        //анимация заполнения
        //сделать неактивными галки которые нельзя выбрать
        animation_teps_1c();
    }
}

function mild_matic()
{

    //убрать активный поиск или новый
    var active_mm=$('.js-matic-cc').find('.active_task_cb').parents('.js-1c-matic');

//alert(active_mm.length);
    active_mm.find('i').removeClass("active_task_cb");
    active_mm.find('input').last().val('');
$('.matic-op').val('');

    var box = $('.box-modal:last');

    box.find('.js-form-save-1c').attr('cor','');
box.find('.meta_units_1c').remove();

}


function view_matic()
{
//alert("!");
    var t_soft=$('.js-type-stock-prime1').val();

    //Скрыть активности в предложенных вариантах
    var act_matic=$('.js-group-c').find('.active_task_cb').parents('.js-checkbox-group');
    //alert(act_matic.length);
    if(act_matic.length!=0) {

        act_matic.find('i').removeClass("active_task_cb");
        act_matic.find('input').last().val(0);

    }
    var box = $('.box-modal:last');

    box.find('.js-form-save-1c').attr('cor','');
    box.find('.meta_units_1c').remove();

    if(t_soft==1)
    {
        $('.js-options-invoice-1').slideDown("slow"); //показать
        $('.js-options-invoice-0').slideUp("slow"); //скрыть
        $('.search_bill_ed').hide();

    } else
    {
        $('.js-options-invoice-0').slideDown("slow");
        $('.js-options-invoice-1').slideUp("slow");

        if($('.js-mat-inv-posta10').val()!='') {
            $('.search_bill_ed').show();
        }
    }
}



function StatusMC()
{
                //открыть окно для вписание замечания
                var pre = $(this).attr('id_status');
var id_file=$('.id-file').val();


var key=$(this).parents('.material-1c').attr('id_key');


                $.arcticmodal({
                    type: 'ajax',
                    url: 'forms/form_1c_material_stock.php?number=' + pre+'&id='+id_file+'&key='+key,
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

function SealWo()
{
    //Отправить прямую форму на согласование
    $('#lalala_seal_form').submit();
}


//переслать заявку
function ForwardWo()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_worder_forward.php?id=' + pre,
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


function RejectWo()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_worder_reject.php?id=' + pre,
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



//сохранить заявку на материал
var save_worder = function()
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
    $('.js-add-worder-material .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            error++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });


    if(error!=0)
    {

        alert_message('error','Не все поля заполнены');

    } else
    {
        $('#lalala_add_form').submit();
    }




}


function calc_open_2021_rang() {
    //alert_message('ok','открыть');
    $("#date_table1").show();
//$("#date_table").focus();
    $('.bookingBox1').css({
        display: 'block'
    });
}


//табсы в обращениях
var tabs_worder = function(event) {
    //event.data.key

    var uoo=$(this).attr("id");


    if(uoo!=0) {
        $(this).parents('.mm_w-preorders').addClass('active-trips-menu');
    } else
    {

        $(this).parents('.mm_w-preorders').removeClass('active-trips-menu');
        $(this).parents('.mm_w-preorders').next().empty().hide();
        $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
    }

    if ( $(this).is(".active") )
    {
        //уже активная вкладка
        $(this).parents('.mm_w-preorders').removeClass('active-trips-menu');
        $(this).parents('.mm_w-preorders').next().empty().hide();
        $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
    } else
    {
        //alert(event.data.key);
        if(uoo!=0) {
            $(this).parents('.mm_w-preorders').next().empty().append('<div class="b_loading_small" style="position:relative; left: calc(50% - 30px); "><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            $(this).parents('.mm_w-preorders').next().slideDown("slow");

            /*
                    $('.form'+event.data.key+' .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            */
            $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
            $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key + '[id=' + uoo + ']').addClass('active');

            //var key_='002U';

            var data = 'url=' + window.location.href + '&id_tabs=' + $(this).attr("id") +
                '&id=' + $(this).parents('.preorders_block_global').attr('id_pre');
            //alert(data);
            AjaxClient('worder','tabs_info','GET',data,'AfterTabsInfoWorder',$(this).attr("id")+','+$(this).parents('.preorders_block_global').attr('id_pre'),0,1);
        }
    }
}

//постфункция вкладки в обращениях
function AfterTabsInfoWorder(data,update)
{
    if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }

    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        $('.preorders_block_global[id_pre='+update[1]+']').find('.px_bg_trips').empty().append(data.query);
        //$('.form'+update[1]+' .px_bg').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        //$('.form'+update[1]+' .js-tabs_docc').hide();
        //$('.form'+update[1]+' .js-tabs_'+update[0]).show();

        NumberBlockFile();
        ToolTip();
        if((update[0]==3)||(update[0]==4))
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            //$('#typesay').unbind('change', changesay);
            //$('#typesay').bind('change', changesay);
            //alert("!");
        }

    }
}

