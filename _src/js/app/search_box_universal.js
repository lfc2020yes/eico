//раздел наряды делался без этих универсальных функций
//другие модули как тендеры и так далее могут использовать их


//поиск по сумме, комментарию (вводимые поля) удаление значения (универсальная)
function changeInputDellu(event)
{
    var iu = $('.users_rule').attr('iu');
    $.cookie(event.data.prefix+event.data.cookie+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
    $(this).prev().val('');
    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();
    $(this).hide();
}

//поиск по сумме, комментарию (вводимые поля) (универсальная)
function changeInputu(event)
{
    var iu = $('.users_rule').attr('iu');
    $.cookie(event.data.prefix+event.data.cookie+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
    CookieList(event.data.prefix+event.data.cookie+iu,$(this).val(),'add');
    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();
    if($(this).val()!='')
    {
        $(this).next().show();
        //скрыть другие элементы поиска
    }else
    {
        $(this).next().hide();
        //показать другие элементы поиска
        //$('.js--sort').removeClass('greei_input');
        //$('.js--sort').find('input').removeAttr('readonly');

    }


}


//город квартал объект (универсальная)
//x,y,p нельзя изменять в названиях cookie,прописаны в коде
function changeCKO(event) {

    var iu=$('.users_rule').attr('iu');
    $.cookie(event.data.prefix+event.data.cookie+event.data.key+iu, null, {path:'/',domain: window.is_session,secure: false});
    CookieList(event.data.prefix+event.data.cookie+event.data.key+iu,$(this).val(),'add');

    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();
    if(event.data.key=='x')
    {
        //выбрал город другой
        //обнавляем списки квартал,объект
        var data = 'url='+window.location.href+'&id='+$(this).val()+'&prefix='+event.data.prefix;
        //alert(data);
        AjaxClient('acc','select_town1','GET',data,'AfterSelectTown_xu',event.data.prefix+event.data.cookie,0);
        $('.js-kvartal').remove();
        $('.js-object-c').remove();
    }


    if(event.data.key=='y')
    {
        //выбрал квартал другой
        //обнавляем списки объект
        var data = 'url='+window.location.href+'&id='+$(this).val()+'&prefix='+event.data.prefix;
        //alert(data);
        AjaxClient('acc','select_kvartal1','GET',data,'AfterSelectKvartal_xu',event.data.prefix+event.data.cookie,0);
        $('.js-object-c').remove();
    }
}



//все выпадающие списки с поиском (универсальная)
function changecheckboxS(event) {

    var iu = $('.users_rule').attr('iu');
    $.cookie(event.data.prefix+event.data.cookie+ iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});
    CookieList(event.data.prefix+event.data.cookie+ iu, $(this).val(), 'add');
    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();
}


//период создания (универсальная)
function changetimeStape(event) {

    var iu = $('.users_rule').attr('iu');
    $.cookie(event.data.prefix+"su_2w_" + iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});
    CookieList(event.data.prefix+"su_2w_" + iu, $(this).val(), 'add');
    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();
    if ($(this).val() == 2) {
        $("#date_table").show();
    } else
    {
        $('.js-toll-22').attr('data-tooltip','Любой');
    }
}




//(универсальная)
function AfterSelectTown_xu(data,update)
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

        $.cookie(update+"y"+iu, null, {path:'/',domain: window.is_session,secure: false});



        if(data.co_kv!='')
        {
            CookieList(update+"y"+iu,data.co_kv,'add');
        }
        $.cookie(update+"p"+iu, null, {path:'/',domain: window.is_session,secure: false});

        if(data.co_ob!='')
        {
            CookieList(update+"p"+iu,data.co_ob,'add');
        }

    }

}

//(универсальная)
function AfterSelectKvartal_xu(data,update)
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

        $.cookie(update+"p"+iu, null, {path:'/',domain: window.is_session,secure: false});

        if(data.co_ob!='')
        {
            CookieList(update+"p"+iu,data.co_ob,'add');
        }


    }

}
