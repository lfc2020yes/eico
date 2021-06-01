$(function (){



    $('body').on("change keyup input click",'.js-add-devices-x',js_add_devices);
    $('body').on("keyup",'.js-input-inv',js_input_devices);
    //кликнуть на что то в раскрывающем меню точки
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-b-devices',menu_devices);

    $('body').on("change keyup input click",'.js-del-items-devives-x',js_dell_items_form);



    //изменить объект
    $('body').on("change keyup input click",'.js-devices-edit',js_edit_devices);

    //кликнуть на что то в раскрывающем меню точки
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-b',menubuttclick);


    $('body').on("change keyup input click",'.js-info-devices',doc_devices);
    //нажатие на вкладку в форме информации по объекту
    $('body').on("change keyup input click",'.js-tabs-devices',tabs_devices);

    //удалить объект
    $('body').on("change keyup input click",'.js-devices-del',js_devices_del);



    //набор текста в поиске
    $('body').on("change keyup input click",'.js-text-search-devices',changesort_stock2_devices);

    //выбор в меня поиска в клиенте
    var changesort1devices = function() {
        var iu=$('.content').attr('iu');

        $.cookie("de_1c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("de_1c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_devices_1').bind('change', changesort1devices);





    //выбор в меня поиска в клиенте
    var changesort2devices = function() {
        var iu=$('.content').attr('iu');

        $.cookie("de_2c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("de_2c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_devices_2').bind('change', changesort2devices);



    //выбор в меня поиска в клиенте
    var changesort5devices = function() {
        var iu=$('.content').attr('iu');

        $.cookie("de_5c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("de_5c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_devices_5').bind('change', changesort5devices);



    //ввод в поиске
    var changesort7devices = function() {
        var iu=$('.content').attr('iu');
        $.cookie("de_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("de_7c"+iu,$(this).val(),'add');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };

    $('#name_stock_search_devices').bind('change keyup input click', changesort7devices);


    //крестик при поиске в клиентах частные лица
    var changesort_stock2__devices= function() {
        var iu=$('.content').attr('iu');
        $(this).prev().val('');
        $.cookie("de_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        $('.js--sort').removeClass('greei_input');
        $('.js--sort').find('input').removeAttr('readonly');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

        $(this).hide();
    }

//удалить поиск по тексту в клиентах
    $('.dell_stock_search_devices').bind('change keyup input click', changesort_stock2__devices);



});


function js_dell_items_form()
{
    var idds=$(this).closest('.js-items-block').attr('op_rel');

    var innput=$(this).closest('.js-block-all-items-devices').find('[name=items-mass]');

    innput.val(AddDellList(innput.val(),idds,'dell'));




    $(this).closest('.js-items-block').slideUp("slow", function () {
        $(this).closest('.js-items-block').remove();
    });

}


function changesort_stock2_devices() {
    //alert("1");
    if($(this).val()!='')
    {
        $(this).next().show();
        //скрыть другие элементы поиска
        $('.js--sort').addClass('greei_input');
        $('.js--sort').find('input').prop('readonly',true);

    }else
    {
        $(this).next().hide();
        //показать другие элементы поиска
        $('.js--sort').removeClass('greei_input');
        $('.js--sort').find('input').removeAttr('readonly');

    }
}

function menu_devices(event)
{
    event.stopPropagation();

    var rel=$(this).find('a').attr('make');

    if(rel=='edit')
    {
        //изменить
        /*
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        */
        //alert("!");

        if($(this).is('[op_rel]'))
        {
            var id_buy= $(this).attr('op_rel');
        } else {
            var id_buy = $(this).parents('.js-devices-block').attr('op_rel');
        }

        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_edit_devices.php?id_buy='+id_buy,
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
    if(rel=='dell')
    {
        //изменить
        /*
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        */

        if($(this).is('[op_rel]'))
        {
            var id_buy= $(this).attr('op_rel');
        } else {
            var id_buy = $(this).parents('.js-devices-block').attr('op_rel');
        }


        event.stopPropagation();
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_dell_devices.php?id_buy='+id_buy,
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

    if(rel=='add_person')
    {
        //изменить
        /*
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        */

        if($(this).is('[op_rel]'))
        {
            var id_buy= $(this).attr('op_rel');
        } else {
            var id_buy = $(this).parents('.js-devices-block').attr('op_rel');
        }


        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_add_person_device.php?id_buy='+id_buy,
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

    if(rel=='dell_person')
    {
        //изменить
        /*
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        */

        if($(this).is('[op_rel]'))
        {
            var id_buy= $(this).attr('op_rel');
        } else {
            var id_buy = $(this).parents('.js-devices-block').attr('op_rel');
        }


        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_dell_person_devices.php?id_buy='+id_buy,
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
    if(rel=='add_akt')
    {
        //изменить
        /*
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        */

        if($(this).is('[op_rel]'))
        {
            var id_buy= $(this).attr('op_rel');
        } else {
            var id_buy = $(this).parents('.js-devices-block').attr('op_rel');
        }


        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_akt_devices.php?id_buy='+id_buy,
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


function js_input_devices()
{
    var st_latin=$(this).val();

    var a = $('.js-input-inv1').val().split('-');
    if(a.length>1)
    {
        var st_end=jQuery.trim(a[0])+' - 0'+st_latin;
    }
    else
    {
        var st_end=$('.js-input-inv1').val();
    }
    $('.js-input-inv1').trigger('click');
    $('.js-input-inv1').val(st_end);
}







/*
 * кликнуть на что то в раскрывающем меню точки
 */

function menubuttclick(event)
{
    event.stopPropagation();


    var rel=$(this).find('a').attr('make');

    if(rel=='edit')
    {
        //изменить
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {


            var id_buy = $(this).parents('.block_pass').attr('pass_rel');
        }

        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_edit_devices.php?id_buy='+id_buy,
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
    if(rel=='dell')
    {
        //изменить
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {


            var id_buy = $(this).parents('.block_pass').attr('pass_rel');
        }

        event.stopPropagation();


        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_dell_devices.php?id_buy='+id_buy,
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


function changesort_stock2() {
    //alert("1");
    if($(this).val()!='')
    {
        $(this).next().show();
        //скрыть другие элементы поиска
        $('.js--sort').addClass('greei_input');
        $('.js--sort').find('input').prop('readonly',true);

    }else
    {
        $(this).next().hide();
        //показать другие элементы поиска
        $('.js--sort').removeClass('greei_input');
        $('.js--sort').find('input').removeAttr('readonly');

    }
}



/*табсы в окне об объекте
 *
 */
function tabs_devices() {
    //alert("!");
    var uoo=$(this).attr("id");
    if ( $(this).is(".active") )
    {
        //уже активная вкладка
    } else
    {
        $('.js-cloud-info-text').empty().append('<div class="b_loading_small" style="position:relative; margin-bottom: 30px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        $('.js-tabs-menu').find('.js-tabs-devices').removeClass('active');
        $('.js-tabs-menu').find('.js-tabs-devices[id='+uoo+']').addClass('active');

        //var key_='002U';



        var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
            '&tk='+$('.box-modal .gloab-cc').attr('mor')+
            '&id='+$('.box-modal .gloab-cc').attr('for');



        //alert(data);
        AjaxClient('devices','tabs_info','GET',data,'AfterTabsInfodevices',$(this).attr("id"),0);
    }
}
//добавление Отдела
function devices_adds()
{
    if(typeof timerId !== "undefined")
    {
        clearInterval(timerId);
        $.arcticmodal('close');
    }

    //var at= $(this).attr('tabs_g');


    $.arcticmodal({
        type: 'ajax',
        url: 'forms/devices/form_add_devices.php',
        beforeOpen: function(data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function(data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function(data, el) { // после закрытия окна ArcticModal
            if(typeof timerId !== "undefined")
            {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });



}





/**вывод информации по объекту
 *
 */
function doc_devices(event)
{
    /*
alert("!");
    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-info-devices'))&&(!$target.hasClass('more_supply1'))&&(!$target.hasClass('js-menu-jjs-b-item'))) {
*/

        var for_id = $(this).parents('.js-devices-block').attr('op_rel');


        $.arcticmodal({
            type: 'ajax',
            url: 'forms/devices/form_doc_devices.php?id=' + for_id + '&tabs=0',
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
/*
    }*/
}


/**
 добавить новое устройство
 **/
function js_add_devices()
{
    var err = 0;
//alert($('.js-form-register .gloab').length);
    // alert("!!");
    $('.js-form-gloab-device .gloab').each(function(i,elem) {
        if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
            $(this).parents('.list_2018').addClass('required_in_2018');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
    });

//	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

//	if (!$(".js-devices-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните Отдел');  err++; }

    //alert(err);

    if(err==0)
    {

        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('devices','add','POST',0,'after_add_devices',0,'vino_xd_add_device',1);


        $('.js-add-devices-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }
}

/**
 * изменить Объекта
 */
function js_edit_devices(event)
{
    //alert("!");
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }
    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {


        var id_buy = $(this).parents('.devices_block_pass').attr('op_rel');
    }
    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/devices/form_edit_devices.php?id_buy='+id_buy,
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


/**
 * удалить объект
 */
function js_devices_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.devices_block_pass').attr('op_rel');
    }

    event.stopPropagation();




    $.arcticmodal({
        type: 'ajax',
        url: 'forms/devices/form_dell_devices.php?id_buy='+id_buy,
        beforeOpen: function(data, el) {
            //во время загрузки формы с ajax загрузчик
            $('.loader_ada_forms').show();
            $('.loader_ada1_forms').addClass('select_ada');
        },
        afterLoading: function(data, el) {
            //после загрузки формы с ajax
            data.body.parents('.arcticmodal-container').addClass('yoi');
            $('.loader_ada_forms').hide();
            $('.loader_ada1_forms').removeClass('select_ada');
        },
        beforeClose: function(data, el) { // после закрытия окна ArcticModal
            if(typeof timerId !== "undefined")
            {
                clearInterval(timerId);
            }
            BodyScrool();
        }

    });



}



/*
 * постфункция Добавление объекта
 */
function after_add_devices(data,update)
{
    if (data.status=='ok')
    {

        alert_message('ok','Устройство добавлено');

        var iu=$('.users_rule').attr('iu');
        $.cookie("basket_item_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

        //Обновить вывод корзины
        basket_init();

        $('.js-add-form-dev').slideUp("slow", function () {
            $('.js-add-form-dev').remove();
        });

        $('.js-new-dev').empty().append(data.blocks);
        $('.js-new-dev').slideDown("slow");


    } else
    {

        $('.js-add-devices-x').show();
        $('.js-add-devices-x').parents('.form-panel').find('.b_loading_small').remove();


        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){


            var err = ['inv','name_devices','inv_busy'];

            var err_name = ['некорректно заполнено - Инвентарный номер','некорректно заполнен - Название','Инвентарный номер занят'];



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

                if(numbers==2)
                {
                    alert_message('error','Следующий свободный инвертарный номер - '+data.nd);
                }
            } else
            {
                //$('.js-form-register .message-form').empty().append('Ошибка! ');
                alert_message('error','Ошибка!');
            }
            //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        });
    }
}