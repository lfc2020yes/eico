$(function (){


    //кликнуть на что то в раскрывающем меню точки
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-b-invoice',menubuttclick_invoice);


    //кликнуть на что то в раскрывающем меню точки
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-b-item',menu_item);


    //изменить объект
    $('body').on("change keyup input click",'.js-invoice-edit',js_edit_invoice);

    $('body').on("change keyup input click",'.js-info-invoice',doc_invoice);
    //нажатие на вкладку в форме информации по объекту
    $('body').on("change keyup input click",'.js-tabs-invoice',tabs_invoice);

    //удалить объект
    $('body').on("change keyup input click",'.js-invoice-del',js_invoice_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-invoice',js_add_invoice);

    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-invoice-add0", js_add_invoice);

    //набор текста в поиске
    $('body').on("change keyup input click",'.js-text-search-invoice',changesort_stock2_invoice);



    /*
     * кликнуть на что то в раскрывающем меню точки
     */

    function menubuttclick_invoice(event)
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
                url: 'forms/invoice/form_edit_invoice.php?id_buy='+id_buy,
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
                url: 'forms/invoice/form_dell_invoice.php?id_buy='+id_buy,
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




    //выбор в меня поиска в клиенте
    var changesort1invoice = function() {
        var iu=$('.content').attr('iu');

        $.cookie("in_1c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("in_1c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_invoice_1').bind('change', changesort1invoice);

    //выбор в меня поиска в клиенте
    var changesort3invoice = function() {
        var iu=$('.content').attr('iu');

        $.cookie("in_3c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("in_3c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_invoice_3').bind('change', changesort3invoice);



    //выбор в меня поиска в клиенте
    var changesort2invoice = function() {
        var iu=$('.content').attr('iu');

        $.cookie("in_2c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("in_2c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#search_invoice_2').bind('change', changesort2invoice);

    //ввод в поиске

    var changesort7invoice = function() {
        var iu=$('.content').attr('iu');
        $.cookie("in_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("in_7c"+iu,$(this).val(),'add');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };

    $('#name_stock_search_invoice').bind('change keyup input click', changesort7invoice);


    //крестик при поиске в клиентах частные лица
    var changesort_stock2__invoice= function() {
        var iu=$('.content').attr('iu');
        $(this).prev().val('');
        $.cookie("in_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        $('.js--sort').removeClass('greei_input');
        $('.js--sort').find('input').removeAttr('readonly');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

        $(this).hide();
    }

//удалить поиск по тексту в клиентах
    $('.dell_stock_search_invoice').bind('change keyup input click', changesort_stock2__invoice);

});





/*
 * кликнуть на что то в раскрывающем меню точки
 */

function menu_item(event)
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

        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {
            var id_buy = $(this).parents('.js-items-block').attr('op_rel');
        }

        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/items/form_edit_items.php?id_buy='+id_buy,
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

        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {


            var id_buy = $(this).parents('.js-items-block').attr('op_rel');
        }

        event.stopPropagation();
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/items/form_dell_items.php?id_buy='+id_buy,
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

    if(rel=='dell_device')
    {
        //изменить
        /*
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }
        */

        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {


            var id_buy = $(this).parents('.js-items-block').attr('op_rel');
        }

        event.stopPropagation();

        $.arcticmodal({
            type: 'ajax',
            url: 'forms/items/form_items_remove_from_device.php?id_buy='+id_buy,
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

    if(rel=='devices')
    {

        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {


            var id_buy = $(this).parents('.js-items-block').attr('op_rel');
        }

        event.stopPropagation();

//добавляем в корзину
        BasketItemsAdd(id_buy,$(this));

    }
    if(rel=='no_basket')
    {

        if($(this).is('[id_rel]'))
        {
            var id_buy= $(this).attr('id_rel');
        } else {
            var id_buy = $(this).parents('.js-items-block').attr('op_rel');
        }

        event.stopPropagation();

//добавляем в корзину
        BasketItemsAdd(id_buy,$(this));

        //вдруг мы в выводе корзины тогда удалить его оттуда и все пересчитать
        $('.items_block_pass_basket[op_rel='+id_buy+']').slideUp("slow", function () {
            $('.items_block_pass_basket[op_rel='+id_buy+']').remove();
        });


        var iu=$('.content').attr('iu');

        if(typeof(iu) === 'undefined')
        {
            iu=$('.users_rule').attr('iu');

        }
        //alert(iu);
        var cookie_new = $.cookie('basket_item_'+iu);

        if((cookie_new=='')||(cookie_new==null))
        {
            $( '.arcticmodal-close', $('.js-form2').closest( '.box-modal' )).click();
            var counts=0;
        } else
        {

            var cc = cookie_new.split('.');
            var counts=cc.length;
        }

        $('.count-basket-items').find('i').empty().append(counts);



    }


}





/*
 * кликнуть на что то в раскрывающем меню точки
 */






function changesort_stock2_invoice() {
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
function tabs_invoice() {
    //alert("!");
    var uoo=$(this).attr("id");
    if ( $(this).is(".active") )
    {
        //уже активная вкладка
    } else
    {
        $('.js-cloud-info-text').empty().append('<div class="b_loading_small" style="position:relative; margin-bottom: 30px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        $('.js-tabs-menu').find('.js-tabs-invoice').removeClass('active');
        $('.js-tabs-menu').find('.js-tabs-invoice[id='+uoo+']').addClass('active');

        //var key_='002U';



        var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
            '&tk='+$('.box-modal .gloab-cc').attr('mor')+
            '&id='+$('.box-modal .gloab-cc').attr('for');



        //alert(data);
        AjaxClient('invoice','tabs_info','GET',data,'AfterTabsInfoinvoice',$(this).attr("id"),0);
    }
}
//добавление Отдела
function invoice_adds()
{
    if(typeof timerId !== "undefined")
    {
        clearInterval(timerId);
        $.arcticmodal('close');
    }

    //var at= $(this).attr('tabs_g');


    $.arcticmodal({
        type: 'ajax',
        url: 'forms/invoice/form_add_invoice.php',
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
function doc_invoice(event)
{


    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-invoice-del'))&&(!$target.hasClass('js-invoice-edit'))) {

        //var for_id = $(this).parents('.js-invoice-block').attr('op_rel');
        if($(this).parents('.js-invoice-block').is('[op_rel]'))
        {
            var for_id = $(this).parents('.js-invoice-block').attr('op_rel');
        } else {


            var for_id = $(this).attr('op_rel');
        }


        if((for_id!=null)&&(for_id!='')&&(for_id!=0)) {
            if (typeof timerId != 'undefined') {

                clearInterval(timerId);
                $.arcticmodal('close');

            }

            $.arcticmodal({
                type: 'ajax',
                url: 'forms/invoice/form_doc_invoice.php?id=' + for_id + '&tabs=0',
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
}


/**
 добавить новый объект
 **/
function js_add_invoice()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/invoice/form_add_invoice.php',
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

/**
 * изменить Объекта
 */
function js_edit_invoice(event)
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


        var id_buy = $(this).parents('.invoice_block_pass').attr('op_rel');
    }
    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/invoice/form_edit_invoice.php?id_buy='+id_buy,
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
function js_invoice_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.invoice_block_pass').attr('op_rel');
    }

    event.stopPropagation();




    $.arcticmodal({
        type: 'ajax',
        url: 'forms/invoice/form_dell_invoice.php?id_buy='+id_buy,
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