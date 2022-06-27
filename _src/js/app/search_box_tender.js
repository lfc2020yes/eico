
$(function () {

    if(typeof search_prefix !== "undefined") {
        search_prefix[0] = 'ten';
    } else {

        var search_prefix = [];
        search_prefix[0] = 'ten';
    }
    //период создания
    $('body').on("change keyup input click",'#'+search_prefix[0]+'sort2w_x',{prefix: search_prefix[0]},changetimeStape);

    //по создателю
    $('body').on("change keyup input click",'#'+search_prefix[0]+'sort4w_x',{prefix: search_prefix[0],cookie:"acc_4w"},changecheckboxS);

    //город
    $('body').on("change keyup input click",'#'+search_prefix[0]+'acc_x',{key: "x",prefix: search_prefix[0],cookie:"acc_"},changeCKO);
    //квартал
    $('body').on("change keyup input click",'#'+search_prefix[0]+'acc_y',{key: "y",prefix: search_prefix[0],cookie:"acc_"},changeCKO);
    //объект
    $('body').on("change keyup input click",'#'+search_prefix[0]+'acc_p',{key: "p",prefix: search_prefix[0],cookie:"acc_"},changeCKO);

//открыть закрыть поиск
    // менять worder в параметрах для других модулей не надо
    $('body').on("change keyup input click",'.'+search_prefix[0]+'js-more-search-x',{key: "worder",prefix: search_prefix[0]},changemoresten);


//поиск по сумме
    $('body').on("change keyup input click",'.'+search_prefix[0]+'js-input-search1-x',{prefix: search_prefix[0],cookie:'su_st_2w_x'},changeInputu);
    $('body').on("change keyup input click",'.'+search_prefix[0]+'js-dell_stock_search_x',{prefix: search_prefix[0],cookie:'su_st_2w_x'},changeInputDellu);

//поиск по комментарию
    $('body').on("change keyup input click",'.'+search_prefix[0]+'js-input-search1-x2',{prefix: search_prefix[0],cookie:'su_st_2w_x2'},changeInputu);
    $('body').on("change keyup input click",'.'+search_prefix[0]+'js-dell_stock_search_x2',{prefix: search_prefix[0],cookie:'su_st_2w_x2'},changeInputDellu);

  //  $('.mask-count-x').mask('99999');

});


//открыть закрыть дополнительные фильтры (не универсальная, для каждого модуля своя)
function changemoresten(event) {
    var iu=$('.users_rule').attr('iu');

    $.cookie(event.data.prefix+"more_search_"+event.data.key+iu, null, {path:'/',domain: window.is_session,secure: false});
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
        $('.'+event.data.prefix+'js-input-search1-x').val('');
        $('.'+event.data.prefix+'js-dell_stock_search_x').hide();
        $.cookie(event.data.prefix+"su_st_2w_x"+iu, null, {path:'/',domain: window.is_session,secure: false});



        //комментарии наряда
        $('.'+event.data.prefix+'js-input-search1-x2').val('');
        $('.'+event.data.prefix+'js-dell_stock_search_x2').hide();
        $.cookie(event.data.prefix+"su_st_2w_x2"+iu, null, {path:'/',domain: window.is_session,secure: false});


    } else
    {
        $(this).addClass('show-more-all-x');
        CookieList(event.data.prefix+"more_search_"+event.data.key+iu,1,'add');
        $(this).attr('data-tooltip','Скрыть дополнительные фильтры');
        $('.more_search_block').show();
    }

}


