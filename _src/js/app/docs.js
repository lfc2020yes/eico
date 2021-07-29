$(function (){

    //форма добавление тура - выбор паспорт какой
    $('body').on("change keyup input click",'.js-password-docs',password_docs);
    //новый старый поставщик

    $('body').on("change keyup input click",'.js-add-docs',add_docs_2021);
    //набор текста в поиске




    $('body').on("change keyup input click",'.js-add-docs-save',save_docs);


    $('body').on("change keyup input click",'.js-edit-docs-more',edit_more_docs);

    $('body').on("change keyup input click",'.tabs_007U',{key: "007U"},tabs_docs);


    $('body').on("change keyup input click",'.js-reject-docs',RejectFoD);
    $('body').on("change keyup input click",'.js-forward-docs',ForwardFoD);

    $('body').on("change keyup input click",'.js-sign-a1',SingFoD);



});

function add_docs_2021()
{
    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_add_docs_2021.php',
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


//отклонить заявку
function RejectFoD()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_docs_reject.php?id=' + pre,
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


//переслать заявку
function ForwardFoD()
{
    if(!$(this).is('.gray-bb')) {
        var pre = $('.preorders_block_global').attr('id_pre');
        $.arcticmodal({
            type: 'ajax',
            url: 'forms/form_add_docs_forward.php?id=' + pre,
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

function SingFoD()
{
    if(!$(this).is('.gray-bb')) {
        var fo = $(this);
        if (!fo.hasClass("gray-bb")) {
            //alert("!");
            if (fo.find('input').val() == 1) {
                //открыть окно для вписание замечания
                var pre = $('.preorders_block_global').attr('id_pre');
                $.arcticmodal({
                    type: 'ajax',
                    url: 'forms/form_add_docs_remark.php?id=' + pre,
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


            } else {
                //Отправить прямую форму на согласование
                $('#js-form-next-sign').submit();
            }
        }
    }
}



//табсы в обращениях
var tabs_docs = function(event) {
    //event.data.key

    var uoo=$(this).attr("id");


    if(uoo!=0) {
        $(this).parents('.mm_w-preorders').addClass('active-trips-menu');
    } else
    {

        $(this).parents('.mm_w-preorders').removeClass('active-trips-menu');
        $(this).parents('.mm_w-preorders').next().empty().hide();
        $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
    }

    if ( $(this).is(".active") )
    {
        //уже активная вкладка
        $(this).parents('.mm_w-preorders').removeClass('active-trips-menu');
        $(this).parents('.mm_w-preorders').next().empty().hide();
        $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
    } else
    {
        //alert(event.data.key);
        if(uoo!=0) {
            $(this).parents('.mm_w-preorders').next().empty().append('<div class="b_loading_small" style="position:relative; left: calc(50% - 30px); "><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            $(this).parents('.mm_w-preorders').next().slideDown("slow");

            /*
                    $('.form'+event.data.key+' .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            */
            $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
            $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key + '[id=' + uoo + ']').addClass('active');

            //var key_='002U';

            var data = 'url=' + window.location.href + '&id_tabs=' + $(this).attr("id") +
                '&id=' + $(this).parents('.preorders_block_global').attr('id_pre');
            //alert(data);
            AjaxClient('docs','tabs_info','GET',data,'AfterTabsInfodocs',$(this).attr("id")+','+$(this).parents('.preorders_block_global').attr('id_pre'),0,1);
        }
    }
}

//постфункция вкладки в обращениях
function AfterTabsInfodocs(data,update)
{
    if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }

    if ( data.status=='reg' )
    {
        WindowLogin();
    }

    if ( data.status=='ok' )
    {
        $('.preorders_block_global[id_pre='+update[1]+']').find('.px_bg_trips').empty().append(data.query);
        //$('.form'+update[1]+' .px_bg').empty().append(data.query);

        //$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

        //$('.form'+update[1]+' .js-tabs_docc').hide();
        //$('.form'+update[1]+' .js-tabs_'+update[0]).show();

        NumberBlockFile();
        ToolTip();
        if((update[0]==3)||(update[0]==4))
        {
            $(".slct").unbind('click.sys');
            $(".slct").bind('click.sys', slctclick);
            $(".drop").find("li").unbind('click');
            $(".drop").find("li").bind('click', dropli);
            //$('#typesay').unbind('change', changesay);
            //$('#typesay').bind('change', changesay);
            //alert("!");
        }

    }
}

function edit_more_docs()
{
    var oppf=$(this).parents('[id_pre]').attr("id_pre");

    $.arcticmodal({
        type: 'ajax',
        url: 'forms/form_edit_docs_more.php?id=' + oppf,
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


//сохранить счет при изменении количества
function save_docs()
{
    var err = 0;
    $('.js-save-form-docs').find('.gloab').each(function(i,elem) {
        if(($(this).val() == '')||($(this).val() == '0')) { $(this).parents('.input_2021').addClass('required_in_2021');
            $(this).parents('.list_2021').addClass('required_in_2021');
            err++;
            //alert($(this).attr('name'));
        } else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
    });

    if(err==0) {

        $('.js-save-form-docs').submit();

    } else
    {
        alert_message('error','Не все поля заполнены');
    }
}




//выбор какой паспорт
function password_docs()
{
    var cb_h=$(this).parents('.password_docs').find('input');
    if(cb_h.val()!=$(this).attr('id'))
    {
        cb_h.val($(this).attr('id'));

        $(this).parents('.password_docs').find('.choice-radio i').removeClass('active_task_cb');
        $(this).parents('.password_docs').find('.input-choice-click-pass').removeClass('active_pass');

        $(this).find('.choice-radio i').addClass('active_task_cb');
        $(this).addClass('active_pass');
        view_type();
    }
}





