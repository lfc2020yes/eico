$(function (){

    //кликнуть на что то в раскрывающем меню корзины
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-basket',menu_item_basket);
    $('body').on("change keyup input click", '.js-del-items-basket', js_del_items_basket);


    //инициализация корзины компонентов сверху
    basket_init();

});



//удалить позицию из списка в корзине
function js_del_items_basket()
{
    var opp=$(this).parents('.items_block_pass_basket').attr('op_rel');

    $('.items_block_pass_basket[op_rel='+opp+']').slideUp("slow", function () {
        $('.items_block_pass_basket[op_rel='+opp+']').remove();
    });
    BasketItemsAdd(opp,$(this));




    var iu=$('.content').attr('iu');

    if(typeof(iu) === 'undefined')
    {
       iu=$('.users_rule').attr('ui');

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


//очистить корзину
function erase_basket()
{
    var iu=$('.users_rule').attr('ui');
    $.cookie("basket_item_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});

    //Обновить вывод корзины
    basket_init();

    //скрыть все что выделено в окнах связанное с корзиной
    $('.js-items-block .js-menu-root').removeClass('more-active-s1');

    alert_message('ok','Корзина очищена');
}


//кликнуть на что то в раскрывающем меню корзины
function menu_item_basket(event)
{
    event.stopPropagation();

    var rel=$(this).find('a').attr('rel');
//alert(rel);
    if(rel==1)
    {
        //очистить корзину
        erase_basket();

    }
    if(rel==2)
    {
        //добавить к устройству
        if (typeof timerId != 'undefined') {

            clearInterval(timerId);
            $.arcticmodal('close');

        }

        event.stopPropagation();


        $.arcticmodal({
            type: 'ajax',
            url: 'forms/items/form_basket.php',
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


//инициализация корзины компонентов сверху
function basket_init()
{

    var iu=$('.users_rule').attr('ui');


    var cookie_new = $.cookie('basket_item_'+iu);
    if(cookie_new==null)
    {
       counts=0;
    } else
        {

            var cc = cookie_new.split('.');
            var counts=cc.length;

        }


    if(counts==0)
    {
        //скрыть корзину
        $('.js-basket').hide();
    } else
    {
        $('.js-basket .more_supply1').find('i').empty().append(counts);
        $('.js-basket').addClass('more-active-s');
        $('.js-basket').show();
    }


}

//добавление или удаление из корзины компонентов
function BasketItemsAdd(id,tt)
{
    //alert("!");
    var iu=$('.content').attr('iu');
    if(typeof(iu) === 'undefined')
    {
        iu=$('.users_rule').attr('ui');
    }

    var cookie_new = $.cookie('basket_item_'+iu);

    //alert_message('ok',cookie_new);

    if(cookie_new==null)
    {
        var basket_root=-1;
    } else {

        var basket_root = AddDellListSep(cookie_new, id, 'add', '.');
       // alert(basket_root);
    }
    if(basket_root!=0) {
       //значит еще не добавляли такой компонент в корзину
        CookieList("basket_item_"+iu,id,'add');

       /* if($(tt).parents('.js-menu-root').length!=0)
        {
            //значит нажато  в меню компонента сбоку
            //$(tt).parents('.js-menu-root').addClass('more-active-s1');

            $('.js-items-block[op_rel='+id+']').find('.js-menu-root').addClass('more-active-s1');

        }else
        {
            if($(tt).is('.js-items-block'))
            {
                $(tt).find('.js-menu-root').addClass('more-active-s1');
            }
        }
        */
        $('.js-items-block[op_rel='+id+']').find('.js-menu-root').addClass('more-active-s1');

        //alert_message('ok','позиция добавлена в корзину');



    } else
    {
        //значит уже добавляли такой компонент в корзину - улаояем
        CookieList("basket_item_"+iu,id,'del');
        /*
        if($(tt).parents('.js-menu-root').length!=0)
        {
            //значит нажато  в меню компонента сбоку
            $(tt).parents('.js-menu-root').removeClass('more-active-s1');
        } else
        {
            if($(tt).is('.js-items-block'))
            {
                $(tt).find('.js-menu-root').removeClass('more-active-s1');
            }
        }

         */
        $('.js-items-block[op_rel='+id+']').find('.js-menu-root').removeClass('more-active-s1');
        //alert_message('ok','позиция удалена из корзины');

        //вдруг открыто окно корзины тогда удалить его оттуда



    }
    basket_init();

    //tr.removeClass("checher_supply");



    //CookieList(ssup+iu,id,'del');



    //проверить есть ли такой id уже там

    //удалить или добавить в кукки

    //изменить цвет кнопки

    //изменить количество общей корзины комплектующих показать или скрыть ее


}
