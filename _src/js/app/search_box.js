
$(function () {

    var changesort_stock2__x= function() {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_st_2w_x"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $(this).prev().val('');


        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();


        $(this).hide();
    }

    var changesort_stock2w_x= function() {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_st_2w_x"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        CookieList("su_st_2w_x"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();
        if($(this).val()!='')
        {
            $(this).next().show();
            //скрыть другие элементы поиска
            //$('.js--sort').addClass('greei_input');
            //$('.js--sort').find('input').prop('readonly',true);

        }else
        {
            $(this).next().hide();
            //показать другие элементы поиска
            //$('.js--sort').removeClass('greei_input');
            //$('.js--sort').find('input').removeAttr('readonly');

        }


    };

    var changesort_stock2__x1= function() {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_st_2w_x1"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $(this).prev().val('');


        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();


        $(this).hide();
    }

    var changesort_stock2w_x1= function() {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_st_2w_x1"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        CookieList("su_st_2w_x1"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();
        if($(this).val()!='')
        {
            $(this).next().show();
            //скрыть другие элементы поиска
            //$('.js--sort').addClass('greei_input');
            //$('.js--sort').find('input').prop('readonly',true);

        }else
        {
            $(this).next().hide();
            //показать другие элементы поиска
            //$('.js--sort').removeClass('greei_input');
            //$('.js--sort').find('input').removeAttr('readonly');

        }


    };


    var changesort_stock2__x2= function() {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_st_2w_x2"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        $(this).prev().val('');


        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();


        $(this).hide();
    }

    var changesort_stock2w_x2= function() {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_st_2w_x2"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
        CookieList("su_st_2w_x2"+iu,$(this).val(),'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();
        if($(this).val()!='')
        {
            $(this).next().show();
            //скрыть другие элементы поиска
            //$('.js--sort').addClass('greei_input');
            //$('.js--sort').find('input').prop('readonly',true);

        }else
        {
            $(this).next().hide();
            //показать другие элементы поиска
            //$('.js--sort').removeClass('greei_input');
            //$('.js--sort').find('input').removeAttr('readonly');

        }


    };

    var changesort4w_x = function () {
        var iu = $('.users_rule').attr('iu');
        $.cookie("acc_4w" + iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});
        CookieList("acc_4w" + iu, $(this).val(), 'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();
    };
    var changesort4w_x1 = function () {
        var iu = $('.users_rule').attr('iu');
        $.cookie("acc_4w1_" + iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});
        CookieList("acc_4w1_" + iu, $(this).val(), 'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();
    };

    $('#sort4w_x').bind('change', changesort4w_x);
    $('#sort4w_x1').bind('change', changesort4w_x1);

    var changesort2w_x = function () {
        var iu = $('.users_rule').attr('iu');
        $.cookie("su_2w_" + iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});
        CookieList("su_2w_" + iu, $(this).val(), 'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();


        if ($(this).val() == 2) {
            //открываем окно с календарем
            /*
            $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_calendar.php',
            afterLoading: function(data, el) {
                //alert('afterLoading');
            },
            afterLoadingOnShow: function(data, el) {
                //alert('afterLoadingOnShow');
            },
            afterClose: function(data, el) { // после закрытия окна ArcticModal
            clearInterval(timerId);
            }

          });
          */
            $("#date_table").show();
            //$("#date_table").focus();
        } else
        {
            $('.js-toll-22').attr('data-tooltip','Любой');
        }

    };
    $('#sort2w_x').bind('change', changesort2w_x);



    $('body').on("change",'#acc_x',{key: "x"},changeaccx);
    $('body').on("change",'#acc_y',{key: "y"},changeaccx);
    $('body').on("change",'#acc_p',{key: "p"},changeaccx);

    $('.js-dell_stock_search_x').bind('change keyup input click', changesort_stock2__x);
    $('.js-input-search1-x').bind('change keyup input click', changesort_stock2w_x);

    $('.js-dell_stock_search_x1').bind('change keyup input click', changesort_stock2__x1);
    $('.js-input-search1-x1').bind('change keyup input click', changesort_stock2w_x1);

    $('.js-dell_stock_search_x2').bind('change keyup input click', changesort_stock2__x2);
    $('.js-input-search1-x2').bind('change keyup input click', changesort_stock2w_x2);

    $('body').on("change keyup input click",'.js-more-search-x',{key: "worder"},changemores);


    $('.mask-count-x').mask('99999');
   // $('.mask-count-x1').mask('99999');


});



function changemores(event) {
    var iu=$('.users_rule').attr('iu');

    $.cookie("more_search_"+event.data.key+iu, null, {path:'/',domain: window.is_session,secure: false});
    //var mmor=$(this);

    if($(this).is('.show-more-all-x'))
    {
        $(this).removeClass('show-more-all-x');
        $(this).attr('data-tooltip','Еще фильтры');
        $('.more_search_block').hide();

        //обнуляем все дополнительные фильтры + выводим кнопку поиск
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();

        //сумма со знаками ><=
        $('.js-input-search1-x').val('');
        $('.js-dell_stock_search_x').hide();
        $.cookie("su_st_2w_x"+iu, null, {path:'/',domain: window.is_session,secure: false});

        //номер наряда
        $('.js-input-search1-x1').val('');
        $('.js-dell_stock_search_x1').hide();
        $.cookie("su_st_2w_x1"+iu, null, {path:'/',domain: window.is_session,secure: false});

        //комментарии наряда
        $('.js-input-search1-x2').val('');
        $('.js-dell_stock_search_x2').hide();
        $.cookie("su_st_2w_x2"+iu, null, {path:'/',domain: window.is_session,secure: false});

        //исполнитель
        $('#sort4w_x1').val('');
        $('[sopen=search_implementer]').val('Любой');
        $.cookie("acc_4w1_" + iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});

     } else
     {
        $(this).addClass('show-more-all-x');
        CookieList("more_search_"+event.data.key+iu,1,'add');
        $(this).attr('data-tooltip','Скрыть дополнительные фильтры');
        $('.more_search_block').show();
    }

}


function changeaccx(event) {
    var iu=$('.users_rule').attr('iu');

    $.cookie("acc_"+event.data.key+iu, null, {path:'/',domain: window.is_session,secure: false});
    CookieList("acc_"+event.data.key+iu,$(this).val(),'add');

    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();


    if(event.data.key=='x')
    {
      //  $.cookie("acc_y"+iu, null, {path:'/',domain: window.is_session,secure: false});
      //  $.cookie("acc_p"+iu, null, {path:'/',domain: window.is_session,secure: false});
        //выбрал город другой
        //обнавляем списки квартал,объект
        var data = 'url='+window.location.href+'&id='+$(this).val();
        //alert(data);
        AjaxClient('acc','select_town1','GET',data,'AfterSelectTown_x',0,0);
        $('.js-kvartal').remove();
        $('.js-object-c').remove();

    }


    if(event.data.key=='y')
    {
        //$.cookie("acc_p"+iu, null, {path:'/',domain: window.is_session,secure: false});
        //выбрал квартал другой
        //обнавляем списки объект
        var data = 'url='+window.location.href+'&id='+$(this).val();
        //alert(data);
        AjaxClient('acc','select_kvartal1','GET',data,'AfterSelectKvartal_x',0,0);
        $('.js-object-c').remove();


    }

};


function AfterSelectTown_x(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        $('.js-city').after(data.echo);
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);
        Zindex();
        $(".drop-radio").find("li").unbind('click');
        $(".drop-radio").find("li").bind('click', dropliradio);


        //обновляем выбранные кукки
        var iu=$('.users_rule').attr('iu');

        $.cookie("acc_y"+iu, null, {path:'/',domain: window.is_session,secure: false});

        if(data.co_kv!='')
        {
            CookieList("acc_y"+iu,data.co_kv,'add');
        }
        $.cookie("acc_p"+iu, null, {path:'/',domain: window.is_session,secure: false});

        if(data.co_ob!='')
        {
            CookieList("acc_p"+iu,data.co_ob,'add');
        }

    }

}

function AfterSelectKvartal_x(data,update)
{
    if ( data.status=='reg' )
    {
        WindowLogin();
        return;
    }

    if ( data.status=='ok' ) {

        $('.js-kvartal').after(data.echo);
        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);
        Zindex();
        $(".drop-radio").find("li").unbind('click');
        $(".drop-radio").find("li").bind('click', dropliradio);


        //обновляем выбранные кукки
        var iu=$('.users_rule').attr('iu');

        $.cookie("acc_p"+iu, null, {path:'/',domain: window.is_session,secure: false});

        if(data.co_ob!='')
        {
            CookieList("acc_p"+iu,data.co_ob,'add');
        }


    }

}
