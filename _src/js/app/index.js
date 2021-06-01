$(document).ready(function(){	
	//измениние курса и стоимости при оформлении тура
	$('.js-form-add-tours').on("change keyup input click",'.xexchange_rates',xexchange_rates1);
	$('.js-form-add-tours').on("change keyup input click",'.xcost_to_1',xexchange_rates2);
	$('.js-form-add-tours').on("change",'[name=id_exchange]',exchange_eico);

	$('body').on("change keyup input click",'.js-test',test_a);
$('body').on("change keyup input click",'.js-edit-2020-user',no_rds_user);

	$('body').on("change keyup input click",'.js-edit-org-2020',no_rds_org);


	$('.js-call-no-v').find('.drop').on("change keyup input click","li",list_number);

	//показать скрыть какой то рейтинг
	$('.winner_2020').on("change keyup input click",".js-all-rating div",rating_list);


	//вывод и скрытие оплатить до какого
	$('.js-form-add-tours').on("change keyup input click",'.js-xx_end_date',xx_end_date);

    //набор текста в поиске
	$('body').on("change keyup input click",'.js-text-search-x',changesort_stock2);

	//туры - показать в РУБ
	$('.trips_block_global').on("change keyup input click",'.js-exc-cost',exc_cost);

//туры - посмотреть добавить впечатление
	$('.trips_block_global').on("change keyup input click",'.js-chat-tours',chat_tours);

	//туры - рассчитать остаток в РУБ
	$('.trips_block_global').on("change keyup input click",'.js-form-cost',form_cost);

//туры договор передан или нет
	$('.trips_block_global').on("change keyup input click",'.js-issue-doc',form_doc);

	//туры добавить впечатлеие
	$('.trips_block_global').on("change keyup input click",'.js-chat-tours-add',form_doc_chat);

	//туры - ок после ввода курса ТО
	$('.trips_block_global').on("change keyup input click",'.js-ok-rate',ok_rate_form);

	//туры - ок после ввода когда отдали договор клиенту
	$('.trips_block_global').on("change keyup input click",'.js-ok-rate-doc',ok_rate_form_doc);

	//туры - добавление впечатления кнопка ок
	$('.trips_block_global').on("change keyup input click",'.js-ok-rate-chat',ok_rate_form_chat);

    //нажатие на курс чтобы изменить
	$('.trips_block_global').on("change keyup input click",'.js-rrate',js_rrate);

	//сроки оплат
	$('.trips_block_global').on("change keyup input click",'.js-srok-my',srok_my);

	//изменение стоимости по туру
	$('.trips_block_global').on("change keyup input click",'.js-all-price-trips',all_price_trips);

	//внести оплату нажать кнопку открытия формы
	$('.trips_block_global').on("change keyup input click",'.js-menu-buybuy',js_menu_buybuy);

	//создать новую версию договора в турах
	$('.trips_block_global').on("change keyup input click",'.js-new-doc-trips',js_new_doc);

    //удалить платеж в турах
	$('.trips_block_global').on("change keyup input click",'.js-buy-del',js_buy_del);

    //редактировать платеж в турах
	$('.trips_block_global').on("change keyup input click",'.js-buy-edit',js_buy_edit);

	$('body').on("click",".js-touroper-eye,.js-commi-eye",js_touroper_eye);

//появление кнопки сохранить когда что-то изменяем в настройках
	$('.form_54_booking').on("change keyup input click","#name_b,#name_b1,#name_b1x,#password_b,#login_b,.radio_1,.js-checkbox-group",function(){   $('.js-save-setting').show();    });


//появление кнопки сохранить когда что-то изменяем при редактирование сотрудника
	$('.form_531_set').on("change keyup input click","#name_b,.js-status-trips-more",function(){   $('.js-save-set').show();    });

    //появление кнопки добавить когда что-то изменяем при добавлении нового сотрудника
    $('.form_532_booking').on("change keyup input click","#name_b,#name_b1,#name_b12,#name_b1x,#password_b,#login_b,.radio_1,.js-checkbox-group",function(){   $('.js-add-users').show();});

	$('.form_531_booking').on("change keyup input click","#name_b,#name_b1,#name_b12,#name_b1x,#password_b,#login_b,.radio_1,.js-checkbox-group",function(){   $('.js-save-users').show();});

	$('.form_532_set').on("change keyup input click","#name_b,.js-status-trips-more",function(){   $('.js-add-set').show();});

    //нажатие на отдельные chtckbox залки в определенной группе
	$('body').on("change keyup input click",'.js-checkbox-group',CheckboxGroup);

    //нажатие на кнопку сохранить настройки
	$('body').on("change keyup input click",".js-save-setting", save_setting);

    //нажатие на кнопку сохранить изменения по пользователю
	$('.js-form-gloab').on("change keyup input click",".js-save-users", save_users_2020);

    //нажатие на кнопку сохранить изменения по пользователю / добавить нового
    $('.js-form-gloab').on("change keyup input click",".js-add-users", add_users_2020);

	//нажатие на кнопку сохранить изменения по пользователю / добавить нового
	$('.menu-09').on("change keyup input click",".js-add-set", add_set_2020);

	$('.menu-09').on("change keyup input click",".js-save-set", save_set_2020);




//заблокировать сотрудника
$('body').on("change keyup input click",'.js-users-block',UsersBlock);

//изменить статус тура по проверки оплате
$('.trips_block_global').on("change keyup input click",'.js-status-trips',StatusTrips);

//выделить тур галкой для каких то действий
$('body').on("change keyup input click",'.js-status-trips-more',st_div);

	$('body').on("change keyup input click",'.js-exam-more',st_div_exam);

//открыть раскрывающее меню точки
$('body').on("change keyup input click",'.menu_jjs .menu_click',menuclick);


//при изменении роли в системе подружать уведомления или скрывать для конкретной роли
$('body').on("change keyup input click",'.js-checkbox-role',RoleNotif);


//активация инпутов 2018
	input_2018();

//показать скрыть пароль глазик
	$('body').on("click",'.ais',Eye);
	ToolTipInput();
AutoResizeT();


});


//загружать или нет js forms // нужно когда открывается несколько окон сразу
//  |
// \/
function initializeFormsJs()
{
	try {
		forms_js_load();
	} catch (error) {
		//а тут то, что делать, когда код выше вызвал ошибку
		$.getScript( window.src_forms, function( data, textStatus, jqxhr ) {
			console.log("yes load script");
		});
	}
}

function LoadFFo()
{
	console.log("проверка полной загрузки");
	if(window.yesform==1) {
		clearInterval(TimerScript);
		ScriptForms();
	}
}



//возвращаем скрул у сайта после закрытия окна если окон больше нет
//  |
// \/
function BodyScrool()
{

	if($('.arcticmodal-container').length==1)
	{
		$('body').css( "margin-right", "0px" );
		$('body').css( "overflow", "auto" );
	}
}


//закрыть форму подписки крестик
//  |
// \/
function Eye()
{
	if($(this).is('.ais-open'))
	{
		$(this).removeClass('ais-open');
		$(this).parents('.input_2018').find('.input_new_2018').attr('type','password');
	} else
	{
		$(this).addClass('ais-open');
		$(this).parents('.input_2018').find('.input_new_2018').attr('type','text');
	}
}

//показать скрыть пароль глазик
$('body').on("click",'.ais',Eye);
//проходим по всем textarea resize и активируем их
//  |
// \/
function AutoResizeT()
{
	//$(this).autoResize({extraSpace : 10});

	$('.js-autoResize').each(function(i,elem) {
		$(this).autoResize({extraSpace : 10});
	});

}


//подсказки особые для формы
//  |
// \/
function ToolTipInput(){



	$(".help-icon").mousemove(function (eventObject) {

		var inputx=$(this).parents('.input_2018');

		if(inputx.length==0)
		{
			var inputx=$(this).parents('.js-helps');
		}

		if(inputx.find('.toolhelp').length==0)
		{
			inputx.prepend('<div class="toolhelp"><span></span></div>');
		}

		var toolh=inputx.find(".toolhelp");
		var toolhs=inputx.find(".toolhelp span");
		$data_tooltip = $(this).attr("help");
		toolhs.text($data_tooltip);
		var offset = $(this).offset();


		if((eventObject.pageX-250)<=($(window).width()/2))
		{
			toolh.css({
				"top" : '0px',
				"right" : - (toolh.outerWidth() + 40)

			});


			setTimeout ( function () { toolh.fadeIn(500); }, 	400 );


		}else
		{

			toolh.hide();


		}
	}).mouseout(function () { var toolh=$(this).parents('.input_2018').find(".toolhelp");


		if(toolh.length==0)
		{
			var toolh=$(this).parents('.js-helps').find(".toolhelp");
		}


		toolh.remove(); });


}



//при изменении роли в системе подружать уведомления или скрывать для конкретной роли
function RoleNotif()
{
	var i= $(this).find('i');
	if(i.is('.active_task_cb'))
	{
		$('.js-panel-notif').hide().before('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		var id_role=i.next().val();
		var id_u=$('.js-panel-notif').attr('ipo');
		var data ='url='+window.location.href+'&id='+id_role+'&id_u='+id_u;
		AjaxClient('users','role_notif','GET',data,'AfterRoleNotif',id_role,0,1);

	} else
	{
$('.js-panel-notif').hide();
	}
}

//проходим по всем textarea resize в открывающем окне и активируем их
//  |
// \/
function AutoResizeTF()
{
    //$(this).autoResize({extraSpace : 10});

    $('.box-modal .js-autoResize-form').each(function(i,elem) {
        $(this).autoResize({extraSpace : 10});
    });

}


function AfterRoleNotif(data,update) {
	$('.js-panel-notif').prev().remove();

	if (data.status == 'ok') {
$('.js-panel-notif').empty().append(data.echo);
		$('.js-panel-notif').slideDown("slow");
	}

}

//удаление параметра из url
//var url = "http://someUrl.ru?param1=123&param2=234&param3=435";
//var url1 = removeParam("param1", url);
function removeParam(key, sourceURL) {
	var splitUrl = sourceURL.split('?'),
		rtn = splitUrl[0],
		param,
		params_arr = [],
		queryString = (sourceURL.indexOf("?") !== -1) ? splitUrl[1] : '';

	if (queryString !== '') {
		params_arr = queryString.split('&');
		for (var i = params_arr.length - 1; i >= 0; i -= 1) {
			param = params_arr[i].split('=')[0];
			if (param === key) {
				params_arr.splice(i, 1);
			}
		}
		rtn = rtn + '?' + params_arr.join('&');
	}

	if(rtn.toString().slice(-1)=='?')
	{
		rtn=rtn.slice(0, -1);
	}

	return rtn;
}





function AfterMoreStatus(data,update)
{
	$('.menu_jjs .more_supply1').show();
	$('.menu_jjs').find('.b_loading_small').remove();

	var status_class=parseInt(data.rel)-3;

	if (data.status=='ok')
	{
		var aw = update.split('.');

		$.each(aw, function(index, value){
		var  butt=$('.trips_block_global[id_trips='+value+']');
			butt.find('.js-status-trips').removeClass('s_a_0 s_a_1 s_a_2');
			butt.find('.js-status-trips').addClass('s_a_'+status_class).empty().append(data.echo);
		});

		//отменить выделение всех выбраннх
		$('.trips_block_global .trips-b-number .choice-radio').find('i').removeClass('active_task_cb');
		basket_trips();
		alert_message('ok','Статусы изменены');
	}
}

//раскрывающее меню по кнопке
var menuclick = function() {
	var tr_s=$(this).next(".menu_supply").find('.drops');
	if(tr_s.is(".active_menu_s"))
	{
		tr_s.removeClass("active_menu_s");
		tr_s.css("transform", "scaleY(0)");
	} else
	{
		tr_s.addClass("active_menu_s");
		tr_s.css("transform", "scaleY(1)");
	}
}


function st_div_exam() {



	//alert(ssup);
	if($(this).find('.js-status-trips-more1 i').is(".active_task_cb"))
	{
		//tr.removeClass("checher_supply");
		$(this).find('.js-status-trips-more1 i').removeClass('active_task_cb');
		//CookieList(ssup+iu,tr.attr('id_trips'),'del');
		// alert($(this).parents('[rel_id]').attr('rel_id'));
		//basket_trips();
		$(this).removeClass('active_exam');
		$('[name=my_yes]').val('');
		//ToolTip();
	} else
	{
		//tr.addClass("checher_supply");
		$('.answer_exam').find('.js-status-trips-more1 i').removeClass('active_task_cb');

		$('.answer_exam').removeClass('active_exam');
		$(this).addClass('active_exam');
		$(this).find('.js-status-trips-more1 i').addClass('active_task_cb');
		//CookieList(ssup+iu,tr.attr('id_trips'),'add');
		//basket_trips();
		//ToolTip();
		$('[name=my_yes]').val($(this).attr('key'));
	}


}

//добавление в корзину туров для изменения статуса к оплате/оплачено
function st_div() {



	//alert(ssup);
	if($(this).find('.js-status-trips-more1 i').is(".active_task_cb"))
	{
		//tr.removeClass("checher_supply");
		$(this).find('.js-status-trips-more1 i').removeClass('active_task_cb');
		//CookieList(ssup+iu,tr.attr('id_trips'),'del');
		// alert($(this).parents('[rel_id]').attr('rel_id'));
		basket_trips();
		//ToolTip();
	} else
	{
		//tr.addClass("checher_supply");
		$(this).find('.js-status-trips-more1 i').addClass('active_task_cb');
		//CookieList(ssup+iu,tr.attr('id_trips'),'add');
		basket_trips();
		//ToolTip();
	}


}

//корзина счетов новый/текущий
function basket_trips()
{

	var count_trips_select=$('.question_block_pass .users-b-number').find('.active_task_cb');
if(count_trips_select.length!=0)
{

	var select_li = '';
	count_trips_select.parents('.question_block_pass').each(function (i, elem) {

			if (select_li == '') {
				select_li = $(this).attr('op_rel');
			} else {
				select_li = select_li + ',' + $(this).attr('op_rel');
			}

	});
	$('[name=set]').val(select_li);


} else
{
	$('[name=set]').val('');

}



}




//изменить статус тура по проверки оплате
function StatusTrips()
{
	var id_task= $(this).parents('.trips_block_global').attr('id_trips');

	$(this).hide().before('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 0px;left:0px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

	var data ='url='+window.location.href+'&id='+id_task;
	AjaxClient('tours','status','GET',data,'AfterStatusTrips',id_task,0,1);
}

function AfterStatusTrips(data,update)
{
	var butt=$('.trips_block_global[id_trips='+update+']');
	butt.find('.js-status-trips').show();
	butt.find('.b_loading_small').remove();

	if (data.status=='ok')
	{
		butt.find('.js-status-trips').removeClass('s_a_0 s_a_1 s_a_2');
		butt.find('.js-status-trips').addClass('s_a_'+data.status_admin).empty().append(data.echo);
		alert_message('ok','Статус изменен');
	}
}

//заблокировать сотрудника
function UsersBlock()
{

    var id= $(this).attr('id-bdata');


    $(this).hide().before('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


    var data ='url='+window.location.href+'&id='+id;
    AjaxClient('users','ban','GET',data,'AfterUsersBlock',id,0,1);

}


function AfterUsersBlock(data,update)
{
    var butt=$('.js-users-block[id-bdata='+update+']');
    butt.parents('.users_block_2020').find('.b_loading_small').remove();
	butt.parents('.users_block_2021').find('.b_loading_small').remove();
    butt.show();


    if (data.status=='ok')
    {


        if((butt.parents('.users_block_2020').length!=0)||(butt.parents('.users_block_2021').length!=0))
        {

            //butt.parents('.users_block_2020').find('.js-party-status').empty().append(data.st);
            if(data.party=='1')
            {

                butt.parents('.users_block_2020').removeClass('red-party');
				butt.parents('.users_block_2021').removeClass('red-party');
                butt.removeClass('block-party');
                alert_message('ok','Доступ открыт');
            } else
            {
                butt.parents('.users_block_2020').addClass('red-party');
				butt.parents('.users_block_2021').addClass('red-party');
                butt.addClass('block-party');
                alert_message('ok','Участник заблокирован');
            }
        } else
        {
            autoReloadHak();
        }

    } else
    {
        alert_message('error','Ошибка!');
    }
}

//нажать на кнопку добавить нового пользователя
function add_set_2020()
{

	$(this).find('span').hide();
	$(this).find('span').before('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

	var err = 0;
	$("#name_b,#name_b1,#login_b,#password_b").removeClass('error_formi');
	$("#name_b").parents('.ok-input-title-2019').removeClass('error_formi_2019');


	if($("#name_b").val() == '')  {alert_message('error','Заполните Название подборки'); err++;	}


	if(err!=0)
	{
		$(this).find('span').show();
		$(this).find('.b_loading_small').remove();
		//alert_message('error','Не все поля заполнены');
		/*
    $('.error_text_add-09').empty().append('Не все поля заполнены').show();
    setTimeout ( function () { $('.error_text_add-09').hide(); }, 7000 );
        */

	} else
	{
		$('#lalala_add_form').submit();
	}
}


//нажать на кнопку добавить нового пользователя
function save_set_2020()
{

	$(this).find('span').hide();
	$(this).find('span').before('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

	var err = 0;
	$("#name_b,#name_b1,#login_b,#password_b").removeClass('error_formi');
	$("#name_b").parents('.ok-input-title-2019').removeClass('error_formi_2019');


	if($("#name_b").val() == '')  {alert_message('error','Заполните Название подборки'); err++;	}


	if(err!=0)
	{
		$(this).find('span').show();
		$(this).find('.b_loading_small').remove();
		//alert_message('error','Не все поля заполнены');
		/*
    $('.error_text_add-09').empty().append('Не все поля заполнены').show();
    setTimeout ( function () { $('.error_text_add-09').hide(); }, 7000 );
        */

	} else
	{
		$('#lalala_save_form').submit();
	}
}


//нажать на кнопку добавить нового пользователя
function add_users_2020()
{



	var err = 0;
//alert($('.js-form-register .gloab').length);
	$('.js-form-gloab .gloab').each(function(i,elem) {
		if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
			$(this).parents('.list_2018').addClass('required_in_2018');
			err++;
			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
	});

	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

	if (!$(".js-office-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните офис');  err++; }

	//alert(err);

	if(err==0)
	{
		$('.js-form-add-office  .js-add-users').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		//AjaxClient('notification','even','GET',data,'AfterNofi',1,0,1);
		//AjaxClient('tedner','add','POST',0,'AfterAddFormTender',0,'js-form-tender-new',1);
		$('#lalala_add_form').submit();

	} else
	{
		//найдем самый верхнюю ошибку и пролестнем к ней
		jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
		//ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
		alert_message('error','Не все поля заполнены');


	}


}

function save_users_2020() {


	var err = 0;
//alert($('.js-form-register .gloab').length);
	$('.js-form-gloab .gloab').each(function(i,elem) {
		if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
			$(this).parents('.list_2018').addClass('required_in_2018');
			err++;
			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
	});

	if (!$(".js-role-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните должность в системе');  err++; }

	if (!$(".js-office-x i").is( ".active_task_cb" ) ) { alert_message('error','Заполните офис');  err++; }

	//alert(err);

	if(err==0)
	{
		$('.js-form-gloab  .js-save-users').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		//AjaxClient('notification','even','GET',data,'AfterNofi',1,0,1);
		//AjaxClient('tedner','add','POST',0,'AfterAddFormTender',0,'js-form-tender-new',1);
		$('#lalala_add_form').submit();

	} else
	{
		//найдем самый верхнюю ошибку и пролестнем к ней
		jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
		//ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
		alert_message('error','Не все поля заполнены');


	}


}


//нажать на кнопку сохранить пользователя


//нажать на кнопку сохранить настройки
function save_setting()
{


	var err = 0;
//alert($('.js-form-register .gloab').length);
	$('.js-form-gloab .gloab').each(function(i,elem) {
		if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
			$(this).parents('.list_2018').addClass('required_in_2018');
			err++;
			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
	});

	//alert(err);

	if(err==0)
	{
		$('.js-form-gloab  .js-save-setting').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		//AjaxClient('notification','even','GET',data,'AfterNofi',1,0,1);
		//AjaxClient('tedner','add','POST',0,'AfterAddFormTender',0,'js-form-tender-new',1);
		$('#lalala_add_form').submit();

	} else
	{
		//найдем самый верхнюю ошибку и пролестнем к ней
		//jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
		//ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
		alert_message('error','Не все поля заполнены');
	}


}

//нажатие на отдельные chtckbox залки в определенной группе
//  |
// \/
function CheckboxGroup()
{
	/*
    var active_old = $(this).parent().parent().find(".slct").attr("data_src");
    var active_new = $(this).find("a").attr("rel");
    */
//var f = $(this).find("a").text();
	var e = $(this).find("input").first().val();
	var drop_object = $(this).parents('.js-group-c');

	var active_jj=0;

	if ($(this).find('i').is(".active_task_cb")) {

		$(this).find('i').removeClass("active_task_cb");
		$(this).find('input').last().val(0);
		active_jj=1;
	} else {

		$(this).find('i').addClass("active_task_cb");
		$(this).find('input').last().val(1);

	}


	//пробежаться по всей выбранному селекту
	var select_li = '';
	drop_object.find('.js-checkbox-group').each(function (i, elem) {
		if ($(this).find('i').is(".active_task_cb")) {
			if (select_li == '') {
				select_li = $(this).find("input").first().val();
			} else {
				select_li = select_li + ',' + $(this).find("input").first().val();
			}
		}
	});


	//есть тип который позволяет выбрать только один пункт
	if (drop_object.is('.js-tolko-one')) {


		//select_li = one_li.find("a").attr("rel");
		drop_object.find('i').removeClass("active_task_cb");

		drop_object.find('.js-checkbox-group').each(function (i, elem) {
			$(this).find('input').last().val(0);
		});
		//alert(active_jj);
		if(active_jj==0)
		{
			$(this).find('i').addClass("active_task_cb");
			$(this).find('input').last().val(1);
		}

	}


	//есть класс который говорит что если выбрано первое в списке то убираем галки со всех остальных
	//если есть что-то выбранное то первое в списке не горит
	//если ничего не выбрано первое в списке зажечь

	if (drop_object.is('.js-one-all-select')) {

		var one_li=drop_object.find('.js-checkbox-group').first();


		//если не одна галка не выделена то зажигаем первое
		if (select_li == '') {

			one_li.trigger('click');
			return;

		}

		//нажимаем на первое в списке когда он не горел тогда тушим все остальные
		if (($(this).find('i').is(".active_task_cb")) && (e == 0) && ((select_li != '') && (select_li != '0'))) {

			select_li = one_li.find("a").attr("rel");
			drop_object.find('i').removeClass("active_task_cb");

			drop_object.find('.js-checkbox-group').each(function (i, elem) {
				$(this).find('input').last().val(0);
			});


			one_li.find('i').addClass("active_task_cb");
			one_li.find('input').last().val(1);

		}


		//если выбрали все кроме первого то потушить все а первый в списке зажечь
		if(e != 0)
		{
			var count_all_li=drop_object.find('.js-checkbox-group').length;
			var count_active_li=drop_object.find('.active_task_cb').length;
			//alert(count_all_li);
			if (parseInt(count_active_li + 1) == count_all_li) {
				drop_object.find('i').removeClass("active_task_cb");

				drop_object.find('.js-checkbox-group').each(function (i, elem) {
					$(this).find('input').last().val(0);
				});


				one_li.find('i').addClass("active_task_cb");
				one_li.find('input').last().val(1);
			}
		}


		//alert(select_li_text);
		//если что-то выбрано кроме первого то и первый гарид то потушить его
		if ((select_li != '')&&(select_li != '0'))
		{
			if(one_li.find('i').is('.active_task_cb'))
			{
				one_li.trigger('click');
				return;
			}
		}

	}
}


function rating_list()
{

	var id=$(this).attr('id_r');
	var rat=$(this).parents('.winner_2020');
	rat.find('.js-rating').slideUp("slow");
	rat.find('.js-rating[idrr='+id+']').slideDown("slow");
	//setTimeout ( function () { rat.find('.js-rating[idrr='+id+']').slideDown("slow"); }, 500 );


}


/**
 * ставим галочки в сроках которые оплачены уже в форме туров сроки
 */
function sroki_yes()
{
	var id_task= $('.js-form-srok-trips').find('[name=id]').val();
	var my= $('.js-form-srok-trips').find('[name=my]').val();

	if(my==0)
	{
		//клиент
		var proce=$('.trips_block_global[id_trips='+id_task+']').find('.trips-b-user .gr-50').attr('proccs');

		$('.js-form-srok-trips .sroki-tabl').each(function (index, value) {
//alert($(this).find('.js-proc-form-x').val());
			if(parseFloat($(this).find('.js-proc-form-x').val())<=parseFloat(proce))
			{
				$(this).addClass('yes-buy-y');
			} else
			{
				$(this).removeClass('yes-buy-y');
			}

		});

	}
	if(my==1)
	{
		//туроператор
		var proce=$('.trips_block_global[id_trips='+id_task+']').find('.trips-b-operator .gr-50').attr('proccs');

		$('.js-form-srok-trips .sroki-tabl').each(function (index, value) {
//alert($(this).find('.js-proc-form-x').val());
			if(parseFloat($(this).find('.js-proc-form-x').val())<=parseFloat(proce))
			{
				$(this).addClass('yes-buy-y');
			} else
			{
				$(this).removeClass('yes-buy-y');
			}

		});

	}

}

function all_price_trips()
{
	var id_task= $(this).parents('.trips_block_global').attr('id_trips');

	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_edit_price.php?id='+id_task,
		beforeOpen: function(data, el) {
			$('.loader_ada_forms').show();
			$('.loader_ada1_forms').addClass('select_ada');

		},
		afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
			ToolTip();
		},
		afterClose: function(data, el) { // после закрытия окна ArcticModal
			clearInterval(timerId);
		}

	});
}


/**
 * открытие формы редактирование финансового плана
 */
function plane_edit()
{
	//window.chart1.data = window.dataxx;
	/*
	window.pieSeries1.dataItems.each(function(row, i) {
		alert("22");
	});
	*/


	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_edit_plane.php',
		beforeOpen: function(data, el) {
			$('.loader_ada_forms').show();
			$('.loader_ada1_forms').addClass('select_ada');

		},
		afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
			ToolTip();
		},
		afterClose: function(data, el) { // после закрытия окна ArcticModal
			clearInterval(timerId);
		}

	});


}

/**
 * открытие формы сроки оплат
 */
function srok_my()
{
	var id_task= $(this).parents('.trips_block_global').attr('id_trips');
    var my=$(this).attr('my');

	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_edit_srok.php?id='+id_task+'&my='+my,
		beforeOpen: function(data, el) {
			$('.loader_ada_forms').show();
			$('.loader_ada1_forms').addClass('select_ada');

		},
		afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
			ToolTip();
		},
		afterClose: function(data, el) { // после закрытия окна ArcticModal
			clearInterval(timerId);
		}

	});
}








/**
 * пустая постфункция
 */
function AfterZero(data,update) {


}




function test_a()
{
alert("!");
	var data ='url='+window.location.href+
		'&id=34&text='+ec('привет');



	AjaxClient('test','test','GET',data,'AfterTest',3,0,1);
}










/**
 * редактировать платеж в турах
 */
function js_buy_edit()
{
	var id_trips= $(this).parents('.trips_block_global').attr('id_trips');
	var id_buy= $(this).parents('.buy_block_global').attr('id_buy');

	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_edit_buy.php?id='+id_trips+'&id_buy='+id_buy,
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
}



/**
 * удалить платеж в турах
 */
function js_buy_del()
{
	var id_trips= $(this).parents('.trips_block_global').attr('id_trips');
	var id_buy= $(this).parents('.buy_block_global').attr('id_buy');

	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_dell_buy.php?id='+id_trips+'&id_buy='+id_buy,
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

}



/**
 * создать новую версию договора в турах кнопку
 */
function js_new_doc()
{
	var id_trips= $(this).parents('.trips_block_global').attr('id_trips');

	$(this).hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');


	var data ='url='+window.location.href+'&id='+id_trips;
	AjaxClient('tours','new_doc','GET',data,'Afterjs_new_doc',id_trips,0,1);




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



/**
внести оплату нажать кнопку открытия формы
 **/
function js_menu_buybuy()
{
	var id_task= $(this).parents('.trips_block_global').attr('id_trips');

	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_add_buy.php?id='+id_task,
		beforeOpen: function(data, el) {
			$('.loader_ada_forms').show();
			$('.loader_ada1_forms').addClass('select_ada');

		},
		afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
			ToolTip();
		},
		afterClose: function(data, el) { // после закрытия окна ArcticModal
			clearInterval(timerId);
		}

	});
}


/**
  нажатие на курс чтобы изменить
 **/
function js_rrate()
{
   //открыть форму
	$(this).parents('.js-trips-comm').find('.form-rate-ok').addClass('show-form-rate');
}



/**
 * туры - ок после ввода даты когда отдали договор
 *
 */
function ok_rate_form_doc(event)
{

	//проверяем что введен курс
	var rate_b= $(this).parents('.form-rate-ok').find('[name=doc_date]').val();
	if((rate_b!='00.00.0000')&&(jQuery.trim(rate_b)!=''))
	{
		//Все ок рассчитываем и скрываем эту форму
		$(this).parents('.issue-block').find('.js-issue-doc').removeClass('red-jj');
		$(this).parents('.issue-block').find('.js-issue-doc').addClass('green-jj');
		$(this).parents('.issue-block').find('.js-issue-doc').empty().append('выдан '+rate_b);
		$(this).parents('.form-rate-ok').removeClass('show-form-rate');
		//console.log("Обработчик параграфа.");
		event.stopPropagation();
	} else {
		$(this).parents('.issue-block').find('.js-issue-doc').addClass('red-jj');
		$(this).parents('.issue-block').find('.js-issue-doc').removeClass('green-jj');
		$(this).parents('.issue-block').find('.js-issue-doc').empty().append('не выдан');
		$(this).parents('.form-rate-ok').removeClass('show-form-rate');
		event.stopPropagation();
	}


	var id_trips= $(this).parents('.trips_block_global').attr('id_trips');



	var data ='url='+window.location.href+'&id='+id_trips+'&date='+rate_b;
	AjaxClient('tours','issue_doc','GET',data,'After_ok_rate_form_doc',id_trips,0,1);


}

/**
 * туры - ок после ввода Впечатления по туру
 *
 */
function ok_rate_form_chat(event)
{

	//проверяем что введен курс
	var rate_b= $(this).parents('.form-rate-ok').find('[name=chat_text]').val();
	if(jQuery.trim(rate_b)!='')
	{
		//Все ок рассчитываем и скрываем эту форму
		$(this).parents('.form-rate-ok').removeClass('show-form-rate');
		//console.log("Обработчик параграфа.");
		$(this).parents('.trips_block_global').find('.js-chat-tours-add').hide();
		var id_trips= $(this).parents('.trips_block_global').attr('id_trips');


		//создать post formu



		$(this).parents('.form-rate-ok').find('.js-prs').removeClass('error_textarea_2018');



		var data ='url='+window.location.href+'&id='+id_trips+'&.chat='+rate_b;

		create_post_form(data,'form_body_action');
		AjaxClient('tours','add_chat','POST',0,'After_ok_rate_form_chat',id_trips,'form_body_action',1);

		$('#form_body_action').remove();

	//	AjaxClient('tours','add_chat','GET',data,'After_ok_rate_form_chat',id_trips,0,1);


		event.stopPropagation();
	} else {
		//$(this).parents('.form-rate-ok').removeClass('show-form-rate');
		$(this).parents('.form-rate-ok').find('.js-prs').addClass('error_textarea_2018');
		alert_message('error','Заполните впечатление по туру');
		event.stopPropagation();
	}




}

/**
 * туры - ок после ввода курса ТО
 *
 */
function ok_rate_form(event)
{

	//проверяем что введен курс
	var rate_b= $(this).parents('.form-rate-ok').find('[name=exchange_rates]').val();
	if((rate_b!=0)&&(rate_b!=''))
	{
		//Все ок рассчитываем и скрываем эту форму
		$(this).parents('.form-rate-ok').find('.input_2018').removeClass('error_2018');

		$(this).parents('.js-form-cost').attr('rate',rate_b);

		//var code_rate=$(this).parents('.trips-b-user').find('.eye-my').attr('code');
		var code_rate='yyy';
		//alert($(this).parents('.trips-b-user').find('.eye-wall-trips').is('.eye-my'));


		$(this).parents('.js-trips-comm').find('.eye-wall-trips').addClass('eye-my');
		$(this).parents('.js-trips-comm').find('.calculate-balance').removeClass('eye-my');

		var div_mama=$(this).parents('.js-trips-comm');
        var ostat= $(this).parents('.form-rate-ok').attr('balance');

        var hii=parseFloat(rate_b);
		div_mama.find('.cacl-rrate').empty().append($.number(hii.toFixed(2), 2, '.', ' ')).show();

		var curs=(parseFloat(ctrim(ostat))*parseFloat(ctrim(rate_b)));
		var curs=$.number(curs.toFixed(2), 2, '.', ' ');

		div_mama.find('.js-all-cost').addClass('hide-cost');
		div_mama.find('.js-all-cost.rate_'+code_rate).empty().append(curs);
		div_mama.find('.js-all-cost.rate_'+code_rate).removeClass('hide-cost');

		div_mama.find('.cost_all_trips').addClass('hide-cost');
		div_mama.find('.cost_all_trips .rate_'+code_rate).parents('.cost_all_trips').removeClass('hide-cost');



		//$(this).parents('.form-rate-ok').removeClass('show-form-rate');
		//setTimeout ( function () { $(this).parents('.form-rate-ok').removeClass('show-form-rate'); }, 1000 );
		$(this).parents('.form-rate-ok').removeClass('show-form-rate');

		//console.log("Обработчик параграфа.");
		event.stopPropagation();
	} else {
		//ошибка заполнения
		$(this).parents('.form-rate-ok').find('.input_2018').addClass('error_2018');
	}
}


/**
 договор отдан
 **/
function form_doc() {


	if (!$(this).parents('.issue-block').find('.form-rate-ok').is(".show-form-rate")) {
		//alert("!!");


		var rate = $(this).parents('.issue-block').attr('doc');

		if ((rate == '') && (rate == 0)) {
			if ($(this).parents('.issue-block').find('.form-rate-ok').length != 0) {
				$('.form-rate-ok').removeClass('show-form-rate');
				$(this).parents('.issue-block').find('.form-rate-ok').addClass('show-form-rate');

			}
		} else
		{
			$(this).parents('.issue-block').find('.form-rate-ok .js-docc').val(rate);
			if ($(this).parents('.issue-block').find('.form-rate-ok').length != 0) {
				$('.form-rate-ok').removeClass('show-form-rate');
				$(this).parents('.issue-block').find('.form-rate-ok').addClass('show-form-rate');
			}
		}
		input_2018();

	}
}

/**
 * добавить впечатление в туре
 */
function form_doc_chat() {


	if (!$(this).parents('.trips-b-number').find('.form-rate-ok').is(".show-form-rate")) {
		//alert("!!");


			if ($(this).parents('.trips-b-number').find('.form-rate-ok').length != 0) {
				$('.form-rate-ok').removeClass('show-form-rate');
				$(this).parents('.trips-b-number').find('.form-rate-ok').addClass('show-form-rate');

			}

		input_2018();

	}
}

/**
 * создание post формы на лету чтобы отправить через ajax. где GET не подходит из-за размера url
 *
 */

function create_post_form(data,id_form)
{
	//var data ='url='+window.location.href+'&id='+id_trips+'&chat='+encodeURIComponent(rate_b);
	var data_forms=data.split('&');

	var form = document.createElement('form');
	form.setAttribute('action', '/');
	form.setAttribute('method', 'POST');
	form.setAttribute('id', id_form);
	form.setAttribute('class', 'none');

	$.each(data_forms, function(index, value){

		var data_forms=value.split('=');

if(data_forms[0][0]=='.') {

	var input1 = document.createElement('textarea');
	input1.setAttribute('name', data_forms[0].slice(1));
	input1.value=data_forms[1];
	form.appendChild(input1);
} else {
	var input1 = document.createElement('input');
	input1.setAttribute('type', 'text');
	input1.setAttribute('name', data_forms[0]);
	input1.setAttribute('value', data_forms[1]);
	form.appendChild(input1);
}


	});
	$('body').append(form);


}

//кнопка редактировать клиента
function no_rds_user()
{
	$('.js-tabs_0').hide();
	$('.jipp_fll').slideDown( "slow" );
	$('.jipp_fll_start').slideUp( "slow" );

	ToolTip();

	$(".slct").unbind('click.sys');
	$(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
	$('#typesay').unbind('change', changesay);
	$('#typesay').bind('change', changesay);
	input_2018();

	$('.date_picker_x').inputmask("datetime",{
		mask: "1.2.y",
		placeholder: "dd.mm.yyyy",
		separator: ".",
		alias: "dd.mm.yyyy"
	});
}

//кнопка редактировать клиента
/*
$('#no_rdx').on( "click", function() {
	$('.js-tabs_0').hide();
	$('.jipp_fll').slideDown( "slow" );
	$('.jipp_fll_start').slideUp( "slow" );

	ToolTip();

	$(".slct").unbind('click.sys');
	$(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
	$('#typesay').unbind('change', changesay);
	$('#typesay').bind('change', changesay);
	input_2018();

	$('.date_picker_x').inputmask("datetime",{
		mask: "1.2.y",
		placeholder: "dd.mm.yyyy",
		separator: ".",
		alias: "dd.mm.yyyy"
	});

});
*/
//кнопка редактировать организацию
function no_rds_org() {
	$('.js-tabs_0').hide();
	$('.jipp_fll').slideDown( "slow" );
	$('.jipp_fll_start').slideUp( "slow" );

	ToolTip();
	$('.reda_org_comment').autoResize({extraSpace : 10}).trigger('keyup');
	$('.js-padej_woo_end').autoResize({extraSpace : 10}).trigger('keyup');

	$(".slct").unbind('click.sys');
	$(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
	$('#typesay').unbind('change', changesay);
	$('#typesay').bind('change', changesay);
	input_2018();

	$('.date_picker_x').inputmask("datetime",{
		mask: "1.2.y",
		placeholder: "dd.mm.yyyy",
		separator: ".",
		alias: "dd.mm.yyyy"
	});

}
/*
$('#no_rdx_org').on( "click", function() {
	$('.js-tabs_0').hide();
	$('.jipp_fll').slideDown( "slow" );
	$('.jipp_fll_start').slideUp( "slow" );

	ToolTip();
	$('.reda_org_comment').autoResize({extraSpace : 10}).trigger('keyup');
	$('.js-padej_woo_end').autoResize({extraSpace : 10}).trigger('keyup');

	$(".slct").unbind('click.sys');
	$(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
	$('#typesay').unbind('change', changesay);
	$('#typesay').bind('change', changesay);
	input_2018();

	$('.date_picker_x').inputmask("datetime",{
		mask: "1.2.y",
		placeholder: "dd.mm.yyyy",
		separator: ".",
		alias: "dd.mm.yyyy"
	});

});

*/

//кнопка отменить закрыть форму
$('#no_rd').on( "click", function() {
	clearInterval(timerId);
	$.arcticmodal('close');
});


/**
 рассчитать остаток в рублях
 **/
function form_cost() {


	if (!$(this).find('.form-rate-ok').is(".show-form-rate")) {
	//alert("!!");

	var code_rate = $(this).find('.eye-my').attr('code');
		var div_mama=$(this).parents('.js-trips-comm');
//alert(code_rate);
	if (!$(this).find('.eye-my').is(".calculate-balance")) {
//если это не кнопка рассчитать остаток в рублях
		$(this).find('.eye-wall-trips').addClass('eye-my');
		$(this).find('[code=' + code_rate + ']').removeClass('eye-my');



		div_mama.find('.js-all-cost').addClass('hide-cost');
		div_mama.find('.js-all-cost.rate_'+code_rate).removeClass('hide-cost');

		div_mama.find('.cost_all_trips').addClass('hide-cost');
		div_mama.find('.cost_all_trips .rate_'+code_rate).parents('.cost_all_trips').removeClass('hide-cost');
		return false;

	}
	var rate = $(this).attr('rate');

	if ((rate == '') && (rate == 0)) {
		if ($(this).find('.form-rate-ok').length != 0) {
			$('.form-rate-ok').removeClass('show-form-rate');
			$(this).find('.form-rate-ok').addClass('show-form-rate');
		}
		} else
		{
			//уже курс задан. просто показать остаток в рублях по курсу заданному
			div_mama.find('.js-all-cost').addClass('hide-cost');
			div_mama.find('.js-all-cost.rate_'+code_rate).removeClass('hide-cost');

			div_mama.find('.cost_all_trips').addClass('hide-cost');
			div_mama.find('.cost_all_trips .rate_'+code_rate).parents('.cost_all_trips').removeClass('hide-cost');

			$(this).find('.eye-wall-trips').addClass('eye-my');
			$(this).find('[code=' + code_rate + ']').removeClass('eye-my');

		}

}
}

/**
 * показать скрыть впечатление по туру
 */
function chat_tours()
{
var chat=$(this).parents('.trips_block_global').find('.chat-tours');
	if( chat.is(':visible') ) { chat.hide("slow");

	} else
	{
		chat.show("slow");
		jQuery.scrollTo(chat, 1000, {offset:-120});
	}

}



/**
 * нажатие на кнопку в списке туров показвать в рублях
 *
 **/
function exc_cost()
{
    var code_rate=$(this).find('.eye-my').attr('code');
	$(this).find('.eye-wall-trips').addClass('eye-my');
	$(this).find('[code='+code_rate+']').removeClass('eye-my');

    var div_mama=$(this).parents('.js-trips-comm');

	div_mama.find('.js-all-cost').addClass('hide-cost');
	div_mama.find('.js-all-cost.rate_'+code_rate).removeClass('hide-cost');

	div_mama.find('.cost_all_trips').addClass('hide-cost');
	div_mama.find('.cost_all_trips').find('.rate_'+code_rate).parents('.cost_all_trips').removeClass('hide-cost');
}


function AddFormTender()
{
	
	var err = 0;
	var err1 = 0;
//alert($('.js-form-register .gloab').length);
	$('.js-form-tender-new .gloab').each(function(i,elem) {
	if($(this).val() == '')  {$(this).parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $(this).parents('.input_2018').addClass('required_in_2018');  
	$(this).parents('.list_2018').addClass('required_in_2018');						  
	err++;	
							  
							  
							  
	//alert($(this).attr('name'));					 
} else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}		
});
	if(err==0)
		{
	if($('.tot_buy_id').val()== '') { err1++;   alert_message('error','Выберите покупателя тура'); jQuery.scrollTo('.js-buy-turs-client', 1000, {offset:-120});  } else
		{
			
				if($('.tot_fly_id').val()== '') { err1++;   alert_message('error','Выберите туристов'); jQuery.scrollTo('.js-fly-turs-client', 1000, {offset:-120});  }
			
		}
		}
	
	
	//alert(err);
	
	if((err==0)&&(err1==0))
		{
			$('.js-form-tender-new  .js-add-tender-form').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
			
			$('.js-form-tender-new .message-form').hide();
		    //AjaxClient('notification','even','GET',data,'AfterNofi',1,0,1);		
		AjaxClient('tours','add','POST',0,'AfterAddFormTender',0,'js-form-tender-new',0);
			
		} else
			{   
				if(err!=0)
					{
				//найдем самый верхнюю ошибку и пролестнем к ней
				jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
				//ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
				alert_message('error','Не все поля заполнены');
					}
				
			}	
	
}

function EditFormTender()
{

	var err = 0;
	var err1 = 0;
//alert($('.js-form-register .gloab').length);
	$('.js-form-tender-edit .gloab').each(function(i,elem) {
		if($(this).val() == '')  {$(this).parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $(this).parents('.input_2018').addClass('required_in_2018');
			$(this).parents('.list_2018').addClass('required_in_2018');
			err++;



			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
	});
	if(err==0)
	{
		if($('.tot_buy_id').val()== '') { err1++;   alert_message('error','Выберите покупателя тура'); jQuery.scrollTo('.js-buy-turs-client', 1000, {offset:-120});  } else
		{

			if($('.tot_fly_id').val()== '') { err1++;   alert_message('error','Выберите туристов'); jQuery.scrollTo('.js-fly-turs-client', 1000, {offset:-120});  }

		}
	}


	//alert(err);

	if((err==0)&&(err1==0))
	{
		$('.js-form-tender-edit  .js-edit-tender-form').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');

		$('.js-form-tender-edit .message-form').hide();
		//AjaxClient('notification','even','GET',data,'AfterNofi',1,0,1);
		AjaxClient('tours','edit','POST',0,'AfterEditFormTender',0,'js-form-tender-edit',1);

	} else
	{
		if(err!=0)
		{
			//найдем самый верхнюю ошибку и пролестнем к ней
			jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
			//ErrorBut('.js-form-tender-new .js-add-tender-form','Ошибка заполнения!');
			alert_message('error','Не все поля заполнены');
		}

	}

}

function After_ok_rate_form_chat(data,update)
{
	if (data.status=='ok')
	{
		alert_message('ok','Впечатление по туру добавлено');
		UpdateTripsA(update,'buy',1);

	} else
	{
		$('.trips_block_global[id_trips='+update+']').find('.js-chat-tours-add').show();
		alert_message('error','Ошибка добавления');
	}
}

function After_ok_rate_form_doc(data,update)
{
	if (data.status!='ok')
	{

		var ddoc=$('.trips_block_global[id_trips='+update+']').find('.issue-block').attr('doc');
		var issoe=$('.trips_block_global[id_trips='+update+']').find('.issue-block .js-issue-doc');
		if(ddoc!='')
		{

			issoe.empty().append('выдан '+ddoc);
			issoe.removeClass('red-jj');
			issoe.addClass('green-jj');
		} else
		{

			issoe.empty().append('не выдан');
			issoe.addClass('red-jj');
			issoe.removeClass('green-jj');
		}


	} else
	{
		$('.trips_block_global[id_trips='+update+']').find('.issue-block').attr('doc',data.download);
	}
}

function AfterUpdateTripsA(data,update)
{
	if (data.status=='ok')
	{
		//обновить общий блок
		$('.trips_block_global[id_trips='+update+']').find('.js-update-block-trips').empty().append(data.query);

        //обновить информацию в меню с сохранением открытой вкладки
		$('.trips_block_global[id_trips='+update+']').find('.js-tabs-menu').empty().append(data.echo);

		if(data.upload_mm==1) {
			//обновить информацию в открытой вкладке если это надо
			$('.trips_block_global[id_trips=' + update + ']').find('.px_bg_trips').empty().append(data.echo_more);
		}

		$('.trips_block_global[id_trips='+update+']').find('.circlestat').circliful();
		$('.date_picker_xe').inputmask("datetime",{
			mask: "1.2.y",
			placeholder: "dd.mm.yyyy",
			separator: ".",
			alias: "dd.mm.yyyy"
		});
	}
}

//постфункция создания нового договора в туре
function Afterjs_new_doc(data,update)
{
	if (data.status=='ok')
	{
		$('.trips_block_global[id_trips='+update+']').find('.px_bg_trips').prepend(data.download);


        var count_v=$('.trips_block_global[id_trips='+update+'] .vers-doc-color').length;
		var i_v=count_v;

		$('.trips_block_global[id_trips='+update+'] .vers-doc-color').empty().removeClass('green-trips red-trips');

		setTimeout ( function () { $( '.new-say-doc ' ).removeClass('new-say-doc'); }, 4000 );



		$('.trips_block_global[id_trips='+update+'] .vers-doc-color').each(function(i,elem) {

			$(this).append('(Версия №'+i_v+')');
			if(i_v==count_v)
			{
				$(this).addClass('green-trips');
			} else
			{
				$(this).addClass('red-trips');
			}
			i_v--;

		});
		$('.trips_block_global[id_trips='+update+']').find('.px_bg_trips .b_loading_small').remove();
		$('.trips_block_global[id_trips='+update+']').find('.js-new-doc-trips').show();

	} else
	{
	    $('.trips_block_global[id_trips='+update+']').find('.px_bg_trips .b_loading_small').remove();
		$('.trips_block_global[id_trips='+update+']').find('.js-new-doc-trips').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['no_all_password_buy','no_all_password_fly','no_phone_tell_buy','no_all_password_x','no_all_info_org','no_all_info_rf_org','number_contract_busy'];

			var err_name = ['Паспортные данные покупателя','Паспортные данные туристов','Телефон, адрес покупателя','паспорт РФ покупателя','данные по организации','паспортные данные руководителя',''];

			numbers=$.inArray(value, err);
			//alert(numbers);
			if(numbers!=-1)
			{
				if(value=='number_contract_busy')
				{
					alert_message('error', 'Номер договора занят. Следующий свободный - ' + data.number);
				} else {
					alert_message('error', 'некорректно заполнено - ' + err_name[numbers]);
				}
			} else
			{
				alert_message('error','Ошибка!');
			}
		});
	}
}

function AfterAddFormTender(data,update)
{
	if (data.status=='ok')
    {
	   // $('.js-form-tender-new').remove();
		
		alert_message('ok','Новый тур добавлен');
		//$('.js-next-step').submit();

		//$('.js-form-tender-new .js-alert-doc').empty().append(data.download);
		//$('.js-form-tender-new .js-doc-create').slideDown( "slow" );
        //$('.js-form-tender-new  .js-doc-yes-hide').slideUp( "slow" );

		$('#js-form-edit-edit-a').attr('action','tours/.id-'+data.for_id);
		setTimeout ( function () { $('#js-form-edit-edit-a').submit(); }, 1000 );

	} else
		{
	 	  $('.js-form-tender-new .js-add-tender-form').show();
		  $('.js-form-tender-new .b_loading_small').remove();
			
		 //alert_message('error','Ошибка! Заполните все поля');
	
		  //$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();	
			
		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){	
			
			
	var err = ['number_contract','id_operator','id_exchange','date_sele_doc','buy_id','count_clients','id_country','date_start','date_end','count_day','hotel','flight_there_route','flight_there_class','flight_there_number','flight_back_route','flight_back_class','flight_back_number','transfer_route','transfer_type','cost_client','no_all_password_buy','no_all_password_fly','no_phone_tell_buy','no_all_password_x','no_all_info_org','no_all_info_rf_org','number_contract_busy','exchange_rates','number_contract_format'];
	
	var err_name = ['Номер договора','Туроператор','Валюта','Дата договора','Покупатель тура','Кол-во человек','Страна','Дата начала тура','Дата окончания тура','Кол-во дней','Отель','Маршрут туда','Класс туда','Номер рейса туда','Маршрут обратно','Класс обратно','Номер рейса обратно','Маршрут трансфера','Тип трансфера','Стоимость тура','Паспортные данные покупателя','Паспортные данные туристов','Телефон, адрес покупателя','паспорт РФ покупателя','данные по организации','паспортные данные руководителя','','Курс валюты (ТО)','Номер договора'];
			
	//var number = [2,1,4,5,3,6,7,8,11,12,13,22,14,15,18,19,16,17,20,21];			
					
				
				numbers=$.inArray(value, err);
				//alert(numbers);
				if(numbers!=-1)
					{
						/*
						var ins=number[numbers];
						$('.js-form-tender-new .js-in'+ins).parents('.input_2018').addClass('required_in_2018');
			$('.js-form-tender-new .js-in'+ins).parents('.input_2018').find('.div_new_2018').append('<div class="error-message">некорректно заполнено поле</div>');
			*/
						if(value=='number_contract_busy')
						{
							alert_message('error', 'Номер договора занят. Следующий свободный - ' + data.number);
							jQuery.scrollTo('[name=number_contract]', 1000, {offset:-180});


							$('[name=number_contract]').parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $('[name=number_contract]').parents('.input_2018').addClass('required_in_2018');
							$('[name=number_contract]').parents('.list_2018').addClass('required_in_2018');
						} else {
							alert_message('error', 'некорректно заполнено - ' + err_name[numbers]);
						}
					} else
					{
							//$('.js-form-register .message-form').empty().append('Ошибка! ');
						alert_message('error','Ошибка!');
					}						
	        //jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});		
		});
		}
}

function AfterEditFormTender(data,update)
{
	if (data.status=='ok')
	{
		// $('.js-form-tender-new').remove();

		alert_message('ok','Данные по туру сохранены');
		//$('.js-next-step').submit();

		//$('.js-form-tender-edit .js-alert-doc').empty().append(data.download);
		//$('.js-form-tender-edit .js-doc-create').slideDown( "slow" );
		//$('.js-form-tender-edit  .js-doc-yes-hide').slideUp( "slow" );

		$('.js-form-tender-edit .js-edit-tender-form').show();
		$('.js-form-tender-edit .b_loading_small').remove();

		//переадрессация

		setTimeout ( function () { $('#js-form-edit-edit').submit(); }, 1000 );
	} else
	{
		$('.js-form-tender-edit .js-edit-tender-form').show();
		$('.js-form-tender-edit .b_loading_small').remove();

		//alert_message('error','Ошибка! Заполните все поля');

		//$('.js-form-tender-new .message-form').empty().append('Заполните все поля').show();

		//проходимя по массиву ошибок
		$.each(data.error, function(index, value){


			var err = ['number_contract','id_operator','id_exchange','date_sele_doc','buy_id','count_clients','id_country','date_start','date_end','count_day','hotel','flight_there_route','flight_there_class','flight_there_number','flight_back_route','flight_back_class','flight_back_number','transfer_route','transfer_type','cost_client','no_all_password_buy','no_all_password_fly','no_phone_tell_buy','no_all_password_x','no_all_info_org','no_all_info_rf_org','number_contract_busy'];

			var err_name = ['Номер договора','Туроператор','Валюта','Дата договора','Покупатель тура','Кол-во человек','Страна','Дата начала тура','Дата окончания тура','Кол-во дней','Отель','Маршрут туда','Класс туда','Номер рейса туда','Маршрут обратно','Класс обратно','Номер рейса обратно','Маршрут трансфера','Тип трансфера','Стоимость тура','Паспортные данные покупателя','Паспортные данные туристов','Телефон, адрес покупателя','паспорт РФ покупателя','данные по организации','паспортные данные руководителя',''];

			//var number = [2,1,4,5,3,6,7,8,11,12,13,22,14,15,18,19,16,17,20,21];


			numbers=$.inArray(value, err);
			//alert(numbers);
			if(numbers!=-1)
			{
				/*
                var ins=number[numbers];
                $('.js-form-tender-new .js-in'+ins).parents('.input_2018').addClass('required_in_2018');
    $('.js-form-tender-new .js-in'+ins).parents('.input_2018').find('.div_new_2018').append('<div class="error-message">некорректно заполнено поле</div>');
    */if(value=='number_contract_busy')
			{
				alert_message('error', 'Номер договора занят. Следующий свободный - ' + data.number);
				jQuery.scrollTo('[name=number_contract]', 1000, {offset:-180});


				$('[name=number_contract]').parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $('[name=number_contract]').parents('.input_2018').addClass('required_in_2018');
				$('[name=number_contract]').parents('.list_2018').addClass('required_in_2018');
				err++;





			} else {
				alert_message('error', 'некорректно заполнено - ' + err_name[numbers]);
			}
			} else
			{
				//$('.js-form-register .message-form').empty().append('Ошибка! ');
				alert_message('error','Ошибка!');
			}
			//jQuery.scrollTo('.required_in_2018:first', 1000, {offset:-70});
		});
	}
}



//открыть окно задачи
function open_task()
{
	var id_task= $(this).parents('.task_clock_selection').attr('id_task');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_task.php?id='+id_task+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
		
		
    },
    afterOpen: function(data, el) {
		
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }
  });		
	
	
	
}

	
/*
window.search_min2 = 0;  //мин количество символов для быстрого поиска
window.search_deley2=700;	//задержка между вводами символов - начало поиска
*/

//window.search_input2=$('.js-keyup-search');			

/*
//проверка наличкой или нет была оплата если это оплата клиентом. скрыть ненужные методы
 */


function nall_buy_tips(load) {
	//alert("!");
	load = load || 0;
	//lert($('.trips_payment_method').attr('nall'));
	if ($('.komy_trips').val() == 1) {
		if ($('.js_trips_payment_method').attr('nall') == 1) {

			$('.js-visible-mt').find('[nall=1]').parents('li').addClass('hide-mt');
			//если что-то выбрано что нельзя тогда изменяем выбор на наличные
			var zna = $('.js-visible-mt').find('[nall=0]').attr('rel');
			if(load==0) {
				$('.js_trips_payment_method').val(zna);
				$('.js-visible-mt').find('[nall=0]').trigger('click');
			}
		}
	}else {
			//показываем все методы - оплата туроператору
			$('.js-visible-mt').find('li').removeClass('hide-mt');
		}

}



function open_task_new()
{
	var id_task= $(this).attr('id_task');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_task.php?id='+id_task+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });		
	
	
}



function hide_finance_pass()
{
	//alert("!");
	$('.js-vid-oper').slideUp("slow");
	$('.js-form-pay-finance-edit .password_turs').slideUp("slow");
}


//изменение валюты
//  |
// \/
function exchange_eico()
{
	//alert_message('error',$(this).val());
	var char=$(this).val();
	if($('.val_rate').find('[rel='+char+']').attr('char')=='₽')
	{
		$('.rates_visible').slideUp("slow");
		$('.xexchange_rates').val('').trigger('click');
	} else
		{
			$('.rates_visible').slideDown("slow");
			$('.xexchange_rates').trigger('click');
		}
	
}


//функция вывода когда надо оплатить конечно
//  |
// \/
function xx_end_date()
{
	var uyy=0;
	var dp  = new Array();
	//alert($('.xcost_to_1').length);
	$('.xcost_to_1').each(function(i,elem) {		
		if(($(this).val()!=0)&&($(this).val()!=''))
		{
			//alert($(this).val());
		   uyy++;
			//alert(i);
		   dp[i]=$(this).val();
		}
	});	
	if((dp[0]==dp[1])&&(uyy==2))			
	{
		//скрыть
		$('.js-date_polnay').slideUp("slow");		
	} else
	{
		if(uyy==2) {
			$('.js-date_polnay').slideDown("slow");
		} else
		{
			$('.js-date_polnay').slideUp("slow");
		}
	}
}


//функция пересчета стоимости в валюте при изменение самой стоимости в рублях
//  |
// \/
function xexchange_rates2()
{
	var curss=$('.xexchange_rates').val();
	var js_200=$(this).parents('.jj-l').find('.oper_name');
		
	//alert_message('error',curss);
	
	   if((curss!='')&&(curss!=0)&&($(this).val()!='')&&($(this).val()!=0))
		{
				var char=$('.val_rate').find('[rel='+$('#exchange_rates').val()+']').attr('char');
				var curs=(parseFloat(ctrim($(this).val()))/parseFloat(curss));
				js_200.empty().append(char+' '+$.number(curs.toFixed(2), 2, '.', ' '));
		} else
		{
			 
			    var joi=js_200.attr('joi');
			    js_200.empty().append(joi);
		}
		
}
//функция пересчета стоимости в валюте при изменение вводе курса
//  |
// \/
function xexchange_rates1()
{
	if($(this).val()!='')
		{
	var wxxx=$(this).val();
	var char=$('.val_rate').find('[rel='+$('#exchange_rates').val()+']').attr('char');
			
	$('.jj-l').each(function(i,elem) {
	if(($(this).find('.gloab').val() != '')&&($(this).find('.gloab').val() != 0))  { 
	var curs=(parseFloat(ctrim($(this).find('.gloab').val()))/parseFloat(wxxx));
		//alert($(this).find('.gloab').val());
					$(this).find('.oper_name').empty().append(char+' '+$.number(curs.toFixed(2), 2, '.', ' '));
	
	} else {var joi=$(this).find('.oper_name').attr('joi');
					$(this).find('.oper_name').empty().append(joi);}		
});		
		} else
			{
				$('.jj-l').each(function(i,elem) {
					var joi=$(this).find('.oper_name').attr('joi');
					$(this).find('.oper_name').empty().append(joi);
				});	
			}
			
}



//функция показа результата на кнопке
//  |
// \/
//ErrorBut('.form-open .js-log','Ошибка заполнения!');
function YesBut(but,text)
{
	var element=$(but);
	var text_bb22 = element.html();
				element.empty().append(text);
				element.addClass('new-say-yes');
				setTimeout ( function () { element.removeClass('new-say-yes'); element.empty().append(text_bb22);  }, 4000 );
}

//функция показа ошибки на кнопки отправки
//  |
// \/
//ErrorBut('.js-form-open .js-log','Ошибка заполнения!');
function ErrorBut(but,text)
{
	var element=$(but);
	var text_bb22 = element.html();
				element.empty().append(text);
				element.addClass('new-say1');
				setTimeout ( function () { element.removeClass('new-say1'); element.empty().append(text_bb22);  }, 4000 );
}


function validDate(date){ // date в формате 31.12.2014
  var d_arr = date.split('.');
  var d = new Date(d_arr[2]+'/'+d_arr[1]+'/'+d_arr[0]+''); // дата в формате 2014/12/31
  if (d_arr[2]!=d.getFullYear() || d_arr[1]!=(d.getMonth() + 1) || d_arr[0]!=d.getDate()) {
    return false; // неккоректная дата
  };
  return true;
}


//разница между двух дат и определение коли-во ночей
function date_nait()
{
	var date2 = $('.js-date-nait2').val();
    var date1 =  $('.js-date-nait1').val();
	
	if ((validDate(date1))&&(validDate(date2))) {
		//alert("!1");
		
	var d_arr1 = date1.split('.');
  var d1 = new Date(d_arr1[2]+'/'+d_arr1[1]+'/'+d_arr1[0]+'');
		
	var d_arr2 = date2.split('.');
  var d2 = new Date(d_arr2[2]+'/'+d_arr2[1]+'/'+d_arr2[0]+'');
	
    var daysLag = Math.ceil(Math.abs(d2.getTime() - d1.getTime()) / (1000 * 3600 * 24));
	if(($.isNumeric(daysLag))&&(daysLag>=0))
	{
       $('.js-date-nait-itog').val(daysLag);
		input_2018();
	}
  }
}

//Обновление вывода по туру

function UpdateTripsA(id,operation,upload_mm)
{
	if (upload_mm == undefined) upload_mm = 0;
	//посмотреть какое меню открыто, если активно какое то
var active_menu_id=$('.trips_block_global[id_trips='+id+']').find('.js-tabs-menu .active').attr('id');
	//alert(active_menu_id);


	var data ='url='+window.location.href+'&id='+id+'&menu_id='+active_menu_id+'&op='+operation+'&mm='+upload_mm;
	AjaxClient('tours','update_trips','GET',data,'AfterUpdateTripsA',id,0,1);
}



//обновление вывода по задаче
function UpdateTaskBi(id)
{
	var data ='url='+window.location.href+'&id='+id;
				
	AjaxClient('task','task_update','GET',data,'AfterUpdateTaskBi',id,0,1);
}
function UpdateTaskBiAdd(id)
{
	var data ='url='+window.location.href+'&id='+id;
				
	AjaxClient('task','task_update','GET',data,'AfterUpdateTaskBiAdd',id,0,1);
}

function count_task()
{
	$('.hidden-count-task')
	
	$('.search-count-task').empty().append($('.hidden-count-task').text());
	//$('.search-count-task').slideDown( "slow" );
}

function open_task1()
{
	var id_task= $(this).parents('.task_block_global').attr('id_task');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_task.php?id='+id_task+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });		
	
	
}


function animation_teps()
{
	$('.teps').each(function(i,elem) {
	$(this).animate({width: $(this).attr('rel_w')+"%"}, 2000, function() {  });
});
}
function animation_graf()
{
	$('.line-fin').each(function(i,elem) {
		$(this).animate({width: $(this).attr('rel_w')+"%"}, 2000, function() {  });
	});
}

/**
 * выбрать что-то в быстрых фильтрах в турах
 * @param e
 **/
function filter_active_a_t(e)
{
	var iu=$('.content').attr('iu');
	e.preventDefault();
	var id_f=$(this).parents('.fi-at').attr('id');

	$.cookie("su_7ftu"+iu, null, {path:'/',domain: window.is_session,secure: false});
	CookieList("su_7ftu"+iu, id_f,'add');
	location.href=$(this).attr('href');
}


function list_number() {
	//alert("!");
//.next().find('li')
	var active_new=$(this).find('a').attr("rel");
	//alert(active_new);
	if(active_new==2)
	{
		$("#date_table").show();
		//$("#date_table").focus();
		$('.bookingBox_range').css({
			display:'block'
		});
	}
}



function filter_active_a(e)
{
	var iu=$('.content').attr('iu');
	e.preventDefault();
	var id_f=$(this).parents('.fi-a').attr('id');
	
	$.cookie("su_7fta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
    CookieList("su_7fta"+iu, id_f,'add');	
	location.href=$(this).attr('href');
}
/**
выбрать быстрые фильтры в задачах
 **/
function filter_active()
	{
		var active_new=$(this).find('.choice-radio i');
		var iu=$('.content').attr('iu');
		
		if(!active_new.is('.active_task_cb'))
		{
			//Делаем его активным
			$('.js-h1-filter').find('.choice-radio i').removeClass('active_task_cb');
			active_new.addClass('active_task_cb');
			//заносим в cookie
			$.cookie("su_7ta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
            CookieList("su_7ta"+iu,$(this).find('.choice-radio input').val(),'add');
			
			if($(this).find('.choice-radio input').val()==2)
				{
					
					$('.filter-wois').addClass("active-filter-s"); 
					 $('.js-plus-filter').removeClass("active-filter-s"); $('.js-plus-filter').addClass("no-active"); 
				} else
					{
					
					    $('.filter-wois').removeClass("active-filter-s"); 
					    $('.js-plus-filter').addClass("active-filter-s"); $('.js-plus-filter').removeClass("no-active"); 
						$('.js-reload-top').addClass('active-r');
					}
			
			
		}
	}

/**
 выбрать быстрые фильтры в турах
 **/
function filter_active_turs()
{
	var active_new=$(this).find('.choice-radio i');
	var iu=$('.content').attr('iu');

	if(!active_new.is('.active_task_cb'))
	{
		//Делаем его активным
		$('.js-h1-filter-turs').find('.choice-radio i').removeClass('active_task_cb');
		active_new.addClass('active_task_cb');
		//заносим в cookie
		$.cookie("su_7tu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_7tu"+iu,$(this).find('.choice-radio input').val(),'add');

		if($(this).find('.choice-radio input').val()==2)
		{

			$('.filter-wois').addClass("active-filter-s");
			$('.js-plus-filter').removeClass("active-filter-s"); $('.js-plus-filter').addClass("no-active");
		} else
		{

			$('.filter-wois').removeClass("active-filter-s");
			$('.js-plus-filter').addClass("active-filter-s"); $('.js-plus-filter').removeClass("no-active");
			$('.js-reload-top').addClass('active-r');
		}


	}
}


//быстрый поиск клиента открытие информации о найденном
function choice_user_task1_uma(tabs,id_list)
{
		clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	if(tabs==2)
	   {
	   	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_org.php?id='+id_list+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	   } else
		   {
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_user.php?id='+id_list+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });		   
		   }
}



/*	

var search_input2_search_c=$('.js-choice-keyup');
	
	
search_input2_search_c.keyup(function() {
	//обнуляем выбор
				
    delays(function(){
		
		if((jQuery.trim(search_input2_search_c.val().length) >= search_min2_search_c)||(jQuery.trim(search_input2_search_c.val().length)==0))
		{
			
			var val1= $('.js-tabs-menu-choiche').find('.active').attr('id');
			
                var data ='url='+window.location.href+
					'&all='+$('.js-eshe-client-x').attr("all")+
					'&search='+encodeURIComponent(search_input2_search_c.val())+
				'&tabs='+val1;	
			$('.js-icon-load').hide().after('<div class="b_loading_small" style="margin-right:-20px; position:relative; top: 0px; right: 0px; padding-top:0px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('clients','search_client_tours','GET',data,'AfterSearchClientT',1,0);		
		}
		
		
    }, search_deley2_search_c);
});		
	*/

//изменить в поле редактирования при выборе в списке
function update_edit_input_eico()
{
	var te=$(this).parents('.select').find('a.slct').text();
	//alert(te);
	$(this).parents('.js-edit-input-list').find('.edit-pole-eico input').val(te);
}


//редактировать выдадающий список 
function edit_eico_list()
{
	$(this).parents('.js-edit-input-list').removeClass('no-active-edit-20');
	var tye=$(this).parents('.js-edit-input-list').find('.edit-pole-eico input').val();
	$(this).parents('.js-edit-input-list').find('.edit-pole-eico input').val('').focus().val(tye);
	
}


//я жду на берусь за эту задачу
function choice_task_you()
{

	var i_c=$(this).find('i');
	var cb_h=$(this).find('input').val();
	
	if($(this).parents('.task_clock_selection').length > 0)
		{
	
	var id_task=$(this).parents('.task_clock_selection').attr('id_task');
		} else
			{
		var id_task=$(this).parents('.task_block_global').attr('id_task');			
			}
	
	if(i_c.is(':visible')) 
	   {
	
	if((cb_h==0)&&(!i_c.is('.active_task_cb')))
		{
			  $(this).find('input').val(1);
			  $(this).find('.choice-radio i').addClass('active_task_cb');
			  $(this).find('.choice-head').empty().append('Вы взялись за выполнение');
			 
			
			//отправляем на сервер
			var data ='url='+window.location.href+'&id='+id_task+'&choice=1';			
	        AjaxClient('task','task_my_task','GET',data,'AfterMyTask',id_task,0);
			
			
			
		} else
			{
			  $(this).find('input').val(0);
			  $(this).find('.choice-radio i').removeClass('active_task_cb');
				
			  			//отправляем на сервер
			var data ='url='+window.location.href+'&id='+id_task+'&choice=0';			
	        AjaxClient('task','task_my_task','GET',data,'AfterMyTask',id_task,0);
				$(this).find('.choice-head').empty().append('Забрать задачу на себя');
				
			  
			}
}
}

//ежемесячный платеж
function choice_buy_you()
{

	var i_c=$(this).find('i');
	var cb_h=$(this).find('input').val();


		var id_task=$(this).parents('.buy_block_global').attr('id_buy');


	if(i_c.is(':visible'))
	{

		if((cb_h==0)&&(!i_c.is('.active_task_cb')))
		{
			$(this).find('input').val(1);
			$(this).find('.choice-radio i').addClass('active_task_cb');
			//$(this).find('.choice-head').empty().append('Вы взялись за выполнение');


			//отправляем на сервер
			var data ='url='+window.location.href+'&id='+id_task+'&choice=1';
			AjaxClient('finance','constant','GET',data,'AfterConstBuy',id_task,0,1);



		} else
		{
			$(this).find('input').val(0);
			$(this).find('.choice-radio i').removeClass('active_task_cb');

			//отправляем на сервер
			var data ='url='+window.location.href+'&id='+id_task+'&choice=0';
			AjaxClient('finance','constant','GET',data,'AfterConstBuy',id_task,0,1);
			//$(this).find('.choice-head').empty().append('Забрать задачу на себя');


		}
	}
}


//после связи с клиентом задачи
function choice_user_task_uma(tabs,id_list)
{
	
	
	$('.js-id-client-task').val(id_list);
	$('.js-client-type-task').val(tabs);
	$('.js-sv-user-task span').empty().append($('.nname_choice[id_ch='+id_list+']').find('.tit').text());
	
	$('.js-sv-user-task').show();	
	
	$( '.arcticmodal-close', $('.js-s_form_xx').closest( '.box-modal' )).click();
}


//добавление в форму то что было выбрано
function choice_after_end_uma(tabs,id_list)
{
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	
	
	$('.js-buy-turs-client').parents('.buy_turs').hide();
	
	$('.js-buy-turs-client').parents('.buy_turs').before('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
	
	var data ='url='+window.location.href+'&type=1'+'&tabs='+tabs+'&id_tabs='+id_list+'&tk='+$('.h111').attr('mor')+'&id='+$('.h111').attr('for');
    
	AjaxClient('tours','card_client','GET',data,'AfterCardClient',1,0);		
	
	
}

function choice_after_end_fly_uma(tabs,id_list)
{
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	
	//alert(id_list);
	
	$('.js-fly-turs-client').parents('.buy_turs').hide();
	
	$('.js-fly-turs-client').parents('.buy_turs').before('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
	
	var data ='url='+window.location.href+'&type=2'+'&tabs='+tabs+'&id_tabs='+id_list+'&tk='+$('.h111').attr('mor')+'&id='+$('.h111').attr('for');
    
	AjaxClient('tours','card_client','GET',data,'AfterCardClient',2,0);		
	
	
}





//окончание выбора в окне выбора клиента нажатие выбрать
function choice_client_end()
{
	var choice_id=$(this).attr('id_rel');
	var choice_tabs=$(this).attr('tabs');
	if(choice_id==0)
	{
			var text_bb22 = $('.js-choice-yyy').find('i').text();
			$('.js-choice-yyy').find('i').empty().append('Ошибка!');
			$('.js-choice-yyy').addClass('new-znay1');
			setTimeout ( function () { $('.js-choice-yyy').removeClass('new-znay1'); $('.js-choice-yyy').find('i').empty().append(text_bb22);  }, 4000 );
	} else
	{
		var fun= $('[name=posta]').val();
        $.globalEval(fun+'_uma('+choice_tabs+',\''+choice_id+'\')');	
	}
}




//удалить из выбранного в окне при выборе клиента
function rrube_choice()
{
	var del_rel=$(this).parents('.nname_choice').attr('id_ch');
	$(this).parents('.nname_choice').remove();
	$('.list_client_choice[rel_notib='+del_rel+']').removeClass('yesss-ch');
	
					var new_choice='';
				var no_choice=del_rel;
				var aaaa = $('.js-choice-yyy').attr('id_rel').split(',');

				var is_c=0;
		        for (var t = 0; t < aaaa.length; t++) 
		        { 
					if(aaaa[t]!=no_choice)
					{
						if(is_c==0) { new_choice=aaaa[t];  } else { new_choice=new_choice+','+aaaa[t]; }
						is_c++;	
					}
				}
				
				if(new_choice=='')
				{
					$('.js-choice-yyy').removeClass('yes_choice_client');
	                $('.js-choice-yyy').attr('id_rel',0);	
				} else
				{
					$('.js-choice-yyy').attr('id_rel',new_choice);	
				}
	
}


//клик на клиенте при выборе клиента в списке
function click_client_choice()
{
	var several = $('[name=several_choice]').val();
	if($(this).is('.yesss-ch'))
		{
			//уже выделен
			//отменяем выделение
			if(several==0)
		{
			//выбор только одного возможного
	$(this).removeClass('yesss-ch');
	$('.js-choice-yyy').removeClass('yes_choice_client');
	$('.js-choice-yyy').attr('id_rel',0);
			
	$('.list_choice_yes').empty();		
			
			
		} else
			{
				
				$(this).removeClass('yesss-ch');
				var new_choice='';
				var no_choice=$(this).attr('rel_notib');
				var aaaa = $('.js-choice-yyy').attr('id_rel').split(',');

				var is_c=0;
		        for (var t = 0; t < aaaa.length; t++) 
		        { 
					if(aaaa[t]!=no_choice)
					{
						if(is_c==0) { new_choice=aaaa[t];  } else { new_choice=new_choice+','+aaaa[t]; }
						is_c++;	
					} else
					{
						$('.list_choice_yes').find('[id_ch='+no_choice+']').remove();	
					}
				}
				
				if(new_choice=='')
				{
					$('.js-choice-yyy').removeClass('yes_choice_client');
	                $('.js-choice-yyy').attr('id_rel',0);	
				} else
				{
					$('.js-choice-yyy').attr('id_rel',new_choice);	
				}
				
				
			}
			
		} else
			{
	if(several==0)
		{
			//выбор только одного возможного
	$('.yesss-ch').removeClass('yesss-ch');
	var val=$(this).attr('rel_notib');
	var val1= $('.js-tabs-menu-choiche').find('.active').attr('id');
	$(this).addClass('yesss-ch');
	$('.js-choice-yyy').addClass('yes_choice_client');
	$('.js-choice-yyy').attr('id_rel',val);
	$('.js-choice-yyy').attr('tabs',val1);
			
	$('.list_choice_yes').empty().append('<div class="nname_choice" id_ch="'+val+'"><span class="tit">'+$(this).find('.h_cb span').text()+'</span><span class="rrube_choice"></span></div>');		
			
			
		} else
		{
			//можно выбрать несколько 	
	var val=$(this).attr('rel_notib');
	var val1= $('.js-tabs-menu-choiche').find('.active').attr('id');
	$(this).addClass('yesss-ch');
	$('.js-choice-yyy').removeClass('yes_choice_client').addClass('yes_choice_client');
	$('.js-choice-yyy').attr('tabs',val1);
			
	var id_rr=$('.js-choice-yyy').attr('id_rel');
		if(id_rr==0)
			{
				//первый выбор
	$('.js-choice-yyy').attr('id_rel',val);
		$('.list_choice_yes').empty().append('<div class="nname_choice" id_ch="'+val+'"><span class="tit">'+$(this).find('.h_cb span').text()+'</span><span class="rrube_choice"></span></div>');		
			} else
				{
					//второй и последующий выбор
					$('.js-choice-yyy').attr('id_rel',id_rr+','+val);
					$('.list_choice_yes').append('<div class="nname_choice" id_ch="'+val+'"><span class="tit">'+$(this).find('.h_cb span').text()+'</span><span class="rrube_choice"></span></div>');		
				}
	
			
			
			
			
		}
			}
}


//выбор покупателя тура
function js_buy_turs_client()
{	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_choice_client.php?tabs=1&several=0&posta=choice_after_end',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');						
    },
    afterOpen: function(data, el) {
		$('.loader_ada_forms').hide();
		$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }
  });		
}


//выбор туриста в тур
function js_fly_turs_client()
{	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_choice_client.php?tabs=4&tabss=0&several=1&posta=choice_after_end_fly',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');						
    },
    afterOpen: function(data, el) {
		$('.loader_ada_forms').hide();
		$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }
  });		
}




//функция обновление цифр туристов при оформлении договора
function UpdateNumberTuris()
{
	var number_ssr=1;
	$('.active-turist-turs').each(function(i,elem) {
	$(this).find('.span-44').empty().append(number_ssr);
	number_ssr++;
});
}


//летит или только покупает
function loli_butt()
{
	var cb_h=$(this).parents('.loli_turs').find('input');
	//var bloo=$(this).parents('.info-client-ruler');
	if(cb_h.val()==0)
		{
			  cb_h.val(1);
			
			  $(this).find('.choice-radio i').addClass('active_task_cb');
			  $(this).addClass('active_pass');
			
			//определяем какой id удалить
			var id_deli = $(this).parents('.info-client-ruler').attr('id_rules');
			
			//удалить из туристов
			$('.tot_fly_id').val(AddDellList($('.tot_fly_id').val(),id_deli,'dell'));
			//уменьшить количество туристов
			var count_turi=parseFloat($('.tot_fly_count').val());
			if(count_turi!=0)
				{
			$('.tot_fly_count').val(count_turi-1);
				}
			
			
			$('.info-client-ruler[id_rules='+id_deli+']').removeClass('active-turist-turs');
			
			
			UpdateNumberTuris();
	
			
			
			
		}  else
			{
			  cb_h.val(0);
			
			  $(this).find('.choice-radio i').removeClass('active_task_cb');
			  $(this).removeClass('active_pass');	
			
				
	
			//определяем какой id добавить в туристов
			var id_deli = $(this).parents('.info-client-ruler').attr('id_rules');
			
			//добавить в туристов
				var add_200=AddDellList($('.tot_fly_id').val(),id_deli,'add');
				if(add_200!=0)
					{
						$('.tot_fly_id').val(AddDellList($('.tot_fly_id').val(),id_deli,'add'));
						
							//увеличить количество туристов
			var count_turi=parseFloat($('.tot_fly_count').val());
			/*
						if(count_turi!=0)
				{*/
			$('.tot_fly_count').val(count_turi+1);
			//	}
						
					//добавить в туристов карточку из покупателя
					//*************************
					$('.info-client-ruler[id_rules='+id_deli+']').addClass('active-turist-turs');
						
					UpdateNumberTuris();	
						
						
					}
			
		
			
			
				
				
				
			}
}


//выбор какой паспорт
function password_butt()
{
	var cb_h=$(this).parents('.password_turs').find('input');
	if(cb_h.val()!=$(this).attr('id'))
		{
			  cb_h.val($(this).attr('id'));
			  
			  $(this).parents('.password_turs').find('.choice-radio i').removeClass('active_task_cb');
			  $(this).parents('.password_turs').find('.input-choice-click-pass').removeClass('active_pass');
			
			  $(this).find('.choice-radio i').addClass('active_task_cb');
			  $(this).addClass('active_pass');
		} 
}


//Фио
//День рождение
//последнее сообщение
//вылет
//прилет
//телефон

//пол
//латиница

//загран серия
//загран номер
//загран кем
//загран когда выдан
//загран до какого

//внпаспорт серия
//внпаспорт номер
//внпаспорт кем
//внпаспорт когда выдан

//если что то надо получить то 1 иначе 0
//обновление каких либо данных по клиенту
function UpdateGlobal(id_user,arr)
{	
	var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+'&id='+id_user+'&arr='+arr;
				
	AjaxClient('clients','update_user_global','GET',data,'AfterUpdateUser',id_user,0,1);
}

function UpdateFinance(arr)
{
	var data ='url='+window.location.href+'&arr='+arr;
	AjaxClient('finance','update','GET',data,'AfterUpdateFinance',arr,0,1);
}



//Название организации
//директор
//юр адрес

//если что то надо получить то 1 иначе 0
//обновление каких либо данных по организации
function UpdateGlobalO(id_org,arr)
{	
	var data ='url='+window.location.href+'&tk='+$('.h111').attr('mor')+'&id='+id_org+'&arr='+arr;
				
	AjaxClient('clients','update_org_global','GET',data,'AfterUpdateOrg',id_org,0,1);
}


/**
 * Склонение русских имён и фамилий
 *
 * var rn = new RussianName('Паниковский Михаил Самуэльевич');
 * rn.fullName(rn.gcaseRod); // Паниковского Михаила Самуэльевича
 *
 * Список констант по падежам см. ниже в коде.
 *
 * Пожалуйста, присылайте свои уточнения мне на почту. Спасибо.
 *
 * @version  0.1.4
 * @author   Johnny Woo <agalkin@agalkin.ru>
 */

var RussianNameProcessor = {
	sexM: 'm',
	sexF: 'f',
	gcaseIm:   'nominative',      gcaseNom: 'nominative',      // именительный
	gcaseRod:  'genitive',        gcaseGen: 'genitive',        // родительный
	gcaseDat:  'dative',                                       // дательный
	gcaseVin:  'accusative',      gcaseAcc: 'accusative',      // винительный
	gcaseTvor: 'instrumentative', gcaseIns: 'instrumentative', // творительный
	gcasePred: 'prepositional',   gcasePos: 'prepositional',   // предложный
	
	rules: {
		lastName: {
			exceptions: [
				'	дюма,тома,дега,люка,ферма,гамарра,петипа,шандра . . . . .',
				'	гусь,ремень,камень,онук,богода,нечипас,долгопалец,маненок,рева,кива . . . . .',
				'	вий,сой,цой,хой -я -ю -я -ем -е'
			],
			suffixes: [
				'f	б,в,г,д,ж,з,й,к,л,м,н,п,р,с,т,ф,х,ц,ч,ш,щ,ъ,ь . . . . .',
				'f	ска,цка  -ой -ой -ую -ой -ой',
				'f	ая       --ой --ой --ую --ой --ой',
				'	ская     --ой --ой --ую --ой --ой',
				'f	на       -ой -ой -у -ой -ой',
				
				'	иной -я -ю -я -ем -е',
				'	уй   -я -ю -я -ем -е',
				'	ца   -ы -е -у -ей -е',
					
				'	рих  а у а ом е',
		
				'	ия                      . . . . .',
				'	иа,аа,оа,уа,ыа,еа,юа,эа . . . . .',
				'	их,ых                   . . . . .',
				'	о,е,э,и,ы,у,ю           . . . . .',
		
				'	ова,ева            -ой -ой -у -ой -ой',
				'	га,ка,ха,ча,ща,жа  -и -е -у -ой -е',
				'	ца  -и -е -у -ей -е',
				'	а   -ы -е -у -ой -е',
		
				'	ь   -я -ю -я -ем -е',
		
				'	ия  -и -и -ю -ей -и',
				'	я   -и -е -ю -ей -е',
				'	ей  -я -ю -я -ем -е',
		
				'	ян,ан,йн   а у а ом е',
		
				'	ынец,обец  --ца --цу --ца --цем --це',
				'	онец,овец  --ца --цу --ца --цом --це',
		
				'	ц,ч,ш,щ   а у а ем е',
		
				'	ай  -я -ю -я -ем -е',
				'	гой,кой  -го -му -го --им -м',
				'	ой  -го -му -го --ым -м',
				'	ах,ив   а у а ом е',
		
				'	ший,щий,жий,ний  --его --ему --его -м --ем',
				'	кий,ый   --ого --ому --ого -м --ом',
				'	ий       -я -ю -я -ем -и',
					
				'	ок  --ка --ку --ка --ком --ке',
				'	ец  --ца --цу --ца --цом --це',
					
				'	в,н   а у а ым е',
				'	б,г,д,ж,з,к,л,м,п,р,с,т,ф,х   а у а ом е'
			]
		},
		firstName: {
			exceptions: [
				'	лев    --ьва --ьву --ьва --ьвом --ьве',
				'	павел  --ла  --лу  --ла  --лом  --ле',
				'm	шота   . . . . .',
				'f	рашель,нинель,николь,габриэль,даниэль   . . . . .'
			],
			suffixes: [
				'	е,ё,и,о,у,ы,э,ю   . . . . .',
				'f	б,в,г,д,ж,з,й,к,л,м,н,п,р,с,т,ф,х,ц,ч,ш,щ,ъ   . . . . .',

				'f	ь   -и -и . ю -и',
				'm	ь   -я -ю -я -ем -е',

				'	га,ка,ха,ча,ща,жа  -и -е -у -ой -е',
				'	а   -ы -е -у -ой -е',
				'	ия  -и -и -ю -ей -и',
				'	я   -и -е -ю -ей -е',
				'	ей  -я -ю -я -ем -е',
				'	ий  -я -ю -я -ем -и',
				'	й   -я -ю -я -ем -е',
				'	б,в,г,д,ж,з,к,л,м,н,п,р,с,т,ф,х,ц,ч	 а у а ом е'
			]
		},
		middleName: {
			suffixes: [
				'	ич   а  у  а  ем  е',
				'	на  -ы -е -у -ой -е'
			]
		}
	},

	initialized: false,
	init: function() {
		if(this.initialized) return;
		this.prepareRules();
		this.initialized = true;
	},

	prepareRules: function() {
		for(var type in this.rules) {
			for(var key in this.rules[type]) {
				for(var i = 0, n = this.rules[type][key].length; i < n; i++) {
					this.rules[type][key][i] = this.rule(this.rules[type][key][i]);
				}
			}
		}
	},

	rule: function(rule) {
		var m = rule.match(/^\s*([fm]?)\s*(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s*$/);
		if(m) return {
			sex: m[1],
			test: m[2].split(','),
			mods: [m[3], m[4], m[5], m[6], m[7]]
		}
		return false;
	},
	
	// склоняем слово по указанному набору правил и исключений
	word: function(word, sex, wordType, gcase) {
		// исходное слово находится в именительном падеже
		if(gcase == this.gcaseNom) return word;
		
		// составные слова
		if(word.match(/[-]/)) {
			var list = word.split('-');
			for(var i = 0, n = list.length; i < n; i++) {
				list[i] = this.word(list[i], sex, wordType, gcase);
			}
			return list.join('-');
		}
		
		// Иванов И. И.
		if(word.match(/^[А-ЯЁ]\.?$/i)) return word;
		
		this.init();
		var rules = this.rules[wordType];

		if(rules.exceptions) {
			var pick = this.pick(word, sex, gcase, rules.exceptions, true);
			if(pick) return pick;
		}
		var pick = this.pick(word, sex, gcase, rules.suffixes, false);
		return pick || word;
	},
	
	// выбираем из списка правил первое подходящее и применяем 
	pick: function(word, sex, gcase, rules, matchWholeWord) {
		wordLower = word.toLowerCase();
		for(var i = 0, n = rules.length; i < n; i++) {
			if(this.ruleMatch(wordLower, sex, rules[i], matchWholeWord)) {
				return this.applyMod(word, gcase, rules[i]);
			}
		}
		return false;
	},
	
	// проверяем, подходит ли правило к слову
	ruleMatch: function(word, sex, rule, matchWholeWord) {
		if(rule.sex == this.sexM && sex == this.sexF) return false; // male by default
		if(rule.sex == this.sexF && sex != this.sexF) return false;
		for(var i = 0, n = rule.test.length; i < n; i++) {
			var test = matchWholeWord ? word : word.substr(Math.max(word.length - rule.test[i].length, 0));
			if(test == rule.test[i]) return true;
		}
		return false;
	},
	
	// склоняем слово (правим окончание)
	applyMod: function(word, gcase, rule) {
		switch(gcase) {
			case this.gcaseNom: var mod = '.'; break;
			case this.gcaseGen: var mod = rule.mods[0]; break;
			case this.gcaseDat: var mod = rule.mods[1]; break;
			case this.gcaseAcc: var mod = rule.mods[2]; break;
			case this.gcaseIns: var mod = rule.mods[3]; break;
			case this.gcasePos: var mod = rule.mods[4]; break;
			default: throw "Unknown grammatic case: "+gcase;
		}
		for(var i = 0, n = mod.length; i < n; i++) {
			var c = mod.substr(i, 1);
			switch(c) {
				case '.': break;
				case '-': word = word.substr(0, word.length - 1); break;
				default: word += c;
			}
		}
		return word;
	}
}

// new RussianName('Козлов Евгений Павлович')      // годится обычная форма
// new RussianName('Евгений Павлович Козлов')      // в таком виде тоже
// new RussianName('Козлов', 'Евгений')        // можно явно указать составляющие
// new RussianName('Кунтидия', 'Убиреко', '', 'f') // можно явно указать пол ('m' или 'f')
var RussianName = function(lastName, firstName, middleName, sex) {
	if(typeof firstName == 'undefined') {
		var m = lastName.match(/^\s*(\S+)(\s+(\S+)(\s+(\S+))?)?\s*$/);
		if(!m) throw "Cannot parse supplied name";
		if(m[5] && m[3].match(/(ич|на)$/) && !m[5].match(/(ич|на)$/)) {
			// Иван Петрович Сидоров
			lastName = m[5];
			firstName = m[1];
			middleName = m[3];
			this.fullNameSurnameLast = true;
		} else {
			// Сидоров Иван Петрович
			lastName = m[1];
			firstName = m[3];
			middleName = m[5];
		}
	}
	this.ln = lastName;
	this.fn = firstName || '';
	this.mn = middleName || '';
	this.sex = sex || this.getSex();
}
RussianName.prototype = {
	// constants
	sexM: RussianNameProcessor.sexM,
	sexF: RussianNameProcessor.sexF,
	gcaseIm:   RussianNameProcessor.gcaseIm,   gcaseNom: RussianNameProcessor.gcaseNom, // именительный
	gcaseRod:  RussianNameProcessor.gcaseRod,  gcaseGen: RussianNameProcessor.gcaseGen, // родительный
	gcaseDat:  RussianNameProcessor.gcaseDat,                                           // дательный
	gcaseVin:  RussianNameProcessor.gcaseVin,  gcaseAcc: RussianNameProcessor.gcaseAcc, // винительный
	gcaseTvor: RussianNameProcessor.gcaseTvor, gcaseIns: RussianNameProcessor.gcaseIns, // творительный
	gcasePred: RussianNameProcessor.gcasePred, gcasePos: RussianNameProcessor.gcasePos, // предложный
	
	fullNameSurnameLast: false,
	
	ln: '', fn: '', mn: '', sex: '',
	// если пол явно не указан, его можно легко узнать по отчеству
	getSex: function() {
		if(this.mn.length > 2) {
			switch(this.mn.substr(this.mn.length - 2)) {
				case 'ич': return this.sexM;
				case 'на': return this.sexF;
			}
		}
		return '';
	},
	
	fullName: function(gcase) {
		return (
			(this.fullNameSurnameLast ? '' : this.lastName(gcase) + ' ')
			+ this.firstName(gcase) + ' ' + this.middleName(gcase) +
			(this.fullNameSurnameLast ? ' ' + this.lastName(gcase) : '')
		).replace(/^ +| +$/g, '');
	},
	lastName: function(gcase) {
		return RussianNameProcessor.word(this.ln, this.sex, 'lastName', gcase);
	},
	firstName: function(gcase) {
		return RussianNameProcessor.word(this.fn, this.sex, 'firstName', gcase);
	},
	middleName: function(gcase) {
		return RussianNameProcessor.word(this.mn, this.sex, 'middleName', gcase);
	}
}


//икранирования я переноса текста через ajax get методом
function ec(vv)
{
	return encodeURIComponent(vv);
}

//падеж имени и должности для текста устава
function padej_woo()
{
	var name_woo=$('.woo1').val();
	var head_woo=$('.woo2').val();
	if(name_woo=='')
	{
		name_woo='________';
	} else
		{
			var rn = new RussianName(name_woo);
	   name_woo=rn.fullName(rn.gcaseRod);
		}
	if(head_woo=='')
	{
		head_woo='________';
	}	else
		{
			var rn1 = new RussianName(head_woo);
	   head_woo=rn1.fullName(rn1.gcaseRod)
		}
	
	
	$('.js-padej_woo_end').empty().append(head_woo+' '+name_woo+', действующего на основании Свидетельства о государственной регистрации');
	$('.js-padej_woo_end').val(head_woo+' '+name_woo+', действующего на основании Свидетельства о государственной регистрации');
	$('.js-padej_woo_end').trigger('keyup');
	
	
}

//перевод в латиницу
function TextToLat(inp)
{
	var ru2en = {
	ru_str : " АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯIабвгдеёжзийклмнопрстуфхцчшщъыьэюяi",
  	en_str : [' ',
            'A','B','V','G','D','E','E','ZH','Z','I','I','K','L','M','N','O','P','R','S','T',
            'U','F','KH','TS','CH','SH','SHCH','IE','Y','','E','IU','IA','I',
            'A','B','V','G','D','E','E','ZH','Z','I','I','K','L','M','N','O','P','R','S','T',
            'U','F','KH','TS','CH','SH','SHCH','IE','Y','','E','IU','IA','I'
        ]
    }

    ru2en.ru2en = {};
  	for(var i = 0, l = ru2en.ru_str.length; i < l; i++)
    	ru2en.ru2en[ru2en.ru_str.charAt(i)] = ru2en.en_str[i];

	var re = /\S+\s\S+\s/i;
	var temp = inp.match(re);
	var a = inp.split("");

	if(temp!=null)
    	a = String(temp).split("");

    for (var i=0,aL=a.length;i<aL;i++) {a[i] = ru2en.ru2en[a[i]]}
    return a.join("");
}



function toTranslit(text) {
    return text.replace(/([а-яё])|([\s_-])|([^a-z\d])/gi,
    function (all, ch, space, words, i) {
        if (space || words) {
            return space ? ' ' : '';
        }
        var code = ch.charCodeAt(0),
            index = code == 1025 || code == 1105 ? 0 :
                code > 1071 ? code - 1071 : code - 1039,
            t = ['yo', 'a', 'b', 'v', 'g', 'd', 'e', 'zh',
                'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
                'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh',
                'shch', '', 'y', '', 'e', 'yu', 'ya'
            ]; 
        return t[index];
    });
}

function close_close_window()
{
	clearInterval(timerId); 
	$.arcticmodal('close');
}

// Функция удаления пробелов
function ctrim(str)
{
	str = str.replace(/\s/g, '');
	return str;
}

//выбрать из найденного клиента
function string_res1()
{
	var pp=$(this).attr('id');
	
	$('.fox_search_result1').hide();
	$('[name=id_search_client1]').val(pp).trigger('click');
	
	$('.end_search1').find('.end_one1').empty().append($(this).find(".name_search_x").html());
	$('.end_search1').find('.end_two1').empty().append($(this).find(".phone_search_x").html());
	$('.end_search1').show();
	
}


//функция всплывающие комментарии
function ToolTip()
{
	
$("[data-tooltip]").mousemove(function (eventObject) {
		
		if(!$("div").is("#tooltip"))
		{
		  $("body").append('<div id="tooltip"></div>');
		}

        $data_tooltip = $(this).attr("data-tooltip");
     $("#tooltip").text($data_tooltip);     
	var offset = $(this).offset();
	
	    
	//$('.debug').empty().append(offset.left+'-'+$(window).width()+'-'+$('#tooltip').width()+'-'+eventObject.pageX);
	//var razn=offset.left+$('#tooltip').width();

	if(eventObject.pageX>=($(window).width()/2))
		{
        $("#tooltip").css({ 
                         "top" : eventObject.pageY + 5,
                        "left" : eventObject.pageX - $('#tooltip').outerWidth() - 5
		
                     });
                     
			
			setTimeout ( function () { $("#tooltip").fadeIn(500); }, 	400 );
			
			
		}else
	{
        $("#tooltip").css({ 
                         "top" : eventObject.pageY + 5,
                        "left" : eventObject.pageX + 5
                     });
		setTimeout ( function () { $("#tooltip").fadeIn(500); }, 400 );
                     
	}
    }).mouseout(function () { $("#tooltip").remove(); });

}

$(document).ready(function(){	
animation_teps();
animation_graf();
//работа с меню	
$('body').on("click",'.burger_ok',SliceMM);	
$('.menu_x').clone().appendTo(".mobile-nav span");
	

	
//получить информацию по  организации	
$('body').on("click",".js-org",doc_org);		
	
//получить информацию по клиенту и организации с определенной вкладке	
$('body').on("click",".js-client-dop",doc_user1);		
$('body').on("click",".js-org-dop",doc_org1)	

	
//$('body').on("keyup",".js-keyup-search",KeyUpS);

//Задачи работа с фильтрами
$('body').on("change keyup input click",".js-h1-filter",filter_active);
$('body').on("change keyup input click",".fi-a a",filter_active_a);

//туры работа с фильтрами
$('body').on("change keyup input click",".js-h1-filter-turs",filter_active_turs);
	$('body').on("change keyup input click",".fi-at a",filter_active_a_t);
	
$('.index_booking').on("change keyup input click",".save_users", save_users);	
$('.index_booking').on("change keyup input click",".save_reports", save_reports);	
$('.index_booking').on("change keyup input click",".save_booking", save_booking);
$('.index_booking').on("change keyup input click",".yess_booking", yess_booking);

//добавление покупателя тура	
$('.js-form-add-tours').on("change keyup input click",".js-buy-turs-client",js_buy_turs_client);

//добавление туриста в тур	
$('.js-form-add-tours').on("change keyup input click",".js-fly-turs-client",js_fly_turs_client);	
	

$('.dell_stock_searcho').bind('change keyup input click', changesort_stock2__o);
$('.dell_stock_search_tours').bind('change keyup input click', changesort_stock2_tours);



$('.menu-09').on("change keyup input click",".js-add_new_client", clients_adds);	
	
//$('.menu-09').on("change keyup input click",".js-add_new_task", task_adds);
	
$('.js-mobile-bottom-z').on("change keyup input click",".js-add_new_client", clients_adds);	
	
$('.mobile-bottom-z').on("change keyup input click",".js-add_new_client", clients_adds);	
//$('.mobile-bottom-z').on("change keyup input click",".js-add_new_task", task_adds);
$('.form_1_booking').on("change",'[name=client_new1_search]',radio_client_svv);
$('.form_2_booking').on("change",'[name=client_new1_search]',radio_client_svv);
	
$('.index_booking').on("change keyup input click",".win_pribl", win_pribl);	
$('.index_booking').on("change keyup input click",".noo_booking", noo_booking);
$('.index_booking').on("change keyup input click",".think_booking", think_booking);
$('.index_booking').on("change keyup input click",".call_booking", call_booking);
	
$('.index_booking').on("change keyup input click",".dis_bron", dis_bron);

$('.clients_block').on("change keyup input click",".open_operator", copyy_clients);	


$('.booking_sourse').on("change keyup input click",".mi_m", fly_edit);
	

$('.booking_sourse').on("change keyup input click",".js--edit--ccomment", add_edit_comment);
		
	
$('.clients_block').on("change keyup input click",".clients_fly_date", fly_edit1);	
	
$('.clients_block').on("change keyup input click",".add_cff",  add_edit_comment1);
	
$('.booking_sourse').on("change keyup input click",".mi_history", fly_history);

$('.trips_block_global').on("change keyup input click",".mi_history_trips", fly_history_trips);
$('.trips_block_global').on("change keyup input click",".mi_m", fly_edit_trips);


	//удалить объект
	$('body').on("change keyup input click",'.js-users-del',js_users_del);

	$('body').on("change keyup input click",".js_open_block", copyy);
$('.answer_block').on("change keyup input click",".open_operator,.h57", copyy1);	
	
	$('.operator_block').on("change keyup input click",".del_operator_", dell_operator);
	$('.users_block').on("change keyup input click",".del_users_", dell_users);	
	$('.reports_block').on("change keyup input click",".del_reports_", dell_reports);		
	
$('.form_1_booking').on("change keyup input click",".wallet_checkbox,#name_b,#radio_bk,#phone_b,#name_client_b,#date_hidden_table_gr2,[name=client_new1_search],[name=id_search_client1]", next_step_booking);
	
$('.form_20_booking').on("change keyup input click","#name_b,#phone_b,#day_b", next_step_clients);	
	
$('.form_5_booking').on("change keyup input click",".wallet_checkbox,.radio_checkbox,#name_b,#name_b1,#name_b12,#password_b,#login_b", next_step_users);
	
$('.form_30_booking').on("change keyup input click","#name_b,#phone_b", next_step_reports);	
	
$('.form_3_booking').on("change keyup input click","#name_b", next_step_operator);	
	
$('.form_2_booking').on("change keyup input click",".span-44", bron_offers_select);	
	
$('.form_2_booking').on("change keyup input click",".click_history_avans", click_history_avans);	
	
	
$('.form_4_booking').on("change keyup input click",".add_sourse_reports", add_answer);
	
$('.sourse_b').on("change keyup input click",".del_booking_sourse", dell_offers);

$('.form_4_booking').on("change keyup input click",".del_answer_", dell_answer);	
$('.form_4_booking').on("change keyup input click",".edit_answer_", edit_answer);
$('.form_4_booking').on("change keyup input click",".save_anna", save_anna);

$('.sourse_b').on("change keyup input click",".add_sourse_booking", add_offers);
	
$('.phone_us1').mask('+7 (000) 000-00-00');
	

	
$('.form_2_booking').on("change keyup input click",".count_mask", validate11);	
	
/*	
$('.form_1_booking').on("change keyup input click",".wallet_checkbox,#name_b,#phone_b,#name_client_b,#date_hidden_table_gr2,#otziv_area_adaxx,.form_offers_",function(){  $('.button_yes_no').hide(); $('.save_booking').show(); alert("!");   });	
*/
	
$('.form_2_booking').on("change keyup input click",".wallet_checkbox,#name_b,#phone_b,#name_client_b,.form_offers_,#otziv_area_adaxx,.fox_dell1,#radio_bk66",function(){  $('.button_yes_no').hide(); $('.save_booking').show();    });		

$('.form_4_booking').on("change keyup input click","#name_b,#phone_b,.form_offers_,#otziv_area_adaxx",function(){  $('.button_yes_no').hide(); $('.save_reports').show();    });
	
	
$('.form_4_booking').on("change keyup input click",".ann_b",function(){   $(this).parents('.answer_block').find('.save_anna').show();    });	

setTimeout (function(){ $('.save_anna').hide(); }, 500); // 1000 Рј.СЃРµРє
	
	
//$('.time_input').mask('00:00');
	
	
//маска для денежных полей	
$('.money_mask').inputmask("numeric", {
    radixPoint: ".",
    groupSeparator: " ",
    digits: 2,
    autoGroup: true,
    prefix: '', //No Space, this will truncate the first character
    rightAlign: false,
    oncleared: function () { self.Value(''); }
});
	

	$('.date_time_picker').inputmask("datetime",{
    mask: "1.2.y h:s", 
    placeholder: "dd.mm.yyyy hh:mm",  
    separator: ".", 
    alias: "dd.mm.yyyy"
  });	
	
	
	
});

//крестик при поиске в клиентах частные лица
var changesort_stock2_tours= function() {
	var iu=$('.content').attr('iu');
	$(this).prev().val('');
	$.cookie("su_7cu"+iu, null, {path:'/',domain: window.is_session,secure: false});
	$('.js--sort').removeClass('greei_input');
	$('.js--sort').find('input').removeAttr('readonly');

	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');

	$(this).hide();
}


//крестик при поиске в клиентах организации
var changesort_stock2__o= function() {  
	var iu=$('.content').attr('iu');
	$(this).prev().val('');
    $.cookie("su_7co"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
	$('.js--sort').removeClass('greei_input');
	$('.js--sort').find('input').removeAttr('readonly');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');
	
	$(this).hide();	
}








//функция задержки при написании поиска в полях

window.search_min = 1;  //мин количество символов для быстрого поиска
window.search_deley=800;	//задержка между вводами символов - начало поиска
window.search_class='.loll_soply';	//задержка между вводами символов - начало поиска



//падеж 
function NumToIndexPadej(num)
{
 if (num>=5 || num==0) { ind=2 }
 else    //1 2-4
 {
   var octatok=num%10;
   if (octatok>1) { ind=1; } else { ind=0; } 
 }
 return ind;
}
/*
         1    3    10
$skl='акцию,акции,акций';
 PadejNumber($count_otziv,$skl)
*/
//падеж
function PadejNumber(Age,type)
{
  var SKL=type.split(',');
  var ind=NumToIndexPadej(Age);
	

  return SKL[ind];	
}

//открытие мобайл меню	
//  |
// \/	

window.SliceMM = function() { 
	var tr_s=$('.burger_ok');
	var mobile=$('.mobile-nav');
	if(tr_s.is(".active")) 
	  {
		  tr_s.removeClass("active");
		  mobile.removeClass("act");
		  $('body').removeClass("menu-open");
		  
	  } else
	  {
		  tr_s.addClass("active");
		  mobile.addClass("act");
		  $('body').addClass("menu-open");
	  }
	
	
}


function InputFocusNew1()
{
	//alert("!");
	var val_input=$(this).val();
	var label=$(this).parents('.ok-input-title-2019').find('label');
	var input_div=$(this).parents('.ok-input-title-2019');
	
	if(!input_div.is('.active_in_2019'))
	{
		input_div.addClass('active_in_2019');	
	}
	
	if(!input_div.is('.active1_in_2019'))
	{
		input_div.addClass('active1_in_2019');	
	}
	
	//может надо открыть календарь
	var calendar=input_div.find('.cal_2019');
	if(calendar.length!=0)
	{
			$(".date___2019").show();	
	}
	
	 
	
}


/**
 * удалить пользователя
 */
function js_users_del(event)
{
	if (typeof timerId != 'undefined') {

		clearInterval(timerId);
		$.arcticmodal('close');

	}

	if($(this).is('[id_rel]'))
	{
		var id_buy= $(this).attr('id_rel');
	} else {
		var id_buy = $(this).parents('.users_block').attr('op_rel');
	}

	event.stopPropagation();
/*
	$.arcticmodal({
		type: 'ajax',
		url: 'forms/users/form_dell_users.php?id_buy='+id_buy,
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
	$.arcticmodal({
		type: 'ajax',
		url: 'forms/users/form_dell_users.php?id_buy='+id_buy,
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

function InputBlurNew1()
{
	//alert($(this).val());
	var val_input=$(this).val();
	var label=$(this).parents('.ok-input-title-2019').find('label');
	var input_div=$(this).parents('.ok-input-title-2019');
	
	input_div.removeClass('active1_in_2019');
	
	if(val_input=='')
	{
		input_div.removeClass('active_in_2019');	
	} else
	{
		input_div.removeClass('error_formi_2019');		
	}
}

//активация инпутов 2019
function input_2019()
{
	//alert("!");
	//перебрать все новые инпуты и если не пусто активировать
	$(".input_new_2019").each(function (index, value) { 

   var input=$.trim($(this).val());
   if(input!='')
	   {
		   $(this).parents('.ok-input-title-2019').addClass('active_in_2019');
	   }
}); 
	
}
//активация инпутов 2018
function input_2018()
{
	//перебрать все новые инпуты и если не пусто активировать
	$(".input_new_2018").each(function (index, value) { 

   var input=$.trim($(this).val());
   if(input!='')
	   {
		   $(this).parents('.input_2018').addClass('active_in_2018');
	   }
}); 
	
}


function copyy()
{
	var block = $(this);
		if ( block.is(".active_operator_x") )
    {
		
		block.removeClass('active_operator_x');
		
	} else
		{
			block.addClass('active_operator_x');
		}
}

function copyy_clients()
{
	var block=$(this).parents('.clients_block');
		if ( block.is(".active_operator_x") )
    {
		
		block.removeClass('active_operator_x');
		
	} else
		{
			block.addClass('active_operator_x');
		}
}


function copyy1()
{
	var block=$(this).parents('.answer_block');
		if ( block.is(".active_operator_x") )
    {
		
		block.removeClass('active_operator_x');
		
	} else
		{
			block.addClass('active_operator_x');
		}
}

function click_history_avans()
{
	var id= $(this).attr('op_uo');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_history_prepaid.php?id='+id,
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
}


function radio_client_svv()
{
	var val=$(this).val();
	if(val==0)
	{
		$('.two_client_box_add').slideUp("slow", function() {$('.one_client_box_add').slideDown(); });
	} else
		{
		$('.one_client_box_add').slideUp("slow", function() {$('.two_client_box_add').slideDown(); });	
		}
}

//уточнение времени вылетов туриста в клиентском списке
function fly_edit1()
{
		var id= $(this).attr('id_fly');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_fly_edit1.php?id='+id,
   	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}

//история изменения времени и даты вылетов
function fly_history()
{
	var id= $(this).parents('.booking_sourse').attr('id_offers');
	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_fly_history.php?id='+id,
		beforeOpen: function(data, el) {
			$('.loader_ada_forms').show();
			$('.loader_ada1_forms').addClass('select_ada');

		},
		afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		},
		afterClose: function(data, el) { // после закрытия окна ArcticModal
			clearInterval(timerId);
		}

	});
}


//история изменения времени и даты вылетов для туров
function fly_history_trips()
{
		var id= $(this).parents('.trips_block_global').attr('id_trips');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_fly_history_trips.php?id='+id,
   	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}

//изменить добавить комментарий к отдыху
function add_edit_comment()
{
		var id= $(this).parents('.booking_sourse').attr('id_offers');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_add_edit_comment.php?id='+id,
   	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}

//изменить добавить комментарий к отдыху
function add_edit_comment1()
{
		var id= $(this).parents('.clients_comment').attr('id_offers');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_add_edit_comment.php?id='+id,
   	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}

//уточнение времени вылетов туриста в заявке
function fly_edit()
{
		var id= $(this).parents('.booking_sourse').attr('id_offers');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_fly_edit.php?id='+id,
   	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}


//уточнение времени вылетов туриста в туре
function fly_edit_trips()
{
	var id= $(this).parents('.trips_block_global').attr('id_trips');
	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_fly_edit_trips.php?id='+id,
		beforeOpen: function(data, el) {
			$('.loader_ada_forms').show();
			$('.loader_ada1_forms').addClass('select_ada');

		},
		afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		},
		afterClose: function(data, el) { // после закрытия окна ArcticModal
			clearInterval(timerId);
		}

	});
}

//посмотреть историю платежей
function win_pribl()
{
	var id= $(this).attr('for');
	    $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_history_payment.php?id='+id,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
}


//забронировать заявку
function yess_booking()
{
	var id= $(this).parents('.button_yes_no').attr('for');


    var data ='url='+window.location.href+'&id='+id;
    AjaxClient('booking','bron_booking','GET',data,'Afterbron_booking',id,0);
}

//сохранить заявку
function save_booking()
{
	 var err = 0;		
	 $(".sourse_error,.sourse_error1,#name_b,#phone_b,#otziv_area_adaxx,#name_client_b,#date_hidden_table_gr2").removeClass('error_formi');
	
	 $('.new_search_add_book').removeClass('error_2019_in');
	
     if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	 if($("#radio_bk").val() == '') { $(".sourse_error1").addClass('error_formi'); err++;	}
	
	
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	//if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}	
	
	//if($("#name_client_b").val() == '')  { $("#name_client_b").addClass('error_formi'); err++;	}	
	
	
	if($('[name=client_new1_search]').val()==0)
	{
	       if($("#name_client_b").val() == '')  { $("#name_client_b").addClass('error_formi'); err++;	}	
		
			      // if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
		
	} else
	{
			if(($("[name=id_search_client1]").val() == '0')||($("[name=id_search_client1]").val() == ''))  { $(".new_search_add_book").addClass('error_2019_in'); err++;	}	
	}
	
	
	if($("#date_hidden_table_gr2").val() == '')  { $("#date_hidden_table_gr1").addClass('error_formi'); err++;	}
	if(err!=0)
	{
	$('.error_text_add').empty().append('Не все поля заполнены для сохранения').show();
	setTimeout ( function () { $('.error_text_add').hide(); }, 7000 );
	} else
	{
		$('#lalala_add_form').submit();	
	}
}

function save_reports()
{
	//alert("!");
		 var err = 0;		
	 $("#name_b,#phone_b").removeClass('error_formi');
     
	
	
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
	if(err!=0)
	{
	$('.error_text_add').empty().append('Не все поля заполнены для сохранения').show();
	setTimeout ( function () { $('.error_text_add').hide(); }, 7000 );
	} else
	{
		$('#lalala_add_form').submit();	
	}
}

function save_users()
{
	//alert("!");
		 var err = 0;		
	 $(".sourse_error,.sourse_error1,#name_b,#name_b1,#login_b,#password_b").removeClass('error_formi');
     if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	 if($("#radio_bk").val() == '') { $(".sourse_error1").addClass('error_formi'); err++;	}
	
	
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#name_b1").val() == '')  { $("#name_b1").addClass('error_formi'); err++;	}
	
	if($("#login_b").val() == '')  { $("#login_b").addClass('error_formi'); err++;	}
	if(err!=0)
	{
	$('.error_text_add').empty().append('Не все поля заполнены для сохранения').show();
	setTimeout ( function () { $('.error_text_add').hide(); }, 7000 );
	} else
	{
		$('#lalala_add_form').submit();	
	}
}

function next_step_reports()
{
   var err = 0;		
	$("#name_b,#phone_b").removeClass('error_formi');
 

	if($("#name_b").val() == '')  {  err++;	}
	if($("#phone_b").val() == '')  {  err++;	}
	

	//alert("!");
	var step=$('.send_form_reports');
	if(err!=0)
	{
		step.removeClass("greeen");
	} else
	{
		var step=$('.send_form_reports');
if(!step.is('.greeen'))
	{
		step.addClass("greeen");
	}
		//даем возможность отправить форму
		
	}	
}

function next_step_users()
{
    var err = 0;		
	$(".sourse_error,.sourse_error1,#name_b,#name_b1,#login_b,#password_b").removeClass('error_formi');
 
     if($("#sourse_b").val() == '') {  err++;	}
	 if($("#radio_bk").val() == '') {  err++;	}
	
	
	if($("#name_b").val() == '')  {  err++;	}
	if($("#name_b1").val() == '')  {  err++;	}
	
	if($("#login_b").val() == '')  {  err++;	}
	if($("#password_b").val() == '')  {  err++;	}
	
	var step=$('.send_form_users');
	if(err!=0)
	{
		step.removeClass("greeen");
	} else
	{
		var step=$('.send_form_users');
if(!step.is('.greeen'))
	{
		step.addClass("greeen");
	}
		//даем возможность отправить форму
		
	}	
}

function next_step_operator()
{
    var err = 0;		
	$("#name_b").removeClass('error_formi');
 
  /*
    if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}	
	if($("#name_client_b").val() == '')  { $("#name_client_b").addClass('error_formi'); err++;	}	
	if($("#date_hidden_table_gr2").val() == '')  { $("#date_hidden_table_gr1").addClass('error_formi'); err++;	}	
*/
   
	if($("#name_b").val() == '')  {  err++;	}
	//if($("#phone_b").val() == '')  {  err++;	}	
	
	var step=$('.add_invoice_booking');
	if(err!=0)
	{
		step.removeClass("greeen");
	} else
	{
		var step=$('.add_invoice_booking');
if(!step.is('.greeen'))
	{
		step.addClass("greeen");
	}
		//даем возможность отправить форму
		
	}

}

function next_step_booking()
{
	//alert("!");
    var err = 0;		
	$(".sourse_error,.sourse_error1,#name_b,#otziv_area_adaxx,#phone_b,#name_client_b,#date_hidden_table_gr2").removeClass('error_formi');
 
	$('.new_search_add_book').removeClass('error_2019_in');
	
	
  /*
    if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}	
	if($("#name_client_b").val() == '')  { $("#name_client_b").addClass('error_formi'); err++;	}	
	if($("#date_hidden_table_gr2").val() == '')  { $("#date_hidden_table_gr1").addClass('error_formi'); err++;	}	
*/
    if($("#sourse_b").val() == '') {  err++;	}
	
	if($("#radio_bk").length!=0)
	{
		if($("#radio_bk").val() == '') {  err++;	}	
	}
	if($("#name_b").val() == '')  {  err++;	}
	
	if($('[name=client_new1_search]').val()==0)
	{
	  	if($("#name_client_b").val() == '')  {  err++;	}
	} else
	{
	if($('[name=id_search_client1]').val()==0)
	        {  err++;	}
	}
	//if($("#phone_b").val() == '')  {  err++;	}
	
	
	
	
	
	
	
	
	
	if($("#date_hidden_table_gr2").val() == '')  { err++; }		
	
	var step=$('.add_invoice_booking');
	if(err!=0)
	{
		step.removeClass("greeen");
	} else
	{
		var step=$('.add_invoice_booking');
if(!step.is('.greeen'))
	{
		step.addClass("greeen");
	}
		//даем возможность отправить форму
		
	}

}

function next_step_clients()
{
	//alert("!");
    var err = 0;		
	$("#name_b,#phone_b,#day_b").removeClass('error_formi');
 
	$('.new_search_add_book').removeClass('error_2019_in');
	
	
  /*
    if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}	
	if($("#name_client_b").val() == '')  { $("#name_client_b").addClass('error_formi'); err++;	}	
	if($("#date_hidden_table_gr2").val() == '')  { $("#date_hidden_table_gr1").addClass('error_formi'); err++;	}	
*/
    
	if($("#name_b").val() == '')  {  err++;	}
	if($("#day_b").val() == '')  {  err++;	}
		if($("#phone_b").val() == '')  {  err++;	}
	

	//if($("#phone_b").val() == '')  {  err++;	}
	
	
	
	
	
	
		
	
	var step=$('.add_invoice_booking');
	if(err!=0)
	{
		step.removeClass("greeen");
	} else
	{
		var step=$('.add_invoice_booking');
if(!step.is('.greeen'))
	{
		step.addClass("greeen");
	}
		//даем возможность отправить форму
		
	}

}


var delay1 = (function(th){ 
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

var delays = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

//функция проверки ввода только чисел и с запятой
var validate11 = function() {
  $(this).val($(this).val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
}
//функция проверки ввода только целых чисел
var validate12 = function() {
  	$(this).val($(this).val().replace(/[^\d]*/g, '').replace(/([])[]+/g, '$1').replace(/^[^\d]*(\d+([]\d{0,5})?).*$/g, '$1'));
}

function animation_teps_supply()
{
	$('.teps_supply').each(function(i,elem) {
	$(this).animate({width: $(this).attr('rel_w')+"%"}, 2000, function() {  });
});
}


//думают над предложениями
function think_booking()
{
	 var id= $(this).parents('.button_yes_no').attr('for');	
	 var data ='url='+window.location.href+'&id='+id;
    AjaxClient('booking','think_booking','GET',data,'After_think_booking',id,0);
	
}

//отменить покупку
function dis_bron()
{
	var id= $(this).attr('dis');
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_disable_booking.php?id='+id,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
}


//позвонить по заявке
function call_booking()
{
var id= $(this).parents('.button_yes_no').attr('for');																

					
				   			$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_call_booking.php?id='+id,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });		
}


//отказались от путевки
function noo_booking()
{
	var id= $(this).parents('.button_yes_no').attr('for');				
					
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_no_booking.php?id='+id,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
						$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
}




//добавление нового пользователя
function clients_adds()
{
	if(typeof timerId !== "undefined")
		{
	clearInterval(timerId); 
	$.arcticmodal('close');
		}
	var at= $(this).attr('tabs_g');
	
	var ppor='?tabs='+at;
	if ($('.box-modal [name=posta]').length > 0) { 
		ppor=ppor+'&posta='+$('.box-modal [name=posta]').val();
	}
	
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_add_user.php'+ppor,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	
}


//вывод информации по организации
function doc_org()
{
	var for_id=$(this).attr('iod');
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_org.php?id='+for_id+'&tabs=0',
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
		ToolTip();
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	
}

//вывод информации по организации на определенной вкладке
function doc_org1()
{
	var for_id=$(this).attr('iod');
	var tabs=$(this).attr('tabs');
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_org.php?id='+for_id+'&tabs='+tabs,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	
}



//вывод информации по клиенту на определенной вкладке
function doc_user1()
{
	var for_id=$(this).attr('iod');
	var tabs=$(this).attr('tabs');
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_doc_user.php?id='+for_id+'&tabs='+tabs,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });
	
}

//Добавление вопроса к отчету
function add_answer()
{
	var for_id=$(this).attr('for');

				   			$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_add_answer.php?id='+for_id,
	beforeOpen: function(data, el) {
        $('.loader_ada_forms').show();
		$('.loader_ada1_forms').addClass('select_ada');
						
    },
    afterOpen: function(data, el) {
			$('.loader_ada_forms').hide();
			$('.loader_ada1_forms').removeClass('select_ada');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });	
}


//добавление предложения в заявке
function add_offers()
{

	var for_id=$('.add_sourse_booking').attr('for');


    var data ='url='+window.location.href+'&id='+for_id;
    AjaxClient('booking','add_offers','GET',data,'AfterAdd_offers',for_id,0);
	
	
	$('.button_yes_no').hide(); $('.save_booking').show();
	
}


//постфункция поиска клиента
function AfterSearchClient1(d,c){
	
$('.b_loading_small').remove();
$('.fox_dell1').show();	
	
	if(d.status=="ok"){
	

	
if($(".fox_search_result1").css("display")!="block"){$(".fox_search_result1").show();var a=false;
																								 
$(document).bind("click.myEvent",function(f){if(!a&&$(f.target).closest(".fox_search_result1").length==0){$(".fox_search_result1").hide();

$(document).unbind("click.myEvent")}a=false})}
												   
$(".fox_search_result1").empty().append(d.query);$(".fox_search_result1").show()}else{$(".fox_search_result1").hide()}}

//постфункция проверка телефона в базе данных клиентов
function AfterTruePhone(d,c){
	
//$('.b_loading_small').remove();
//$('.fox_dell1').show();	
	
	if(d.status=="ok")
	{
	  if(d.echo=="1")
		 
	  {
		  if($('.js-true-phone').is('[old_value]'))
		  {
			
			  if($('.js-true-phone').val()!=$('.js-true-phone').attr('old_value'))
				  {
					  $(".js-open-phone").show(); $('.js-true-phone').parents('.input_2018').addClass('error_2018');
		  $('.js-true-search-phone').val(1);
				  } else
					  {
						   $(".js-open-phone").hide(); $('.js-true-phone').parents('.input_2018').removeClass('error_2018');
			   $('.js-true-search-phone').val(0);
					  }
		  } else
			  {
		  
		  
		  $(".js-open-phone").show(); $('.js-true-phone').parents('.input_2018').addClass('error_2018');
		  $('.js-true-search-phone').val(1);
			  }
		  
	  } else
		  {
			  $(".js-open-phone").hide(); $('.js-true-phone').parents('.input_2018').removeClass('error_2018');
			   $('.js-true-search-phone').val(0);
			  
		  }
		
	
	}else{   $(".js-open-phone").hide(); $('.js-true-phone').parents('.input_2018').removeClass('error_2018'); $('.js-true-search-phone').val(0);  }

}




//постфункция проверки отправки на бронирование заявки
function Afterbron_booking(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
			if ( data.count==1 )
				{
					//отправляем на бронирование
				   			$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_bron_booking_end.php?id='+update,
    afterLoading: function(data, el) {
        //alert('afterLoading');

    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
					$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
				ToolTip();	
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });						
					
				} else
				{
					      var count_offers= $("[id_offers]").length;																

					
				   			$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_bron_booking.php?id='+update+'&number='+(count_offers-1),
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
				}
    
}
}

//постфункция думают над предложениями
function After_think_booking(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
	    autoReloadHak();	
	}
}

//постфункция при добавление вопроса к отчету
function AfterAdd_answer(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
			
	var count_offers= $("[op_rel]").length;																
	  $('.count_offers_ajax').empty().append(count_offers-1);
	  
      var tytt=PadejNumber((count_offers-1),'вопрос к отчету,вопроса к отчету,вопросов к отчету');													
	  $('.padej_offers').empty().append(tytt);			
		
		
	  $('.add_sourse_reports').before(data.echo);		
	
		

		
		
	}
}

//постфункция добавление нового предложения
function AfterAdd_offers(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {		
		//
var count__=$('#count_sourse').val();	
	var dee=parseInt(count__)+1;	
	
		
	var count_offers= $("[id_offers]").length;																
	  $('.count_offers_ajax').empty().append(count_offers-1);
	  
      var tytt=PadejNumber((count_offers-1),'предложение,предложения,предложений');													
	  $('.padej_offers').empty().append(tytt);			
		
		
	$('#count_sourse').val(dee);
	$('#count_sourse1').val(count__);	
		
		
		
		

    var html = $( '.replace_mm' ).html ();     
    html = html.replace ( /IDMIDD/g, dee); 
	html = html.replace ( /SIDMIDS/g, count__);		
	html = html.replace ( /IDMID/g, data.id);
	
    $('.replace_mm').before(html);	
	
	$(".slct").unbind('click.sys');
    $(".slct").bind('click.sys', slctclick);
	$(".drop").find("li").unbind('click');
	$(".drop").find("li").bind('click', dropli);
	
	$('.money_mask').inputmask('remove');
	$('.money_mask').inputmask("numeric", {
    radixPoint: ".",
    groupSeparator: " ",
    digits: 2,
    autoGroup: true,
    prefix: '', //No Space, this will truncate the first character
    rightAlign: false,
    oncleared: function () { self.Value(''); }
    });
	$('.date_time_picker').inputmask('remove');	
	$('.date_time_picker').inputmask("datetime",{
    mask: "1.2.y h:s", 
    placeholder: "dd.mm.yyyy hh:mm",  
    separator: ".", 
    alias: "dd.mm.yyyy"
  });	
		
	}
}

//выбор предложения как выбранного клиентом
function bron_offers_select()
{
	var for_id1=$(this).parents('.booking_sourse').attr('number_sourse');
	var attr=$(this).parents('.booking_sourse').attr('id_offers');
		$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_select_offers.php?id='+attr+'&number='+for_id1,
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
}

function js_dell_form_no(event)
{
	var form_move=$('.form'+event.data.key);

	
	clearInterval(timerId); // îñòàíàâëèâàåì âûçîâ ôóíêöèè ÷åðåç êàæäóþ ñåêóíä
	$.arcticmodal('close');
	
	var data ='url='+window.location.href+'&tk='+form_move.find('.h111').attr('mor')+
					'&id='+form_move.find('.h111').attr('for');


		
AjaxClient('task','dell_task','GET',data,'AfterDellTask',form_move.find('.h111').attr('for')+','+event.data.key,0);		
	
	
}

function exit_form_active(event)
{
	$('.arcticmodal-close','.form'+event.data.key).click();	
}


//удалить отчет
function dell_reports()
{
	var attr=$(this).attr('id_rel');
		$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_reports.php?id='+attr,
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
}

//удалить пользователя системы
function dell_users()
{
	var attr=$(this).attr('id_rel');
		$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_users.php?id='+attr,
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
}

//удалить туроператора
function dell_operator()
{
	var attr=$(this).attr('id_rel');
		$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_operator.php?id='+attr,
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
}


//редактировать вопрос к отчету
function edit_answer()
{
	var attr=$(this).attr('id_rel');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_answer.php?id='+attr,
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
	
}

//удалить вопрос к отчету
function dell_answer()
{
	var attr=$(this).attr('id_rel');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_answer.php?id='+attr,
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
	
}

//удалить предложение
function dell_offers()
{
	var attr=$(this).attr('id_rel');
	//$('[id_offers='+attr+']').slideUp("slow");
	var for_id1=$(this).parents('.booking_sourse').attr('number_sourse');
	
	
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_offers.php?id='+attr+'&number='+for_id1,
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
	
}



//сохранение вопроса к отчету
function save_anna()
{
	var attr=$(this).parents('.answer_block').attr('op_rel');
	var anna=$(this).parents('.answer_block').find('#otziv_area_adaxx_'+attr).val();
	$(this).hide();
	
	var data ='url='+window.location.href+'&id='+attr+'&text='+encodeURIComponent(anna);
    AjaxClient('reports','save_answer','GET',data,'AfterSaveAnswer',attr,0);	
}




//получение фокуса для инпута в поиске при добавление покупателя тура
function InputFocusNewTours()
{
	var input_div=$(this).parents('.choice-client-2019');
	
	if(!input_div.is('.active_tours_focus'))
	{
		input_div.addClass('active_tours_focus');	
	}
}
//потеря фокуса для инпута в поиске при добавление покупателя тура
function InputBlurNewTours()
{
	var input_div=$(this).parents('.choice-client-2019');
    input_div.removeClass('active_tours_focus');	
}


//получение фокуса для новых инпутов
function InputFocusNew()
{
	var val_input=$(this).val();
	var label=$(this).prev('label');
	var input_div=$(this).parents('.input_2018');
	
	if(!input_div.is('.active_in_2018'))
	{
		input_div.addClass('active_in_2018');	
	}
	
	if(!input_div.is('.active1_in_2018'))
	{
		input_div.addClass('active1_in_2018');	
	}
	
	//может надо открыть календарь
	var calendar=input_div.find('.cal_2018');
	if(calendar.length!=0)
	{
			$(".date___2019").show();	
	}
	
	 
	
}



//ввод текста в новые инпуты скрытие ошибки если она была
//  |
// \/
function KeyUpInput()
{
	if($(this).is('.gloab'))
		{
			if(($(this).val()!='')&&($(this).val()!=0))
			$(this).parents('.input_2018').removeClass('required_in_2018');
			$(this).parents('.input_2018').removeClass('error_2018');
		}
}
//потеря фокуса для новых инпутов
function InputBlurNew()
{
	//alert($(this).val());
	var val_input=$(this).val();
	var label=$(this).prev('label');
	var input_div=$(this).parents('.input_2018');
	
	input_div.removeClass('active1_in_2018');
	
	if(val_input=='')
	{
		input_div.removeClass('active_in_2018');	
				if($(this).is('.gloab'))
		{
			input_div.addClass('required_in_2018');	
		}else
			{
				input_div.removeClass('required_in_2018');
			}
	}
	
	
	
	/*
	if(!$(this).is('.date2018_mask'))
	{
	  //для всего остального кроме дат с маской
	  if(($(this).is('.required'))&&(val_input=='')&&(!input_div.is('.required_in_2018')))
	  {
		input_div.addClass('required_in_2018');	
	  } else
	  {
		if(($(this).is('.required'))&&(val_input!=''))
		{
		  input_div.removeClass('required_in_2018');
		}
	  }
	} else
	{
	  if(($(this).is('.required'))&&((val_input=='')||(val_input=='дд.мм.гггг'))&&(!input_div.is('.required_in_2018')))
	  {
		input_div.addClass('required_in_2018');	
	  } else
	  {
		if(($(this).is('.required'))&&(val_input!='')&&(val_input!='дд.мм.гггг'))
		{
		  input_div.removeClass('required_in_2018');
		}
	  }
		
		
	}
	*/
		
	
}


//кнопки еще задачи на главной
function js_eshe_ring()
{
	var block_gg=$(this);
		if(block_gg.is('.active-ring'))
	{
		 block_gg.removeClass('active-ring');
		block_gg.parents('.ring_block').find('.max-day-ring').slideUp("slow");
		
	} else
		{
		 block_gg.addClass('active-ring');
			block_gg.parents('.ring_block').find('.max-day-ring').slideDown("slow");
		}
}


//удаление покупателя из тура
function js_dell_buy_tours()
{
	var for_id=$(this).attr('id_rel');
	var block_gg=$(this).parents('.info-client-ruler');
	
	$('.tot_buy_id').val('');
	$('.tot_buy_type').val('');
	
	//если он был и туристом то удаляем из переменных и пересчитываем
	if(block_gg.is('.active-turist-turs'))
	{
	   //удалить из туристов
			$('.tot_fly_id').val(AddDellList($('.tot_fly_id').val(),for_id,'dell'));
			//уменьшить количество туристов
			var count_turi=parseFloat($('.tot_fly_count').val());
			if(count_turi!=0)
				{
			$('.tot_fly_count').val(count_turi-1);
				}
		block_gg.remove();
		UpdateNumberTuris();
	
	} else
		{
			block_gg.remove();
		}
	
	$('.js-buy-my-tours').find('.buy_turs').show();
	
	
}
//удаление туриста из тура
function js_dell_fly_tours()
{
		var for_id=$(this).attr('id_rel');
	    var block_gg=$(this).parents('.info-client-ruler');
	    
	$('.tot_fly_id').val(AddDellList($('.tot_fly_id').val(),for_id,'dell'));
			//уменьшить количество туристов
			var count_turi=parseFloat($('.tot_fly_count').val());
			if(count_turi!=0)
				{
			$('.tot_fly_count').val(count_turi-1);
				}
	
	    block_gg.remove();
	    UpdateNumberTuris();
}


//удалить фото товарный чек из заявки
function DellImageInvoice()
{
	var for_id=$(this).attr('for');
	var data ='url='+window.location.href+'&id='+for_id;
    AjaxClient('booking','del_img','GET',data,'AfterDellImageInvoice',for_id,0);	
}

//удалить фото из отчета
function DellImageReports()
{
	var for_id=$(this).attr('for');
	var data ='url='+window.location.href+'&id='+for_id;
    AjaxClient('reports','del_img','GET',data,'AfterDellImageReports',for_id,0);	
}



//обновление фото в заявке
function UpdateImageInvoice(id)
{
	var data ='url='+window.location.href+'&id='+id;
    AjaxClient('booking','update_img','GET',data,'AfterUpdateImageInvoice',id,0);	
}

//обновление фото в отчете
function UpdateImageReports(id)
{
	var data ='url='+window.location.href+'&id='+id;
    AjaxClient('reports','update_img','GET',data,'AfterUpdateImageReports',id,0);	
}


function message_load()
{
	if( $('.history_message').is(':visible') ) { 
	$('.history_message').hide();
	
	var for_id=$('.content_block').attr('id_content');	
    var data ='url='+window.location.href+'&id='+for_id+'&n_st='+$('.content_block').attr('n')+'&s='+$('.history_message').attr('s_m');
    AjaxClient('message','load_message','GET',data,'AfterMESS',for_id,0);	
	}
}



//прокрутка до низа
function scroll_to_bottom(speed) {
	var height= $("body").height(); 
	$("html,body").animate({"scrollTop":height},speed); 
}

 function inWindow(s){
  var scrollTop = $(window).scrollTop();
  var windowHeight = $(window).height();
  var currentEls = $(s);
  var result = [];
  currentEls.each(function(){
    var el = $(this);
    var offset = el.offset();
    if(scrollTop <= offset.top && (el.height() + offset.top) < (scrollTop + windowHeight))
      result.push(this);
  });
  return $(result);
  

}
//изменение размеров браузера
function windowSize()
{
 // sl_message_width();	
}

function trim_number($number)
{
	$number=$number.replace(/\s+/g,'');
	return $number;
}

//переход по диалогу в сообщениях
function Dialog(e)
{
  if($(e.target).closest(".del_dialog").length==0)
  {
	var dialog_id=$(this).attr('rel_diagol');
	$(this).attr('href','/message/dialog/'+dialog_id+'/');
	$(this).trigger('Click');

  }
}
//анимация загрузчика количесвта выполненных работы
function animation_teps()
{
	$('.teps').each(function(i,elem) {
	$(this).animate({width: $(this).attr('rel_w')+"%"}, 2000, function() {  });
});

	
}


//маска вводить только целые и float
function maskk(thiss)
{
	thiss.val(thiss.val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
	//alert("!!");
	if($('[name=save_zayy]').length > 0)
		{
	savedefault_zay(thiss);
		} else
			{
    savedefault(thiss);
			}
	
}




//маска вводить только целые
function maskk1(thiss)
{
	thiss.val(thiss.val().replace(/[^\d]*/g, '').replace(/([])[]+/g, '$1').replace(/^[^\d]*(\d+([]\d{0,5})?).*$/g, '$1'));
		if($('[name=save_zayy]').length > 0)
		{
	savedefault_zay(thiss);
		} else
			{
	savedefault(thiss);				
			}
}





//показать подсказки к полям после загрузки страницы где заполнено
var label_show_load = function() {
	
	$('.label_s').each(function(i,elem) {
	if($(this).prev('label').length)
	{
	   if($(this).val()=='')
		   {
			   $(this).prev('label').hide();
			   
		   } else
			   {
				   
				   $(this).prev('label').show();
			   }
	
	}
	
	});
	
}


//подсказки под инпут поля
var label_show = function() {
	
	
	if($(this).prev('label').length)
	{
	   if($(this).val()=='')
		   {
			   $(this).prev('label').hide();
			   
		   } else
			   {
				   
				   $(this).prev('label').show();
			   }
	
	}
	
	
	
}


//удалить диалог
function del_dialog()
{
	if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_dialog.php?id='+$(this).attr("for"),
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
}
}
  
return false;
}


// таймер времени для форм ajax
function initializeTimer() {
	
	var endDate = new Date(); // получаем дату истечения таймера
	var endDate =((endDate/1000)+1800)*1000; //30 минут
	var currentDate = new Date(); // получаем текущую дату
	var seconds = (endDate-currentDate) / 1000; // определяем количество секунд до истечения таймера
	if (seconds > 0) { // проверка - истекла ли дата обратного отсчета
		var minutes = seconds/60; // определяем количество минут до истечения таймера
		var hours = minutes/60; // определяем количество часов до истечения таймера
		minutes = (hours - Math.floor(hours)) * 60; // подсчитываем кол-во оставшихся минут в текущем часе
		hours = Math.floor(hours); // целое количество часов до истечения таймера
		seconds = Math.floor((minutes - Math.floor(minutes)) * 60); // подсчитываем кол-во оставшихся секунд в текущей минуте
		minutes = Math.floor(minutes); // округляем до целого кол-во оставшихся минут в текущем часе
		
		setTimePage(hours,minutes,seconds); // выставляем начальные значения таймера
		
		function secOut() {
		  if (seconds == 0) { // если секунду закончились то
			  if (minutes == 0) { // если минуты закончились то
				  if (hours == 0) { // если часы закончились то
					  showMessage(timerId); // выводим сообщение об окончании отсчета
				  }
				  else {
					  hours--; // уменьшаем кол-во часов
					  minutes = 59; // обновляем минуты 
					  seconds = 59; // обновляем секунды
				  }
			  }
			  else {
				  minutes--; // уменьшаем кол-во минут
				  seconds = 59; // обновляем секунды
			  }
		  }
		  else {
			  seconds--; // уменьшаем кол-во секунд
		  }
		  setTimePage(hours,minutes,seconds); // обновляем значения таймера на странице
		}
		timerId = setInterval(secOut, 1000) // устанавливаем вызов функции через каждую секунду
	}
	else {
		//alert("Установленная дата уже прошла");
	}
}

//функция изменения времени в окне
function setTimePage(h,m,s) { // функция выставления таймера на странице

    if(m<10){ m='0'+m;}
	if(s<10){ s='0'+s;}
	
    $('.clock_table').empty().append(m+':'+s);
	
	if(m<5)
	{
		$('.clock_table').show();
	}
}

// функция, вызываемая по истечению времени
function showMessage(timerId) { 
	clearInterval(timerId); 
	$.arcticmodal('close');	
}

//вывод окна входа в систему
function WindowLogin()
{
	  $(document).unbind('mousemove.time keydown.time scroll.time');
	  //завершение сессии пользователя
	  //$.cookie('user_id', null, {path:'/'});  
	  //$.cookie('da', null, {path:'/'}); 
	  
	  //открытие формы для входа
	  $.arcticmodal({
    type: 'ajax',
    url: 'forms/login.php?url='+window.location.href,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	 
    }

  });
	  
	  
	  
      idleState = true; 	
}

//перезагрузка страницы
function autoReloadHak(){
  var goal = self.location;
  location.href = goal;
}

function TimeHak()
{

	var tsl = $.cookie('tsl');
	//alert(tsl);
	//alert(cookie_new);
	if((tsl!=null)&&(tsl==1) )
	{
	  autoReloadHak();
	}
}


//следит за изменением и работой в системе в других окнах
function TimeSystem()
{ 
  //$('.debug').empty().append($.cookie("tss"));	
	
  if((!isNaN(localStorage.getItem('tss')))) 
  { 
	//$('.debug').empty().append('!1');
	if(idTimeStampe!=localStorage.getItem('tss'))
   {
	   // $('.debug').empty().append(localStorage.getItem('tss'));
		idTimeStampe=localStorage.getItem('tss');   
	    clearTimeout(idleTimer); // отменяем прежний временной отрезок
	    idleState = false;
        idleTimer = setTimeout(timesss, idleWait);	   
	   }
   }
}
function js_touroper_eye()
{
	var iu=$('.content').attr('iu');
	var spp=$(this).attr('spp');

	if(!$(this).is('.tours-eas-open') )
	{
		$(this).addClass('tours-eas-open');

		$.cookie("eye_t_"+iu+'_'+spp, null, {path:'/',domain: window.is_session,secure: false});
		if(spp==1)
		{
			$('.trips-b-operator').show();
		} else
		{
			$('.trips-b-comission').show();
		}
	} else
	{
		$(this).removeClass('tours-eas-open');
		$.cookie("eye_t_"+iu+'_'+spp, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("eye_t_"+iu+'_'+spp,"1",'add');

		if(spp==1)
		{
			$('.trips-b-operator').hide();
		} else
		{
			$('.trips-b-comission').hide();
		}
	}

	classblockTrips();
}
//смотрим какие поля в блоке туров скрыты и даем правильный стиль для блока
function classblockTrips()
{
	var tor=1;
	var coms=1;
	//по умолчанию блоки видны и никакой стиль не нужен

	if($('.trips_block_global:first .trips-b-operator').is(':visible') ) { } else {  tor=0; }
	if($('.trips_block_global:first .trips-b-comission').is(':visible') ) { } else {  coms=0; }

	$('.trips_block_global').removeClass('block_t00');
	$('.trips_block_global').removeClass('block_t10');
	$('.trips_block_global').removeClass('block_t01');

	if((tor==0)&&(coms==0))
{
	$('.trips_block_global').addClass('block_t00');
}
if((tor==1)&&(coms==0))
{
	$('.trips_block_global').addClass('block_t10');
}
if((tor==0)&&(coms==1))
{
	$('.trips_block_global').addClass('block_t01');
}

}

//обращение за уведомлением
function NotificationSystem()
{ 
  //
  if($('.users_rule').is('[not]')) 
  {  	
	
	  //если есть вывод куда выводить задачу тогда проверяем не обновились ли они
	  var task_cloud=0;
	  if ($('.js-task-cloud').length > 0) { task_cloud=1; }
	  
    var data='tk='+$('.users_rule').attr('not');

    nprogress=1;	  
    AjaxClient('notification','even','GET',data,'AfterNofi',1,0,1);
  }
}


//уведомления запуск
function NotifSystem()
{
//на каких то страницах можно не включать обновление уведомлений	
 if(typeof NotifVar == "undefined")	
 { 
  //timerS = setInterval(TimeSystem, 1000);	 
  $(document).bind('mousemove.notif keydown.notif scroll.notif', function(){
    clearTimeout(idleTimerx); // отменяем прежний временной отрезок
	 
     // $.cookie('tss', $.now(), {expires: 1,path: '/'});
	  
	  //$('.debug').empty().append($.cookie('tss'));	  
	  
    if(idleStatex == true){ 
      // Действия на возвращение пользователя
      idleWait_yes=idleWait_start;
	  clearInterval(timerSx);
	  timerSx = setInterval(NotificationSystem, idleWait_yes); 
	  NotificationSystem();	
    }
 
    idleStatex = false;
	idleWait_yes=idleWait_start; 
	//clearInterval(timerSx);
	//timerSx = setInterval(NotificationSystem, idleWait_yes);   
	  
    idleTimerx = setTimeout(timesssx, idleWait_stop);
	 
  });
  timerSx = setInterval(NotificationSystem, idleWait_yes); 
  $("body").trigger("mousemove"); // сгенерируем ложное событие, для запуска скрипта	
 }
}

//если произошло бездействие в течении 10 минут
function timesssx() { 
	  
	  //если пароль не ввели через минут перезагрузить страницу
      // Действия на отсутствие пользователя
	  //alert('выход из системы');
	  //$(document).unbind('mousemove.time keydown.time scroll.time');
	  //завершение сессии пользователя
	  //$.cookie('user_id', null, {path:'/'});  
	  //$.cookie('da', null, {path:'/'}); 
	  
	  //открытие формы для входа
	  idleWait_yes=idleWait_end;
      idleStatex = true; 
	  clearInterval(timerSx);
	  timerSx = setInterval(NotificationSystem, idleWait_yes); 
    }


//функция проверки вдруг в каком то окне зашли под логином тогда и в другом окне перезагрузить страницу
function updateloginhak()
{
	timerH = setInterval(TimeHak, 15000);	
}

//выход из системы при бездействии во всех окнах этой системы
function ExitSystem()
{
 if(typeof LoginVar == "undefined")	
 { 
  timerS = setInterval(TimeSystem, 1000);	 
  $(document).bind('mousemove.time keydown.time scroll.time', function(){
    clearTimeout(idleTimer); // отменяем прежний временной отрезок
	 
      //$.cookie('tss', $.now(), {expires: 100,path: '/'});
	  localStorage.setItem('tss', $.now());
	 // $.cookie('tss', $.now());
	  //$('.debug').empty().append($.cookie("tss"));
	  //$.cookie('tss', $.now(), {expires: 60,path: '/',domain: window.is_session,secure: false};
	  //$.cookie('iss', 's', {expires: 60,path: '/'});
	  
	    
	  
    if(idleState == true){ 
      // Действия на возвращение пользователя
    }
 
    idleState = false;
    idleTimer = setTimeout(timesss, idleWait);
  });
 
  $("body").trigger("mousemove"); // сгенерируем ложное событие, для запуска скрипта	
 }
}
//вызов функции ввода логина пароля
function timesss() { 
	  clearInterval(timerS);
	  //если пароль не ввели через минут перезагрузить страницу
	  setTimeout ( function () { autoReload(); }, 60000 );
      // Действия на отсутствие пользователя
	  //alert('выход из системы');
	  $(document).unbind('mousemove.time keydown.time scroll.time');
	  //завершение сессии пользователя
	  //$.cookie('user_id', null, {path:'/'});  
	  //$.cookie('da', null, {path:'/'}); 
	  $.cookie("tsl", null, {path:'/',domain: window.is_session,secure: false});
	  //открытие формы для входа
	  $.arcticmodal({
    type: 'ajax',
    url: 'forms/login.php?url='+window.location.href,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	 
    }

  });
	  
	  
	  
      idleState = true; 
    }





function compareNumbers(a, b) {
  return a - b;
}

//добавление и удаление из кукки переменных
function CookieList(name,id,command,sort)
{
//del - add
//alert($.cookie(name));
var cookie = $.cookie(name);
	//alert(cookie);
if(cookie==null) {  $.cookie(name, id, {expires: 60,path: '/',domain: window.is_session,secure: false,samesite:'lax'});
 } else
{
	if(command=='del')
	{
		
	var cc = cookie.split('.');
	var text='';
	var lp=0;
	for ( var t = 0; t < cc.length; t++ ) 
	{ 
	  if(cc[t]!=id)
	  {
		  if(cc[t]!='')
		  {	  
		    if(lp==0)
		    {
			  text=cc[t];
		    } else
		    {
			  text=text+'.'+cc[t];
		    }
		    lp++;
		  }
	  }
	}
	if(text=='')
	{
		$.cookie(name, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
	} else
	{
	    $.cookie(name, text, {path: '/',domain: window.is_session,secure: false,samesite:'lax'});  //60 дней
	}
	
	} else
	{
		//alert(sort);
		  if (sort === undefined) {
               $.cookie(name, cookie+'.'+id, {path: '/',domain: window.is_session,secure: false,samesite:'lax'}); //60 дней
          } else
	      {
				  if(sort=='sort')
				  {
						var jon_cookie=cookie+'.'+id;
					    var jon_cc = jon_cookie.split('.'); 
					  
					   jon_cc= jon_cc.sort(compareNumbers);
					   //alert(jon_cc.join("."));
					   $.cookie(name, jon_cc.join("."), {path: '/',domain: window.is_session,secure: false,samesite:'lax'}); //60 дней
					    
				  }
				  
		  }
		
		
		
	}
}
	//alert(cookie);
}


//добавление или удаление из строки вида 4,3,5 еще элементов
//возвращает 0 если надо добавить а это уже есть
function AddDellListSep(string,id,command,separator)
{
//del - add

	//alert(cookie);
	if((string=='')&&(command=='add')) { return id;
	} else
	{
		if(command=='dell')
		{

			var cc = string.split(separator);
			var text='';
			var lp=0;
			for ( var t = 0; t < cc.length; t++ )
			{
				if(cc[t]!=id)
				{
					if(cc[t]!='')
					{
						if(lp==0)
						{
							text=cc[t];
						} else
						{
							text=text+separator+cc[t];
						}
						lp++;
					}
				}
			}
			if(text=='')
			{
				return '';
			} else
			{
				return text;
			}

		} else
		{
			//alert(sort);
			//вдруг такой элемент уже есть тогда вернем 0
			var cc = string.split(separator);
			var text='';
			var lp=0;
			for ( var t = 0; t < cc.length; t++ )
			{
				if(cc[t]==id)
				{

					lp++;

				}
			}
			if(lp!=0) {  return 0;} else {return (string+separator+id);}


		}
	}
	//alert(cookie);
}


//добавление или удаление из строки вида 4,3,5 еще элементов
//возвращает 0 если надо добавить а это уже есть
function AddDellList(string,id,command)
{
//del - add

	//alert(cookie);
if((string=='')&&(command=='add')) { return id;
 } else
{
	if(command=='dell')
	{
		
	var cc = string.split(',');
	var text='';
	var lp=0;
	for ( var t = 0; t < cc.length; t++ ) 
	{ 
	  if(cc[t]!=id)
	  {
		  if(cc[t]!='')
		  {	  
		    if(lp==0)
		    {
			  text=cc[t];
		    } else
		    {
			  text=text+','+cc[t];
		    }
		    lp++;
		  }
	  }
	}
	if(text=='')
	{
		return '';
	} else
	{
	    return text;
	}
	
	} else
	{
		//alert(sort);
	    //вдруг такой элемент уже есть тогда вернем 0
		var cc = string.split(',');
	var text='';
	var lp=0;
	for ( var t = 0; t < cc.length; t++ ) 
	{ 
	  if(cc[t]==id)
	  {
		  
		    lp++;
		  
	  }
	}
	if(lp!=0) {  return 0;} else {return (string+','+id);}
		
		
	}
}
	//alert(cookie);
}



//отправка сообщения
var send_meee= function()
{

	var tt=$('#otziv_area').val();
	
	var err = [0];
		
	$(".otziv_mess").removeClass('error_formi');
	//$("#number_r").removeClass('error_formi');
 
  
    if($("#otziv_area").val() == '')
	{
		$(".otziv_mess").addClass('error_formi');
		err[0]=1;		
	} else
		{
	
var for_id=$('.content_block').attr('id_content');	
var data ='url='+window.location.href+'&id='+for_id+'&text='+$('#otziv_area').val();	
AjaxClient('message','send_message_global','GET',data,'AfterSendMM',for_id,0);	
$("#otziv_area").val('');			

		}
	
}

//отправка сообщений пользователю
var SendMessage= function()
{
	var id_user=$(this).attr('sm');
	//открытие формы для сообщения
	var you_id_user=$('[iu]').attr('iu');
	
	if(you_id_user!=id_user)
		{
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_message.php?id='+id_user,
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	 
    }

  });
		}
}



//загрузка скана кассового ордера
var UploadScan = function()
{
	var id_upload=$(this).attr('id_upload');
	$('[name=myfile'+id_upload+']').trigger('click');
}


  function log(html) {
      $('#log').empty().append(html);
    }

function upload(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
          
		  $('[id_upload='+id+']').remove();
		  $('.scap_load_'+id).remove(); 
		  updatecash(id);
        } else {
          $('[id_upload='+id+']').show();
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		$('[id_upload='+id+']').hide();  
		$('.scap_load_'+id).show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_'+id).find('.scap_load__').width(widths);  
      }

      xhr.open("POST", "implementer/upload.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }




var UploadScanChange = function()
{
	var id=$(this).parents('form').attr('id_sc');
	file = this.files[0];
	      if (file) {
        upload(file,id);
      } 
      return false;	
}

//открыть уведомления
var view_notification = function()
{
	if( $('.noti_block').is(':visible') ) {   $('.noti_block').remove(); $('.view__not').hide(); $('.not_li').find('i').hide();  } else 
	{ 	 
	  $('.view__not').append('<div class="noti_block"><div class="title_noti"><ul class="t_ul"><li>Уведомления</li><li><i class="noti_co" style="display:none;"><span class="noti_coc"></span></i></li></ul></div><div class="scro"></div></div>');
	  //отправляем запрос на получение новых уведомлений
	  $('.noti_block').find('.scro').empty().append('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	  var data ='';

      AjaxClient('notification','view_notification','GET',data,'AfterVVN',1,0,1);
	}
}



//нажать на кнопку отменить как выполнена в новых задачах
var YesTask1 = function() {
if ( $(this).is("[rel_taskk]") )
{
	if($.isNumeric($(this).attr("rel_taskk")))
	{
       var attr=$(this).attr('rel_taskk');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_yes_task.php?id='+attr,
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
	
}
}
return false;
	
}

//нажать на кнопку задача выполенна
var YesTask = function() {
if ( $(this).is("[rel_taskk]") )
{
	if($.isNumeric($(this).attr("rel_taskk")))
	{
       var attr=$(this).attr('rel_taskk');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_yes_task.php?id='+attr,
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
	
}
}
return false;
	
}


//удаление организации
var DellOrg = function() {
if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
       var attr=$(this).attr('id_rel');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_org.php?id='+attr,
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
	
}
}
  
return false;
	
}

//удаление задачи
var DellTask = function() {
	
if ($(this).is("[id_rel]"))
{
	if($.isNumeric($(this).attr("id_rel")))
	{
    
	var attr=$(this).attr('id_rel');
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_task.php?id='+attr,
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
	
    }
}
  
return false;
	
}


//удаление клиента
var DellClients = function() {
if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
       var attr=$(this).attr('id_rel');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_clients.php?id='+attr,
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
	
}
}
  
return false;
	
}

//удаление заявки
var DellBooking = function() {
if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
       var attr=$(this).attr('id_rel');
	//$('[id_offers='+attr+']').slideUp("slow");
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_booking.php?id='+attr,
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
	
}
}
  
return false;
	
}


//удалить уведомление
var DellNotif = function() {
if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
       var data ='url='+window.location.href+'&id='+$(this).attr("id_rel");
       AjaxClient('notification','del_notif','GET',data,'AfterDellNot',$(this).attr("id_rel"),0);
	   $('[rel_noti='+$(this).is("[id_rel]")+']').hide();	
}
}
  
return false;
	
}





//табсы в окне при добавлении клиента
var tabs_client_add  = function() {
	//alert("!");
	var uoo=$(this).attr("id");
	if ( $(this).is(".active") )
    {
		//уже активная вкладка
	} else
	{
		$('.client_window .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		
		$('.js-tabs-menu').find('.tabsss1').removeClass('active');
		$('.js-tabs-menu').find('.tabsss1[id='+uoo+']').addClass('active');
		
		var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
					'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for');
        AjaxClient('clients','tabs_organ','GET',data,'AfterTabsInfoAdd',$(this).attr("id"),0);	
	}
}

//табсы в окне организации
var tabs_org  = function() {
	//alert("!");
	var uoo=$(this).attr("id");
	if ( $(this).is(".active") )
    {
		//уже активная вкладка
	} else
	{
		$('.client_window .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		
		$('.js-tabs-menu_org').find('.tabsss_org').removeClass('active');
		$('.js-tabs-menu_org').find('.tabsss_org[id='+uoo+']').addClass('active');
		
		var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
					'&tk='+$('.h111').attr('mor')+
					'&id='+$('.h111').attr('for');
        AjaxClient('clients','tabs_info_org','GET',data,'AfterTabsInfoOrg',$(this).attr("id"),0);	
	}
}

//табсы в окне при выборе клиента
var tabs_client_choice  = function() {
	var uoo=$(this).attr("id");
	if ( $(this).is(".active") )
    {
		//уже активная вкладка
	} else
	{		
		$('.js-tabs-menu-choiche').find('.tabsss_choice').removeClass('active');
		$('.js-tabs-menu-choiche').find('.tabsss_choice[id='+uoo+']').addClass('active');
		
		$('.js-choice-keyup').val('');
		$('.js-choice-yyy').attr('id_rel',0);
		$('.js-choice-yyy').attr('tabs',uoo);
		$('.js-choice-yyy').removeClass('yes_choice_client');
		
		$('.list_choice_yes').empty();
		
		if(uoo==2)
			{
				//организация вкладка
				$('.js-new_open_client').find('i').empty().append('новая организация');
				$('.js-new_open_client').attr('tabs_g',1);
				$('.js-choice-keyup').attr('placeholder','Название организации, ИНН');
			}
		
				if(uoo==1)
			{
				//частное лицо вкладка
				$('.js-new_open_client').find('i').empty().append('новый клиент');
				$('.js-new_open_client').attr('tabs_g',0);
				$('.js-choice-keyup').attr('placeholder','Фамилия, телефон или код клиента');
			}
				if(uoo==3)
			{
				//частное лицо вкладка
				$('.js-new_open_client').find('i').empty().append('новый клиент');
				$('.js-new_open_client').attr('tabs_g',2);
				$('.js-choice-keyup').attr('placeholder','Фамилия, телефон или код клиента');
			}		
		
		var data ='url='+window.location.href+
					'&all='+$('.js-eshe-client-x').attr("all")+
			        '&tk='+$('.js-s_form_xx').attr('mor')+
					'&id='+$('.js-s_form_xx').attr('for')+
					'&search='+encodeURIComponent($('.js-choice-keyup').val())+
			'&tabs='+uoo;
		
			$('.js-icon-load').hide().after('<div class="b_loading_small" style="margin-right:-20px; position:relative; top: 0px; right: 0px; padding-top:0px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('clients','search_client_tours','GET',data,'AfterSearchClientT',1,0);
		
	}
}




//табсы в туре
var tabs_trips = function(event) {
	//event.data.key

	var uoo=$(this).attr("id");

   if(uoo!=0) {
	   $(this).parents('.mm_w-trips').addClass('active-trips-menu');
   } else
   {
	   $(this).parents('.mm_w-trips').removeClass('active-trips-menu');
	  $(this).parents('.mm_w-trips').next().empty().hide();
	   $(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
   }

	if ( $(this).is(".active") )
	{
		//уже активная вкладка
		$(this).parents('.mm_w-trips').removeClass('active-trips-menu');
		$(this).parents('.mm_w-trips').next().empty().hide();
		$(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');



	} else
	{
		//alert(event.data.key);
		if(uoo!=0) {
			$(this).parents('.mm_w-trips').next().empty().append('<div class="b_loading_small" style="position:relative; left: calc(50% - 30px); "><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
			$(this).parents('.mm_w-trips').next().slideDown("slow");

			/*
                    $('.form'+event.data.key+' .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
            */
			$(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key).removeClass('active');
			$(this).parents('.js-tabs-menu').find('.tabs_' + event.data.key + '[id=' + uoo + ']').addClass('active');

			//var key_='002U';

			var data = 'url=' + window.location.href + '&id_tabs=' + $(this).attr("id") +
				'&id=' + $(this).parents('.trips_block_global').attr('id_trips');
			//alert(data);
			AjaxClient('tours','tabs_info','GET',data,'AfterTabsInfoTrips',$(this).attr("id")+','+$(this).parents('.trips_block_global').attr('id_trips'),0,1);
		}
	}
}


//табсы в окне Задачи
var tabs_task  = function(event) {
	//event.data.key
	
	
	var uoo=$(this).attr("id");
	if ( $(this).is(".active") )
    {
		//уже активная вкладка
	} else
	{
		//alert(event.data.key);
		$('.form'+event.data.key+' .px_bg').empty().append('<div class="b_loading_small" style="position:relative;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
		
		$('.form'+event.data.key+' .js-tabs-menu').find('.tabs_'+event.data.key).removeClass('active');
		$('.form'+event.data.key+' .js-tabs-menu').find('.tabs_'+event.data.key+'[id='+uoo+']').addClass('active');
		
		//var key_='002U';
		
		var data ='url='+window.location.href+'&id_tabs='+$(this).attr("id")+
					'&tk='+$('.form'+event.data.key+' .h111').attr('mor')+
					'&id='+$('.form'+event.data.key+' .h111').attr('for');
		//alert(data);
        AjaxClient('task','tabs_info','GET',data,'AfterTabsInfoTask',$(this).attr("id")+','+event.data.key,0);	
	}
}


var savedefault = function (thiss)
{
	if($('#save').length)
	{
	var wdefault=thiss.attr('defaultv');
	if(thiss.val()!=wdefault)
	{
	   $('#save').attr('save','1');
    } 
	
	var atrr=$('#save').attr('save');
	if(atrr==1)
		{
			$('.add_nar').show();
			$('.pod_nar').hide();
		}
	}
}

//проверить и отправить форму на добавление пользователя
function send_form_users()
{
	   var err = 0;	
	$(".sourse_error,.sourse_error1,#name_b,#name_b1,#login_b,#password_b").removeClass('error_formi');
     if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	 if($("#radio_bk").val() == '') { $(".sourse_error1").addClass('error_formi'); err++;	}
	
	
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#name_b1").val() == '')  { $("#name_b1").addClass('error_formi'); err++;	}
	
	if($("#login_b").val() == '')  { $("#login_b").addClass('error_formi'); err++;	}
	if($("#password_b").val() == '')  { $("#password_b").addClass('error_formi'); err++;	}
	
	
	if((err==0)&&($(this).is('.greeen')) )	
		{
			$('#lalala_add_form').submit();	
		}
}

//проверить и отправить форму на добавление отчета
function send_form_reports()
{
	   var err = 0;	
	$("#name_b,#phone_b").removeClass('error_formi');
     
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
	
	
	if((err==0)&&($(this).is('.greeen')) )	
		{
			$('#lalala_add_form').submit();	
		}
}

//проверить и отправить форму на добавление туроператора
function send_form_operator()
{
	
		    var err = 0;		
	$("#name_b").removeClass('error_formi');
 
  
  
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	
	//if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
	
		
	if((err==0)&&($(this).is('.greeen')) )	
		{
			$('#lalala_add_form').submit();	
		}
		
		
	
	
}

//проверить и отправить форму на добавление клиента
function send_form_clients()
{
	
	var err = 0;		
	$(".sourse_error,#name_b,#otziv_area_adaxx,#phone_b,#day_b,#email_b,#company_b").removeClass('error_formi');
	
	$('.new_search_add_book').removeClass('error_2019_in');
 

	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
	if($("#day_b").val() == '')  { $("#day_b").addClass('error_formi'); err++;	}
	//if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
	
	

	if((err==0)&&($(this).is('.greeen')) )	
		{
			$('#lalala_add_form').submit();	
		}
		
		
	
	
}

////проверить и отправить форму на добавление заявки
function send_form_booking()
{
	
	var err = 0;		
	$(".sourse_error,.sourse_error1,#name_b,#otziv_area_adaxx,#phone_b,#name_client_b,#date_hidden_table_gr2").removeClass('error_formi');
	
	$('.new_search_add_book').removeClass('error_2019_in');
 
	if($("#radio_bk").length!=0)
	{
		if($("#radio_bk").val() == '') {  $(".sourse_error1").addClass('error_formi'); err++;	}	
	}
  
    if($("#sourse_b").val() == '') { $(".sourse_error").addClass('error_formi'); err++;	}
	if($("#name_b").val() == '')  { $("#name_b").addClass('error_formi'); err++;	}
	
	//if($("#phone_b").val() == '')  { $("#phone_b").addClass('error_formi'); err++;	}
	
	
	if($('[name=client_new1_search]').val()==0)
		{
	       if($("#name_client_b").val() == '')  { $("#name_client_b").addClass('error_formi'); err++;	}	
		} else
		{
			if(($("[name=id_search_client1]").val() == '0')||($("[name=id_search_client1]").val() == ''))  { $(".new_search_add_book").addClass('error_2019_in'); err++;	}	
		}
	
	
	if($("#date_hidden_table_gr2").val() == '')  { $("#date_hidden_table_gr1").addClass('error_formi'); err++;	}	
		
	if((err==0)&&($(this).is('.greeen')) )	
		{
			$('#lalala_add_form').submit();	
		}
		
		
	
	
}


//работа с радио input
function radio_checkbox_no_yes()
{
		
if($(this).parents('.radioselect').find('.radio_b').attr('readonly')==undefined) { 	
	
	//alert("!");
	var pp=$(this).parents('.radio_material');
	var id=pp.attr('radio_id');
	
	if(!pp.is('.active_radio')) 
	{
		var numOpt=$(this).parents('.radioselect').find('.radio_material');    
			  var input='';
			  var i=0;
			 
			  numOpt.each(function (index, value) { 
				  $(this).removeClass('active_radio');
				  var ids=$(this).attr('radio_id');
				  $(this).find('.radio_'+ids).val(0).change(); 
			  });

		pp.addClass('active_radio');
		pp.find('.radio_'+id).val(1).change();
		$(this).parents('.radioselect').find('.radio_b').val(id).change();
		
	} else
	{
			pp.removeClass('active_radio');
		pp.find('.radio_'+id).val(0).change();
		$(this).parents('.radioselect').find('.radio_b').val('').change();
	}
	
  }
	
	
}


//выбор источника обращения при добавлении заявки
function wallet_checkbox()
{
	
if($(this).parents('.cha_1').find('.sourse_b').attr('readonly')==undefined) { 	
	
	//alert("!");
	var pp=$(this).parents('.wallet_material');
	var id=pp.attr('wall_id');
	
	if(pp.is('.active_wall')) 
	{ 
	   
		pp.removeClass('active_wall');
		pp.find('.yop_'+id).val(0);
		


		
	} else
	{
		pp.addClass('active_wall');
		pp.find('.yop_'+id).val(1);			
	}
			var numOpt=$(this).parents('.cha_77').find('.wallet_material');    
			  var input='';
			  var i=0;
			 
			  numOpt.each(function (index, value) { 
			  
			  if ( $(this).hasClass("active_wall") ) 
			   {
				  if(i==0)
				  { 
                    input=$(this).attr('wall_id');
					i++;
				  } else
				  {
					input=input+','+$(this).attr('wall_id');
					i++; 
				  }
			   }
			   
              });
				 
		//alert(input);
		$(this).parents('.cha_77').find('.sourse_b').val(input);
	
  }
}

//работа с радио input
function radio_checkbox()
{
		
if($(this).parents('.radioselect').find('.radio_b').attr('readonly')==undefined) { 	
	
	//alert("!");
	var pp=$(this).parents('.radio_material');
	var id=pp.attr('radio_id');
	
	if(!pp.is('.active_radio')) 
	{
		var numOpt=$(this).parents('.radioselect').find('.radio_material');    
			  var input='';
			  var i=0;
			 
			  numOpt.each(function (index, value) { 
				  $(this).removeClass('active_radio');
				  var ids=$(this).attr('radio_id');
				  $(this).find('.radio_'+ids).val(0).change(); 
			  });

		pp.addClass('active_radio');
		pp.find('.radio_'+id).val(1).change();
		$(this).parents('.radioselect').find('.radio_b').val(id).change();
		
	}
	
  }
	
	
}

function UploadInvoice_old()
{
	var id_upload=$(this).attr('id_upload');
	$('[name=myfiles'+id_upload+']').trigger('click');
}




$(function (){
//изменение размера окна	
$(window).on('resize',windowSize);	

//Загрузчик страницы	
$('.loader_ada').remove();
$('.loader_ada1').remove();

$('.date_picker_xe').inputmask("datetime",{
    mask: "1.2.y", 
    placeholder: "dd.mm.yyyy",  
    separator: ".", 
    alias: "dd.mm.yyyy"
  });	

//количество ночей из двух дат	
$('body').on("change keyup input click",'.js-date-nait2,.js-date-nait1',date_nait);
	
//добавить новый тур	
$('body').on("change keyup input click",'.js-add-tender-form',AddFormTender);

//редактировать тур
	$('body').on("change keyup input click",'.js-edit-tender-form',EditFormTender);


//редактировать поле с выпадающим списком	
$('body').on("change keyup input click",'.js-edit-eico',edit_eico_list);	
$('body').on("change",'.js-list-vibor',update_edit_input_eico);	
	
//я берусь за эту задачу
$('body').on("change keyup input click",'.js-choice-task-y',choice_task_you);
//нажать на выполнить задачу
$('body').on("change keyup input click",'.task__click1',YesTask1);	
	
//форма добавление тура - выбор паспорт какой	
$('body').on("change keyup input click",'.js-password-butt',password_butt);

//форма оплаты тура изменяем кому платим клиент-туроператор
$('body').on("change keyup input click",'.js-click-mmmt',click_mmmt);


//форма добавление тура - галка не летит только покупает	
$('body').on("change keyup input click",'.js-loli-butt',loli_butt);	
	

	
$('body').on("change keyup input click",'.js-exit-win',close_close_window);	
	
	
//открыть форму по организации с определенной вкладки	
$('body').on("change keyup input click",'.tabsss_org',tabs_org);
//открыть форму по клиенту с определенной вкладки


$('body').on("change keyup input click",'.tabs_003U',{key: "003U"},tabs_task);

	$('body').on("change keyup input click",'.tabs_004U',{key: "004U"},tabs_trips);

//еще - показать уведомления	
$('body').on("change keyup input click",'.js-eshe-ring',js_eshe_ring);	
	
	
//все что связано с выбором клиентов form_choice_client	
$('body').on("change keyup input click",'.tabsss_choice',tabs_client_choice);
	

	
//нажать при выборе клиента на клиента
$('body').on("change keyup input click",'.list_client_choice',click_client_choice);

	
$('body').on("change keyup input click",'.js-new_open_client',clients_adds);

//удалить из списка выбранных при окне выбор клиента	
$('body').on("change keyup input click",'.rrube_choice',rrube_choice);	

//нажатие на кнопку выбрать в окне выбора клиента	
$('body').on("change keyup input click",'.js-choice-yyy',choice_client_end);


/*	
var search_min2_search_c = 2;  //мин количество символов для быстрого поиска
var search_deley2_search_c=800;	//задержка между вводами символов - начало поиска телефона в базе
var search_input2_search_c=$('.js-choice-keyup');
	
	
search_input2_search_c.keyup(function() {
	//обнуляем выбор
				
    delays(function(){
		
		if((jQuery.trim(search_input2_search_c.val().length) >= search_min2_search_c)||(jQuery.trim(search_input2_search_c.val().length)==0))
		{
			
			var val1= $('.js-tabs-menu-choiche').find('.active').attr('id');
			
                var data ='url='+window.location.href+
					'&all='+$('.js-eshe-client-x').attr("all")+
					'&search='+encodeURIComponent(search_input2_search_c.val())+
				'&tabs='+val1;	
			$('.js-icon-load').hide().after('<div class="b_loading_small" style="margin-right:-20px; position:relative; top: 0px; right: 0px; padding-top:0px;"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('clients','search_client_tours','GET',data,'AfterSearchClientT',1,0);		
		}
		
		
    }, search_deley2_search_c);
});		
	*/
	
//Открыть окно задачи по нажатию на иконку
$('.oka_block').on("change keyup input click",'.task_clock_selection i',open_task);	

$('body').on("change keyup input click",'.task_block_global .ggh-e',open_task1);	
	
$('body').on("change keyup input click",'.js-taa',open_task_new);	
	
$('body').on("change keyup input click",'.task_block_global .task-b-number',open_task1);
	
//открыть форму по добавлению клиента или оргазации	
$('body').on("change keyup input click",'.tabsss1',tabs_client_add);
	

//выбор в заявке источника обращения	
$('.cha_1').on("change keyup input click",'.wallet_checkbox',wallet_checkbox);

//загрузить фото в настройках
$('.l_photo').on("change keyup input click",'.invoice_upload',UploadInvoice_old);
//$('.content').on("change",'.sc_sc_loos2',UploadReportsChange_old);

$('.content').on("change",'.sc_sc_loos2',UploadReportsChange_old);


//работа с инпутами	
$('body').on("focus click",'.input_new_2019',InputFocusNew1);
$('body').on("blur",'.input_new_2019',InputBlurNew1);
$('body').on("change keyup input click",'.radio_checkbox',radio_checkbox);
$('body').on("change keyup input click",'.radio_checkbox_no_yes',radio_checkbox_no_yes);



//ежемесячный платеж
	$('.js-finance-operation').on("change keyup input click",'.js-choice-buy-y',choice_buy_you);





$('body').on("change keyup input click",'.js-place-finance',plane_edit);
	
//отправка и проверка форм по нажатию кнопки
$('.index_booking').on("change keyup input click",'.send_form_clients',send_form_clients);	 //клиенты
$('.index_booking').on("change keyup input click",'.send_form_booking',send_form_booking);   //заявки
$('.index_booking').on("change keyup input click",'.send_form_operator',send_form_operator); //туроператор	 
$('.index_booking').on("change keyup input click",'.send_form_users',send_form_users);	//пользовател	
$('.index_booking').on("change keyup input click",'.send_form_reports',send_form_reports); //отчеты		


jQuery('.scrollbar-inner').scrollbar(); //скрулл меню при малой высоте
ToolTip();  //подсказки при наведении
$('.label_s').bind("change keyup input click", label_show);

$('.save_button2').bind("change keyup input click", send_meee);
	
$('.content').on("click",'.send_mess',SendMessage);	
$('.help_user').on("click",'.send_mess',SendMessage);

//$('.menu_jjs').on("change keyup input click",'.menu_click',menuclick);
//$('.menu_click').bind("change keyup input click", menuclick);
	

$('.div_dialog').on("click",'.dialog_a',function(e) {  if($(e.target).closest(".del_dialog").length==0)
  {
	var dialog_id=$(this).attr('rel_diagol');
	$(this).attr('href','/message/dialog/'+dialog_id+'/');
	$(this).trigger('Click');

  } });


function UploadReportsChange_old()
{
		var id=$(this).parents('form').attr('id_sc');
		file = this.files[0];
		if (file) {
			uploadRR_old(file,id);
		}
		return false;
	}

	
var UploadScanS = function()
{
	var id_upload=$(this).attr('id_upload');
	$('[name=myfile'+id_upload+']').trigger('click');
}


var UploadInvoiceAkt = function()
{
	var id_upload_a=$(this).attr('id_upload_a');
	$('[name=myfileakt'+id_upload_a+']').trigger('click');
}
var UploadInvoicePhoto = function()
{
	var id_upload_a1=$(this).attr('id_upload_a1');
	$('[name=myfilephoto'+id_upload_a1+']').trigger('click');
}

	
var UploadInvoice = function()
{
	var id_upload=$(this).attr('id_upload');
	$('[name=myfile'+id_upload+']').trigger('click');
}


function uploadS(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
          
		  $('[id_upload='+id+']').show(); //кнопка
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
		  UpdateImageSupply(id);
        } else {
          $('[id_upload='+id+']').show();
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		$('[id_upload='+id+']').hide();  
		$('.scap_load_'+id).show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_'+id).find('.scap_load__').width(widths);  
      }

      xhr.open("POST", "supply/upload.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }
//загрузка актов на отбраковку
function uploadIA(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
          
		$('[id_upload_a='+id+']').next().find('.b_loading_circle_wrapper_small').hide();
			$('[id_upload_a='+id+']').show();  
			
		  UpdateImageInvoiceAkt(id,0);
        } else {
		$('[id_upload_a='+id+']').next().find('.b_loading_circle_wrapper_small').hide();
			$('[id_upload_a='+id+']').show();  
		
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		 //скрыть кнопку показать загрузчик 
		$('[id_upload_a='+id+']').hide();  
		$('[id_upload_a='+id+']').next().find('.b_loading_circle_wrapper_small').show();
      }

      xhr.open("POST", "invoices/upload_akt.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }

//загрузка фото брака	
function uploadIP(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
          
		$('[id_upload_a1='+id+']').next().find('.b_loading_circle_wrapper_small').hide();
			$('[id_upload_a1='+id+']').show();  
		  UpdateImageInvoiceAkt(id,1);
        } else {
		$('[id_upload_a1='+id+']').next().find('.b_loading_circle_wrapper_small').hide();
			$('[id_upload_a1='+id+']').show();  
		
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		 //скрыть кнопку показать загрузчик 
		$('[id_upload_a1='+id+']').hide();  
		$('[id_upload_a1='+id+']').next().find('.b_loading_circle_wrapper_small').show();
      }

      xhr.open("POST", "invoices/upload_photo.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }	
	
function uploadI(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
          
		  $('[id_upload='+id+']').show(); //кнопка
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
		  UpdateImageInvoice(id);
        } else {
          $('[id_upload='+id+']').show();
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		$('[id_upload='+id+']').hide();  
		$('.scap_load_'+id).show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_'+id).find('.scap_load__').width(widths);  
      }

      xhr.open("POST", "booking/upload.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }
/*
function uploadRR(file,id) {

      var xhr = new XMLHttpRequest();

      // обработчики можно объединить в один,
      // если status == 200, то это успех, иначе ошибка
      xhr.onload = xhr.onerror = function() {
        if (this.status == 200) {
          
		  $('[id_upload='+id+']').show(); //кнопка
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
		  UpdateImageReports(id);
			alert_message('ok','ваш профиль обновлен');
			autoReloadHak();
        } else {
          $('[id_upload='+id+']').show();
		  $('.scap_load_'+id).find('.scap_load__').width(0); 
		  $('.scap_load_'+id).hide();
        }
      };

      // обработчик для закачки
      xhr.upload.onprogress = function(event) {
		$('[id_upload='+id+']').hide();  
		$('.scap_load_'+id).show();  
		var widths=Math.round((event.loaded*100)/event.total);
		$('.scap_load_'+id).find('.scap_load__').width(widths);  
      }

      xhr.open("POST", "reports/upload.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }	
*/
	/*
	function uploadRR_old(file,id) {

		var xhr = new XMLHttpRequest();

		// обработчики можно объединить в один,
		// если status == 200, то это успех, иначе ошибка
		xhr.onload = xhr.onerror = function() {
			// alert(this.status);
			if (this.status == 200) {

				$('[id_upload='+id+']').show(); //кнопка
				$('.scap_load_'+id).find('.scap_load__').width(0);
				$('.scap_load_'+id).hide();
				$('.scap_load_'+id).after();
				//UpdateImageReports(id);
				alert_message('ok','ваш профиль обновлен');
				autoReloadHak();
			} else {

				$('[id_upload='+id+']').show();
				$('.scap_load_'+id).find('.scap_load__').width(0);
				$('.scap_load_'+id).hide();
			}
		};

		// обработчик для закачки
		xhr.upload.onprogress = function(event) {
			$('[id_upload='+id+']').hide();
			$('.scap_load_'+id).show();
			var widths=Math.round((event.loaded*100)/event.total);
			$('.scap_load_'+id).find('.scap_load__').width(widths+'%');
		}

		xhr.open("POST", "users/upload.php", true);
		//xhr.send(file);

		var formData = new FormData();
		formData.append("thefile", file);
		formData.append("id",id);
		xhr.send(formData);

	}
*/


	var UploadInvoicePhotoChange = function()
{
	var id=$(this).parents('form').attr('id_a');
	file = this.files[0];
	      if (file) {
        uploadIP(file,id);
      } 
      return false;	
}		

var UploadInvoiceAktChange = function()
{
	
	var id=$(this).parents('form').attr('id_a');
	file = this.files[0];
	      if (file) {
        uploadIA(file,id);
      } 
      return false;	
}	

/*
var UploadReportsChange = function()
{
	var id=$(this).parents('form').attr('id_sc');
	file = this.files[0];
	      if (file) {
        uploadRR(file,id);
      } 
      return false;	
}
*/

var UploadInvoiceChange = function()
{
	var id=$(this).parents('form').attr('id_sc');
	file = this.files[0];
	      if (file) {
        uploadI(file,id);
      } 
      return false;	
}

var UploadScanSChange = function()
{
	var id=$(this).parents('form').attr('id_sc');
	file = this.files[0];
	      if (file) {
        uploadS(file,id);
      } 
      return false;	
}

	//делаем поля с классом только дробными и целыми числами	
$('.count_mask').bind("change keyup input click", validate11);
$('.count_mask1').bind("change keyup input click", validate12);
	

	
	
	$('.messa_form_a').on("change",'.invoice_file_photo',UploadInvoicePhotoChange);
	$('.messa_form_a').on("change",'.invoice_file_akt',UploadInvoiceAktChange);	
	
	$('.invoice_block').on("click",".add_akt_defect", UploadInvoiceAkt);	
	$('.invoice_block').on("click",".add_akt_defect1", UploadInvoicePhoto);
	


	

	

	
	
	


$('.img_invoice_div').on("click",'.del_image_invoice',DellImageInvoice);	

$('.img_invoice_div').on("click",'.del_image_reports',DellImageReports);	
	
$('.img_invoice_div').on("click",'.invoice_upload',UploadInvoice);
$('.content').on("change",'.sc_sc_loo12',UploadInvoiceChange);
//$('.content').on("change",'.sc_sc_loos2',UploadReportsChange);
	
$('body').on("click",'.soply_upload',UploadScanS);
$('body').on("change",'.sc_sc_loo11',UploadScanSChange);
		

//$('.booker_table').on("change keyup input click",'.booker_yes',booker_yes);	
	
$('.pay_imp').on("click",'.naryd_upload',UploadScan);
$('.pay_imp').on("change",'.sc_sc_loo',UploadScanChange);


jQuery(document).on("focus click",'.input_new_2018',InputFocusNew);	
jQuery(document).on("blur",'.input_new_2018',InputBlurNew);
jQuery(document).on("keyup",'.input_new_2018',KeyUpInput);	

//фокус и потеря в окне выбора покупателя тура в поиске	
jQuery(document).on("focus click",'.js-choice-keyup',InputFocusNewTours);	
jQuery(document).on("blur",'.js-choice-keyup',InputBlurNewTours);		


$('.notif_imp').on("click",'.del_notif',DellNotif);	
$('.notif_div_2018').on("click",'.del_notif',DellNotif);
	$('.booking_div').on("click",'.del_booking_',DellBooking);

	$('.clients_block').on("click",'.del_clients_',DellClients);
	
	
		$('.clients_org').on("click",'.del_org_',DellOrg);
	
$('.place-wrapper').on("click",'.task__click',YesTask);	
	
	


$('.fox_search_result1').on("change keyup input click",'.string_res',string_res1);
	

//удаление покупателя из тура
$('.js-buy-my-tours').on("change keyup input click",'.js-dell-buy-tours',js_dell_buy_tours);
//удаление туриста из тура
$('.js-fly-my-tours').on("change keyup input click",'.js-dell-fly-tours',js_dell_fly_tours);



	
//выход из системы при бездействии
idleTimer = null;
timerS = null;	
timerH=null;	
idleState = false; // состояние отсутствия
idleWait = 30*60*1000; // время ожидания в мс. (1/1000 секунды) - 30 минут
idTimeStampe=0;	
ExitSystem();
//выход из системы при бездействии
	

window.is_session='umatravel.club';
	

//уведомления настройки	
idleTimerx = null;
timerSx = null;	
idleStatex = false; // состояние отсутствия
idleWait_start = 10*1000; // время обновления notification - каждые 30 секунд 
idleWait_stop = 5*60*1000; // время простоя после которого скрипт начинает обращаться реже к обновлениям - 5 минут	
idleWait_end = 2*60*1000; // время обновления notification после простоя системы в течении 5 минут - каждые 2 минуты
idleWait_yes=idleWait_start;	
idTimeStampex=0;	
NotifSystem();
$('<audio id="chatAudio"><source src="notify.ogg" type="audio/ogg"><source src="notify.mp3" type="audio/mpeg"><source src="notify.wav" type="audio/wav"></audio>').appendTo('body');	
//уведомления настройки	
	
nprogress=0; //показывать загрузчик линию при ajax запросах	

	
setInterval(function(){ $this=inWindow(".Effectbbo");  if(inWindow(".Effectbbo").length!=0) {   setTimeout ( function () {  $this.removeClass('yes_bbs1'); }, 5000 );  }  }, 1000); // 1000 м.сек	
 
	



	
	

//$('.mkr_,.smeta2').on("change",'.option_mat',option_mat);	

	
	
//$(".drops").find("li").bind('click', droplis);
	
$('.menu_top,.smeta2').on("click",'.drops li',droplis);	
//анимация линеек
animation_teps();


	

	

//удалить диалог
$(".del_dialog").bind('click', del_dialog);	
	
//открыть уведомления
//$(".view__not i").bind('click', view_notification);
	

	
$('#lalala_add_form').on("change keyup input click",'.error_formi', function(){ $this = $(this); setTimeout ( function () {$this.removeClass('error_formi');  }, 2000 ); });	
	


//закрытие поиска себестоимости при клике вне его	
window.show_search=0;	
//$("body").click(function(e) {
$(document).mouseup(function (e) {
    
    if(($(e.target).closest(".search_seb").length==0)&&($(e.target).closest(".icon3").length==0) ){
		//alert(window.show_search);
		//если вне поиска и кнопки поиск то если открыт поиск закрыть
		if(window.show_search==1)
			{
				//alert("!");
				//$('.debug').empty().append($(e.target).attr("class"));
	$('.icon1').show();
	$('.search_seb').hide();
	$('.search_seb').width('60px');
				window.show_search=0;
				 $('var.highlight').each(function(){ $(this).after($(this).html()).remove(); });
			}
	}
	
	/*
	if(($(e.target).closest(".loll_drop").length==0)  ){
	       $('.loll_drop').hide();		
	}	
	*/
	
	var container = $(".noti_block");
	var container1x = $(".box-modal");
	
	if ((container.has(e.target).length === 0)&&(container1x.has(e.target).length === 0)){
	 		if( $('.noti_block').is(':visible') ) {
	       $('.noti_block').remove();
	       $('.view__not').hide(); $('.not_li').find('i').hide();	
		}
	}
	
	/*
	if(($(e.target).closest(".noti_block").length==0)&&($(e.target).closest(".view__not").length==0)  ){
		if( $('.noti_block').is(':visible') ) {
	       $('.noti_block').remove();
	       $('.view__not').hide(); $('.not_li').find('i').hide();	
		}
		}
	*/
});


	
//нажатие на кнопку искать при вводе текста в поиске	
//$('.search_seb').find('i').bind('click', search_p);

//нажатие на enter при вводе
$("#search_text").keypress(function(e){
	     	   if(e.keyCode==13){
	     	   dosearch();
	     	   }
	     	 });
	

$("#otziv_area").keypress(function(e){
	     	   if(e.keyCode==13){
	     	   send_meee();
	     	   }
	     	 });	
	

//автоматическое срабатывание поиска при задержки ввода 	
$('#search_text').keyup(function(){
  var d1 = new Date();
  time_keyup = d1.getTime();
  if ($('#search_text').val()!=term) // проверяем, изменилась ли строка
   if ($('#search_text').val().length>=minlen) { // проверяем длину строки
    setTimeout(function(){ // ждем следующего нажатия
     var d2 = new Date();
     time_search = d2.getTime();
     if (time_search-time_keyup>=keyint) // проверяем интервал между нажатиями
      dosearch(); // если все в порядке, приступаем к поиску
    }, keyint); 
   }
   else
    $('.result_s').hide(); // если строка короткая, убираем текст из DIVа с результатом 
 });		




	//открытие календаря в оформлении наряда по иконке
$(".cal_223").bind('click', function() {  $(this).prev('.calendar_t').trigger('focus');});

//авторизация
//авторизация
//авторизация
	$("#email_formi").keyup(function(){

		var email = $("#email_formi").val();

		if(email != '')
		{

		} else
		{
			$("#email_formi").addClass('error_formi');

		}


	});

	$("#password_formi,#email_formi").keypress(function(e){
		if(e.keyCode==13){
			$('#yes1').trigger('click');
		}
	});

	$("#password_formi").keyup(function(){

		if(($("#password_formi").val()=='')||($("#password_formi").val()==0))
		{
			//$("#password_formi").addClass('error_formi');

		} else
		{
			$("#password_formi").removeClass('error_formi');
		}

	});
	$("#email_formi").keyup(function(){

		if(($("#email_formi").val()=='')||($("#email_formi").val()==0))
		{

			$(".width-setter-yes").removeClass('yes_da');

		} else
		{
			$("#email_formi").removeClass('error_formi');
			$(".width-setter-yes").addClass('yes_da');
		}

	});

	$('#yes1').on( "click", function() {


		//смотрим заполнены ли обязательные поля
		var email = $("#email_formi").val();
		var err = [0,0];

		$("#email_formi").removeClass('error_formi');
		$("#password_formi").removeClass('error_formi');

		if(email != '')
		{
			/*
        if(isValidEmailAddress(email))
        {


        } else
        {
            $("#email_formi").addClass('error_formi');
            err[0]=1;
        }
        */
		} else
		{
			$("#email_formi").addClass('error_formi');
			err[0]=1;
		}
		if(($("#password_formi").val()=='')||($("#password_formi").val()==0))
		{
			$("#password_formi").addClass('error_formi');
			err[1]=1;
		}

		if((err[0]==0)&&(err[1]==0))
		{
			$('#pod_form').submit();
		}



	});
//авторизация
//авторизация
//авторизация
	


	
//крестик, удалить все символы в поиске	
$('.fox_dell1').on('click',function(){
	search_input1.val('');
	$('.fox_dell1').hide();
	$('.div_result1').hide();
	$('.end_search1').hide();
	$('[name=id_search_client1]').val(0).trigger('click');
});


var search_min1 = 3;  //мин количество символов для быстрого поиска
var search_deley1=800;	//задержка между вводами символов - начало поиска
var search_input1=$('#fox_search_client_i1');	
	
//при вводе поиска в клиенте	
search_input1.keyup(function() {
	if(jQuery.trim(search_input1.val().length) >= 1)
		{
		  $('.fox_dell1').show();	
		} else
		{
			$('.fox_dell1').hide();
		}
    delays(function(){
		
		if(jQuery.trim(search_input1.val().length) >= search_min1)
		{
                var data ='url='+window.location.href+
					'&search='+encodeURIComponent(search_input1.val());	
			$('.fox_dell1').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('booking','search_client','GET',data,'AfterSearchClient1',1,0);		
		}
    }, search_deley1);
});




	
	
/*	
var search_min2 = 0;  //мин количество символов для быстрого поиска
var search_deley2=500;	//задержка между вводами символов - начало поиска
var search_input2=$('.js-keyup-search');			
search_input2.keyup(function() {
	
	//обнуляем выбор
	search_input2.parents('.input_2018').find('.js-hidden-search').val(0);
	
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
					'&search='+encodeURIComponent(search_input2.val());	
			//$('.fox_dell1').hide().after('<div class="b_loading_small"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
                AjaxClient('tours','search_turoper','GET',data,'AfterSearchTuroper',1,0);		
		}
    }, search_deley2);
});	
*/	

	//перейти в себестоимость по объекту по клику меню сверху с выбранным объектом
$('.menu1').on('click','.menu3_prime li',  function(){ $(this).children('a')[0].click(); });
	
//свернуть развернуть левое основное меню
$('.hide_left,.mobile').on( "click", function() {
	var est=0;
	if($(".iss").is(".big,.small")) 
	{
	   est=1;	
	}
	if(est==0)
	{
		if( $('.left_menu').is(':visible') ) 
		{
			$(".iss").addClass('small');
			$.cookie('iss', 's', {expires: 60,path: '/'});
			
		} else
		{
			//$(".iss").removeClass('small');
			$(".iss").addClass('big');
			$.cookie('iss', 'b', {expires: 60,path: '/'});
		}
				
	} else
	{
	  if($(".iss").is(".big")) 
	  {
		 $(".iss").removeClass('big');
		 $(".iss").addClass('small');
		 $.cookie('iss', 's', {expires: 60,path: '/'});
	  } else
	  {
		 $(".iss").removeClass('small');
		 $(".iss").addClass('big');  
		 $.cookie('iss', 'b', {expires: 60,path: '/'});
	  }
	  
	}

sl_message_width();
});


	
	
/*клик на раскрывающее меню исполнитель*/
$(document).mouseup(function (e) {
    var container = $(".select_box");
    if (container.has(e.target).length === 0){
        //клик вне блока и включающих в него элементов
	    //$(".drop_box").hide();
		$(".drop_box").css("transform", "scaleY(0)");
		$(".slct_box").removeClass("active");
		
		
		
		
    }


//клик в не формы курс ТО
	var to_k = $(".form-rate-ok");
	if (to_k.has(e.target).length === 0){
		//клик вне блока и включающих в него элементов
		//to_k.find(".drops").css("transform", "scaleY(0)");
		to_k.removeClass('show-form-rate');
	}


	
	var container1 = $(".menu_supply");
    if (container.has(e.target).length === 0){
        //клик вне блока и включающих в него элементов
	   	container1.find(".drops").css("transform", "scaleY(0)");
		container1.find(".drops").removeClass('active_menu_s');
    }




	var container22 = $(".loll_drop");
    if (container22.has(e.target).length === 0){
        //клик вне блока и включающих в него элементов
	   	container22.css("transform", "scaleY(0)");
		
		if($('.post_p').val()=='')
		{
		   $('.loll_div').addClass('required_in_2018');
		   $('.b-loading-message').empty().append('нет связи с поставщиком').show();
		} else
		{
		  $('[name=number_soply]').val($('[name=number_soply]').attr('val_old'));
			$(".loll_drop").empty();
			$('.b-loading-message').hide();
		}
		
		
    }	
	
	
});
window.slctclick_box1 = function() { 


if($(this).parents('.select_box').find('input').attr('readonly')==undefined) {  
	
	  if($(this).is(".active")) 
	  {
		  $(this).removeClass("active");
		 // $(this).next().hide();
		  $(this).next().css("transform", "scaleY(0)");
	  } else
	  {
		  $(this).addClass("active");
		 // $(this).next().show();
		  $(this).next().css("transform", "scaleY(1)");
	  }




var elemss_box=$(this).attr('data_src');	


$('.slct_box').each(function(i,elem) 
{
    var att=$(this).attr('data_src');
	if ($(this).attr('data_src')!=elemss_box) {  	
			$(this).removeClass("active");
			//$(this).next().hide();
		$(this).next().css("transform", "scaleY(0)");
	} 
});	
	
}
	 
		  
//return false;

}


$(".slct_box").bind('click', slctclick_box1);



	
	
window.dropli_box1 = function() { 

var active_old=$(this).parent().parent().find(".slct_box").attr("data_src");
var active_new=$(this).find("a").attr("rel");

			  var f=$(this).find("a").text();
			  var e=$(this).find("a").attr("rel");
			  
			  if(active_old!=active_new)
			  {
			    $(this).parent().find("li").removeClass("sel_active");
			    $(this).addClass("sel_active");
			  
			
			  
			 // $(this).parent().parent().find(".slct").removeClass("active").html(f);
			   $(this).parent().parent().find(".slct_box").removeClass("active").empty().append(f);
			   $(this).parent().parent().find(".slct_box").attr("data_src",e);
			  
			  // $(this).parent().parent().find(".drop_box").hide();
			   $(this).parent().parent().find(".drop_box").css("transform", "scaleY(0)"); 
				  
			   $(this).parent().parent().find("input").val(e).change();
			   savedefault($(this).parent().parent().find("input"));	  
			  } else
			  {
				 //$(this).parent().parent().find(".drop_box").hide();
				  $(this).parent().parent().find(".drop_box").css("transform", "scaleY(0)");
				 $(this).parent().parent().find(".slct_box").removeClass("active"); 
			  }
		  

}
$(".drop_box").find("li").bind('click', dropli_box1);
		
	

//меню выбора города-квартала и дома в себестоимости	
//меню выбора города-квартала и дома в себестоимости
//меню выбора города-квартала и дома в себестоимости	

	
	
/*клик на раскрывающее меню квартал*/
$(document).mouseup(function (e) {
    var container = $(".select");
	var open_cont_list = $(".js-drop-search");
	var open_cont_list1 = $(".js-open-search");
	/*
    if ((container.has(e.target).length === 0)&&(!open_cont_list.is(e.target))&&(!open_cont_list1.is(e.target)))
	{
        //клик вне блока и включающих в него элементов
	    //$(".drop").hide();
		//alert("!");
		$(".drop").css("transform", "scaleY(0)");
		$(".slct").removeClass("active");
		$(".drop").parents('.input-search-list').find('i').removeClass('open-search-active');
    }
	*/
	//alert(container.has(e.target).length);
	if ((container.has(e.target).length === 0)&&(!open_cont_list.is(e.target))&&(!open_cont_list1.is(e.target)))
	{
        //клик вне блока и включающих в него элементов
	    //$(".drop").hide();
		//alert("!");
		$(".drop").css("transform", "scaleY(0)");
		$(".drop-radio").css("transform", "scaleY(0)");
		$(".slct").removeClass("active");
		$(".drop").parents('.input-search-list').find('i').removeClass('open-search-active');
		$(".drop-radio").parents('.input-search-list').find('i').removeClass('open-search-active');
    }
	
	
});
window.slctclick = function() { 

if($(this).parents('.select').find('input').attr('readonly')==undefined) {

	if($(this).is(".active"))
	{
		$(this).removeClass("active");
		//$(this).next().hide();
		$(this).next().css("transform", "scaleY(0)");
		$(this).parents('.list_2018').removeClass('active1_in_2018x');
	} else
	{
		$(this).addClass("active");
		//$(this).next().show();
		$(this).next().css("transform", "scaleY(1)");

		$(this).parents('.list_2018').addClass('active1_in_2018x');
	}




	var elemss=$(this).attr('list_number');
//var elemss1=$(this);

	$('.slct').not(this).each(function(i,elem)
	{
		var att=$(this).attr('data_src');
		//закрыть все кроме себя
		//if($(this).not(elemss1))
		//	{

		//if ($(this).attr('list_number')!=elemss) {
		$(this).removeClass("active");
		//$(this).next().hide();
		$(this).next().css("transform", "scaleY(0)");
		$(this).parents('.list_2018').removeClass('active1_in_2018x');
		//}
	});

//скрываем все списки по поиску
$('.drop-search').each(function(i,elem) 
{  	
	    $(this).parents('.input-search-list').find('i').removeClass('open-search-active');
		$(this).css("transform", "scaleY(0)");
	
});	
		
	 
		  
return false;
}

}

$(".slct").bind('click.sys', slctclick);


function droplis() { 
//alert("!");
var active_old=$(this).parent().attr("data_src");
var active_new=$(this).find("a").attr("rel");
		

			 // var f=$(this).find("a").text();
			 var e=$(this).find("a").attr("rel");
			  
	if(!$(this).parent().is(".no_active"))
		{
	
	
			  if(active_old!=active_new)
			  {
			    $(this).parent().find("li").removeClass("sel_active_sss");
			    $(this).addClass("sel_active_sss");
				$(this).parent().attr("data_src",e);  
			  
			
			  
			   // $(this).parent().parent().find(".slct").removeClass("active").html(f);
			   //$(this).parent().parent().find(".slct").removeClass("active").empty().append(f);
			   // $(this).parent().parent().find(".slct").attr("data_src",e);
			  
			   //$(this).parent().parent().find(".drop").hide();
			   //$(this).parent().parent().find(".drop").css("transform", "scaleY(0)");
			  
			   $(this).parent().parent().find("input").val(e).change();
			  } else
			  {
				 //$(this).parent().parent().find(".drop").hide();
				 //$(this).parent().parent().find(".drop").css("transform", "scaleY(0)");
				  
				 //$(this).parent().parent().find(".slct").removeClass("active"); 
			  }
		} else
			{
				$(this).parent().parent().find("input").val(e).change();
				
			}

}	


	
	
window.dropli = function() { 

var active_old=$(this).parent().parent().find(".slct").attr("data_src");
var active_new=$(this).find("a").attr("rel");

			  var f=$(this).find("a").text();
			  var e=$(this).find("a").attr("rel");
			  
			  if(active_old!=active_new)
			  {
				if(e!=0)
				{
					$(this).parents('.left_drop').find('label').addClass('active_label');	
				} else
					{
$(this).parents('.left_drop').find('label').removeClass('active_label');
					}
				  
				  
			    $(this).parent().find("li").removeClass("sel_active");
			    $(this).addClass("sel_active");
			  
			$(this).parents('.left_drop').removeClass('required_in_2018');
			  
			 // $(this).parent().parent().find(".slct").removeClass("active").html(f);
			   $(this).parent().parent().find(".slct").removeClass("active").empty().append(f);
			   $(this).parent().parent().find(".slct").attr("data_src",e);
				  $(this).parents('.list_2018').addClass('active_in_2018x');

				  //$(this).parent().parent().find(".drop").hide();
				  $(this).parent().parent().find(".drop").css("transform", "scaleY(0)");
			  
			   $(this).parent().parent().find("input").val(e).change();
			  } else
			  {
				 //$(this).parent().parent().find(".drop").hide();
				  $(this).parent().parent().find(".drop").css("transform", "scaleY(0)");
				  
				 $(this).parent().parent().find(".slct").removeClass("active"); 
			  }
		  

}
$(".drop").find("li").bind('click', dropli);

window.dropliradio = function() { 

var active_old=$(this).parent().parent().find(".slct").attr("data_src");
var active_new=$(this).find("a").attr("rel");

			  var f=$(this).find("a").text();
			  var e=$(this).find("a").attr("rel");
	var drop_object=$(this).parents('.drop-radio');
			  
	if ($(this).find('i').is(".active_task_cb")) 
		{
			$(this).find('i').removeClass("active_task_cb");
		} else
			{
				$(this).find('i').addClass("active_task_cb");
			}
	
	
	          //пробежаться по всей выбранному селекту
	 var select_li='';   
	var select_li_text=''; 
	drop_object.find('li').each(function(i,elem) {
	if ($(this).find('i').is(".active_task_cb")) {  if(select_li==''){select_li=$(this).find("a").attr("rel");
																	 select_li_text=$(this).find("a").text();
																	 } else {select_li=select_li+','+$(this).find("a").attr("rel");
																			select_li_text=select_li_text+', '+$(this).find("a").text();
																			}}
});
	
	
	if(drop_object.is('.js-no-nul-select'))
	{
		//есть класс который говорит что если убрать галки со всех то загарятся все сразу
		if(select_li=='')
			{
					drop_object.find('li').each(function(i,elem) {
	  if(select_li==''){select_li=$(this).find("a").attr("rel");
																	 select_li_text=$(this).find("a").text();
																	 } else {select_li=select_li+','+$(this).find("a").attr("rel");
																			select_li_text=select_li_text+', '+$(this).find("a").text();
																			}
});
				drop_object.find('i').addClass("active_task_cb");
			}
		
		
	}
	
	/*
				if(e!=0)
				{
					$(this).parents('.left_drop').find('label').addClass('active_label');	
				} else
					{
$(this).parents('.left_drop').find('label').removeClass('active_label');
					}
	*/			  
				  /*
			    $(this).parent().find("li").removeClass("sel_active");
			    $(this).addClass("sel_active");
			  */
			
			  
			 // $(this).parent().parent().find(".slct").removeClass("active").html(f);
			   $(this).parent().parent().find(".slct").empty().append(select_li_text);
			   $(this).parent().parent().find(".slct").attr("data_src",select_li);
			  
			   //$(this).parent().parent().find(".drop").hide();
				 // $(this).parent().parent().find(".drop").css("transform", "scaleY(0)");
			  
			   $(this).parent().parent().find("input").val(select_li).change();
			  
		  

}	
	
$(".drop-radio").find("li").bind('click', dropliradio);

	
//$('#save').bind('change', changesave);	

	function uploadRR_old(file,id) {

		var xhr = new XMLHttpRequest();

		// обработчики можно объединить в один,
		// если status == 200, то это успех, иначе ошибка
		xhr.onload = xhr.onerror = function() {
			// alert(this.status);
			if (this.status == 200) {

				$('[id_upload='+id+']').show(); //кнопка
				$('.scap_load_'+id).find('.scap_load__').width(0);
				$('.scap_load_'+id).hide();
				$('.scap_load_'+id).after();
				//UpdateImageReports(id);
				alert_message('ok','ваш профиль обновлен');
				autoReloadHak();
			} else {

				$('[id_upload='+id+']').show();
				$('.scap_load_'+id).find('.scap_load__').width(0);
				$('.scap_load_'+id).hide();
			}
		};

		// обработчик для закачки
		xhr.upload.onprogress = function(event) {
			$('[id_upload='+id+']').hide();
			$('.scap_load_'+id).show();
			var widths=Math.round((event.loaded*100)/event.total);
			$('.scap_load_'+id).find('.scap_load__').width(widths+'%');
		}

		xhr.open("POST", "users/upload.php", true);
		//xhr.send(file);

		var formData = new FormData();
		formData.append("thefile", file);
		formData.append("id",id);
		xhr.send(formData);

	}







/*клик на раскрывающее меню сортировка снабжение*/



/*клик на раскрывающее меню сортировка снабжение*/
var changesort2 = function() {  
$.cookie("su_2", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_2",$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');
if($(this).val()==2)
{
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
	//alert("!");
	//$('.bookingBox_range').show();
}

};
$('#sort2').bind('change', changesort2);	
	
	
//$('[list_number=t2]').next().find('li').bind('click', list_number);



var changesort1 = function() { 
	//alert("1");
$.cookie("su_1", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_1",$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort1').bind('change', changesort1);	


	
var changesort_stock3 = function() {  
$.cookie("su_st_3", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_st_3",$(this).val(),'add');
$('.show_sort_stock').removeClass('active_supply');
$('.show_sort_stock').addClass('active_supply');	

};
$('#sort_stock3').bind('change', changesort_stock3);		
	

var changesort_stock1 = function() {  
$.cookie("su_st_1", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_st_1",$(this).val(),'add');
$('.show_sort_stock').removeClass('active_supply');
$('.show_sort_stock').addClass('active_supply');	

};
$('#sort_stock1').bind('change', changesort_stock1);	
	
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

var changesort_stock2__o= function() {  
	var iu=$('.content').attr('iu');
	$(this).prev().val('');
    $.cookie("su_7co"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
	$('.js--sort').removeClass('greei_input');
	$('.js--sort').find('input').removeAttr('readonly');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');
	
	$(this).hide();	
}
	
	








	


	
var changesort3 = function() {  
$.cookie("su_3", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_3",$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort3').bind('change', changesort3);	
	
	
var changesort4 = function() {  
$.cookie("su_4", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_4",$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort4').bind('change', changesort4);	
	
var changesort5 = function() {  
$.cookie("su_5", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_5",$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');

};
$('#sort5').bind('change', changesort5);	
	
	
var changesort6 = function() {  
$.cookie("su_6", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_6",$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort6').bind('change', changesort6);	


//***************************************************************************************
//***************************************************************************************
//***************************************************************************************		





$('#sort2c').bind('change', changesort2c);		

var changesort3c = function() {
var iu=$('.content').attr('iu');	
$.cookie("su_3c"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_3c"+iu,$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort3c').bind('change', changesort3c);	
	
	
var changesort4c = function() {  
var iu=$('.content').attr('iu');	
$.cookie("su_4c"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_4c"+iu,$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort4c').bind('change', changesort4c);	
	

$('#sort5c').bind('change', changesort5c);		


	var changesort7ct = function() {
		var iu=$('.content').attr('iu');
		$.cookie("su_7cu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_7cu"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');

	};


$('#name_stock_search_tours').bind('change keyup input click', changesort7ct);

	
//***************************************************************************************
//***************************************************************************************
//***************************************************************************************		
	





var changesort1co = function() {
var iu=$('.content').attr('iu');	
	
$.cookie("su_1co"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_1co"+iu,$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		

};
$('#sort1co').bind('change', changesort1co);		


var changesort5co = function() {  
var iu=$('.content').attr('iu');	
$.cookie("su_5co"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_5co"+iu,$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	
};
$('#sort5co').bind('change', changesort5co);		
		
var changesort7co = function() {  
var iu=$('.content').attr('iu');	
$.cookie("su_7co"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_7co"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	
	
};	
$('#name_stock_searcho').bind('change keyup input click', changesort7co);	
	
//***************************************************************************************
//***************************************************************************************
	var changesort5tu = function() {
		var iu=$('.content').attr('iu');

		$.cookie("su_5tu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_5tu"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');
	};
	$('#sort5tu').bind('change', changesort5tu);
//***************************************************************************************
	//***************************************************************************************
	var changesort4tu = function() {
		var iu=$('.content').attr('iu');

		$.cookie("su_4tu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_4tu"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');
	};
	$('#sort4tu').bind('change', changesort4tu);
//***************************************************************************************
	var changesort3tu = function() {
		var iu=$('.content').attr('iu');

		$.cookie("su_3tu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_3tu"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');
	};
	$('#sort3tu').bind('change', changesort3tu);
//***************************************************************************************	
	var changesort2tu = function() {
		var iu=$('.content').attr('iu');

		$.cookie("su_2tu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_2tu"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');
	};
	$('#sort2tu').bind('change', changesort2tu);
//***************************************************************************************
	var changesort1tu = function() {
		var iu=$('.content').attr('iu');

		$.cookie("su_1tu"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_1tu"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');
	};
	$('#sort1tu').bind('change', changesort1tu);








var changesort2ta = function() {  
var iu=$('.content').attr('iu');
	
$.cookie("su_2ta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_2ta"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		
};
$('#sort2ta').bind('change', changesort2ta);		

	
var changesort1ta = function() {  
var iu=$('.content').attr('iu');
	
$.cookie("su_1ta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_1ta"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		
};
$('#sort1ta').bind('change', changesort1ta);	


var changesort4ta = function() {  
var iu=$('.content').attr('iu');
	
$.cookie("su_4ta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_4ta"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		
};
$('#sort4ta').bind('change', changesort4ta);	
	
var changesort3ta = function() {  
var iu=$('.content').attr('iu');
	
$.cookie("su_3ta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_3ta"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		
};
$('#sort3ta').bind('change', changesort3ta);
	
	
var changesort5ta = function() {  
var iu=$('.content').attr('iu');
	
$.cookie("su_5ta"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_5ta"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		
};
$('#sort5ta').bind('change', changesort5ta);	
	
var changesort2s = function() {  
var iu=$('.content').attr('iu');
	
$.cookie("su_2s"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_2s"+iu,$(this).val(),'add');
	
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');		
};
$('#sort2s').bind('change', changesort2s);



	var changesort2f = function() {
		var iu=$('.content').attr('iu');

		$.cookie("su_2f"+iu, null, {path:'/',domain: window.is_session,secure: false});
		CookieList("su_2f"+iu,$(this).val(),'add');

		$('.js-reload-top').removeClass('active-r');
		$('.js-reload-top').addClass('active-r');
	};
	$('#sort2f').bind('change', changesort2f);


	var changesort5s = function() {

var iu=$('.content').attr('iu');
	
$.cookie("su_5s"+iu, null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("su_5s"+iu,$(this).val(),'add');
$('.js-reload-top').removeClass('active-r');
$('.js-reload-top').addClass('active-r');	

};
$('#sort5s').bind('change', changesort5s);		

	
	


});
 


//постфункция отправки сообщения
function AfterSendMM(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		//добавляем сообщение в панель
		if($('.sego_mess').length==0)
		{
			$('.padding_mess').append('<div class="dialog_clear"></div><div class="message_date"><div><span class="sego_mess">сегодня</span></div></div>');	
		}
		$('.padding_mess').append('<div class="dialog_clear"></div>'+data.echo);
		scroll_to_bottom(2000);
		$('#otziv_area').val('');
	}
}

function changesort2c() {
	var iu=$('.content').attr('iu');

	$.cookie("su_2c"+iu, null, {path:'/',domain: window.is_session,secure: false});
	CookieList("su_2c"+iu,$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');
};

function changesort5c() {
	var iu=$('.content').attr('iu');
	$.cookie("su_5c"+iu, null, {path:'/',domain: window.is_session,secure: false});
	CookieList("su_5c"+iu,$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');
}

//постфункция добавление карточки клиента в форме добавление тура
function AfterCardClient(d,u)
{
	if ( d.status=='reg' )
    {
		WindowLogin();
	}	
	if ( d.status=='ok' )
    {
		if(u==1)
			{
				//добавление покупателя
				//покупатель
				$('.js-buy-turs-client').parents('.block-add-tours').find('.b_loading_small').remove();
				$('.js-buy-turs-client').parents('.block-add-tours').append(d.echo);
				
				$('.tot_buy_id').val(d.id_tabs);
				$('.tot_buy_type').val(d.tabs);
				
				if(d.tabs==1)
					{
						//если добавяем частное лицо как покупателя
				var fly_list_new=AddDellList($('.tot_fly_id').val(),d.id_tabs,'add');
				if(fly_list_new!=0)
					{
				$('.tot_fly_id').val(fly_list_new);
					}
						
					//вдруг покупатель которого мы добавляем уже есть в туристах
					//тогда
						//не прибавляем общее количество туристов
						//удаляем его из туристов так как он теперь будет в покупателях
					if($('.js-fly-my-tours').find('.info-client-ruler[id_rules='+d.id_tabs+']').length > 0) {
						$('.js-fly-my-tours').find('.info-client-ruler[id_rules='+d.id_tabs+']').remove();
					} else
						{
							  var count_turi=parseFloat($('.tot_fly_count').val());		
			    $('.tot_fly_count').val(count_turi+1);
						}
						
					
						
						UpdateNumberTuris();
					}
				
				
				//показать блок туристов этого тура
				$('.js-fly-my-tours').show();
				//добавляем в него этого же покупателя как туриста
				//$('.js-fly-my-tours').find('.buy_turs').before(d.echo1);
			}
		if(u==2)
			{
				//добавление дополнительного туриста / туристов
			
				$('.js-fly-turs-client').parents('.block-add-tours').find('.b_loading_small').remove();
				
				
				//показать кнопку добавить еще
				$('.js-fly-turs-client').parents('.buy_turs').show();
				
				//определить номера новых туристов
				//UpdateNumberTuris();
				
				
				//добавить в hidden новые данные по добавленным туристам
				//их может быть сразу несколько
				
				var cc = d.id_tabs.split(',');
	            
				if(cc.length==1)
				{
						
					var fly_list_new=AddDellList($('.tot_fly_id').val(),d.id_tabs,'add');
				if(fly_list_new!=0)
					{
				$('.tot_fly_id').val(fly_list_new);
				
                var count_turi=parseFloat($('.tot_fly_count').val());		
			    $('.tot_fly_count').val(count_turi+1);	
					
					//посмотреть вдруг он покупатель тогда просто уберем галку
						
					
					if($('.js-buy-my-tours').find('[id_rules='+d.id_tabs+']').length>0)
					{
						var new_sloja=$('.js-buy-my-tours').find('[id_rules='+d.id_tabs+']');
					   if(new_sloja.is('[type_co=1]')) {
							
						 new_sloja.find('.choice-radio i').removeClass('active_task_cb');
						 new_sloja.find('.js-loli-butt').removeClass('active_pass'); 
						 new_sloja.find('.loli_turs input').val(0);
						 new_sloja.addClass('active-turist-turs');
					     UpdateNumberTuris();	  						 						      
						   
					   } else
						   {
							   
							   
							   $('.js-fly-turs-client').parents('.buy_turs').before(d.echo1);
							   UpdateNumberTuris();
						   }
					} else
						   {
							   
							   
							   $('.js-fly-turs-client').parents('.buy_turs').before(d.echo1);
							   UpdateNumberTuris();
						   }
						
						
						
						
					}
					
				
					
				} else
					{
				
				var cc_pppe = d.echo1.split('/2/');		
						
	            for ( var t = 0; t < cc.length; t++ ) 
	            { 
		
					
					var fly_list_new=AddDellList($('.tot_fly_id').val(),cc[t],'add');
				if(fly_list_new!=0)
					{
				$('.tot_fly_id').val(fly_list_new);
				
                var count_turi=parseFloat($('.tot_fly_count').val());		
			    $('.tot_fly_count').val(count_turi+1);	
					
					if($('.js-buy-my-tours').find('[id_rules='+cc[t]+']').length>0)
					{
						
						var new_sloja=$('.js-buy-my-tours').find('[id_rules='+cc[t]+']');
					   if(new_sloja.is('[type_co=1]')) {
							
						 new_sloja.find('.choice-radio i').removeClass('active_task_cb');
						 new_sloja.find('.js-loli-butt').removeClass('active_pass'); 
						 new_sloja.find('.loli_turs input').val(0);
						 new_sloja.addClass('active-turist-turs');
					     UpdateNumberTuris();	  						 						      
						   
					   } else
						   {
							   
							   
							   $('.js-fly-turs-client').parents('.buy_turs').before(cc_pppe[t]);
							   UpdateNumberTuris();
						   }
					} else
						   {
							   
							   
							   $('.js-fly-turs-client').parents('.buy_turs').before(cc_pppe[t]);
							   UpdateNumberTuris();
						   }						
						
						
					}
					
					
	            }
					}
				
				
			}
		ToolTip();
	}
}


//постфункция авто определение обновились ли уведомления или задачи
function AfterNofi(data,update)
{
	nprogress=0;
	if ( data.status=='update' )
	{
		//узнаем что за новые уведомления у пользователя и выводим их
		var dialog=0;
		var date='';

		var data ='tk='+data.token;
		AjaxClient('notification','notification','GET',data,'AfterNotification','1',0,1);
	}
}



function AfterDellTask(data,update)
{
		if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }	
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	} 
	if ( data.status=='ok' )
    {
			if($('.js-global-task-link').length>0)
			{
				
			  	$('.task_block_global[id_task="'+update[0]+'"]').slideUp("slow", function() {$('.task_block_global[id_task="'+update[0]+'"]').remove();});
			}
	}
}


//постфункция удаление файла накладной (jpg)
function AfterDellImageInvoice(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	} 
	if ( data.status=='ok' )
    {
		$('.img_invoice').find('[sop='+update+']').remove();
		//если количество li 0 то прячем весь блог с файлами
		if($('.img_invoice').find('li').length==0)
		{
				$('.img_invoice').hide();
			
			   $('.dollor_yes').before('<div class="attach_no">нет товарного чека</div>');
			 
			
		}
		
		
		
		
	}
}


//постфункция удаление файла накладной (jpg)
function AfterDellImageReports(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	} 
	if ( data.status=='ok' )
    {
		$('.img_invoice').find('[sop='+update+']').remove();
		//если количество li 0 то прячем весь блог с файлами
		if($('.img_invoice').find('li').length==0)
		{
				$('.img_invoice').hide();
			
			   //$('.dollor_yes').before('<div class="attach_no">нет товарного чека</div>');
			 
			
		}
		
		
		
		
	}
}



//постфункция удаление файла счета (jpg) в счете
function AfterDellImageSupply(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	} 
	if ( data.status=='ok' )
    {
		$('.img_ssoply').find('[sop='+update+']').remove();
		//если количество li 0 то прячем весь блог с файлами
		if($('.img_ssoply').find('li').length==0)
		{
				$('.img_ssoply').hide();
		}
	}
}


//постфункция вкладки в турах
function AfterTabsInfoTrips(data,update)
{
	if(update!=null){ if (typeof(update) == "string") { update = update.split(','); } else { update[0]=update; } }

	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
$('.trips_block_global[id_trips='+update[1]+']').find('.px_bg_trips').empty().append(data.query);
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


//постфункция получения новой инфы по организации
function AfterUpdateOrg(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
//название
//директор
//юр адрес
		
//телефон контактного лица
//email

//ИНН		
//КПП
//ОГРН
//ОКПО
		
//РАСЧЕТНЫЙ СЧЕТ
//БИК
//БАНК
//Кор. счет		

		var class_glu = ["js-glo-n-", "js-glo-d-","js-glo-a-",
						
						 "js-glo-t-",
						 "js-glo-e-",
						 
						 "js-glo-in-",
						 "js-glo-kp-",
						 "js-glo-og-",
						 "js-glo-ok-",
						 
						 "js-glo-rs-",
						 "js-glo-bi-",
						 "js-glo-ba-",
						 "js-glo-ko-",
						
						
						];
		
		var aaaa = data.echo.split('/-');
		
		var int_pass=0;
		var inn_pass=0;
		
		for (var t = 0; t < aaaa.length; t++) 
		{ 
		    if((aaaa[t]!='0')&&(aaaa[t]!='dell'))
			{
				$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);	
				
				if($('.js-buy-my-tours').length > 0) {
					//это добавление или внутренность тура тут свои правило обновления информации
					if(t<5)
						{
							
							$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);
									
						} else
						{
							//все что связано со счетами организации
							$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);
							
							
							//коды
							if((t>=5)&&(t<9))
							{
								if((aaaa[t]!='—')&&(aaaa[t]!='0'))
								{int_pass++;}
							}
							
							if(int_pass!=0)
							{
									$('.label-empty-code-'+update).hide();
								    $('.label-filled-code-'+update).show();
							} else
								{
									$('.label-empty-code-'+update).show();
								    $('.label-filled-code-'+update).hide();								
								}
							
							//банковские реквизиты
							if((t>=9)&&(t<13))
							{
								if((aaaa[t]!='—')&&(aaaa[t]!='0'))
								{inn_pass++;}
							}
							
							if(inn_pass!=0)
							{
									$('.label-empty-rek-'+update).hide();
								    $('.label-filled-rek-'+update).show();
							} else
								{
									$('.label-empty-rek-'+update).show();
								    $('.label-filled-rek-'+update).hide();								
								}
							
						}
					
					
				} else{
					$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);
				}
				
			}
		    if(aaaa[t]=='dell')
			{
				if(t==1)
					{
				$('.'+class_glu[t]+update).hide();	
					}
				
			}			
		}
		
	}
}



function click_mmmt ()
{
	nall_buy_tips();
}

//постфункция получения новой инфы по Финансам
function AfterUpdateFinance(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
//Доходы и Расходы
//График продаж
//Структура доходов
//Структура расходов


		var class_glu = ["js-fin-0", "js-fin-1", "js-fin-2","js-fin-3"];




		var int_pass=0;
		var inn_pass=0;
		var aaaa = update.split(',');
		for (var t = 0; t < 4; t++)
		{
			if(aaaa[t]!='0')
			{
				if(t==0) {
					$('.' + class_glu[t]).empty().show().append(data.echo);
					animation_graf();
				}
				if(t==1) {
					window.chart2.data=data.chart2;
				}
				if(t==2) {
					window.chart.data=data.chart;
					setTimeout ( function () { legendCreate(); }, 1000 );
				}
				if(t==3) {

					window.chart1.data=data.chart1;
					setTimeout ( function () { legendCreate1(); }, 1000 );

				}

			}
		}

	}
}


//постфункция получения новой инфы по клиенту
function AfterUpdateUser(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {	
		//Фио
//День рождение
//последнее сообщение
//вылет
//прилет
//телефон
		
//пол
//латиница

//загран серия
//загран номер
//загран кем
//загран когда выдан
//загран до какого

//внпаспорт серия
//внпаспорт номер
//внпаспорт кем
//внпаспорт когда выдан		
		
		var class_glu = ["js-glu-f-", "js-glu-d-", "js-glu-s-","js-glu-fs-","js-glu-fe-","js-glu-t-",
						"js-glu-pol-",
						"js-glu-latin-",
						
						"js-glu-ints-",
						 "js-glu-intn-",
						 "js-glu-intk-",
						 "js-glu-intko-",
						 "js-glu-intd-",
						 
						 "js-glu-ines-",
						 "js-glu-inen-",
						 "js-glu-inek-",
						 "js-glu-ineko-"
						
						];
		
		var aaaa = data.echo.split('/-');

		
		var int_pass=0;
		var inn_pass=0;
		for (var t = 0; t < aaaa.length; t++) 
		{ 
		    if((aaaa[t]!='0')&&(aaaa[t]!='dell'))
			{
				$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);	
				
				if($('.js-buy-my-tours').length > 0) {
					//это добавление или внутренность тура тут свои правило обновления информации
					if(t<8)
						{
							if(t==6)
								{
									//пол
									if(aaaa[t]==1)
										{
											$('.'+class_glu[t]+update).empty().show().append('(MR)');
											$('.'+class_glu[t]+update).attr('data-tooltip','мистер');
										}
									if(aaaa[t]==2)
										{
											$('.'+class_glu[t]+update).empty().show().append('(MRS)');
											$('.'+class_glu[t]+update).attr('data-tooltip','миссис');
										}
								} else
									{
							$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);
									}
						} else
						{
							//все что связано с паспорт данными
							$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);
							
							
							//загран паспорт
							if((t>=8)&&(t<13))
							{
								if((aaaa[t]!='—')&&(aaaa[t]!='0'))
								{int_pass++;}
							}
							
							if(int_pass!=0)
							{
									$('.label-empty-int-'+update).hide();
								    $('.label-filled-int-'+update).show();
							} else
								{
									$('.label-empty-int-'+update).show();
								    $('.label-filled-int-'+update).hide();								
								}
							
							//внутренний пасспорт
							if((t>=13)&&(t<17))
							{
								if((aaaa[t]!='—')&&(aaaa[t]!='0'))
								{inn_pass++;}
							}
							
							if(inn_pass!=0)
							{
									$('.label-empty-inn-'+update).hide();
								    $('.label-filled-inn-'+update).show();
							} else
								{
									$('.label-empty-inn-'+update).show();
								    $('.label-filled-inn-'+update).hide();								
								}
							
						}
					
					
				} else{
					$('.'+class_glu[t]+update).empty().show().append(aaaa[t]);
				}
				
				
			}
		    if(aaaa[t]=='dell')
			{
				if(t==2)
					{
				$('.'+class_glu[t]+update).hide();	
					}
				
			}			
		}
		
	}
}

//постфункция я жду на берусь за эту задачу
function AfterMyTask(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='error' )
    {	
		//почему то не прошло изменение
	var taski=$('.task_clock_selection[id_task="'+update+'"]').find('.js-choice-task-y');
	var i_c=taski.find('i')
	var cb_h=taski.find('input').val();
	
	if(i_c.is(':visible')) 
	   {
	
	if((cb_h==0)&&(!i_c.is('.active_task_cb')))
		{
			  taski.find('input').val(1);
			  taski.find('.choice-radio i').addClass('active_task_cb');
			  taski.find('.choice-head').empty().append('Вы взялись за выполнение');
		} else
			{
			  taski.find('input').val(0);
			  taski.find('.choice-radio i').removeClass('active_task_cb');
			}
}
	}
}

//постфункция для ежемесячного платежа
function AfterConstBuy(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='error' )
	{
		//почему то не прошло изменение
		var taski=$('.buy_block_global[id_buy="'+update+'"]').find('.js-choice-buy-y');
		var i_c=taski.find('i')
		var cb_h=taski.find('input').val();

		if(i_c.is(':visible'))
		{

			if((cb_h==0)&&(!i_c.is('.active_task_cb')))
			{
				taski.find('input').val(1);
				taski.find('.choice-radio i').addClass('active_task_cb');
				//taski.find('.choice-head').empty().append('Вы взялись за выполнение');
			} else
			{
				taski.find('input').val(0);
				taski.find('.choice-radio i').removeClass('active_task_cb');
			}
		}
	}
}


//постфункция обновление фоток по накладной
function AfterUpdateImageReports(data,update)
{
	nprogress=0;
	if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		$('.img_invoice').find('ul').empty().append(data.echo);
		$('.img_invoice').show();
		ToolTip();
		
		if($('.img_invoice').find('li').length!=0)
		{				
			   $('.attach_no').remove();	
		}
		
		
	}
		}
}

//постфункция обновление фоток по накладной
function AfterUpdateImageInvoice(data,update)
{
	nprogress=0;
	if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		$('.img_invoice').find('ul').empty().append(data.echo);
		$('.img_invoice').show();
		ToolTip();
		
		if($('.img_invoice').find('li').length!=0)
		{				
			   $('.attach_no').remove();	
		}
		
		
	}
		}
}

//постфункция обновление фоток по счету
function AfterUpdateImageSupply(data,update)
{
	nprogress=0;
	if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		$('.img_ssoply').find('ul').empty().append(data.echo);
		$('.img_ssoply').show();
		ToolTip();
	}
		}
}

//удаление заявки постфункция
function AfterDellBoo(data,update)
{
	nprogress=0;
	if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		//узнаем что за новые уведомления у пользователя и выводим 
		$('[rel_notib='+update+']').remove();	
		
	} else
			{
				$('[rel_notib='+update+']').show();
				
			}
		}
}



function AfterUpdateTaskBiAdd(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		$('.js-message-task-search').slideUp("slow");
		$('.js-global-task-link').prepend(data.echo);
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say'); }, 4000 );
		
	}
}
}

function AfterUpdateTaskBi(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		
		$('.task_block_global[id_task='+update+']').after(data.echo);
		$('.new-say').prev('.task_block_global').remove();		
		setTimeout ( function () { $( '.new-say ' ).removeClass('new-say'); }, 4000 );
		
	}
}
}
//постфункция удаление уведомления
function AfterDellNot(data,update)
{
	nprogress=0;
	if ( data.status=='reg' )
    {
		WindowLogin();
	} else
		{
	if ( data.status=='ok' )
    {
		//узнаем что за новые уведомления у пользователя и выводим 
		$('[rel_noti='+update+']').remove();	
		if( $('.noti_block').is(':visible') ) {
		var tips=parseInt(trim_number($('.noti_block').find('.noti_coc').text()));
		 if ((tips!='')&&(tips!=0))
			 {
				 tips=tips-1;
				 if(tips==0)
				 {
						$('.noti_block').remove();
					    $('.view__not').hide();
					    $('.not_li').find('i').hide();
				 }
				 {
					 $('.noti_block').find('.noti_coc').empty().append(tips);
					  $('.not_li').find('i').empty().append(tips);
					 
				 }
			 }
		}
		
	} else
			{
				$('[rel_noti='+update+']').show();
				
			}
		}
}

//постфункция получение новых уведомлений
function AfterVVN(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {

		$('.noti_block').find('.scro').empty().append(data.echo);
		$('.noti_block').find('.noti_coc').empty().append(data.not);
		$('.noti_block').find('.noti_co').show();
		$('.notif_div_2018').on("click",'.del_notif',DellNotif);	
	}
}

//постфункция получения новых задач
function AfterCloudTask(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		
		$('.users_rule').attr('tas',data.key);
		
		//удаление чего нет
		for ( var t = 0; t < 4; t++ ) { 
		   //$('.js-ring-'+t).
		   $('.js-ring-'+t).find('.task_clock_selection').each(function(i,elem) {
	            var id_old=$(this).attr('id_task');
			   //есть ли он в нужном массиве в новом списке
			   if( data.cloud_day[t].indexOf( id_old ) == -1 )
				   {
					   /*$('.js-ring-'+t).find('[id_task='+id_old+']').slideUp("slow",function() {$(this).remove();});
					   */
					   $('.js-ring-'+t).find('[id_task='+id_old+']').remove();
				   }
           });  
		}
		//Скрыть весь блок если там не осталось не одной задачи
		
		var count_fa=0;
		for ( var t = 0; t < 4; t++ ) { 
			if(data.cloud_day[t].length==0)
			{
				$('.js-ring-'+t).hide();
				if(t!=3)
				{
				   count_fa++;	
				}
			}
		}

		//Обновление существующих задач данных
		$.each(data.cloud, function(index, value){
			//value[0]
			//смотрим есть ли такая задача
			//alert($('.js-ring-'+value[0]).find('.task_clock_selection[id_task="'+value[2]+'"]').length);
			if($('.js-ring-'+value[0]).find('.task_clock_selection[id_task="'+value[2]+'"]').length>0)
				{
					//просто обновить данные в существующей задаче
					var ko_block=$('.task_clock_selection[id_task="'+value[2]+'"]');
					
					if(index!=3)
					{
						if((value[1]==1)||(value[1]==2))
							{
								ko_block.find('.ring-comm').empty().append(value[5]);  //текст
							}
					} else
						{
					ko_block.find('.ring-comm').empty().append(value[5]);  //текст
						}
					
					if(index!=3)
					{
					   ko_block.find('.task__time1').empty().append(value[6]);  //время
					} else
					{
					   ko_block.find('.red__task').empty().append(value[6]);  //время			
					}
					
					if(value[1]==2)
						{
							//это общая задача смотрим кто выбрал ее
						if(value[7]==0)
							{
								//нет ответственных и выбравших эту задачу
								ko_block.find('.choice-head').empty().append('Забрать задачу на себя');
								ko_block.find('.choice-radio i').removeClass('active_task_cb').show();
								ko_block.find('.choice-radio input').val(0);
								
							} else
								{
									if(value[8]==1)
							        {
										ko_block.find('.choice-head').empty().append('Вы взялись за выполнение');
										
										ko_block.find('.choice-radio i').show().addClass('active_task_cb');
										ko_block.find('.choice-radio input').val(1);
										
									} else
									{
										ko_block.find('.choice-head').empty().append('Задачу выполняет → <strong>'+value[7]+'</strong>');
										ko_block.find('.choice-radio input').val(0);
										ko_block.find('.choice-radio i').removeClass('active_task_cb').hide();
									}
									
								}
							
						//ko_block.('.choice-head').empty().append(value[5]);
						}
				}
			else
				{
					//добавить новую задачу
					
					//открывает весь блок куда добавл. задача, вдруг его было не видно
					var bbg=$('.js-ring-'+value[0]);
					//alert(value[0]);
					bbg.show();
					var temp_task='';
					var red_a='';
					var class_bb='';
					if(value[0]==3)
						{
					red_a='red_all';
					class_bb='task-ring';		
						}
					if(value[1]==3)
						{
							//день рождение 1,2,3,4 блок
							if(value[0]!=3) { class_bb='birthday-ring';	}	
							
							temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+class_bb+' '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb">';
							if(value[0]!=3) {
								//1,2,3 блок
							    temp_task=temp_task+'<span>День рождения</span>';
							} else
							{
								//4 блок	
								temp_task=temp_task+'<span>Задача №'+value[2]+'</span>';	
							}
							temp_task=temp_task+', <span class="js-client ring-user js-glu-f-'+value[11]+'" iod="'+value[11]+'">«'+value[4]+'»</span>';
							
								if(value[0]==3)
								{
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>';		
								} else
								{
							temp_task=temp_task+'<div class="ring-comm"></div>';
								}
							
							
							temp_task=temp_task+'</div><div class="ring-time">';
							if(value[0]==3)
								{
							temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
								}
							
							temp_task=temp_task+'<div rel_taskk="'+value[2]+'" data-tooltip="Отметить как выполнена" class="task__click1"></div></div></div></div>';
						}
			
					if((value[1]==5)||(value[1]==4))
					{
							//вылетает/прилетает 1,2,3 блок
							if(value[1]==5)
								{
									var flt='flyend-ring';
									var flt1='fly-ring-end';
								} else
								{
									var flt='flystart-ring';	
									var flt1='fly-ring-start';
								}
						if(value[0]==3)
								{
									//4 блок
									var flt='task-ring';
									var flt1='';
								}
													
							
							temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+flt+' '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb">';
							if(value[0]!=3)
								{
							temp_task=temp_task+'<a href="booking/'+value[9]+'/"><strong>'+value[10]+'</strong></a>';
								} else
									{
										//4 блок	
								temp_task=temp_task+'<span>Задача №'+value[2]+'</span>';
									}
								
								
								temp_task=temp_task+', <span class="js-client ring-user js-glu-f-'+value[11]+'" iod="'+value[11]+'">«'+value[4]+'»</span>';
							
							if(value[0]==3)
								{
							temp_task=temp_task+'<div><a href="booking/'+value[9]+'/"><strong>'+value[10]+'</strong></a></div>';
								}
							if(value[0]==3)
								{
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>';		
								} else
								{
							temp_task=temp_task+'<div class="ring-comm"></div>';
								}
							temp_task=temp_task+'</div><div class="ring-time">';
							if(value[0]!=3)
								{
							temp_task=temp_task+'<div class="task__time1 '+flt1+'">'+value[6]+'</div>';
								} else
									{
										temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
									}
							temp_task=temp_task+'<div rel_taskk="'+value[2]+'" data-tooltip="Отметить как выполнена" class="task__click1"></div></div></div></div>';
						}


					if((value[1]==6)||(value[1]==7))
					{
						//вылетает/прилетает
						if(value[1]==7)
						{
							var flt='flyend-ring';
							var flt1='fly-ring-end';
						} else
						{
							var flt='flystart-ring';
							var flt1='fly-ring-start';
						}
						if(value[0]==3)
						{
							//4 блок
							var flt='task-ring';
							var flt1='';
						}


						temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+flt+' '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a>';
						} else
						{
							//4 блок
							temp_task=temp_task+'<span>Задача №'+value[2]+'</span>';
						}


						var as = value[11].split('-');

						if(as[0]==1) {
							//частное лицо
							temp_task = temp_task + ', <span class="js-client ring-user js-glu-f-' + as[1] + '" iod="' + as[1] + '">«' + value[4] + '»</span>';
						} else
						{
							//организация
							temp_task = temp_task + ', <span class="js-org ring-user js-glo-f-' + as[1] + '" iod="' + as[1] + '">«' + value[4] + '»</span>';
						}


						if(value[0]==3)
						{
							temp_task=temp_task+'<div><a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a></div>';
						}
						if(value[0]==3)
						{
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>';
						} else
						{
							temp_task=temp_task+'<div class="ring-comm"></div>';
						}
						temp_task=temp_task+'</div><div class="ring-time">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<div class="task__time1 '+flt1+'">'+value[6]+'</div>';
						} else
						{
							temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
						}
						temp_task=temp_task+'</div></div></div>';
					}



					if((value[1]==9))
					{
						//впечатление туры

							var flt='flychat-ring';
							var flt1='';

						if(value[0]==3)
						{
							//4 блок
							var flt='task-ring';
							var flt1='';
						}


						temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+flt+' '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a>';
						} else
						{
							//4 блок
							temp_task=temp_task+'<span>Задача №'+value[2]+'</span>';
						}


						if(value[0]!=3) {
							temp_task = temp_task + ', <span class="ring-user">Узнать впечатление по туру</span>';
						}



						if(value[0]==3)
						{
							temp_task=temp_task+'<div><a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a></div>';
						}
						if(value[0]==3)
						{
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>';
						} else
						{
							temp_task=temp_task+'<div class="ring-comm"></div>';
						}
						temp_task=temp_task+'</div><div class="ring-time">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<div class="task__time1 '+flt1+'"></div>';
						} else
						{
							temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
						}
						temp_task=temp_task+'<div rel_taskk="'+value[2]+'" data-tooltip="Отметить как выполнена" class="task__click1"></div></div></div></div>';
					}


					if((value[1]==8))
					{
						//срок оплаты от клиента

						var flt='flymoney-ring';
						var flt1='';

						if(value[0]==3)
						{
							//4 блок
							var flt='task-ring';
							var flt1='';
						}


						temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+flt+' '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a>';
						} else
						{
							//4 блок
							temp_task=temp_task+'<span>Задача №'+value[2]+'</span>';
						}


						if(value[0]!=3) {
							temp_task = temp_task + ', <span class="ring-user">Срок оплаты от клиента</span>';
						}



						if(value[0]==3)
						{
							temp_task=temp_task+'<div><a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a></div>';
						}
						if(value[0]==3)
						{
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>';
						} else
						{
							temp_task=temp_task+'<div class="ring-comm"></div>';
						}
						temp_task=temp_task+'</div><div class="ring-time">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<div class="task__time1 '+flt1+'"></div>';
						} else
						{
							temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
						}
						temp_task=temp_task+'</div></div></div>';
					}

					if((value[1]==10))
					{
						//срок оплаты туроператора

						var flt='flymoney-ring';
						var flt1='';

						if(value[0]==3)
						{
							//4 блок
							var flt='task-ring';
							var flt1='';
						}


						temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+flt+' '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a>';
						} else
						{
							//4 блок
							temp_task=temp_task+'<span>Задача №'+value[2]+'</span>';
						}


						if(value[0]!=3) {
							temp_task = temp_task + ', <span class="ring-user">Срок оплаты туроператору</span>';
						}



						if(value[0]==3)
						{
							temp_task=temp_task+'<div><a href="tours/.id-'+value[9]+'"><strong>'+value[10]+'</strong></a></div>';
						}
						if(value[0]==3)
						{
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>';
						} else
						{
							temp_task=temp_task+'<div class="ring-comm"></div>';
						}
						temp_task=temp_task+'</div><div class="ring-time">';
						if(value[0]!=3)
						{
							temp_task=temp_task+'<div class="task__time1 '+flt1+'"></div>';
						} else
						{
							temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
						}
						temp_task=temp_task+'</div></div></div>';
					}

					if(((value[1]==1)||(value[1]==2)))
						{
							//просто или общая задача 1,2,3,4 блок
							
							if(value[1]==1)
								{
									//простая
									var prs='task-ring';
									var prs1='Задача';
									var prs2='';
								} else
								{
									//общая
									var prs='task-ring-all';	
									var prs1='Общая задача';
				
							if(value[7]==0)
							{
								var prs2='<div class="ring-comm-option"><div class="input-choice-click-task"><div class="choice-head">Забрать задачу на себя</div><div class="choice-radio"><div class="center_vert1"><i class=""></i><input name="" id="" value="0" type="hidden"></div></div></div></div>';
								
							} else
								{
									if(value[8]==1)
							        {
											var prs2='<div class="ring-comm-option"><div class="input-choice-click-task js-choice-task-y"><div class="choice-head">Вы взялись за выполнение</div><div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i><input name="" id="" value="1" type="hidden"></div></div></div></div>';
										
									} else
									{
										
											var prs2='<div class="ring-comm-option"><div class="input-choice-click-task"><div class="choice-head">Задачу выполняет → <strong>'+value[7]+'</strong></div><div class="choice-radio"><div class="center_vert1"><i style="display:none;" class="active_task_cb"></i><input name="" id="" value="0" type="hidden"></div></div></div></div>';
									}
									
								}
									
									
									
								}
							
							temp_task='<div id_task="'+value[2]+'" class="new-task task_clock_selection '+prs+'  '+red_a+'"><div class="task_clock_selection1"><div class="clock_cbb"><i></i></div><div class="why_task_cbb"><span>'+prs1+' №'+value[2]+'</span>';
							
							if(value[3]!=0)
								{
							//с кем то связана
									if(value[3]==1)
										{
											//частное/потенц
							temp_task=temp_task+', <span class="js-client ring-user js-glu-f-'+value[11]+'" iod="'+value[11]+'">«'+value[4]+'»</span>';
										}
								if(value[3]==2)
										{
											//организация
							temp_task=temp_task+', <span class="js-org ring-user js-glo-n-'+value[11]+'" iod="'+value[11]+'">«'+value[4]+'»</span>';
										}									
								}
									
							temp_task=temp_task+'<div class="ring-comm">'+value[5]+'</div>'+prs2+'</div><div class="ring-time">';
							
														if(value[0]==3)
								{
									temp_task=temp_task+'<span class="red__task">'+value[6]+'</span>';
								} else
									{
										temp_task=temp_task+'<div class="task__time1">'+value[6]+'</div>';
									}
							
							
							
							temp_task=temp_task+'<div rel_taskk="'+value[2]+'" data-tooltip="Отметить как выполнена" class="task__click1"></div></div></div></div>';
						}
					
					bbg.find('.block-ring-x').prepend(temp_task);
					
			
					setTimeout ( function () { $('.task_clock_selection[id_task="'+value[2]+'"]').removeClass('new-task'); }, 4000 );
					
					

					

					
				}

        });	
		
		
		
							//разбираемся с кнопками еще для блоков сегодня, завтра, послезавтра, просроченные
			for ( var t = 0; t < 4; t++ ) { 
					var eshe_jv=$('.js-ring-'+t).find('.eshe-ring');
					var max=eshe_jv.attr('max');
					var all_block=$('.js-ring-'+t).find('.task_clock_selection').length;
					var no_visible=parseInt(all_block)-parseInt(max);
				//alert(no_visible);
					
					var eshe_v=0;
					var eshe_o=0;
					if(eshe_jv.is(':visible'))
						{
							//уже показывается кнопка
							var eshe_v=1;
						}
					if(eshe_jv.is('.active-ring'))
						{
							//уже открыта
							var eshe_o=1;
						}
					
					if(eshe_v==0)
					{
						//не было видно но теперь видно и один надо скрыть
						if(all_block>max)
						{
 						   eshe_jv.show();
						   eshe_jv.find('.ring-x1').empty().append('еще '+no_visible);

						   //скрыть те которые невидимые должны быть
						   $('.js-ring-'+t).find('.task_clock_selection').removeClass('max-day-ring');
							
						   $('.js-ring-'+t).find('.task_clock_selection').each(function(i,elem) {
							   
							   if(i>=max)
								   {
									   $(this).addClass('max-day-ring').hide();
								   }
							   
						   });
							
							
						}
					}
					if(((eshe_v==1)&&(eshe_o==0)))
					{
						//кнопка еще уже есть и видна Но не нажата раскрыть все
                        eshe_jv.find('.ring-x1').empty().append('еще '+no_visible);
						$('.js-ring-'+t).find('.task_clock_selection').removeClass('max-day-ring');
						$('.js-ring-'+t).find('.task_clock_selection').each(function(i,elem) {
							   
							   if(i>=max)
								   {
									   $(this).addClass('max-day-ring').hide();
								   }
							   
						   });
					}
					if(((eshe_v==1)&&(eshe_o==1)))
					{
						//кнопка еще уже есть и видна и раскрыта показать все
						 eshe_jv.find('.ring-x1').empty().append('еще '+no_visible);
						 $('.js-ring-'+t).find('.task_clock_selection').removeClass('max-day-ring');
							
						   $('.js-ring-'+t).find('.task_clock_selection').each(function(i,elem) {
							   
							   if(i>=max)
								   {
									   $(this).addClass('max-day-ring');
								   }
							   
						   });
					}	
					
					
					if(all_block<=max)
					{
						//alert("!");
						eshe_jv.hide();
					}
			}
		
		
		
					//показать или скрыть всю правую сторону задач. вдруг там нет
					
					if(count_fa==3)
					{
							//Скрыть вообще правую часть
						    $('.task-left').css("width", "100%");
						    $('.task-right').hide();
					} else
					{
						    $('.task-left').css("width", "50%");
						    $('.task-right').show();							
					}	
		
		
	}
}


//постфункция определение новых уведомлений
function AfterNotification(data,update)
{
	if ( data.status=='reg' )
	{
		WindowLogin();
	}

	if ( data.status=='ok' )
	{
		$('.users_rule').attr('not',data.tk);
		if(data.not==0)
		{
			//скрываем уведомления и количество ставим 0	
			$('.not_li').find('i').empty();
			$('.not_li').find('i').hide();
			$('.view__not').hide();
		} else
		{
			$('.not_li').find('i').empty().append(data.not);
			$('.not_li').find('i').show();
			$('.view__not').css( "display", "inline-block" );
			$('#chatAudio')[0].play();

			alert_message('ok','У вас новые уведомления');


		}

	}
}
	
	
function AfterMESS(data,update)
{
		if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		$('.content_block').attr('n',data.n_st);
		$('.history_message').attr('s_m',data.poo);
		var B = document.body;
		var sc=B.scrollHeight;
		
		$('.padding_mess').prepend(data.echo);
	
		
		window.scrollTo(0,(B.scrollHeight - sc  + B.scrollTop));
		if( data.eshe==1 )
			{
		$('.padding_mess').prepend($('.history_message'));
		$('.history_message').show();
			} else
				{
					$('.history_message').remove();
				}
	}
		if ( data.status=='error' )
    {
		$('.history_message').remove();
	}
	
}




function AfterTest(data,update)
{
	$('.js-cloud').empty().append(data.test);
}


function AfterSaveAnswer(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='error' )
    {
		$('[op_rel='+update+']').find('.save_anna').show();
	}
}



//меню выбора города-квартала и дома в себестоимости
//меню выбора города-квартала и дома в себестоимости
//меню выбора города-квартала и дома в себестоимости


/* Modernizr 2.5.3 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransforms3d-csstransitions-shiv-cssclasses-teststyles-testprop-testallprops-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function z(a){j.cssText=a}function A(a,b){return z(m.join(a+";")+(b||""))}function B(a,b){return typeof a===b}function C(a,b){return!!~(""+a).indexOf(b)}function D(a,b){for(var d in a)if(j[a[d]]!==c)return b=="pfx"?a[d]:!0;return!1}function E(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:B(f,"function")?f.bind(d||b):f}return!1}function F(a,b,c){var d=a.charAt(0).toUpperCase()+a.substr(1),e=(a+" "+o.join(d+" ")+d).split(" ");return B(b,"string")||B(b,"undefined")?D(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),E(e,b,c))}var d="2.5.3",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k=b.createElement("div"),l=b.body,m=l?l:b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),k.appendChild(j);return f=["­","<style>",a,"</style>"].join(""),k.id=h,(l?k:m).innerHTML+=f,m.appendChild(k),l||(m.style.background="",g.appendChild(m)),i=c(k,a),l?k.parentNode.removeChild(k):m.parentNode.removeChild(m),!!i},x={}.hasOwnProperty,y;!B(x,"undefined")&&!B(x.call,"undefined")?y=function(a,b){return x.call(a,b)}:y=function(a,b){return b in a&&B(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e});var G=function(a,c){var d=a.join(""),f=c.length;w(d,function(a,c){var d=b.styleSheets[b.styleSheets.length-1],g=d?d.cssRules&&d.cssRules[0]?d.cssRules[0].cssText:d.cssText||"":"",h=a.childNodes,i={};while(f--)i[h[f].id]=h[f];e.csstransforms3d=(i.csstransforms3d&&i.csstransforms3d.offsetLeft)===9&&i.csstransforms3d.offsetHeight===3},f,c)}([,["@media (",m.join("transform-3d),("),h,")","{#csstransforms3d{left:9px;position:absolute;height:3px;}}"].join("")],[,"csstransforms3d"]);q.csstransforms3d=function(){var a=!!F("perspective");return a&&"webkitPerspective"in g.style&&(a=e.csstransforms3d),a},q.csstransitions=function(){return F("transition")};for(var H in q)y(q,H)&&(v=H.toLowerCase(),e[v]=q[H](),t.push((e[v]?"":"no-")+v));return z(""),i=k=null,function(a,b){function g(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function h(){var a=k.elements;return typeof a=="string"?a.split(" "):a}function i(a){var b={},c=a.createElement,e=a.createDocumentFragment,f=e();a.createElement=function(a){var e=(b[a]||(b[a]=c(a))).cloneNode();return k.shivMethods&&e.canHaveChildren&&!d.test(a)?f.appendChild(e):e},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+h().join().replace(/\w+/g,function(a){return b[a]=c(a),f.createElement(a),'c("'+a+'")'})+");return n}")(k,f)}function j(a){var b;return a.documentShived?a:(k.shivCSS&&!e&&(b=!!g(a,"article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}audio{display:none}canvas,video{display:inline-block;*display:inline;*zoom:1}[hidden]{display:none}audio[controls]{display:inline-block;*display:inline;*zoom:1}mark{background:#FF0;color:#000}")),f||(b=!i(a)),b&&(a.documentShived=b),a)}var c=a.html5||{},d=/^<|^(?:button|form|map|select|textarea)$/i,e,f;(function(){var a=b.createElement("a");a.innerHTML="<xyz></xyz>",e="hidden"in a,f=a.childNodes.length==1||function(){try{b.createElement("a")}catch(a){return!0}var c=b.createDocumentFragment();return typeof c.cloneNode=="undefined"||typeof c.createDocumentFragment=="undefined"||typeof c.createElement=="undefined"}()})();var k={elements:c.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:c.shivCSS!==!1,shivMethods:c.shivMethods!==!1,type:"default",shivDocument:j};a.html5=k,j(b)}(this,b),e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.testProp=function(a){return D([a])},e.testAllProps=F,e.testStyles=w,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+t.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return o.call(a)=="[object Function]"}function e(a){return typeof a=="string"}function f(){}function g(a){return!a||a=="loaded"||a=="complete"||a=="uninitialized"}function h(){var a=p.shift();q=1,a?a.t?m(function(){(a.t=="c"?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){a!="img"&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l={},o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};y[c]===1&&(r=1,y[c]=[],l=b.createElement(a)),a=="object"?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),a!="img"&&(r||y[c]===2?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i(b=="c"?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),p.length==1&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&o.call(a.opera)=="[object Opera]",l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return o.call(a)=="[object Array]"},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,i){var j=b(a),l=j.autoCallback;j.url.split(".").pop().split("?").shift(),j.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]||h),j.instead?j.instead(a,e,f,g,i):(y[j.url]?j.noexec=!0:y[j.url]=1,f.load(j.url,j.forceCSS||!j.forceJS&&"css"==j.url.split(".").pop().split("?").shift()?"c":c,j.noexec,j.attrs,j.timeout),(d(e)||d(l))&&f.load(function(){k(),e&&e(j.origUrl,i,g),l&&l(j.origUrl,i,g),y[j.url]=2})))}function i(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var j,l,m=this.yepnope.loader;if(e(a))g(a,0,m,0);else if(w(a))for(j=0;j<a.length;j++)l=a[j],e(l)?g(l,0,m,0):w(l)?B(l):Object(l)===l&&i(l,m);else Object(a)===a&&i(a,m)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,b.readyState==null&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};



<!--
//v1.7
// Flash Player Version Detection
// Detect Client Browser type
// Copyright 2005-2008 Adobe Systems Incorporated.  All rights reserved.
var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;
function ControlVersion()
{
	var version;
	var axo;
	var e;
	// NOTE : new ActiveXObject(strFoo) throws an exception if strFoo isn't in the registry
	try {
		// version will be set for 7.X or greater players
		axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
		version = axo.GetVariable("$version");
	} catch (e) {
	}
	if (!version)
	{
		try {
			// version will be set for 6.X players only
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
			
			// installed player is some revision of 6.0
			// GetVariable("$version") crashes for versions 6.0.22 through 6.0.29,
			// so we have to be careful. 
			
			// default to the first public version
			version = "WIN 6,0,21,0";
			// throws if AllowScripAccess does not exist (introduced in 6.0r47)		
			axo.AllowScriptAccess = "always";
			// safe to call for 6.0r47 or greater
			version = axo.GetVariable("$version");
		} catch (e) {
		}
	}
	if (!version)
	{
		try {
			// version will be set for 4.X or 5.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = axo.GetVariable("$version");
		} catch (e) {
		}
	}
	if (!version)
	{
		try {
			// version will be set for 3.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = "WIN 3,0,18,0";
		} catch (e) {
		}
	}
	if (!version)
	{
		try {
			// version will be set for 2.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			version = "WIN 2,0,0,11";
		} catch (e) {
			version = -1;
		}
	}
	
	return version;
}
// JavaScript helper required to detect Flash Player PlugIn version information
function GetSwfVer(){
	// NS/Opera version >= 3 check for Flash plugin in plugin array
	var flashVer = -1;
	
	if (navigator.plugins != null && navigator.plugins.length > 0) {
		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
			var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
			var descArray = flashDescription.split(" ");
			var tempArrayMajor = descArray[2].split(".");			
			var versionMajor = tempArrayMajor[0];
			var versionMinor = tempArrayMajor[1];
			var versionRevision = descArray[3];
			if (versionRevision == "") {
				versionRevision = descArray[4];
			}
			if (versionRevision[0] == "d") {
				versionRevision = versionRevision.substring(1);
			} else if (versionRevision[0] == "r") {
				versionRevision = versionRevision.substring(1);
				if (versionRevision.indexOf("d") > 0) {
					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
				}
			}
			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
		}
	}
	// MSN/WebTV 2.6 supports Flash 4
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
	// WebTV 2.5 supports Flash 3
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
	// older WebTV supports Flash 2
	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
	else if ( isIE && isWin && !isOpera ) {
		flashVer = ControlVersion();
	}	
	return flashVer;
}
// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available
function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)
{
	versionStr = GetSwfVer();
	if (versionStr == -1 ) {
		return false;
	} else if (versionStr != 0) {
		if(isIE && isWin && !isOpera) {
			// Given "WIN 2,0,0,11"
			tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]
			tempString        = tempArray[1];			// "2,0,0,11"
			versionArray      = tempString.split(",");	// ['2', '0', '0', '11']
		} else {
			versionArray      = versionStr.split(".");
		}
		var versionMajor      = versionArray[0];
		var versionMinor      = versionArray[1];
		var versionRevision   = versionArray[2];
        	// is the major.revision >= requested major.revision AND the minor version >= requested minor
		if (versionMajor > parseFloat(reqMajorVer)) {
			return true;
		} else if (versionMajor == parseFloat(reqMajorVer)) {
			if (versionMinor > parseFloat(reqMinorVer))
				return true;
			else if (versionMinor == parseFloat(reqMinorVer)) {
				if (versionRevision >= parseFloat(reqRevision))
					return true;
			}
		}
		return false;
	}
}
function AC_AddExtension(src, ext)
{
  if (src.indexOf('?') != -1)
    return src.replace(/\?/, ext+'?'); 
  else
    return src + ext;
}
function AC_Generateobj(objAttrs, params, embedAttrs) 
{ 
  var str = '';
  if (isIE && isWin && !isOpera)
  {
    str += '<object ';
    for (var i in objAttrs)
    {
      str += i + '="' + objAttrs[i] + '" ';
    }
    str += '>';
    for (var i in params)
    {
      str += '<param name="' + i + '" value="' + params[i] + '" /> ';
    }
    str += '</object>';
  }
  else
  {
    str += '<embed ';
    for (var i in embedAttrs)
    {
      str += i + '="' + embedAttrs[i] + '" ';
    }
    str += '> </embed>';
  }
  document.write(str);
}
function AC_FL_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
     , "application/x-shockwave-flash"
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}
function AC_SW_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000"
     , null
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}
function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
  var ret = new Object();
  ret.embedAttrs = new Object();
  ret.params = new Object();
  ret.objAttrs = new Object();
  for (var i=0; i < args.length; i=i+2){
    var currArg = args[i].toLowerCase();    
    switch (currArg){	
      case "classid":
        break;
      case "pluginspage":
        ret.embedAttrs[args[i]] = args[i+1];
        break;
      case "src":
      case "movie":	
        args[i+1] = AC_AddExtension(args[i+1], ext);
        ret.embedAttrs["src"] = args[i+1];
        ret.params[srcParamName] = args[i+1];
        break;
      case "onafterupdate":
      case "onbeforeupdate":
      case "onblur":
      case "oncellchange":
      case "onclick":
      case "ondblclick":
      case "ondrag":
      case "ondragend":
      case "ondragenter":
      case "ondragleave":
      case "ondragover":
      case "ondrop":
      case "onfinish":
      case "onfocus":
      case "onhelp":
      case "onmousedown":
      case "onmouseup":
      case "onmouseover":
      case "onmousemove":
      case "onmouseout":
      case "onkeypress":
      case "onkeydown":
      case "onkeyup":
      case "onload":
      case "onlosecapture":
      case "onpropertychange":
      case "onreadystatechange":
      case "onrowsdelete":
      case "onrowenter":
      case "onrowexit":
      case "onrowsinserted":
      case "onstart":
      case "onscroll":
      case "onbeforeeditfocus":
      case "onactivate":
      case "onbeforedeactivate":
      case "ondeactivate":
      case "type":
      case "codebase":
      case "id":
        ret.objAttrs[args[i]] = args[i+1];
        break;
      case "width":
      case "height":
      case "align":
      case "vspace": 
      case "hspace":
      case "class":
      case "title":
      case "accesskey":
      case "name":
      case "tabindex":
        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
        break;
      default:
        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
    }
  }
  ret.objAttrs["classid"] = classid;
  if (mimeType) ret.embedAttrs["type"] = mimeType;
  return ret;
}


(function($) {

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// ----------------------------------------- DATA ----------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

	var Data = {

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ defaults

		//default settings values
		defaults: {
			//style
			width: '100%', 
			size: 'medium', 
			themes: [], 
			//texts
			placeholder: 'Select an item', 
			//controls
			removable: false, 
			empty: false, 
			search: false, 
			//ajax
			ajax: false, 
			data: {}, 
			//positionning
			scrollContainer: null, 
			zIndex: null
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ setDefaults

		//set default settings values
		setup: function(opts) {
			//controls provided settings keys
			var defKeys = Object.keys(this.defaults);
			var optKeys = Object.keys(opts);
			var isOk = true;
			optKeys.forEach(function(k) {
				if($.inArray(k, defKeys) === -1) {
					console.error('selectMania | wrong setup settings');
					isOk = false;
				}
			});
			//if provided settings are ok
			if(isOk) {
				this.defaults = $.extend(true, {}, Data.defaults, opts);
			}
		}

	};

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// ---------------------------------------- ENGINE ---------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

	var Engine = {

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ internalSettings

		//insert internal data into settings object
		internalSettings: function($originalSelect, settings) {
			var thisEngine = this;
			//initialize interal data
			settings.multiple = false;
			settings.values = [];
			//if select is multiple
			settings.multiple = $originalSelect.is('[multiple]');
			//if select is disabled
			settings.disabled = $originalSelect.is('[disabled]');
			//loop through selected options
			$originalSelect.find('option:selected').each(function() {
				//insert selected value data
				settings.values.push({
					value: this.value, 
					text: this.text
				});
			});
			//send back settings
			return settings;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ getAttrSettings

		//get selectMania settings stored as attributes
		getAttrSettings: function($originalSelect) {
			var attrData = {};
			//available attributes
			var attrs = ['width','size','placeholder','removable','empty','search','scrollContainer','zIndex'];
			//loop through attributes
			attrs.forEach(function(attr) {
				//if attribute is set on select
				if($originalSelect.is('[data-'+attr+']')) {
					//insert data
					var elAttr = $originalSelect.attr('data-'+attr);
					if(elAttr === 'true' || elAttr === 'false') {
						elAttr = elAttr === 'true';
					}
					attrData[attr] = elAttr;
				}
			});
			//send back select attributes data
			return attrData;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ initialize

		//initialize selectMania on original select
		initialize: function($originalSelect, userSettings) {
			var thisEngine = this;
			//clone settings before starting work
			var settings = $.extend(true, {}, userSettings);
			//get select settings stored as attributes
			var attrSettings = thisEngine.getAttrSettings($originalSelect);
			//merge settings with attributes
			settings = $.extend(settings, attrSettings);
			//set selected value as empty if explicitly asked
			if(settings.empty) {
				$originalSelect.val('');
			}
			//insert internal data into settings
			settings = thisEngine.internalSettings($originalSelect, settings);
			//control ajax function type and size
			if(thisEngine.controlSettings($originalSelect, settings)) {
				//build selectMania elements
				var $builtSelect = Build.build($originalSelect, settings);
				//attach original select element to selectMania element
				$builtSelect.data('selectMania-originalSelect', $originalSelect);
				//attach selectMania element to original select element
				$originalSelect.data('selectMania-element', $builtSelect);
				//if ajax is activated
				if(settings.ajax !== false) {
					//initialize ajax data
					thisEngine.initAjax($builtSelect, settings);
				}
				//update clean values icon display
				thisEngine.updateClean($builtSelect);
				//add witness / hding class original select element
				$originalSelect.addClass('select-mania-original');
				//insert selectMania element before original select
				$builtSelect.insertBefore($originalSelect);
				//move original select into selectMania element
				$originalSelect.appendTo($builtSelect);
				//bind selectMania element
				Binds.bind($builtSelect);
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ update

		//update selectMania element according to original select element
		update: function($originalSelect) {
			var thisEngine = this;
			//selectMania elements
			var $selectManiaEl = $originalSelect.data('selectMania-element');
			var $valueList = $selectManiaEl.find('.select-mania-values').first();
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			var $itemList = $dropdown.find('.select-mania-items').first();
			//update disabled status
			if($originalSelect.is('[disabled]')) {
				$selectManiaEl.addClass('select-mania-disabled');
			}
			else {
				$selectManiaEl.removeClass('select-mania-disabled');
			}
			//remove selectMania values and items
			$selectManiaEl.find('.select-mania-value').remove();
			$itemList.empty();
			//build and insert selected values
			$originalSelect.find('option:selected').each(function() {
				if($(this).is(':selected')) {
					$valueList.append(Build.buildValue({
						value: this.value, 
						text: this.text
					}));
				}
			});
			//build and insert items
			$itemList.append(Build.buildItemList($originalSelect.children()));
			//update clean values icon display
			thisEngine.updateClean($selectManiaEl);
			//rebind selectMania element
			Binds.bind($selectManiaEl);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ destroy

		//destroy selectMania on targeted original select
		destroy: function($originalSelect) {
			//selectMania element
			var $selectManiaEl = $originalSelect.data('selectMania-element');
			//move original select out of the selectMania element
			$originalSelect.insertAfter($selectManiaEl);
			//remove selectMania element
			$selectManiaEl.remove();
			//remove class from original select
			$originalSelect.removeClass('select-mania-original');
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ openDropdown / closeDropdown

		//open items dropdown
		openDropdown: function($dropdown) {
			var thisEngine = this;
			//select-mania element
			var $selectManiaEl = $dropdown.closest('.select-mania');
			//if scroll container option is set
			if($selectManiaEl.is('[data-selectMania-scrollContainer]')) {
				//scroll container element
				var $scrollContainer = $($selectManiaEl.attr('data-selectMania-scrollContainer'));
				//position absolute dropdown
				Engine.positionDropdown($dropdown);
				//apply positionning class
				$dropdown.addClass('select-mania-absolute');
				//bind scroll container to close dropdown on scroll
				$scrollContainer.off('scroll.selectMania').on('scroll.selectMania', function() {
					//unbind close dropdown on scrolling
					$scrollContainer.off('scroll.selectMania');
					//close open dropdown
					Engine.closeDropdown($('.select-mania-dropdown.open'));
				});
				//reposition dropdown when window is resized
				$(window).off('resize.selectMania').on('resize.selectMania', function() {
					//position absolute dropdown
					Engine.positionDropdown($dropdown);
				});
			}
			//open dropdown
			$dropdown.stop().addClass('open').slideDown(100);
			//scroll dropdown to top
			$dropdown.find('.select-mania-items').scrollTop(0);
			//focus search input
			thisEngine.focusSearch($dropdown);
			//bind keyboard control
			$(document).off('keydown.selectMania').on('keydown.selectMania', Binds.keyboardControl);
		}, 

		//close items dropdown
		closeDropdown: function($dropdown) {
			var $selectManiaEl = $dropdown.data('selectMania-element');
			//unbind keyboard control
			$(document).off('keydown.selectMania');
			//remove every hover class from items
			$dropdown.find('.select-mania-item').removeClass('select-mania-hover');
			//if dropdown has aboslute positionning
			if($dropdown.hasClass('select-mania-absolute')) {
				//select-mania inner element
				var $selectManiaInner = $dropdown
					.data('selectMania-element')
					.find('.select-mania-inner')
					.first();
				//move back the dropdown inside select-mania element
				$dropdown
					.removeClass('open')
					.hide()
					.insertAfter(
						$selectManiaInner
					);
				//unbind repositioning on resize
				$(window).off('resize.selectMania');
				//unbind close dropdown on scrolling
				var $scrollContainer = $($selectManiaEl.attr('data-selectMania-scrollContainer'));
				if($scrollContainer.length > 0) {
					$scrollContainer.off('scroll.selectMania');
				}
			}
			//if dropdown has standard positionning
			else {
				//close dropdown
				$dropdown.stop().removeClass('open').slideUp(100);
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ positionDropdown

		//position dropdown relative to its select-mania element
		positionDropdown: function($dropdown) {
			var $selectManiaEl = $dropdown.data('selectMania-element');
			//item list scroll data
			var $itemList = $dropdown.find('.select-mania-items');
			var itemListScroll = $itemList.scrollTop();
			//data for calculating dropdown absolute position
			var selectManiaElPos = $selectManiaEl.offset();
			var selectManiaElWidth = $selectManiaEl.outerWidth();
			var selectManiaElHeight = $selectManiaEl.outerHeight();
			//append dropdown to body in absolute position
			$dropdown.appendTo('body').css({
				position: 'absolute', 
				top: selectManiaElPos.top + selectManiaElHeight, 
				left: selectManiaElPos.left, 
				width: selectManiaElWidth
			});
			//force item list scroll to its initial state
			$itemList.scrollTop(itemListScroll);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ selectItem

		//perform item selection in dropdown
		selectItem: function($item) {
			//dropdown element
			var $dropdown = $item.closest('.select-mania-dropdown');
			//selectMania element
			var $selectManiaEl = $dropdown.data('selectMania-element');
			//select original element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			//if item not already selected
			if(!$item.is('.select-mania-selected')) {
				//clicked item value
				var itemVal = $item.attr('data-value');
				
				//build value element
				var $value = Build.buildValue({
					
					value: itemVal, 
					text: $item.text()
				});
				//if select multiple
				if($selectManiaEl.is('.select-mania-multiple')) {
					//insert value element in selectMania values
					$selectManiaEl.find('.select-mania-values').append($value);
					//add value in original select element
					Engine.addMultipleVal($originalSelect, itemVal);
				}
				//if select not multiple
				else {
					//unselect every other items
					$dropdown.find('.select-mania-item').removeClass('select-mania-selected');
					//insert value element in selectMania values
					$selectManiaEl.find('.select-mania-values .select-mania-value').remove();
					$selectManiaEl.find('.select-mania-values').append($value);
					//change value in original select element
					$originalSelect.val(itemVal);
				}
				//set clicked item as selected
				$item.addClass('select-mania-selected');
				//trigger original select change event
				$originalSelect.trigger('change');
			}
			//if absolute position dropdown
			if($dropdown.is('.select-mania-absolute')) {
				//position absolute dropdown
				Engine.positionDropdown($dropdown);
			}
			//if select not multiple
			if(!$selectManiaEl.is('.select-mania-multiple')) {
				//close dropdown
				Engine.closeDropdown($dropdown);
			}
			//update clear values icon display
			Engine.updateClean($selectManiaEl);
			//rebind selectMania element
			Binds.bind($selectManiaEl);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ focusSearch

		//focus search input in dropdown
		focusSearch: function($dropdown) {
			$dropdown.find('.select-mania-search-input').focus();
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ addMultipleVal

		//add value to multiple original select
		addMultipleVal: function($originalSelect, val) {
			var originalVals = $originalSelect.val();
			if(!(originalVals instanceof Array)) {
				originalVals = [];
			}
			originalVals.push(val);
			$originalSelect.val(originalVals);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ removeMultipleVal

		//remove value from multiple original select
		removeMultipleVal: function($originalSelect, val) {
			var originalVals = $originalSelect.val();
			if(!(originalVals instanceof Array)) {
				originalVals = [];
			}
			originalVals.splice($.inArray(val, originalVals), 1);
			$originalSelect.val(originalVals);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ updateClean

		//display / hide clean values icon according to current values
		updateClean: function($selectManiaEl) {
			//original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			//if value is not empty
			if($originalSelect.val() !== null && $originalSelect.val().length > 0) {
				//display clean values icon
				$selectManiaEl.find('.select-mania-clear-icon').show();
			}
			//if empty value
			else {
				//hide clean values icon
				$selectManiaEl.find('.select-mania-clear-icon').hide();
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ doSearch

		//do search in items dropdown
		doSearch: function($selectManiaEl) {
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//search value
			var searchVal = $dropdown.find('.select-mania-search-input').first().val().toLowerCase().trim();
			//if empty search value
			if(searchVal === '') {
				//display all items
				$dropdown.find('.select-mania-group, .select-mania-item').removeClass('select-mania-hidden');
				//stop function
				return;
			}
			//loop through dropdown items
			$dropdown.find('.select-mania-item').each(function() {
				//if item text matches search value
				if($(this).text().toLowerCase().indexOf(searchVal) !== -1) {
					//display item
					$(this).removeClass('select-mania-hidden');
				}
				//if item text don't match search value
				else {
					//hide item
					$(this).addClass('select-mania-hidden');
				}
			});
			//show / hide optgroups if contain results / empty
			$dropdown.find('.select-mania-group').each(function() {
				if($(this).find('.select-mania-item:not(.select-mania-hidden)').length > 0) {
					$(this).removeClass('select-mania-hidden');
				}
				else {
					$(this).addClass('select-mania-hidden');
				}
			});
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ doSearchAjax

		//do ajax search in items dropdown
		doSearchAjax: function($selectManiaEl) {
			var thisEngine = this;
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//search value
			var thisSearch = $dropdown.find('.select-mania-search-input').first().val();
			//pause ajax scroll
			$selectManiaEl.data('selectMania-ajaxReady', false);
			//reset current page number
			$selectManiaEl.data('selectMania-ajaxPage', 1);
			//loading icon
			thisEngine.dropdownLoading($selectManiaEl);
			//call ajax function
			var thisAjaxFunction = $selectManiaEl.data('selectMania-ajaxFunction');
			var thisAjaxData = $selectManiaEl.data('selectMania-ajaxData');
			thisAjaxFunction(thisSearch, 1, thisAjaxData, function(optHTML) {
				//remove loading icon
				thisEngine.dropdownLoading($selectManiaEl, true);
				//replace current items with sent options
				Engine.replaceItems($selectManiaEl, optHTML);
				//rebind select
				Binds.bind($selectManiaEl);
				//reset ajax scroll data
				thisEngine.initAjax($selectManiaEl);
			});
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ addItems / replaceItems

		//add items to dropdown
		addItems: function($selectManiaEl, optionsHTML) {
			var thisEngine = this;
			thisEngine.addOrReplaceItems($selectManiaEl, optionsHTML, false);
		}, 

		//replace dropdown items
		replaceItems: function($selectManiaEl, optionsHTML) {
			var thisEngine = this;
			thisEngine.addOrReplaceItems($selectManiaEl, optionsHTML, true);
		}, 

		//add / replace dropdown items
		addOrReplaceItems: function($selectManiaEl, optionsHTML, replace) {
			var thisEngine = this;
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			//items dropdown
			var $itemsContainer = $dropdown.find('.select-mania-items');
			//options jquery parsing
			var $options = $(optionsHTML);
			//get selectMania element values
			var selectedVals = thisEngine.getVal($selectManiaEl);
			//loop through selected values
			selectedVals.forEach(function(val) {
				$options
					//search for options matching selected value
					.filter(function() {
						return $(this).attr('value') === val.value && $(this).text() === val.text;
					})
					//set matching options as selected
					.prop('selected', true);
			});
			//build items list
			$builtItems = Build.buildItemList($options);
			//if items are meant to be replaced
			if(replace === true) {
				//empty old options except selected ones
				$originalSelect.find('option').remove(':not(:checked)');
				//empty items dropdown
				$itemsContainer.empty();
			}
			//add items to selectMania dropdown
			$itemsContainer.append($builtItems);
			//add options to original select element
			$originalSelect.append($options);
			//rebind selectMania element
			Binds.bind($selectManiaEl);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ initAjax

		//reset selectMania element ajax data and attach ajax function
		initAjax: function($selectManiaEl, settings) {
			//if ajax settings are provided to be attached
			if(typeof settings === 'object') {
				//attach ajax function
				if(settings.hasOwnProperty('ajax') && typeof settings.ajax === 'function') {
					$selectManiaEl.data('selectMania-ajaxFunction', settings.ajax);
				}
				//attach ajax data
				if(settings.hasOwnProperty('data') && typeof settings.data === 'object') {
					$selectManiaEl.data('selectMania-ajaxData', settings.data);
				}
			}
			//reset ajax data
			$selectManiaEl.data('selectMania-ajaxPage', 1);
			$selectManiaEl.data('selectMania-ajaxReady', true);
			$selectManiaEl.data('selectMania-ajaxScrollDone', false);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ dropdownLoading

		//display / hide loading icon inside items dropdown
		dropdownLoading: function($selectManiaEl, hide) {
			//if hide icon requested
			var isHide = false;
			if(typeof hide !== 'undefined' && hide === true) {
				isHide = true;
			}
			//dropdown inner list element
			var $dropdownContainer = $selectManiaEl.find('.select-mania-items-container').first();
			//remove loading icon if exists
			$dropdownContainer.find('.icon-loading-container').remove();
			//if show icon requested
			if(isHide !== true) {
				//build loading icon
				var $loadingIcon = $('<div class="icon-loading-container"></div>');
				$loadingIcon.append('<i class="icon-loading"></i>');
				//insert loading icon
				$dropdownContainer.append($loadingIcon);
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ getVal

		//get parsed selected values
		getVal: function($selectManiaEl) {
			var valObjs = [];
			//loop though values elements
			$selectManiaEl.find('.select-mania-value').each(function() {
				//selected value text
				var thisText = $(this).find('.select-mania-value-text').first().text();
				//insert selected value object
				valObjs.push({
					 
					value: $(this).attr('data-value'), 
					text: thisText
				});
			});
			//send back parsed selected values
			return valObjs;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ clear

		//clear select values
		clear: function($selectManiaEl) {
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//empty selectMania values
			$selectManiaEl.find('.select-mania-value').remove();
			//unselect items in dropdown
			$dropdown.find('.select-mania-item').removeClass('select-mania-selected');
			//empty values in original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			if($selectManiaEl.is('.select-mania-multiple')) {
				$originalSelect.val([]);
			}
			else {
				$originalSelect.val('');
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ setVal

		//set parsed values as selected values
		setVal: function($selectManiaEl, valObjs) {
			var thisEngine = this;
			//original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			//clear select values before setting provided values
			thisEngine.clear($selectManiaEl);
			//if there's more than one value in the values and select is not multiple
			if(valObjs.length > 1 && !$selectManiaEl.is('.select-mania-multiple')) {
				//keep only first value
				valObjs = valObjs.slice(0, 1);
			}
			//loop through values
			valObjs.forEach(function(val) {
				//parse value object
				var valObj = $.extend({
					value: '', 
					text: '', 
					selected: true
				}, val);
				//set value in selectMania element
				thisEngine.setOneValSelectMania($selectManiaEl, valObj);
				//set value in original select
				thisEngine.setOneValOriginal($originalSelect, valObj);
			});
			//update clean values icon display
			thisEngine.updateClean($selectManiaEl);
			//rebind selectMania element
			Binds.bind($selectManiaEl);
		}, 

		//set one value on selectMania element
		setOneValSelectMania: function($selectMania, valObj) {
			//build value element for selectMania element
			var $value = Build.buildValue(valObj);
			//insert built value element in selectMania element
			$selectMania.find('.select-mania-values').append($value);
			//check if corresponding item exists in dropdown
			var $searchItem = $selectMania.find('.select-mania-item[data-value="'+valObj.value+'"]').filter(function() {
				return $(this).text() === valObj.text;
			});
			//if item exists in dropdown
			if($searchItem.length > 0) {
				//set item as selected
				$searchItem.first().addClass('select-mania-selected');
			}
		}, 

		//set one value on original select element
		setOneValOriginal: function($originalSelect, valObj) {
			//check if corresponding option exists in original select
			var $searchOpt = $originalSelect.find('option[value="'+valObj.value+'"]').filter(function() {
				return $(this).text() === valObj.text;
			});
			//if option doesn't exist in original select
			if($searchOpt.length < 1) {
				//build option for original select
				var $option = Build.buildOption(valObj);
				//insert built option in original select
				$originalSelect.append($option);
			}
			//if option already exists in original select
			else {
				//fond option element
				var $foundOption = $searchOpt.first();
				//set option as selected
				$foundOption[0].selected = true;
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ controls

		//control target element
		controlTarget: function($target, controls) {
			//error if element is not a select
			if($.inArray('isSelect', controls) !== -1 && !$target.is('select')) {
				console.error('selectMania | invalid select element');
				console.log($target[0]);
				return false;
			}
			//error if plugin not initialized
			if($.inArray('isInitialized', controls) !== -1 && !$target.hasClass('select-mania-original')) {
				console.error('selectMania | select is not initialized');
				console.log($target[0]);
				return false;
			}
			//error if plugin already initialized
			if($.inArray('notInitialized', controls) !== -1 && $target.hasClass('select-mania-original')) {
				console.error('selectMania | ignore because already initialized');
				console.log($target[0]);
				return false;
			}
			//control method was called on single element
			if($.inArray('isSingle', controls) !== -1 && $target.length > 1) {
				console.error('selectMania | check method can be called on single element only');
				console.log($target[0]);
				return false;
			}
			//if control ok
			return true;
		}, 

		//control selectMania settings
		controlSettings: function($target, settings) {
			//control ajax function type
			if(settings.ajax !== false && typeof settings.ajax !== 'function') {
				settings.ajax = false;
				console.error('selectMania | invalid ajax function');
				console.log($target[0]);
				console.log(settings);
				return false;
			}
			//error if invalid size provided
			if($.inArray(settings.size, ['tiny','small','medium','large']) === -1) {
				settings.size = 'medium';
				console.error('selectMania | invalid size');
				console.log($target[0]);
				console.log(settings);
				return false;
			}
			//error if invalid sroll container provided
			if(settings.scrollContainer !== null && $(settings.scrollContainer).length < 1) {
				settings.scrollContainer = null;
				console.error('selectMania | invalid scroll container');
				console.log($target[0]);
				console.log(settings);
				return false;
			}
			//error if invalid sroll container provided
			if(settings.zIndex !== null && (isNaN(parseInt(settings.zIndex)) || !isFinite(settings.zIndex))) {
				settings.zIndex = null;
				console.error('selectMania | invalid z-index');
				console.log($target[0]);
				console.log(settings);
				return false;
			}
			//if control ok
			return true;
		}, 

		//control selectMania values
		controlValues: function($target, values) {
			//error if values is not an array
			if(!(values instanceof Array)) {
				console.error('selectMania | values parameter is not a valid array');
				console.log($target[0]);
				console.log(values);
				return false;
			}
			//if control ok
			return true;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ navigateItem

		//navigate hover to next or previous item in dropdown
		navigateItem: function($dropdown, nextOrPrevious) {
			//selectMania element
			var $selectManiaEl = $dropdown.closest('.select-mania');
			//item scrollable list
			var $itemList = $dropdown.find('.select-mania-items');
			//active enabled items
			var validItemSelector = '.select-mania-item:not(.select-mania-disabled):not(.select-mania-hidden)';
			if($selectManiaEl.hasClass('select-mania-multiple')) {
				validItemSelector += ':not(.select-mania-selected)';
			}
			var $validItems = $dropdown.find(validItemSelector);
			//current hovered item
			var $hoveredItem = $dropdown.find(validItemSelector+'.select-mania-hover');
			//item to target
			var $targetItem = $();
			//if there is currently a hovered item
			if($hoveredItem.length > 0) {
				//if arrow up get previous item
				if(nextOrPrevious === 'next') {
					$targetItem = $validItems.slice($validItems.index($hoveredItem) + 1).first();
				}
				//if arrow down get next item
				else if(nextOrPrevious === 'previous') {
					$targetItem = $validItems.slice(0, $validItems.index($hoveredItem)).last();
				}
			}
			//no current hovered item
			else {
				//hovers first item
				$targetItem = $validItems.first();
			}
			//if target item exists hover this item
			if($targetItem.length > 0) {
				//remove hover from every item
				$dropdown.find('.select-mania-item').removeClass('select-mania-hover');
				//add hover class to target item
				$targetItem.addClass('select-mania-hover');
				//data for item visibility calculation
				var $targetItemPosition = $targetItem.position();
				var $targetItemHeight = $targetItem.outerHeight(true);
				var $itemListHeight = $itemList.height();
				var $itemListScrollTop = $itemList.scrollTop();
				//if target item not visible in item list (above)
				if($targetItemPosition.top < 0) {
					//scroll to see item
					$itemList.scrollTop($itemListScrollTop + $targetItemPosition.top);
				}
				//if target item not visible in item list (below)
				else if($targetItemPosition.top + $targetItemHeight > $itemListHeight) {
					//scroll to see item
					$itemList.scrollTop($itemListScrollTop + $targetItemPosition.top + $targetItemHeight - $itemListHeight);
				}
			}
		}

	};

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// ---------------------------------------- BUILD ----------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

var Build = {

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ build

		//build selectMania element
		build: function($originalSelect, settings) {
			var thisBuild = this;
			//class for selectMania size
			var sizeClass = 'select-mania-'+settings.size;
			//explicit selectMania width style
			var widthStyle = 'style="width:'+settings.width+';"';
			//general selectMania div
			var $selectManiaEl = $('<div class="select-mania '+sizeClass+'" '+widthStyle+'></div>');
			//class for multiple
			if(settings.multiple) {
				$selectManiaEl.addClass('select-mania-multiple');
			}
			//class for disabled
			if(settings.disabled) {
				$selectManiaEl.addClass('select-mania-disabled');
			}
			//classes for themes
			if(settings.themes instanceof Array && settings.themes.length > 0) {
				//loop through themes
				settings.themes.forEach(function(theme) {
					//applies theme class
					$selectManiaEl.addClass('select-mania-theme-'+theme);
				});
			}
			//class for activated ajax
			if(settings.ajax !== false) {
				$selectManiaEl.addClass('select-mania-ajax');
			}
			//attribute for scroll container
			if(settings.scrollContainer !== null) {
				$selectManiaEl.attr('data-selectMania-scrollContainer', settings.scrollContainer);
			}
			//build inner elements
			var $innerElements = thisBuild.buildInner(settings);
			//build dropdown
			var $dropdown = thisBuild.buildDropdown($originalSelect, settings);
			//insert elements
			$selectManiaEl.append($innerElements).append($dropdown);
			//attach dropdown to select-mania element
			$selectManiaEl.data('selectMania-dropdown', $dropdown);
			//attach select-mania element to dropdown
			$dropdown.data('selectMania-element', $selectManiaEl);
			//send back selectMania element
			return $selectManiaEl;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildInner

		//build inner elements
		buildInner: function(settings) {
			var thisBuild = this;
			//inner div
			var $inner = $('<div class="select-mania-inner"></div>');
			//values div
			var $values = $('<div class="select-mania-values"></div>');
			//insert placeholder
			var $placeholder = $('<div class="select-mania-placeholder">'+settings.placeholder+'</div>');
			$values.append($placeholder);
			//insert selected values
			settings.values.forEach(function(val) {
				$values.append(thisBuild.buildValue(val));
			});
			$inner.append($values);
			//insert clean values icon
			var $clean = $('<div class="select-mania-clear"></div>');
			if(settings.removable || settings.multiple) {
				$clean.append('<i class="select-mania-clear-icon icon-cross">');
			}
			$inner.append($clean);
			$inner.append('<div class="select-mania-add"><i class="select-mania-add-icon icon-add"></div>');
			//insert dropdown arrow icon
			$inner.append($('<div class="select-mania-arrow"><i class="select-mania-arrow-icon icon-arrow-down"></i></div>'));
			//send back inner elements
			return $inner;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildValue

		//build selected value
		buildValue: function(valObj) {
			//selected value element html
			var valHtml = '<div class="select-mania-value"  data-value="'+valObj.value+'">'+
				'<div class="select-mania-value-text">'+valObj.text+'</div>'+
				'<div class="select-mania-value-clear">'+
					'<i class="select-mania-value-clear-icon icon-cross"></i>'+
				'</div>'+
			'</div>';
			//send back selected value element
			return $(valHtml);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildOption

		//build option for original select
		buildOption: function(valObj) {
			//build option
			var $opt = $('<option value="'+valObj.value+'">'+valObj.text+'</option>');
			//set option selected status
			$opt[0].selected = valObj.selected;
			//send back option element
			return $opt;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildDropdown

		//build items dropdown
		buildDropdown: function($originalSelect, settings) {
			var thisBuild = this;
			//class for sizing
			var sizeClass = 'select-mania-'+settings.size;
			//dropdown element
			var $dropdown = $('<div class="select-mania-dropdown '+sizeClass+'"></div>');
			//classe si select multiple
			if(settings.multiple) {
				$dropdown.addClass('select-mania-multiple');
			}
			//insert search input in dropdown if activated
			if(settings.search) {
				var $dropdownSearch = $('<div class="select-mania-dropdown-search"></div>');
				$dropdownSearch.append('<input class="select-mania-search-input" />');
				$dropdown.append($dropdownSearch);
			}
			//build items container
			var $itemListContainer = $('<div class="select-mania-items-container"></div>');
			var $itemList = $('<div class="select-mania-items"></div>');
			//build and insert items list
			$itemList.append(thisBuild.buildItemList($originalSelect.children()));
			//insert items list into dropdown
			$itemListContainer.append($itemList);
			$dropdown.append($itemListContainer);
			//classes for themes
			if(settings.themes instanceof Array && settings.themes.length > 0) {
				//loop through themes
				settings.themes.forEach(function(theme) {
					//applies theme class
					$dropdown.addClass('select-mania-theme-'+theme);
				});
			}
			//if zIndex setting is set
			if(settings.zIndex !== null) {
				$dropdown.css('z-index', settings.zIndex);
			}
			//send back items dropdown
			return $dropdown;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildItemGroup

		//build items list
		buildItemList: function($optList) {
			var thisBuild = this;
			//empty item list
			var $itemList = $();
			//loop through original select children
			$optList.each(function() {
				//if optgroup
				if($(this).is('optgroup')) {
					//build and insert item group
					$itemList = $itemList.add(thisBuild.buildItemGroup($(this)));
				}
				//if option
				else if($(this).is('option')) {
					//build and insert item
					$itemList = $itemList.add(thisBuild.buildItem($(this)));
				}
			});
			//send back build items list
			return $itemList;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildItemGroup

		//build dropdown items group
		buildItemGroup: function($optgroupEl) {
			var thisBuild = this;
			//build group element
			var $group = $('<div class="select-mania-group"></div>');
			var $groupInner = $('<div class="select-mania-group-inner"></div>');
			//build group title element
			var $groupTitle = $('<div class="select-mania-group-title"></div>');
			//if group icon is set
			if($optgroupEl.is('[data-icon]')) {
				//insert group title icon
				$groupTitle.append('<div class="select-mania-group-icon"><i class="'+$optgroupEl.attr('data-icon')+'"></i></div>');
			}
			//insert group title text
			$groupTitle.append('<div class="select-mania-group-text">'+$optgroupEl.attr('label')+'</div>');
			//insert group title in group element
			$group.append($groupTitle);
			//if group is disabled set class
			var groupIsDisabled = $optgroupEl.is(':disabled');
			if(groupIsDisabled) {
				$group.addClass('select-mania-disabled');
			}
			//build and insert items
			$optgroupEl.find('option').each(function() {
				$groupInner.append(thisBuild.buildItem($(this), groupIsDisabled));
			});
			$group.append($groupInner);
			//send back items group
			return $group;
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ buildItem

		//build dropdown item
		buildItem: function($optionEl, forceDisabled) {
			var optionEl = $optionEl[0];
			
			//build item html
			var $item = $('<div class="select-mania-item" data-value="'+optionEl.value+'"></div>');
			//if option icon is set
			
			if($optionEl.is('[class]')) {
				//insert item icon
				$item.addClass($optionEl.attr('class'));
			}
			
			
			if($optionEl.is('[data-icon]')) {
				//insert item icon
				$item.append('<div class="select-mania-item-icon"><i class="'+$optionEl.attr('data-icon')+'"></i></div>');
			}
			//insert item text
			$item.append('<div class="select-mania-item-text">'+optionEl.text+'</div>');
			//if item is disabled set class
			if($optionEl.is(':disabled') || Tools.def(forceDisabled) === true) {
				$item.addClass('select-mania-disabled');
			}
			//if item is selected add class
			if($optionEl.is(':selected')) {
				$item.addClass('select-mania-selected');
			}
			//send back item
			return $item;
		}

	};

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// ---------------------------------------- BINDS ----------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

	var Binds = {

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ bind

		//bind all selectMania controls
		bind: function($selectManiaEl) {
			var thisBinds = this;
			//original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//if select is not disabled
			if(!$selectManiaEl.is('.select-mania-disabled')) {
				//click outside select
				$(document).off('click.selectMania').on('click.selectMania', thisBinds.documentClick);
				//focus / blur original select element
				$originalSelect.off('focus.selectMania').on('focus.selectMania', thisBinds.focus);
				$originalSelect.off('blur.selectMania').on('blur.selectMania', thisBinds.blur);
				//clear values
				$selectManiaEl.find('.select-mania-clear-icon').off('click.selectMania').on('click.selectMania', thisBinds.clearValues);
				
				//добавить новый
				//$selectManiaEl.find('.select-mania-add-icon').off('click.selectMania').on('click.selectMania', thisBinds.add_mania);
				
				
				//clear select multiple individual value
				$selectManiaEl.find('.select-mania-value-clear-icon').off('click.selectMania').on('click.selectMania', thisBinds.clearValue);
				//open / close dropdown
				$selectManiaEl.find('.select-mania-inner').off('click.selectMania').on('click.selectMania', thisBinds.dropdownToggle);
				//item hover in dropdown
				$dropdown.find('.select-mania-item:not(.select-mania-disabled)').off('mouseenter.selectMania').on('mouseenter.selectMania', thisBinds.hoverItem);
				//item selection in dropdown
				$dropdown.find('.select-mania-item:not(.select-mania-disabled)').off('click.selectMania').on('click.selectMania', thisBinds.itemSelection);
				//search input in dropdown
				$dropdown.find('.select-mania-search-input').off('input.selectMania').on('input.selectMania', thisBinds.inputSearch);
				//prevents body scroll when reached dropdown top or bottom
				$dropdown.find('.select-mania-items').off('wheel.selectMania').on('wheel.selectMania', thisBinds.scrollControl);
				//ajax scroll
				if($selectManiaEl.is('.select-mania-ajax')) {
					$dropdown.find('.select-mania-items').off('scroll.selectMania').on('scroll.selectMania', thisBinds.scrollAjax);
				}
			}
			//if select is disabled unbind controls
			else {
				//focus / blur original select element
				$originalSelect.off('focus.selectMania');
				$originalSelect.off('blur.selectMania');
				//clear values
				$selectManiaEl.find('.select-mania-clear-icon').off('click.selectMania');
				//clear select multiple individual value
				$selectManiaEl.find('.select-mania-value-clear-icon').off('click.selectMania');
				//open / close dropdown
				$selectManiaEl.find('.select-mania-inner').off('click.selectMania');
				//item hover in dropdown
				$dropdown.find('.select-mania-item:not(.select-mania-disabled)').off('mouseenter.selectMania');
				//item selection in dropdown
				$dropdown.find('.select-mania-item:not(.select-mania-disabled)').off('click.selectMania');
				//search input in dropdown
				$dropdown.find('.select-mania-search-input').off('input.selectMania');
				//prevents body scroll when reached dropdown top or bottom
				$dropdown.find('.select-mania-items').off('wheel.selectMania');
				//ajax scroll
				$dropdown.find('.select-mania-items').off('scroll.selectMania');
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ dropdownToggle

		//BIND ONLY - open / close dropdown
		dropdownToggle: function(e) {
			e.stopPropagation();
			//select-mania element
			var $selectManiaEl = $(this).closest('.select-mania');
			//dropdown element
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//if dropdown open
			if($dropdown.is('.open')) {
				//close dropdown
				Engine.closeDropdown($dropdown);
			}
			//if dropdown closed
			else {
				//close every open dropdown
				Engine.closeDropdown($('.select-mania-dropdown.open'));
				//open target dropdown
				Engine.openDropdown($dropdown);
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ documentClick

		//BIND ONLY - click outside select
		documentClick: function(e) {
			//if click not in open dropdown
			if($(e.target).closest('.select-mania-dropdown').length < 1) {
				//close every open dropdown
				Engine.closeDropdown($('.select-mania-dropdown.open'));
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ clearValues

		//BIND ONLY - clear values
		clearValues: function(e) {
			e.stopPropagation();
			//selectMania element
			var $selectManiaEl = $(this).closest('.select-mania');
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			//clear values
			Engine.clear($selectManiaEl);
			//if absolute position dropdown
			if($dropdown.is('.select-mania-absolute')) {
				//position absolute dropdown
				Engine.positionDropdown($dropdown);
			}
			//trigger original select change event
			$originalSelect.trigger('change');
			//update clear values icon display
			Engine.updateClean($selectManiaEl);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ clearValue
     /*
		add_mania: function(e) {
			e.stopPropagation();
			$('.select-mania').hide();	
			$('.add_sklad_pl').show();
			$('.new_sklad_name').val(1);
		},
	*/	
		//BIND ONLY - clear select multiple individual value
		clearValue: function(e) {
			e.stopPropagation();
			//selectMania element
			var $selectManiaEl = $(this).closest('.select-mania');
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//value to delete
			var $value = $(this).closest('.select-mania-value');
			//unselect item in dropdown
			$dropdown
				.find('.select-mania-item[data-value="'+$value.attr('data-value')+'"]')
				.removeClass('select-mania-selected');
			//remove value from selectMania element
			$value.remove();
			//remove value from original select element
			var $originalSelect = $selectManiaEl.data('selectMania-originalSelect');
			Engine.removeMultipleVal($originalSelect, $value.attr('data-value'));
			//if absolute position dropdown
			if($dropdown.is('.select-mania-absolute')) {
				//position absolute dropdown
				Engine.positionDropdown($dropdown);
			}
			//trigger original select change event
			$originalSelect.trigger('change');
			//update clear values icon display
			Engine.updateClean($selectManiaEl);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ itemSelection

		//BIND ONLY - item selection in dropdown
		itemSelection: function() {
			var $selectedItem = $(this);
			//select item in dropdown
			Engine.selectItem($selectedItem);
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ inputSearch

		//BIND ONLY - dropdown search input
		inputSearch: function() {
			var $input = $(this);
			//selectMania element
			$selectManiaEl = $input.closest('.select-mania-dropdown').data('selectMania-element');
			//timer duration according to select multiple or not
			var thisTime = 200;
			if($selectManiaEl.is('.select-mania-ajax')) {
				thisTime = 400;
			}
			//clear timeout
			clearTimeout($input.data('selectMania-searchTimer'));
			//search input timeout
			$input.data('selectMania-searchTimer', setTimeout(function() {
				//ajax search
				if($selectManiaEl.is('.select-mania-ajax')) {
					Engine.doSearchAjax($selectManiaEl);
				}
				//normal search
				else {
					Engine.doSearch($selectManiaEl);
				}
			}, thisTime));
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ scrollAjax

		//BIND ONLY - dropdown ajax scroll
		scrollAjax: function(e) {
			var $itemList = $(this);
			//dropdown element
			var $dropdown = $itemList.closest('.select-mania-dropdown');
			//selectMania element
			var $selectManiaEl = $dropdown.data('selectMania-element');
			//if ajax scroll is not over
			if($selectManiaEl.data('selectMania-ajaxScrollDone') !== true) {
				//if scroll reached bottom with 12px tolerance
				if($itemList.scrollTop() >= $itemList[0].scrollHeight - $itemList.outerHeight() - 12) {
					//if ajax scroll is ready
					if($selectManiaEl.data('selectMania-ajaxReady') === true) {
						//page number to call
						var thisPage = $selectManiaEl.data('selectMania-ajaxPage') + 1;
						//search value
						var thisSearch = $selectManiaEl.find('.select-mania-search-input').first().val();
						//pause ajax scroll
						$selectManiaEl.data('selectMania-ajaxReady', false);
						//enregistre nouvelle page en cours
						$selectManiaEl.data('selectMania-ajaxPage', thisPage);
						//loading icon
						Engine.dropdownLoading($selectManiaEl);
						//call ajax function
						var thisAjaxFunction = $selectManiaEl.data('selectMania-ajaxFunction');
						var thisAjaxData = $selectManiaEl.data('selectMania-ajaxData');
						thisAjaxFunction(thisSearch, thisPage, thisAjaxData, function(optHTML) {
							//remove loading icon
							Engine.dropdownLoading($selectManiaEl, true);
							//if options returned
							if(optHTML.trim() !== '') {
								//add items to dropdown from sent options
								Engine.addItems($selectManiaEl, optHTML);
								//rebind selectMania element
								Binds.bind($selectManiaEl);
								//set ajax scroll as ready
								$selectManiaEl.data('selectMania-ajaxReady', true);
							}
							//if no options sent back
							else {
								//ajax scroll is over
								$selectManiaEl.data('selectMania-ajaxScrollDone', true);
							}
						});
					}
				}
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ scrollControl

		//BIND ONLY - prevents body scroll when reached dropdown top or bottom
		scrollControl: function(e) {
			var $thisDropdown = $(this);
			if(e.originalEvent.deltaY < 0) {
				return ($thisDropdown.scrollTop() > 0);
			}
			else {
				return($thisDropdown.scrollTop() + $thisDropdown.innerHeight() < $thisDropdown[0].scrollHeight);
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ focus / blur

		//BIND ONLY - focus selectMania when original select is focused
		focus: function(e) {
			var $originalSelect = $(this);
			//selectMania element
			var $selectManiaEl = $originalSelect.data('selectMania-element');
			//add focus class to selectMania element
			$selectManiaEl.addClass('select-mania-focused');
			//bind keyboard dropdown opening
			$originalSelect.off('keydown.selectMania').on('keydown.selectMania', Binds.keyboardOpening);
		}, 

		//BIND ONLY - unfocus selectMania when original select is focused
		blur: function(e) {
			var $originalSelect = $(this);
			//selectMania element
			var $selectManiaEl = $originalSelect.data('selectMania-element');
			//remove focus class from selectMania element
			$selectManiaEl.removeClass('select-mania-focused');
			//unbind keyboard dropdown opening
			$originalSelect.off('keydown.selectMania');
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ hoverItem

		//BIND ONLY - hover status on dropdown items
		hoverItem: function(e) {
			var $item = $(this);
			//dropdown
			var $dropdown = $item.closest('.select-mania-dropdown');
			//remove hover from every item
			$dropdown.find('.select-mania-item').removeClass('select-mania-hover');
			//apply hover class
			$item.addClass('select-mania-hover');
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ keyboardOpening / keyboardControl

		//BIND ONLY - keyboard dropdown opening
		keyboardOpening: function(e) {
			var $originalSelect = $(this);
			//selectMania element
			var $selectManiaEl = $originalSelect.data('selectMania-element');
			//dropdown
			var $dropdown = $selectManiaEl.data('selectMania-dropdown');
			//list of key codes triggering opening beside characters (enter, spacebar, arrow keys)
			var openingKeys = [13,32,37,38,39,40];
			//if dropdown is closed and triggering key pressed
			if(!$dropdown.hasClass('open') && $.inArray(e.keyCode, openingKeys) !== -1) {
				e.preventDefault();
				e.stopPropagation();
				//unfocus original select
				$originalSelect.blur();
				//opens dropdown
				Engine.openDropdown($dropdown);
			}
		}, 

		//BIND ONLY - keyboard control within dropdown
		keyboardControl: function(e) {
			//currently open dropdown
			var $dropdown = $('.select-mania-dropdown.open').first();
			//list of control keys (tab, enter, escape, arrow up, arrow down)
			var controlKeys = [9,13,27,38,40];
			//if a selectMania dropdown is open and key pressed is a control key
			if($dropdown.length > 0 && $.inArray(e.keyCode, controlKeys) !== -1) {
				e.preventDefault();
				e.stopPropagation();
				//switch key pressed
				switch(e.keyCode) {
					//enter
					case 13:
						//currently hovered element
						var $hoverItem = $dropdown.find('.select-mania-item:not(.select-mania-disabled):not(.select-mania-hidden).select-mania-hover').first();
						//if hovered element exists
						if($hoverItem.length > 0) {
							//select item in dropdown
							Engine.selectItem($hoverItem);
						}
						break;
					//tab
					case 9:
					//escape
					case 27:
						//close dropdown
						Engine.closeDropdown($dropdown);
						break;
					//arrow up
					case 38:
						//hover previous item in dropdown
						Engine.navigateItem($dropdown, 'previous');
						break;
					//arrow down
					case 40:
						//hover next item in dropdown
						Engine.navigateItem($dropdown, 'next');
						break;
				}
			}
		}

	};

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// ---------------------------------------- TOOLS ----------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

	var Tools = {

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ def

		//force null if var is undefined
		def: function(v) {
			if(typeof v === 'undefined') {
				return null;
			}
			return v;
		}

	};

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// --------------------------------------- METHODS --------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

	var Methods = {

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ init

		//initialize selectMania
		init: function(opts) {
			//settings provided by user
			var settings = $.extend(true, {}, Data.defaults, opts);
			//loop through targeted elements
			return this.each(function() {
				//current select to initialize
				var $originalSelect = $(this);
				//controls if element is a select and plugin is not already initialized
				if(Engine.controlTarget($originalSelect, ['isSelect','notInitialized'])) {
					//initialize selectMania on original select
					Engine.initialize($originalSelect, settings);
				}
			});
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ update

		//update selectMania items and values
		update: function() {
			//loop through targeted elements
			return this.each(function() {
				//current select to destroy
				var $originalSelect = $(this);
				//controls if selectMania initialized
				if(Engine.controlTarget($originalSelect, ['isInitialized'])) {
					//update selectMania
					Engine.update($originalSelect);
				}
			});
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ destroy

		//destroy selectMania
		destroy: function() {
			//loop through targeted elements
			return this.each(function() {
				//current select to destroy
				var $originalSelect = $(this);
				//controls if selectMania initialized
				if(Engine.controlTarget($originalSelect, ['isInitialized'])) {
					//destroy selectMania
					Engine.destroy($originalSelect);
				}
			});
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ check

		//check if selectMania initialized
		check: function() {
			//controls method was called on single element
			if(Engine.controlTarget(this, ['isSingle'])) {
				//send back if plugin initialized or not
				return this.hasClass('select-mania-original');
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ get

		//returns parsed selected values
		get: function() {
			//controls if single element and plugin initialized
			if(Engine.controlTarget(this, ['isSingle','isInitialized'])) {
				//selectMania element
				var $selectManiaEl = this.data('selectMania-element');
				//get and return parsed selected values
				return Engine.getVal($selectManiaEl);
			}
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ set

		//set parsed values as selected values
		set: function(values) {
			//controls if single element and plugin initialized
			if(Engine.controlTarget(this, ['isSingle','isInitialized'])) {
				//controls values are valid
				if(Engine.controlValues(this, values)) {
					//selectMania element
					var $selectManiaEl = this.data('selectMania-element');
					//get and return parsed selected values
					Engine.setVal($selectManiaEl, values);
				}
			}					
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ clear

		//clear values
		clear: function() {
			//loop through targeted elements
			return this.each(function() {
				//current select to destroy
				var $originalSelect = $(this);
				//controls if plugin initialized
				if(Engine.controlTarget($originalSelect, ['isInitialized'])) {
					//selectMania element
					var $selectManiaEl = $originalSelect.data('selectMania-element');
					//clear values
					Engine.clear($selectManiaEl);
					//trigger original select change event
					$originalSelect.trigger('change');
					//update clear values icon display
					Engine.updateClean($selectManiaEl);
				}
			});
		}, 

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ setup

		//setup default settings values
		setup: function() {
			//loop through targeted elements
			return this.each(function() {
				//current select to destroy
				var $originalSelect = $(this);
				//controls if plugin initialized
				if(Engine.controlTarget($originalSelect, ['isInitialized'])) {
					//selectMania element
					var $selectManiaEl = $originalSelect.data('selectMania-element');
					//clear values
					Engine.clear($selectManiaEl);
					//trigger original select change event
					$originalSelect.trigger('change');
					//update clear values icon display
					Engine.updateClean($selectManiaEl);
				}
			});
		}

	};

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //
// --------------------------------------- HANDLER ---------------------------------------- //
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ //

	//plugin methods handler
	$.fn.selectMania = function(methodOrOpts) {
		//stop right away if targeted element empty
		if(this.length < 1) { return; }
		//call method
		if(Methods[methodOrOpts]) {
			//remove method name from call arguments
			var slicedArguments = Array.prototype.slice.call(arguments, 1);
			//call targeted mathod with arguments
			return Methods[methodOrOpts].apply(this, slicedArguments);
		}
		//call init
		else if(typeof methodOrOpts === 'object' || !methodOrOpts) {
			//call init with arguments
			return Methods.init.apply(this, arguments);
		}
		//error
		else {
			console.error('selectMania | wrong method called');
			console.log(this);
		}
	};

	//plugin setup handler
	$.extend({
		selectManiaSetup: function(opts) {
			//set default settings values
			Data.setup(opts);
		}
	});

})(jQuery);




(function(a){a.fn.circliful=function(b,d){var c=a.extend({fgcolor:"#556b2f",bgcolor:"#eee",fill:false,width:15,dimension:200,fontsize:15,percent:50,animationstep:1,iconsize:"20px",iconcolor:"#999",border:"default",complete:null},b);return this.each(function(){var w=["fgcolor","bgcolor","fill","width","dimension","fontsize","animationstep","endPercent","icon","iconcolor","iconsize","border"];var f={};var F="";var n=0;var t=a(this);var A=false;var v,G;t.addClass("circliful");e(t);if(t.data("text")!=undefined){v=t.data("text");if(t.data("icon")!=undefined){F=a("<i></i>").addClass("fa "+a(this).data("icon")).css({color:f.iconcolor,"font-size":f.iconsize})}if(t.data("type")!=undefined){j=a(this).data("type");if(j=="half"){s(t,"circle-text-half",(f.dimension/1.45))}else{s(t,"circle-text",f.dimension)}}else{s(t,"circle-text",f.dimension)}}if(a(this).data("total")!=undefined&&a(this).data("part")!=undefined){var I=a(this).data("total")/100;percent=((a(this).data("part")/I)/100).toFixed(3);n=(a(this).data("part")/I).toFixed(3)}else{if(a(this).data("percent")!=undefined){percent=a(this).data("percent")/100;n=a(this).data("percent")}else{percent=c.percent/100}}if(a(this).data("info")!=undefined){G=a(this).data("info");if(a(this).data("type")!=undefined){j=a(this).data("type");if(j=="half"){D(t,0.9)}else{D(t,1.25)}}else{D(t,1.25)}}a(this).width(f.dimension+"px");var i=a("<canvas></canvas>").attr({width:f.dimension,height:f.dimension}).appendTo(a(this)).get(0);var g=i.getContext("2d");var r=i.width/2;var q=i.height/2;var C=f.percent*360;var H=C*(Math.PI/180);var l=i.width/2.5;var B=2.3*Math.PI;var z=0;var E=false;var o=f.animationstep===0?n:0;var p=Math.max(f.animationstep,0);var u=Math.PI*2;var h=Math.PI/2;var j="";var k=true;if(a(this).data("type")!=undefined){j=a(this).data("type");if(j=="half"){B=2*Math.PI;z=3.13;u=Math.PI*1;h=Math.PI/0.996}}function s(J,x,y){a("<span></span>").appendTo(J).addClass(x).text(v).prepend(F).css({"line-height":y+"px","font-size":f.fontsize+"px"})}function D(y,x){a("<span></span>").appendTo(y).addClass("circle-info-half").css("line-height",(f.dimension*x)+"px")}function e(x){a.each(w,function(y,J){if(x.data(J)!=undefined){f[J]=x.data(J)}else{f[J]=a(c).attr(J)}if(J=="fill"&&x.data("fill")!=undefined){A=true}})}function m(x){g.clearRect(0,0,i.width,i.height);g.beginPath();g.arc(r,q,l,z,B,false);g.lineWidth=f.width+1;g.strokeStyle=f.bgcolor;g.stroke();if(A){g.fillStyle=f.fill;g.fill()}g.beginPath();g.arc(r,q,l,-(h),((u)*x)-h,false);if(f.border=="outline"){g.lineWidth=f.width+13}else{if(f.border=="inline"){g.lineWidth=f.width-13}}g.strokeStyle=f.fgcolor;g.stroke();if(o<n){o+=p;requestAnimationFrame(function(){m(Math.min(o,n)/100)},t)}if(o==n&&k&&typeof(b)!="undefined"){if(a.isFunction(b.complete)){b.complete();k=false}}}m(o/100)})}}(jQuery));