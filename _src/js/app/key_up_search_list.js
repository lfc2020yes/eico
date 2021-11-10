
window.search_min2 = 0;  //мин количество символов для быстрого поиска
window.search_deley2=500;	//задержка между вводами символов - начало поиска

$(function () {

    var delays = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
//поиск инпут - ввод текста
    $('body').on("keyup",".js-keyup-search",KeyUpS);
    $('body').on("click",".js-keyup-search",ClickUpS);
   //поиск инпут
    $('body').on("change keyup input click",'.js-drop-search li',drop_search);  //нажатие на найденное
    $('body').on("change keyup input click",'.js-open-search',open_search);  //открытие списка поиска
});
function ClickUpS() {
    var yioo=$(this).attr('oneli');
  if($(this).val()==yioo)
  {
      $(this).val('');
  }

}

function KeyUpS() {
    //обнуляем выбор
    var search_input2=$(this);
    var sopen=$(this).attr('sopen');
    var options=0;
    if($(this).is('[fns]'))
    {
        options=$(this).attr('fns');
    }

    var ls=search_input2.parents('.input_2021').attr('list_number');

    search_input2.parents('.input_2021').find('.js-hidden-search').val(0);

    if(jQuery.trim(search_input2.val().length) >= 1)
    {
        $('.fox_dell1').show();
    } else
    {
        $('.fox_dell1').hide();
    }
    delays(function(){

        if(jQuery.trim(search_input2.val().length) >= search_min2)
        {
            var data ='url='+window.location.href+
                '&search='+encodeURIComponent(search_input2.val())+'&option='+options;

            search_input2.parents('.input_2021').find('.b_loading_small').empty().append('<div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div>').show();


            AjaxClient('search',sopen,'GET',data,'AfterSearchTuroper',ls+','+sopen,0,1);




        }
    }, search_deley2);
}

//постфункция поиска клиента при добавлении тура в главной форме
function AfterSearchTuroper(d,c){

    if(c!=null){ if (typeof(c) == "string") { c = c.split(','); } else { c[0]=c; } }

//$('.b_loading_small').remove();
//$('.fox_dell1').show();
    //alert(c);
    var input_search_after=$('.input-search-list[list_number='+c[0]+']').find('.js-keyup-search[sopen='+c[1]+']');


    if(d.status=="ok")
    {




        input_search_after.parents('.input_2021').find('.js-drop-search').empty().append(d.query);

        input_search_after.parents('.input_2021').find('.js-drop-search').css("transform", "scaleY(1)");

        input_search_after.parents('.input-search-list').find('i').addClass('open-search-active');

    }else{   input_search_after.parents('.input_2021').find('.js-drop-search').css("transform", "scaleY(0)");  }

    //$('#sort5c').unbind('change');
    //$('#sort5c').bind('change', changesort5c);

    var uiii=input_search_after.attr('oneli');

    if(uiii!='') {
        input_search_after.parents('.input_2021').find('.js-drop-search').prepend('<li><a href="javascript:void(0);" rel="0">' + uiii + '</a></li>');
    }
    input_search_after.parents('.input_2021').find('.b_loading_small').hide();
}


//открытия подбора поиска в input
function open_search()
{
    var i_open = $(this).parents('.input-search-list').find('i');
    //alert("11");
    if(i_open.is(".open-search-active"))
    {
        i_open.removeClass('open-search-active');
        $(this).parents('.input-search-list').find('.js-drop-search').css("transform", "scaleY(0)");
    } else
    {

        i_open.addClass('open-search-active');
        $(this).parents('.input-search-list').find('.js-drop-search').css("transform", "scaleY(1)");
    }


    //скрываем все списки кроме того на который нажали
    $('.slct').each(function(i,elem)
    {
        $(this).removeClass("active");
        $(this).next().css("transform", "scaleY(0)");
    });


    elemss=$(this).parents('.input-search-list').attr('list_number');
    //скрыть все списки поиска кроме того на который нажали
    $('.drop-search').each(function(i,elem)
    {
        if ($(this).parents('.input_2021').attr('list_number')!=elemss)
        {
            $(this).parents('.input-search-list').find('i').removeClass('open-search-active');
            $(this).parents('.input-search-list').find('.js-drop-search').css("transform", "scaleY(0)");
        }
    });



}

//выбор из поиска в input
function drop_search()
{
    var f1=$(this).find("a").html();
    var obj = $("<div>" + f1 + "</div>");
    obj.find(".green-base").remove();
    var f=obj.text();
    //var f=$(this).find("a").text();


    var e=$(this).find("a").attr("rel");

    var input_pr=$(this).parents('.input_2021');

    input_pr.find('.click-search-name').empty().append(f).slideDown("slow");
    input_pr.find('.click-search-icon').slideDown("slow");

    input_pr.find('.js-hidden-search').val(e).change();

    input_pr.find('.js-keyup-search').val(f);

    input_pr.removeClass('required_in_2021');
    $(this).parents('.input-search-list').find('i').removeClass('open-search-active');

    input_2021();

}