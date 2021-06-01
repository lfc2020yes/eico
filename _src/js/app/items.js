//удалить объект с проверкой в форме

$(function () {
    $('body').on("dblclick", '.js-select-items', add_it);

    //набор текста в поиске
    $('body').on("change keyup input click",'.js-text-search-items',changesort_stock2_items);


    $('body').on("change keyup input click",'.js-info-items',doc_items);
    //нажатие на вкладку в форме информации по объекту
    $('body').on("change keyup input click",'.js-tabs-items',tabs_items);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-items',js_add_items);

    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-items-add0", js_add_items);


    //выбор в меня поиска в клиенте
    var changesort1items = function() {
        var iu=$('.content').attr('iu');

        $.cookie("it_1c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("it_1c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_items_1').bind('change', changesort1items);





    //выбор в меня поиска в клиенте
    var changesort2items = function() {
        var iu=$('.content').attr('iu');

        $.cookie("it_2c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("it_2c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_items_2').bind('change', changesort2items);



    //выбор в меня поиска в клиенте
    var changesort5items = function() {
        var iu=$('.content').attr('iu');

        $.cookie("it_5c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("it_5c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_items_5').bind('change', changesort5items);



    //ввод в поиске
    var changesort7items = function() {
        var iu=$('.content').attr('iu');
        $.cookie("it_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("it_7c"+iu,$(this).val(),'add');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };

    $('#name_stock_search_items').bind('change keyup input click', changesort7items);


    //крестик при поиске в клиентах частные лица
    var changesort_stock2__items= function() {
        var iu=$('.content').attr('iu');
        $(this).prev().val('');
        $.cookie("it_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        $('.js--sort').removeClass('greei_input');
        $('.js--sort').find('input').removeAttr('readonly');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

        $(this).hide();
    }

//удалить поиск по тексту в клиентах
    $('.dell_stock_search_items').bind('change keyup input click', changesort_stock2__items);



});

/**вывод информации по объекту
 *
 */
function doc_items(event)
{

    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-info-invoice'))&&(!$target.hasClass('more_supply1'))&&(!$target.hasClass('js-menu-jjs-b-item'))) {


        var for_id = $(this).parents('.js-items-block').attr('op_rel');


        $.arcticmodal({
            type: 'ajax',
            url: 'forms/items/form_doc_items.php?id=' + for_id + '&tabs=0',
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
/*табсы в окне об объекте
 *
 */
function tabs_items() {
    //alert("!");
    var uoo=$(this).attr("id");
    if ( $(this).is(".active") )
    {
        //уже активная вкладка
    } else
    {
        var box_active = $(this).closest('.box-modal');
        box_active.find('.js-cloud-info-text').empty().append('<div class="b_loading_small" style="position:relative; margin-bottom: 30px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        box_active.find('.js-tabs-menu .js-tabs-items').removeClass('active');
        box_active.find('.js-tabs-menu .js-tabs-items[id='+uoo+']').addClass('active');

        //var key_='002U';



        var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
            '&tk='+box_active.find('.gloab-cc').attr('mor')+
            '&id='+box_active.find('.gloab-cc').attr('for');



        //alert(data);
        AjaxClient('items','tabs_info','GET',data,'AfterTabsInfoitems',$(this).attr("id"),0);
    }
}


/*
 * постфункцию получение информации по нажатию на вкладку об объекте
 * @param data
 * @param update
 * @constructor
 */
function AfterTabsInfoitems(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        //alert("!");
        //определяем активное сейчас окно
        var box = $('.box-modal:last');

        box.find('.js-cloud-info-text').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        box.find('.js-tabs_docc').hide();
        box.find('.js-tabs_'+update).show();
        ToolTip();
        //NumberBlockFile();
        if(update==2)
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            $('#typesay').unbind('change', changesay);
            $('#typesay').bind('change', changesay);
            NumberBlockFile();

        }
    }
}

/**
 добавить новый объект
 **/
function js_add_items()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/items/form_add_items.php',
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



//arr - id (1.2.4.5) по которым надо получить новые данные
function UpdateItems(arr)
{
    var data ='url='+window.location.href+'&arr='+arr;

    AjaxClient('items','update_items','GET',data,'AfterUpdateItems',arr,0,1);
}

/*

"js-items-id-"  - id компонента
"js-items-up-"  - 0 - обновить 1 - удалить
"js-items-na-"  - название
"js-items-sv-"  - связь или 0 если не с кем
"js-items-sd-"  - id устройства с которым связан
"js-items-co-"  - комментарий или 0
"js-items-in-"  - название счета или 0
"js-items-ba-"  - 0 - нет в корзине 1 - есть в корзине
"js-items-ind-" - id счета с которым связана или 0
*/
//постфункция получения новой инфы по набору компонентов
function AfterUpdateItems(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {

        var class_glu = ["js-items-id-","js-items-up-","js-items-na-", "js-items-sv-","js-items-sd-","js-items-co-","js-items-in-","js-items-ba-","js-items-ind-"];

        for (var t = 0; t < data.arr.length; t++) {

            var aaaa1 = data.arr[t].split('/-');

                    if (aaaa1[1] == 1) {
                        $('.js-items-block[op_rel=' + aaaa1[0] + ']').slideUp("slow", function () {
                            $('.js-items-block[op_rel=' + aaaa1[0] + ']').remove();
                        });
                    } else {

                        //Название
                        $('.js-items-na-' + aaaa1[0]).empty().append(aaaa1[2]);

                        //связь с устройством
                        if (aaaa1[3] == 0) {

                            //Связи с устройством нет значит можно добавлять удалять из корзины
                            $('.js-items-sv-' + aaaa1[0]).empty().hide();
                            $('.js-items-block[op_rel='+aaaa1[0]+']').addClass('select-item-yes');
                            $('.js-items-block[op_rel='+aaaa1[0]+']').addClass('js-select-items');

                            var menu_item=$('.js-items-block[op_rel='+aaaa1[0]+']').find('.js-menu-root');

                            menu_item.find('.js-menu-jjs-b-item').removeClass('no-display');

                            menu_item.find('[make=dell_device]').closest('.js-menu-jjs-b-item').addClass('no-display');


                        } else {
                            $('.js-items-sv-' + aaaa1[0]).empty().append(aaaa1[3]).show();
                            $('.js-items-sv-' + aaaa1[0]).attr('op_rel', aaaa1[4]);

                            //значит теперь нельзя добавить в корзину
                            $('.js-items-block[op_rel='+aaaa1[0]+']').removeClass('select-item-yes');
                            $('.js-items-block[op_rel='+aaaa1[0]+']').removeClass('js-select-items');

                            //открыть меню недоступное и скрыть нужное

                            var menu_item=$('.js-items-block[op_rel='+aaaa1[0]+']').find('.js-menu-root');

                            menu_item.find('.js-menu-jjs-b-item').removeClass('no-display');

                            menu_item.find('[make=dell]').closest('.js-menu-jjs-b-item').addClass('no-display');
                            menu_item.find('[make=no_basket]').closest('.js-menu-jjs-b-item').addClass('no-display');
                            menu_item.find('[make=devices]').closest('.js-menu-jjs-b-item').addClass('no-display');

                            //menu_item.find('[make=devices]').closest('.js-menu-jjs-b-item').addClass('no-display');


                        }

                        //комментарий
                        if (aaaa1[5] == 0) {
                            $('.js-items-co-' + aaaa1[0]).empty().hide();
                        } else {
                            $('.js-items-co-' + aaaa1[0]).empty().append(aaaa1[5]).show();
                        }

                        //связь со счетом
                        if (aaaa1[6] == 0) {
                            $('.js-items-in-' + aaaa1[0]).empty().hide();
                        } else {
                            $('.js-items-in-' + aaaa1[0]).empty().append(aaaa1[6]).show();
                            $('.js-items-in-' + aaaa1[0]).attr('op_rel', aaaa1[8]);
                        }

                        //корзина есть там или нет
                        if (aaaa1[7] == 0) {
                            //нет в корзине
                            $('.js-items-block[op_rel=' + aaaa1[0] + '] js-menu-root').removeClass('.more-active-s1');
                        } else {
                            //есть в корзине
                            $('.js-items-block[op_rel=' + aaaa1[0] + '] js-menu-root').addClass('.more-active-s1');
                        }


                    }
                }





    }
}



function changesort_stock2_items() {
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


//добавить/удалить их корзины при клике по компоненту
function add_it(event)
{
    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('more_supply1'))&&(!$target.hasClass('js-menu-jjs-b-item'))&&(!$target.hasClass('invoice-link'))) {
        var id=$(this).attr('op_rel');
        BasketItemsAdd(id,$(this));

    }

}

function js_add_items_x()
{
    var box_active = $(this).closest('.box-modal');

    var err = 0;
//alert($('.js-form-register .gloab').length);
    box_active.find('.js-form-add-items .gloab').each(function(i,elem) {
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

        var for_id=box_active.find('.gloab-cc').attr('for');


        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('items','add','POST',0,'after_add_items_x',0,'vino_xd_fiance_pay_2');


        box_active.find('.js-add-items-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }




}

function js_edit_items_x()
{
    var err = 0;

    var box_active = $(this).closest('.box-modal');


//alert($('.js-form-register .gloab').length);


    box_active.find('.js-form-edit-items  .gloab').each(function(i,elem) {
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

        var for_id=box_active.find('.gloab-cc').attr('for');

        //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
        //$.arcticmodal('close');

        AjaxClient('items','edit','POST',0,'after_edit_items_x',0,'vino_xd_fiance_pay_2');


        box_active.find('.js-edit-items-x').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 17px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');



    } else
    {
        //найдем самый верхнюю ошибку и пролестнем к ней
        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
        //ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
        alert_message('error','Не все поля заполнены');


    }




}


function js_dell_items_b()
{

    var box_active = $(this).closest('.box-modal');

    var for_id=box_active.find('.gloab-cc').attr('for');


    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.gloab-cc').attr('mor');

    AjaxClient('items','dell','GET',data,'Afterdellitems',for_id,0);





    box_active.find('.js-dell-items-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
}



function js_itemsdevice_remove()
{
    var box_active = $(this).closest('.box-modal');

    var for_id=box_active.find('.gloab-cc').attr('for');


    //clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
    //$.arcticmodal('close');

    var data ='url='+window.location.href+'&id='+for_id+'&tk='+box_active.find('.gloab-cc').attr('mor');

    AjaxClient('items','remove_from_items','GET',data,'Afteritemsdevice_remove',for_id,0);





    box_active.find('.js-dell-itemsdevice-b').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: auto; display: inline-block;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
}


function after_add_items_x(data,update)
{
    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();
//определяем активное сейчас окно
        var box = $('.box-modal:last');

        alert_message('ok','Позиция добавлена');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();
        var block_count=parseInt($('.js-count-items .smena_').text());
        block_count++;
        $('.js-count-items .smena_').empty().append(block_count);
        //alert(data.blocks);
        $('.js-count-items').after(data.blocks);

        var tytt=PadejNumber((block_count),'позиция, позиции,позиций');
        $('.js-count-items .smena_1').empty().append(tytt);


        setTimeout ( function () { $('.js-items-block').removeClass('new-say');  }, 4000 );

        $('.js-cloud-items .help_div').slideUp("slow");
        $('.js-cloud-items .js-count-items').slideDown("slow");

        clearInterval(timerId);

        box.find('.arcticmodal-close').click();
        //$( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();

        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        box.find('.js-add-items-x').show();
        box.find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['name_b','id_kto'];

            var err_name = ['некорректно заполнено - Название','некорректно заполнен - Счет'];

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


function after_edit_items_x(data,update)
{
    //определяем активное сейчас окно
    var box=$('.box-modal:last');

    if (data.status=='ok')
    {
        // $('.js-form-tender-new').remove();

        alert_message('ok','Позиция изменена');
        //UpdateFinance('1,0,1,1');
        //$('.js-next-step').submit();

//alert(box.find('#vino_xd_fiance_pay_2 [name=name_b]').val());

        var t=box.find('#vino_xd_fiance_pay_2 [name=name_b]').val();
        var r=box.find('#vino_xd_fiance_pay_2 [name=comm_b]').val();

//изменить на то на что изменили

        if(jQuery.trim(t)!='')
        {
            $('.js-items-na-'+data.update).empty().append(t).show();
        } else
        {
            $('.js-items-na-'+data.update).empty().hide();
        }

        if(jQuery.trim(r)!='')
        {
            $('.js-items-co-'+data.update).empty().append(r).show();
        } else
        {
            $('.js-items-co-'+data.update).empty().hide();
        }



        //обновление позиций
        UpdateItems(data.update);


        //если счет изменился на новый то удалить если есть вывод .items_block_pass_small
        if(data.up==1)
        {
            $('.items_block_pass_small[op_rel='+data.update+']').slideUp("slow", function() {
                $('.items_block_pass_small[op_rel=' + data.update + ']').remove();
            });
        }

        box.find('.arcticmodal-close').click();


        //setTimeout ( function () { $('#js-form-add-fin').submit();  }, 1000 );

    } else
    {
        box.find('.js-edit-items-x').show();
        box.find('.js-edit-items-x').parents('.box-modal').find('.b_loading_small').remove();

        //alert_message('error','Ошибка! Заполните все поля');

        //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

        //проходимя по массиву ошибок
        $.each(data.error, function(index, value){

            var err = ['name_b'];

            var err_name = ['некорректно заполнено - Название'];

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



function Afterdellitems(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' ) {

        //определяем активное сейчас окно
        var box = $('.box-modal:last');

        box.find('.arcticmodal-close').click();
        //$( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();

        alert_message('ok','Позиция удалена');

        $('.js-items-block[op_rel='+update+']').slideUp("slow", function() {
            $('.js-items-block[op_rel=' + update + ']').remove();
        });

        //если он был в корзине удаляем оттуда
        var iu=$('.content').attr('iu');
        var cookie_new = $.cookie('basket_item_'+iu);
        var basket_root = AddDellListSep(cookie_new, update, 'add', '.');
        if(basket_root==0)
        {
            CookieList("basket_item_"+iu,update,'del');
        }
        basket_init();

        //уменьшаем общее количество компонентов в выводе по счету
        if($('.js-invoice-it-'+data.inv).length!=0)
        {
            var block_count=parseInt($('.js-invoice-it-'+data.inv).text());
            block_count--;
            $('.js-invoice-it-'+data.inv).empty().append(block_count);
        }
    }
}


/*
 * постфункция удаления компонента из
 * @param data
 * @param update
 * @constructor
 */
function Afteritemsdevice_remove(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        //определяем активное сейчас окно
        var box = $('.box-modal:last');
        box.find('.arcticmodal-close').click();

        //$( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();
        alert_message('ok','Связь с устройством удалена');
        $('.js-items-sv-'+data.id).empty().hide();

        //открыть меню недоступное и скрыть нужное

        var menu_item=$('.js-items-block[op_rel='+data.id+']').find('.js-menu-root');

        //alert(menu_item.length);

        menu_item.find('.js-menu-jjs-b-item').removeClass('no-display');


        menu_item.find('[make=dell_device]').closest('.js-menu-jjs-b-item').addClass('no-display');


        $('.js-items-block[op_rel='+data.id+']').addClass('js-select-items');
        $('.js-items-block[op_rel='+data.id+']').addClass('select-item-yes');
    }
}