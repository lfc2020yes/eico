
$(function () {


    var changesort4w_x = function () {
        var iu = $('.users_rule').attr('iu');
        $.cookie("acc_4w" + iu, null, {path: '/', domain: window.is_session, secure: false, samesite: 'lax'});
        CookieList("acc_4w" + iu, $(this).val(), 'add');
        $('.js-reload-top').removeClass('active-r');
        $('.js-reload-top').addClass('active-r');
        $('.search-count-2022').hide();
    };
    $('#sort4w_x').bind('change', changesort4w_x);


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
        }

    };
    $('#sort2w_x').bind('change', changesort2w_x);
    $('body').on("change",'#acc_x',{key: "x"},changeaccx);
    $('body').on("change",'#acc_y',{key: "y"},changeaccx);
    $('body').on("change",'#acc_p',{key: "p"},changeaccx);
});


function changeaccx(event) {
    var iu=$('.users_rule').attr('iu');

    $.cookie("acc_"+event.data.key+iu, null, {path:'/',domain: window.is_session,secure: false});
    CookieList("acc_"+event.data.key+iu,$(this).val(),'add');

    $('.js-reload-top').removeClass('active-r');
    $('.js-reload-top').addClass('active-r');
    $('.search-count-2022').hide();


    if(event.data.key=='x')
    {
        $.cookie("acc_y"+iu, null, {path:'/',domain: window.is_session,secure: false});
        $.cookie("acc_p"+iu, null, {path:'/',domain: window.is_session,secure: false});
        //выбрал город другой
        //обнавляем списки квартал,объект
        var data = 'url='+window.location.href+'&id='+$(this).val();
        //alert(data);
        AjaxClient('acc','select_town1','GET',data,'AfterSelectTown',0,0);
        $('.js-kvartal').remove();
        $('.js-object-c').remove();

    }
    if(event.data.key=='y')
    {
        $.cookie("acc_p"+iu, null, {path:'/',domain: window.is_session,secure: false});
        //выбрал квартал другой
        //обнавляем списки объект
        var data = 'url='+window.location.href+'&id='+$(this).val();
        //alert(data);
        AjaxClient('acc','select_kvartal1','GET',data,'AfterSelectKvartal',0,0);
        $('.js-object-c').remove();


    }

};
