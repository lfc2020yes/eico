$(function (){

    //изменить объект
    $('body').on("change keyup input click",'.js-person-edit',js_edit_person);

    //кликнуть на что то в раскрывающем меню точки
    $('body').on("change keyup input click",'.menu_jjs .js-menu-jjs-b',menubuttclick_person);


    $('body').on("change keyup input click",'.js-info-person',doc_person);
    //нажатие на вкладку в форме информации по объекту
    $('body').on("change keyup input click",'.js-tabs-person',tabs_person);

    //удалить объект
    $('body').on("change keyup input click",'.js-person-del',js_person_del);

    //добавить новый объект
    $('body').on("change keyup input click",'.js-add-person',js_add_person);

    //добавить новый объект меню слева
    $('.menu_x').on("change keyup input click",".js-person-add0", js_add_person);

    //набор текста в поиске
    $('body').on("change keyup input click",'.js-text-search-x',changesort_stock2);

    //выбор в меня поиска в клиенте
    var changesort1c = function() {
        var iu=$('.content').attr('iu');

        $.cookie("su_1c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("su_1c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#sort1c').bind('change', changesort1c);

    //выбор в меня поиска в клиенте
    var changesort3c = function() {
        var iu=$('.content').attr('iu');

        $.cookie("su_3c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("su_3c"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };
    $('#sort3c').bind('change', changesort3c);


    //ввод в поиске

    var changesort7c = function() {
        var iu=$('.content').attr('iu');
        $.cookie("su_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        CookieList("su_7c"+iu,$(this).val(),'add');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

    };

    $('#name_stock_search').bind('change keyup input click', changesort7c);


    //крестик при поиске в клиентах частные лица
    var changesort_stock2__= function() {
        var iu=$('.content').attr('iu');
        $(this).prev().val('');
        $.cookie("su_7c"+iu, null, {path:'/',domain: window.is_session,secure: false});
        $('.js--sort').removeClass('greei_input');
        $('.js--sort').find('input').removeAttr('readonly');

        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');

        $(this).hide();
    }

//удалить поиск по тексту в клиентах
    $('.dell_stock_search').bind('change keyup input click', changesort_stock2__);

});

/*
 * кликнуть на что то в раскрывающем меню точки
 */

function menubuttclick_person(event)
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
            url: 'forms/person/form_edit_person.php?id_buy='+id_buy,
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
            url: 'forms/person/form_dell_person.php?id_buy='+id_buy,
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
function tabs_person() {
    //alert("!");
    var uoo=$(this).attr("id");
    if ( $(this).is(".active") )
    {
        //уже активная вкладка
    } else
    {
        $('.js-cloud-info-text').empty().append('<div class="b_loading_small" style="position:relative; margin-bottom: 30px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

        $('.js-tabs-menu').find('.js-tabs-person').removeClass('active');
        $('.js-tabs-menu').find('.js-tabs-person[id='+uoo+']').addClass('active');

        //var key_='002U';



        var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
            '&tk='+$('.box-modal .gloab-cc').attr('mor')+
            '&id='+$('.box-modal .gloab-cc').attr('for');



        //alert(data);
        AjaxClient('person','tabs_info','GET',data,'AfterTabsInfoPerson',$(this).attr("id"),0);
    }
}
//добавление Отдела
function person_adds()
{
    if(typeof timerId !== "undefined")
    {
        clearInterval(timerId);
        $.arcticmodal('close');
    }

    //var at= $(this).attr('tabs_g');


    $.arcticmodal({
        type: 'ajax',
        url: 'forms/person/form_add_person.php',
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
function doc_person(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    $target = $(event.target);
    //если это не нажатие на кнопки редактировать удалить то открытие информации
    if ((!$target.hasClass('js-person-del'))&&(!$target.hasClass('js-person-edit'))) {


        //var for_id = $(this).parents('.js-person-block').attr('op_rel');

        if($(this).is('[op_rel]'))
        {
            var for_id= $(this).attr('op_rel');
        } else {


            var for_id = $(this).parents('.js-person-block').attr('op_rel');
        }




        $.arcticmodal({
            type: 'ajax',
            url: 'forms/person/form_doc_person.php?id=' + for_id + '&tabs=0',
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


/**
 добавить новый объект
 **/
function js_add_person()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/person/form_add_person.php',
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
function js_edit_person(event)
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


        var id_buy = $(this).parents('.person_block_pass').attr('op_rel');
    }
    event.stopPropagation();

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/person/form_edit_person.php?id_buy='+id_buy,
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
function js_person_del(event)
{
    if (typeof timerId != 'undefined') {

        clearInterval(timerId);
        $.arcticmodal('close');

    }

    if($(this).is('[id_rel]'))
    {
        var id_buy= $(this).attr('id_rel');
    } else {
        var id_buy = $(this).parents('.person_block_pass').attr('op_rel');
    }

    event.stopPropagation();




    $.arcticmodal({
        type: 'ajax',
        url: 'forms/person/form_dell_person.php?id_buy='+id_buy,
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