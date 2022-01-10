

//функция задержки при написании поиска в полях

window.search_min = 1;  //мин количество символов для быстрого поиска
window.search_deley=800;	//задержка между вводами символов - начало поиска
window.search_class='.loll_soply';	//задержка между вводами символов - начало поиска

var delay1 = (function(th){ 
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


//табсы в обращениях
var tabs_app = function(event) {
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
			AjaxClient('app','tabs_info','GET',data,'AfterTabsInfoApp',$(this).attr("id")+','+$(this).parents('.preorders_block_global').attr('id_pre'),0,1);
		}
	}
}

// Функция удаления пробелов
function ctrim(str)
{
	str = str.replace(/\s/g, '');
	return str;
}


//функция проверки ввода только чисел и с запятой
var validate11 = function() {
  $(this).val($(this).val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
}


function UploadInvoice_old()
{
	var id_upload=$(this).attr('id_upload');
	$('[name=myfiles'+id_upload+']').trigger('click');
}


function UploadReportsChange_old()
{
	var id=$(this).parents('form').attr('id_sc');
	file = this.files[0];
	if (file) {
		uploadRR_old(file,id);
	}
	return false;
}
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



//нажать на кнопку сохранить настройки
function save_setting()
{


	var err = 0;
//alert($('.js-form-register .gloab').length);
	$('.js-form-gloab .gloab').each(function(i,elem) {
		if($(this).val() == '')  { $(this).parents('.input_2021').addClass('required_in_2021');
			$(this).parents('.list_2021').addClass('required_in_2021');
			err++;
			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2021').removeClass('required_in_2021');$(this).parents('.list_2021').removeClass('required_in_2021');}
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




//закрыть форму подписки крестик
//  |
// \/
function Eye()
{
	if($(this).is('.ais-open'))
	{
		$(this).removeClass('ais-open');
		$(this).parents('.input_2021').find('.input_new_2021').attr('type','password');
	} else
	{
		$(this).addClass('ais-open');
		$(this).parents('.input_2021').find('.input_new_2021').attr('type','text');
	}
}



function count_task()
{
var count_dr=$('.hidden-count-task').text();
if(count_dr!='')
{
	$('.menu-09-count').empty().append($('.hidden-count-task').text());
	$('.menu-09-count').show();
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



//переслать заявку
function ForwardFo()
{
	if(!$(this).is('.gray-bb')) {
		var pre = $('.preorders_block_global').attr('id_pre');
		$.arcticmodal({
			type: 'ajax',
			url: 'forms/form_add_app_forward.php?id=' + pre,
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

//отклонить заявку
function RejectFo()
{
	if(!$(this).is('.gray-bb')) {
		var pre = $('.preorders_block_global').attr('id_pre');
		$.arcticmodal({
			type: 'ajax',
			url: 'forms/form_add_app_reject.php?id=' + pre,
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

function SingFo()
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
					url: 'forms/form_add_app_remark.php?id=' + pre,
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

function MemoButType(elem)
{

	var bbt=elem.parents('.save_button');
	if(elem.val()==1)
	{
		bbt.addClass('yellow-bb');

	} else
	{
		bbt.removeClass('yellow-bb');
	}
	bbt.find('.js-son').hide();
	bbt.find('[son='+elem.val()+']').show();
}


//активация инпутов 2021
function input_2021()
{
	//перебрать все новые инпуты и если не пусто активировать
	$(".input_new_2021").each(function (index, value) {

		var input=$.trim($(this).val());
		if(input!='')
		{
			$(this).parents('.input_2021').addClass('active_in_2021');
		}
	});

}
//нажатие на отдельные chtckbox залки в определенной группе
//  |
// \/
function CheckboxGroup(event)
{
	/*
    var active_old = $(this).parent().parent().find(".slct").attr("data_src");
    var active_new = $(this).find("a").attr("rel");
    */
//var f = $(this).find("a").text();

	//если стоит класс no_active_check то ничего не делаем
	if(!$(this).is('.no_active_check')) {


		var e = $(this).find("input").first().val();
		var drop_object = $(this).parents('.js-group-c');

		var active_jj = 0;

		if ($(this).find('i').is(".active_task_cb")) {

			$(this).find('i').removeClass("active_task_cb");
			$(this).find('input').last().val(0);
			active_jj = 1;
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
			if (active_jj == 0) {
				$(this).find('i').addClass("active_task_cb");
				$(this).find('input').last().val(1);
			}

		}


		//есть класс который говорит что если выбрано первое в списке то убираем галки со всех остальных
		//если есть что-то выбранное то первое в списке не горит
		//если ничего не выбрано первое в списке зажечь

		if (drop_object.is('.js-one-all-select')) {

			var one_li = drop_object.find('.js-checkbox-group').first();


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
			if (e != 0) {
				var count_all_li = drop_object.find('.js-checkbox-group').length;
				var count_active_li = drop_object.find('.active_task_cb').length;
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
			if ((select_li != '') && (select_li != '0')) {
				if (one_li.find('i').is('.active_task_cb')) {
					one_li.trigger('click');
					return;
				}
			}

		}
		MemoButType($(this).find("input"));
		event.stopPropagation();
	}
}

function animation_teps_supply()
{
	$('.teps_supply').each(function(i,elem) {
	$(this).animate({width: $(this).attr('rel_w')+"%"}, 2000, function() {  });
});
}

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

//ввод текста в новые инпуты скрытие ошибки если она была
//  |
// \/
function KeyUpInput2021()
{
	if($(this).is('.gloab'))
	{
		if(($(this).val()!='')&&($(this).val()!=0))
			$(this).parents('.input_2021').removeClass('required_in_2021');
		$(this).parents('.input_2021').removeClass('error_2021');
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


//подсказки особые для формы
//  |
// \/
function ToolTipInput(){



	$(".help-icon").mousemove(function (eventObject) {

		var inputx=$(this).parents('.input_2021');

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
	}).mouseout(function () { var toolh=$(this).parents('.input_2021').find(".toolhelp");


		if(toolh.length==0)
		{
			var toolh=$(this).parents('.js-helps').find(".toolhelp");
		}


		toolh.remove(); });


}

//загружать или нет js forms // нужно когда открывается несколько окон сразу
//  |
// \/
function initializeFormsJs()
{
	try {
		//функция определена в файле js forms. и если он не подгружен то он не будет знать такую функцию и она вызовет ошибку
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



//перезагрузка страницы
//  |
// \/
function autoReloadHak(){
	var goal = self.location;
	location.href = goal;
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





function dell_invoice()
{
	var attr=$(this).attr('id_rel');
	$('[invoice_material='+attr+']').hide();
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_invoice.php?id='+attr,
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





function  UpdateImageInvoiceAkt(id,type)
{	
	var data ='url='+window.location.href+'&id='+id+'&type='+type;
    AjaxClient('invoices','update_akt','GET',data,'AfterUpdateAkt',type,0);	
}








function ErrorMax()
{
	
	var max=parseFloat($(this).attr('max'));
	$(this).removeClass('redaas_invcoice');
	var count=parseFloat($(this).val());
	
	//alert(id);
	
	if((count!='')&&(max<count)&&(count!='0'))
	{
			$(this).addClass('redaas_invcoice');
	} else
	{
			//$('[invoices_messa='+id+']').find('.count_defect_in_').removeClass('redaas_invcoice');
	}
	
}







//проверка количество брака не больше общего количества этого материала

function BrakError()
{
	
	var id=$(this).parents('[invoice_group]').attr('invoice_group');
	$('[invoices_messa='+id+']').find('.count_defect_in_').removeClass('redaas_invcoice');
	var count=parseFloat($('[invoice_material='+id+']').find('.count_in_').val());
	var count_akt=parseFloat($('[invoices_messa='+id+']').find('.count_defect_in_').val());
	
	//alert(id);
	
	if((count_akt!='')&&(count_akt>count)&&(count!=''))
	{
			$('[invoices_messa='+id+']').find('.count_defect_in_').addClass('redaas_invcoice');
	} else
	{
			//$('[invoices_messa='+id+']').find('.count_defect_in_').removeClass('redaas_invcoice');
	}
	
}




function countErrorMax()
{
	
	var xvg=$('.count_in_');
	xvg.each(function(i,elem) {
		var max=parseFloat($(this).attr('max'));
	    $(this).removeClass('redaas_invcoice');
	    var count=parseFloat($(this).val());
		
	    if((count!='')&&(max<count)&&(count!='0'))
	    {
			$(this).addClass('redaas_invcoice');
	    }
	});
}






function search_posta_li2()
{
	$('.contractor_add').hide();
	$('.select-mania-theme-orange1').show();
	
	$('.new_contractor_').val(0);	
}

function plus_postt()
{
	$('.contractor_add').show();
	$('.contractor__').hide();
	$('.new_contractor_').val(1);
}


function yoop_click()
{
	//alert("!");
	var hl=$(this).parents('.yoop_');
	if ( hl.is(".hide_yoop") )
    {
		
		hl.removeClass('hide_yoop');
		
	} else
		{
			hl.addClass('hide_yoop');
		}
}


function search_posta_li()
{
	$('.loll_drop').css("transform", "scaleY(0)");
	$('.post_p').val($(this).find('a').attr('rel'));
	$(this).parents('.loll_div').removeClass('required_in_2018');
	$('[name=number_soply]').val($(this).find('a').text().toUpperCase());
	$('[name=number_soply]').attr('val_old',$(this).find('a').text().toUpperCase());
	$('.b-loading-message').empty().hide();
}

function search_posta1()
{
if($.trim($(this).val().length) >= 1)
		{
		  $('.loll_drop').css("transform", "scaleY(1)");	
		} 
}
	
function search_posta()
{
	    //проверить что поле можно править
	//alert("!!");
	if($(this).attr("readonly")==undefined) {
		if($.trim($(this).val().length) >= 1)
		{
		  $(this).parents('.loll_div').find('.loll_dell').show();	
		} else
		{
			$(this).parents('.loll_div').find('.loll_dell').hide();
		}
	var th=$(this);
	
    delay1(function(th){
		//alert(th.val());
		
		if($.trim($(window.search_class).val().length) >= window.search_min)
		{
             // alert($(window.search_class).val());  
			$('.b-loading-message').empty().hide();
			 $('.b-loading').show();
			 $(this).parents('.loll_div').find('.loll_drop').css("transform", "scaleY(0)");
			 
				var data ='url='+window.location.href+'&query='+$(window.search_class).val()+'&active='+$('.post_p').val();
	           AjaxClient('supply','search_contractor','GET',data,'Aftersearch_posta',1,0);	
			
			  //послать ajax поиск поставщиков
			
			  //запустить лодер что ищется
		}
		
    }, window.search_deley,$(this));
	}
}




function Aftersearch_posta(data,update)
{
	if ( data.status=='reg' )
    {
		$('.b-loading').hide();
		WindowLogin();
	}
	
	if ( data.status=='yes' )
    {				
		$('.loll_drop').empty().append(data.echo).css("transform", "scaleY(1)");
		$('.b-loading').hide();
	}
	
	if ( data.status=='ok' )
    {
		$('.b-loading').hide();
		$('.b-loading-message').empty().append('ничего не найдено').show();
		//показать кнопку добавить новый
	}
	
}

//получение фокуса для новых инпутов
function InputFocusNew2021()
{
	var val_input=$(this).val();
	var label=$(this).prev('label');
	var input_div=$(this).parents('.input_2021');

	if(!input_div.is('.active_in_2021'))
	{
		input_div.addClass('active_in_2021');
	}

	if(!input_div.is('.active1_in_2021'))
	{
		input_div.addClass('active1_in_2021');
	}

	//может надо открыть календарь
	var calendar=input_div.find('.cal_2021');
	if(calendar.length!=0)
	{
		$(".date___2019").show();
	}



}
//потеря фокуса для новых инпутов
function InputBlurNew2021()
{
	if($(this).is('.gloab')) {
		//alert($(this).val());
		var val_input = $(this).val();
		var label = $(this).prev('label');
		var input_div = $(this).parents('.input_2021');

		input_div.removeClass('active1_in_2021');

		if (val_input == '') {
			input_div.removeClass('active_in_2021');
		}


		if (!$(this).is('.date2021_mask')) {
			//для всего остального кроме дат с маской
			if (($(this).is('.required')) && (val_input == '') && (!input_div.is('.required_in_2021'))) {
				input_div.addClass('required_in_2021');
			} else {
				if (($(this).is('.required')) && (val_input != '')) {
					input_div.removeClass('required_in_2021');
				}
			}
		} else {
			if (($(this).is('.required')) && ((val_input == '') || (val_input == 'дд.мм.гггг')) && (!input_div.is('.required_in_2021'))) {
				input_div.addClass('required_in_2021');
			} else {
				if (($(this).is('.required')) && (val_input != '') && (val_input != 'дд.мм.гггг')) {
					input_div.removeClass('required_in_2021');
				}
			}


		}

	}
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
//потеря фокуса для новых инпутов
function InputBlurNew()
{
	/*
	//alert($(this).val());
	var val_input=$(this).val();
	var label=$(this).prev('label');
	var input_div=$(this).parents('.input_2018');
	
	input_div.removeClass('active1_in_2018');
	
	if(val_input=='')
	{
		input_div.removeClass('active_in_2018');	
	}
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
	
}



//удалить фото из накладной
function DellImageInvoice()
{
	var for_id=$(this).attr('for');
	var data ='url='+window.location.href+'&id='+for_id;
    AjaxClient('invoices','del_img','GET',data,'AfterDellImageInvoice',for_id,0);	
}

//изменить поставщика в нарядах
function UpdateContractorInvoice()
{
	var val=$(this).val();
	if(($.isNumeric(val))&&(val!=0))
	{
		$('.add_material_invoice').attr('col',val);
    }
}







function DellImageSupply()
{
	var for_id=$(this).attr('for');
	var data ='url='+window.location.href+'&id='+for_id;
    AjaxClient('supply','del_img','GET',data,'AfterDellImageSupply',for_id,0);	
}

function UpdateImageSupply(id)
{
	var data ='url='+window.location.href+'&id='+id;
    AjaxClient('supply','update_img','GET',data,'AfterUpdateImageSupply',id,0);	
}

function UpdateImageInvoice(id)
{
	var data ='url='+window.location.href+'&id='+id;
    AjaxClient('invoices','update_img','GET',data,'AfterUpdateImageInvoice',id,0);	
}

//обнавление статуса в счетах после "к оплате"
function UpdateWalletStatus(id)
{
	$('.billl[rel_id='+id+']').find('.status_wallet_ada').empty();
	$('.billl[rel_id='+id+']').find('.button_ada_wall').empty().append('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	
	var data ='url='+window.location.href+'&id='+id;			
	
    AjaxClient('bill','bill_status','GET',data,'AfterWalletSTx',id,0);	
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

//к оплате счет
function xvg_yes()
{
	var iu=$('.content_block').attr('iu');
	var id_bill=$(this).attr('rel_bill');
	
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_yes_bill.php?id='+id_bill,
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


//оплатить бухгалтерия
function booker_yes()
{
	var iu=$('.content_block').attr('iu');
	var id_bill=$(this).attr('rel_booker');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_booker_yes.php?id='+id_bill,
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

//изменить наименование из склада
function xvg_yes1()
{

	var attr=$(this).attr('rel_bill');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_stock.php?id='+attr,
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

//удалить наименование из склада
function xvg_no1()
{
	var iu=$('.content_block').attr('iu');
	var id_bill=$(this).attr('rel_bill');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_stock.php?id='+id_bill,
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



//отменить оплату по счету
function xvg_no()
{
	var iu=$('.content_block').attr('iu');
	var id_bill=$(this).attr('rel_bill');

	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_no_bill.php?id='+id_bill,
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





function vall_supply() {  
	var el_v=$(this).val();
	
	
	$('[rel_status='+$(this).attr('rel')+']').hide();
	var data ='url='+window.location.href+'&id='+$(this).attr('rel')+'&val='+el_v;
	AjaxClient('supply','status_work','GET',data,'Aftervall_supply',$(this).attr('rel'),0);			
};

function option_mat1() {
	var el_v=$(this).val();
	var id_bill=$(this).parents('[rel_id]').attr('rel_id');
	//var id_soply=soply.attr('rel_score');

		
	
	if(el_v==1)	
	{
		//изменить 
		
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_yes_bill.php?id='+id_bill,
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
		
		//var data ='url='+window.location.href+'&id='+id_soply;
	    //AjaxClient('supply','dell_soply','GET',data,'Afterdell_soply',id_soply,0);		
		
	}
		if(el_v==2)	
	{
		//отменить оплату
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_yes_bill.php?id='+id_bill,
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



function option_mat() {
	var el_v=$(this).val();
	var id_soply=$(this).parents('[supply_id]').attr('supply_id');
	//var id_soply=soply.attr('rel_score');

	
	if(el_v==1)	
	{
		//удалить счет
		
	$.arcticmodal({
    type: 'ajax',
    url: 'forms/form_soply_sklad_2021.php?id='+id_soply,
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
		
		//var data ='url='+window.location.href+'&id='+id_soply;
	    //AjaxClient('supply','dell_soply','GET',data,'Afterdell_soply',id_soply,0);		
		
	}
	
	
}

function UpdateCostFinery(id)
{

	var count=parseFloat($('.mat[rel_mat='+id+']').find('.аmater_').val());
	var count_my=parseFloat($('.mat[rel_mat='+id+']').find('.count_finery_mater_').attr('my'));
	var id_stock=parseFloat($('.mat[rel_mat='+id+']').find('[id_stock_m]').attr('id_stock_m'));
	
	//alert(count_my);
	
	if((count!='')&&(count!=0)&&(id_stock!='')&&(id_stock!=0)&&(count_my!='')&&(count_my!=0)&&(count_my>=count))
    {
		$('.mat[rel_mat='+id+']').find('.price_finery_mater_').val('');
		//alert("!!");
		
			var rel_id=$('.mat[rel_mat='+id+']').find('.price_finery_mater_').parents('.mat').attr('rel_w');
	var rel_mat=$('.mat[rel_mat='+id+']').find('.price_finery_mater_').parents('.mat').attr('rel_mat');
	
	var max=parseFloat($('.mat[rel_mat='+id+']').find('.price_finery_mater_').attr('max'));
	var my=parseFloat($('.mat[rel_mat='+id+']').find('.price_finery_mater_').attr('my'));
	
	var value=$('.mat[rel_mat='+id+']').find('.price_finery_mater_').val();	
	$('.mat[rel_mat='+id+']').find('.price_finery_mater_').removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		//if(((parseFloat(value)!=max)&&(!isNaN(max)))||(parseFloat(value)>my))
			if(((parseFloat(value)!=max)&&(!isNaN(max))))
			{
				//выделяем красным и открываем служебную записку
				$('.mat[rel_mat='+id+']').find('.price_finery_mater_').addClass('redaas');

			} 
				
	} 
		
		serv_mess_m($('.mat[rel_mat='+id+']').find('.price_finery_mater_'));
		summ_finery1(id);
		
		if($('[name=id_naa]').length!=0)
			{
				 	var data ='url='+window.location.href+'&id='+id_stock+'&count='+count+'&fin='+$('[name=id_naa]').val();
			} else
				{
		
		
	   	var data ='url='+window.location.href+'&id='+id_stock+'&count='+count;
	    
				}
		AjaxClient('finery','update_cost','GET',data,'AfterUpdateCostFinery',id,0);	
	} else
	{
	
		if($('[name=status_naryad]').length==0)
		{	
	$('.mat[rel_mat='+id+']').find('.price_finery_mater_').val('');
		}
		
	var rel_id=$('.mat[rel_mat='+id+']').find('.price_finery_mater_').parents('.mat').attr('rel_w');
	var rel_mat=$('.mat[rel_mat='+id+']').find('.price_finery_mater_').parents('.mat').attr('rel_mat');
	
	var max=parseFloat($('.mat[rel_mat='+id+']').find('.price_finery_mater_').attr('max'));
	var my=parseFloat($('.mat[rel_mat='+id+']').find('.price_finery_mater_').attr('my'));
	
	var value=$('.mat[rel_mat='+id+']').find('.price_finery_mater_').val();	
	$('.mat[rel_mat='+id+']').find('.price_finery_mater_').removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		//if(((parseFloat(value)!=max)&&(!isNaN(max)))||(parseFloat(value)>my))
			if(((parseFloat(value)!=max)&&(!isNaN(max))))
			{
				//выделяем красным и открываем служебную записку
				$('.mat[rel_mat='+id+']').find('.price_finery_mater_').addClass('redaas');

			} 
				
	} 	
		

	   serv_mess_m($('.mat[rel_mat='+id+']').find('.price_finery_mater_'));
	   summ_finery1(id);


	}

}


function xvg_bill()
{
	var id_soply=$(this).attr('rel_score');
	
	jQuery.scrollTo('.billl[rel_id='+id_soply+']', 1000, {offset:-120});
}







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
  sl_message_width();	
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
		$(this).css('width', $(this).attr('rel_w')+"%");
		//$(this).animate({width: $(this).attr('rel_w')+"%"}, 2000, function() {  });
	});


}

//приведение служебых записок к нужному виду
function sl_message_width()
{
	setTimeout ( function () {  
	if($('.smeta1').length)
		{
	var width_jk4=$('.smeta1').find('.jk4').outerWidth();  //столбик название
	var width_jk44=$('.smeta1').find('.jk44').outerWidth(); //столбик ед. изм
			
	//var width_jk5=$('.smeta1').find('.jk5').outerWidth();
	//var width_jk6=$('.smeta1').find('.jk6').outerWidth();
	
    var width_jk7=$('.smeta1').find('.jk6').outerWidth();	 //столбик удалить	
	var table=$('.smeta1').width();  //общая ширина
	//alert(table);	
	var ww=table-width_jk4-width_jk44-width_jk7-20;
			
			
	$('.smeta1').find('.mess_slu').width(ww);
			
	$('.smeta1').find('.hs').width((width_jk4+width_jk44));
		}
	
   }, 1000 );
	
}

//маска вводить только целые и float
function maskk(thiss)
{
	thiss.val(thiss.val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));
	//alert(thiss.val());
	if($('[name=save_zayy]').length > 0)
		{
	savedefault_zay(thiss);
		} else
			{
    savedefault(thiss);
			}
	
}


function maskk_max(thiss)
{
	
	var max_=0;
	//alert("!");
	var count=parseFloat(thiss.val());
	//alert(count);
	if(count>0)
		{
	
	var mat=thiss.parents('.mat');	
	var id_stock=mat.find('.my_material').attr('id_stock_m');
	var my_stock=mat.find('.my_material').attr('count');
	
	
	$('[id_stock_m='+id_stock+']').each(function(i,elem) {
			var count_input=parseFloat($(this).parents('.mat').find('.count_finery_mater_').val());
		    if((count_input!='')&&(count_input>0))
			{
		       max_=max_ + parseFloat(count_input);
			}
    });
	max_=max_-	count;	
	
	if((count+max_)>parseFloat(my_stock))
	{
		  //alert(max_);	
		  //alert(count);
	      thiss.val(thiss.val().slice(0, -1));
	}
			
			
			
 }

	
	
	var max_=0;
	//alert("!");
	var count=parseFloat(thiss.val());
	//alert(count);
	if(count>0)
		{
	
	var mat=thiss.parents('.mat');	
	var id_stock=mat.find('.my_material').attr('id_stock_m');
	var my_stock=mat.find('.my_material').attr('count');
	
	
	$('[id_stock_m='+id_stock+']').each(function(i,elem) {
			var count_input=parseFloat($(this).parents('.mat').find('.count_finery_mater_').val());
		    if((count_input!='')&&(count_input>0))
			{
		       max_=max_ + parseFloat(count_input);
			}
    });
	max_=max_-	count;	
	
	if((count+max_)>parseFloat(my_stock))
	{
		  //alert(max_);	
		  //alert(count);
	      thiss.val('');
	}
			
			
			
 }
		
	
	
}


//маска вводить только целые
function maskk1(thiss)
{
	//console.log(thiss.val());
	thiss.val(thiss.val().replace(/[^\d]*/g, '').replace(/([])[]+/g, '$1').replace(/^[^\d]*(\d+([]\d{0,5})?).*$/g, '$1'));

	//console.log(thiss.val());

		if($('[name=save_zayy]').length > 0)
		{
	savedefault_zay(thiss);
		} else
			{
	savedefault(thiss);				
			}
}


var ChangeSupply=function() {
	var tr_s=$(this).parents('.suppp_tr');
	var rel_tr_s=tr_s.attr('rel_id');
	if(!tr_s.is('.active_supplyx'))
	{
	  tr_s.addClass('active_supplyx');
		$('[supply_stock='+rel_tr_s+']').show();
	} else
	{
		tr_s.removeClass('active_supplyx');
		$('[supply_stock='+rel_tr_s+']').hide();
	}
}


var slide_skkk = function() {
	
	if(!$(this).is('.slide_onon'))
	{
		$(this).find('.sklad_plus_uss').slideDown( "slow" ); 
		$(this).addClass('slide_onon');
	} else
	{
		$(this).find('.sklad_plus_uss').slideUp("slow"); 
		$(this).removeClass('slide_onon');			
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



function MydblclickXX()
{
var max_=0;
	if($(this).attr('readonly')==undefined) { 
	//alert("!");
	var count=$(this).attr('max');
	//alert(count);

	
	var mat=$(this).parents('.mat');	
	var id_stock=mat.find('.my_material').attr('id_stock_m');
	var my_stock=mat.find('.my_material').attr('count');
	
	
	$('[id_stock_m='+id_stock+']').each(function(i,elem) {
			var count_input=parseFloat($(this).parents('.mat').find('.count_finery_mater_').val());
	
		    if((count_input!='')&&(count_input>0)&&((!isNaN(count_input))))
			{
		       max_=max_ + parseFloat(count_input);
			}
    });
		/*
		if(count!='')
			{
	max_=max_- parseFloat(count);	
			}
			*/
		//alert(max_);
	
	if(parseFloat(count+max_)<=parseFloat(my_stock))
	{
		
		 $(this).val($(this).attr('max')).change();
				if($('[name=save_zayy]').length > 0)
		{
	savedefault_zay($(this));
		} else
			{
	   savedefault($(this));
			}
		
	}
			
		
		
		
	}
}







//двойно клик по инпуту
function Mydblclick()
{
	if($(this).attr('readonly')==undefined) { 
	   $(this).val($(this).attr('max')).change();
				if($('[name=save_zayy]').length > 0)
		{
	savedefault_zay($(this));
		} else
			{
	   savedefault($(this));
			}
	}
	
}

//вывод служебной записки по работе
function serv_mess(id_trr)
{
	var id_work=$('.work__s[id_trr='+id_trr+']').attr('rel_id');
	var count=parseFloat($('#count_work_'+id_trr).val());
	var price=parseFloat($('#price_work_'+id_trr).val());
	//alert(price);
	var max_count=parseFloat($('#count_work_'+id_trr).attr('max'));	
	var max_price=parseFloat($('#price_work_'+id_trr).attr('max'));
	var flag_show=0;
	var count_raz=0;
	var price_raz=0;
	if(count>max_count) {flag_show=1; count_raz=max_count; } else {  count_raz=count; }
	if(price>max_price) {flag_show=1;}
	//alert(flag_show);
	//$('.w_size').append(' '+flag_show);
	
	//проверяем нужно ли выводить на сколько привышение
	$('.work__s[id_trr='+id_trr+']').find('.exceed').empty();
	var exceed=0; // не надо
	if($('.exceed').length)
		{
			exceed=1;
			var exceed_summ= ((count_raz*max_price)-(count*price)).toFixed(2);
			if(exceed_summ>0)
				{
					exceed=0;
				}
		}
	
	
	if(flag_show==1)
	{	
	   //открываем записку			
	   $('.work__s[id_trr='+id_trr+']').next().find('.messa').stop(true).slideDown( "slow", function() {  $(this).css("height", "");  });
	   //alert("!");
	   if(exceed==1) {$('.work__s[id_trr='+id_trr+']').find('.exceed').empty().append('+'+$.number(Math.abs(exceed_summ), 2, '.', ' '));	}
		//alert("!!");
	   //$('.messa[id_mes='+id_work+']').stop(true).slideDown( "slow" );
	} else
	{
		//$('.messa[id_mes='+id_work+']').stop(true).slideUp( "slow" );
		$('.work__s[id_trr='+id_trr+']').next().find('.messa').stop(true).slideUp( "slow" );
		 //if(exceed==1) {$('.work__s[id_trr='+id_trr+']').find('.exceed').empty();	}
		
	}
}

//вывод служебной записки по материалам
function serv_mess_m(thiss)
{
	//alert("!!!");
	var rel_mat=thiss.parents('.mat').attr('rel_mat');
	
	//alert(rel_mat);
	
	var count=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').val());
	var price=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.price_finery_mater_').val());
	
	//alert(price);
	var max_count=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').attr('max'));
	var max_my=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').attr('my'));
	var max_price=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.price_finery_mater_').attr('max'));
	var flag_show=0;
	var count_raz=0;
	var price_raz=0;
	//alert(max_count);
	//alert(count);
	if((count!='')||(count==0))
		{
			//alert(count);
	if(((count!=max_count)&&(!isNaN(max_count)))||(count==0)) {flag_show=1; count_raz=max_count; } else {  count_raz=count; }
	//if(price>max_price) {flag_show=1;}
		
	if($('[name=status_naryad]').length==0)
		{
	if(count>max_my) {flag_show=2;}
		}
			
		}
	//alert(flag_show);
	//$('.w_size').append(' '+flag_show);
	//alert(count);
	/*
	if((count!='')&&(count!=0))
	{
	  UpdateCostFinery(rel_mat);
	}
	*/
		//проверяем нужно ли выводить на сколько привышение
	$('.mat[rel_mat='+rel_mat+']').find('.exceed').empty();
	var exceed=0; // не надо
	if($('.exceed').length)
		{
			exceed=1;
			var exceed_summ= ((count_raz*max_price)-(count*price)).toFixed(2);
			if(exceed_summ>0)
				{
					exceed=0;
				}
		}
	//alert(flag_show);
	if(flag_show==1)
	{	
	   //открываем записку			
	   $('.mat[rel_mat='+rel_mat+']').next().find('.messa').stop(true).slideDown( "slow" );
		$('.mat[rel_mat='+rel_mat+']').next().next().find('.messa_my').stop(true).slideUp( "slow" );
		if(exceed==1) { $('.mat[rel_mat='+rel_mat+']').find('.exceed').empty().append('+'+$.number(Math.abs(exceed_summ), 2, '.', ' '));	}
		//alert("!!");
	   //$('.messa[id_mes='+id_work+']').stop(true).slideDown( "slow" );
	} else
	{
		//$('.messa[id_mes='+id_work+']').stop(true).slideUp( "slow" );
		$('.mat[rel_mat='+rel_mat+']').next().find('.messa').stop(true).slideUp( "slow" );	
		
		
		if(flag_show==2)
	    {
			$('.mat[rel_mat='+rel_mat+']').next().next().find('.messa_my').stop(true).slideDown( "slow" );
			
			$('.js-ut_nar').hide();
			$('.js-pod_nar').hide();
			$('.js-add_nar').show();
			
			
		} else
		{
			$('.mat[rel_mat='+rel_mat+']').next().next().find('.messa_my').stop(true).slideUp( "slow" );	
		}
			
		
	}
	
}

//вывод служебной записки по материалам - заявка на материал
function serv_mess_m_app(thiss)
{
	var rel_mat=thiss.parents('.mat_zz').attr('rel_mat_zz');
	
	var count=$('.mat_zz[rel_mat_zz='+rel_mat+']').find('.count_app_mater_').val();
	//var price=$('.mat[rel_mat='+rel_mat+']').find('.price_finery_mater_').val();
	
	//alert(price);
	var max_count=parseFloat($('.mat_zz[rel_mat_zz='+rel_mat+']').find('.count_app_mater_').attr('max'));	
	//var max_price=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.price_finery_mater_').attr('max'));
	var flag_show=0;
		var count_raz=0;
	//var price_raz=0;
	if(count>max_count) {flag_show=1; count_raz=max_count; } else {  count_raz=count; }
	//if(price>max_price) {flag_show=1;}
	//alert(flag_show);
	//$('.w_size').append(' '+flag_show);
	
	
	if(flag_show==1)
	{	
	   //открываем записку			
	   $('.mat_zz[rel_mat_zz='+rel_mat+']').next().next().find('.messa').stop(true).slideDown( "slow" );
		//if(exceed==1) { $('.mat[rel_mat='+rel_mat+']').find('.exceed').empty().append('+'+$.number(Math.abs(exceed_summ), 2, '.', ' '));	}
		//alert("!!");
	   //$('.messa[id_mes='+id_work+']').stop(true).slideDown( "slow" );
	} else
	{
		//$('.messa[id_mes='+id_work+']').stop(true).slideUp( "slow" );
		$('.mat_zz[rel_mat_zz='+rel_mat+']').next().next().find('.messa').stop(true).slideUp( "slow" );	
		
	}
	
}

//пересчет общей суммы материалов
function summ_finery1(rel_mat)
{
	
	var count=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').val());
	var price=parseFloat($('.mat[rel_mat='+rel_mat+']').find('.price_finery_mater_').val());
	
	var sum=$('.mat[rel_mat='+rel_mat+']').find('.summa_finery_mater_');
	
	var value=(count*price).toFixed(2);
	//alert(sum);
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
	  sum.empty().append($.number(value, 2, '.', ' '));
	} else
		{
	  sum.empty();
		}	
	UpdateItog();
}

//пересчет общей суммы и суммы и количество материалов
function summ_finery(id_trr)
{
	var rel_id=$('.work__s[id_trr='+id_trr+']').attr('rel_id');
	var count=parseFloat($('#count_work_'+id_trr).val());
	var count_all_work=parseFloat($('#count_work_'+id_trr).attr('all'));
	var price=parseFloat($('#price_work_'+id_trr).val());
	var sum=$('#summa_finery_'+id_trr);
	var value=(count*price).toFixed(2);
	//alert(sum);
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
	sum.empty().append($.number(value, 2, '.', ' '));
	} else
		{
	sum.empty();
		}
	
	//считаем для материалов количество стоимость и сумму
	if((count!=0)&&(count!='')&&($.isNumeric(count)))
	{
//alert("!!");
	   $('.mat[rel_w='+rel_id+']').each(function(i,elem) {
	    var count_all_matt = parseFloat($(this).find('.count_finery_mater_').attr('all'));
		var count_ost_matt = parseFloat($(this).find('.count_finery_mater_').attr('ost'));
		   
		//var count_end = ((count_all_matt*count)/count_all_work).toFixed(4);
		   var count_end = ((count_all_matt*count)/count_all_work).toFixed(3);
		var flag_soot=1;   
		//alert(count_all_matt);
		//alert(count);   
		   //alert(count_all_work);   
		//если рассчитанное кол-во материала больше чем запланировано в себестоимости
		//бывает из-за привышения работы связанной с этими материалами
		if(count_end>count_ost_matt)
		{
		  count_est=count_end;	 //EST - предполагаемое количество
		  //count_end=count_ost_matt;
			count_end=count_ost_matt.toFixed(3);
		  flag_soot=0;  
		}
		
		 
		   
		if(flag_soot==1)
			{
		$(this).find('.count_finery_mater_').attr('placeholder','MAX - '+count_end);
		$(this).find('.count_finery_mater_').attr('max',count_end);
												  
		$(this).find('.hidden_max_count').val(count_end);										  
		$(this).find('.count_finery_mater_').prev('label').empty().append('MAX ('+count_end+')');
		$(this).find('.count_finery_mater_').change();   
			} else
				{
		$(this).find('.count_finery_mater_').attr('placeholder','MAX - '+count_end+' EST - '+count_est);
		$(this).find('.count_finery_mater_').attr('max',count_end);
												  
		$(this).find('.hidden_max_count').val(count_end);										  
		$(this).find('.count_finery_mater_').prev('label').empty().append('MAX ('+count_end+')'+' EST ('+count_est+')');
		$(this).find('.count_finery_mater_').change();  				
					
					
				}
				
       });
	} else
	{
	
	   $('.mat[rel_w='+rel_id+']').each(function(i,elem) {

		
		$(this).find('.count_finery_mater_').attr('placeholder','');
		$(this).find('.count_finery_mater_').attr('max','');
		$(this).find('.count_finery_mater_').prev('label').empty();
		$(this).find('.count_finery_mater_').change();  
		  $(this).find('.hidden_max_count').val("");	 
		   
       });		
	
	}
	UpdateItog();
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
  
return false;
}

//удалить материал из заявки из корзины

function DellZayvaMaterial()
{

	if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_material_zayava.php?id='+$(this).attr("id_rel")+'&n='+$(this).attr("naryd"),
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
  
return false;	
}

function DellZayvaMaterial1()
{

	if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_material_zayava1.php?id='+$(this).attr("id_rel")+'&n='+$(this).attr("zayu"),
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
  
return false;	
}

//удалить работу из корзины наряда
function DellNarydWork()
{
	if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_no_ajax.php?id='+$(this).attr("id_rel")+'&n='+$(this).attr("naryd"),
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
  
return false;
}

//удалить заявку на материал целиком
function DellZayZay()
{
	if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_zay_zay.php?id='+$(this).attr("id_rel"),
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
  
return false;
}

//удалить наряд целиком
function DellNaryd()
{
	if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_nariad.php?id='+$(this).attr("id_rel"),
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
  
return false;
}

//удалить работу из наряда
function DellNarydWork1()
{
 if($(this).is("[id_rel]"))
 {
  if($.isNumeric($(this).attr("id_rel")))
  {
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_work_is_nariad.php?id='+$(this).attr("id_rel")+'&n='+$(this).attr("naryd"),
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

 if($(this).parents('.my_no').length!=0)
 {
	 $('.pod_zay').hide(); $('.add_zay').show();
 }

  
return false;
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



//Обновление корзины при оформлении заявки на материал
function BasketUpdate_Z(dom_id)
{
	var cookie = $.cookie(window.b_cm+'_'+dom_id);
	//alert(window.b_co);
	var cc = cookie.split('.');
	var counts=cc.length;
	$('.basket_order').empty().append(counts);
	$('.count_workssss').val(counts);
}


//Обновление корзины при оформлении наряда
function BasketUpdate(dom_id)
{
	var cookie = $.cookie(window.b_co+'_'+dom_id);
	//alert(window.b_co);
	var cc = cookie.split('.');
	var counts=cc.length;
	$('.basket_order').empty().append(counts);
	$('.count_workssss').val(counts);
}

function updatecash(id)
{
	       var data ='url='+window.location.href+'&id='+id;
	        AjaxClient('cashbox','update_cash','GET',data,'AfterUCASH',id,0);
}


function UpdateItog()
{
	var sum_work=0;
	var sum_mat=0;
	
	//lert($('.work__s').find('.summ_price').text());
	//alert($('.work__s').find('.summ_price').length);
	$('.work__s').find('.summ_price').each(function(i,elem) {
		if($(this).text()!='')
			{
		var vall=parseFloat(trim_number($(this).text()));
	     if ((vall!='')&&(vall!=0)) {sum_work=sum_work+vall;	}
			}
    });
	$('.mat[rel_w]').find('.summa_finery_mater_').each(function(i,elem) {
				if($(this).text()!='')
			{
		var vall=parseFloat(trim_number($(this).text()));
	     if ((vall!='')&&(vall!=0)) {sum_mat=sum_mat+vall;	}
			}
    });
	
	
	var sum_exceed=0;
	$('.previ').hide();
	$('.exceed').each(function(i,elem) {
			if($(this).text()!='')
			{
		var vall=parseFloat(trim_number($(this).text()));
	     if ((vall!='')&&(vall!=0)) {sum_exceed=sum_exceed+vall;	}
			}
    });	
	if(sum_exceed!=0)
	{
		//$.number( 5020.2364, 2, ',', ' ');   // Outputs: 5 020,21	
		$('.previ').find('.itogsumall1').empty().append('+'+$.number(sum_exceed, 2, '.', ' '));	
		$('.previ').show();	
	}
	
	
	//alert(sum_work);
	$('.itogsummat').empty().append($.number(sum_mat.toFixed(2), 2, '.', ' '));
	$('.itogsumwork').empty().append($.number(sum_work.toFixed(2), 2, '.', ' '));
	//$('.itogsumall').empty().append($.number((sum_work+sum_mat).toFixed(2), 2, '.', ' '));	
}
//показать историю списания по материалу - наряды
function HistoryN1(event) {


	var block_his=$(this).parents('.edit_panel11_mat').find('.history_act_mat');
	$('.history_act_mat').not(block_his).hide();




	var block_his=$(this).parents('.edit_panel11_mat').find('.history_act_mat');
	//alert($('#yourID:visible').length);
	if(block_his.is(':visible'))
	{

		//alert("2");
		//скрыть
		block_his.slideUp("slow");
		//event.stopPropagation();

	} else
	{
		block_his.slideDown("slow");
		//alert("3");
	}

}

//история по нарядам по работе
function HistoryN()
{
	var id_rel=$(this).attr('for');
	if($(this).is('.shows'))
	{
		$(this).removeClass('shows');
		$('.histtory[rel_h='+id_rel+']').hide();
	} else
	{
	  if($('.histtory[rel_h='+id_rel+']').length)
	  {
		 $(this).addClass('shows');
		 $('.histtory[rel_h='+id_rel+']').show();
	  } else
	  {
			$('.loader_history[fo='+id_rel+']').show();
		    $(this).addClass('shows');
		    	
	        var data ='url='+window.location.href+'&id='+id_rel;
	        AjaxClient('prime','history_works','GET',data,'AfterHIST',id_rel,0);
			  
	  }
	
	}
}
function AfterHIST(data,update)
{
	if ( data.status=='reg' )
    {
		var loader=$('.loader_history[fo='+update+']');
		loader.hide();
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {				
		var loader=$('.loader_history[fo='+update+']');
		loader.hide();
		loader.after(data.echo);
	}
	
}

//контроль ввода количества материала при оформлении заявки на материал
function MmyHandlerApp()
{
	maskk($(this));
	
	var rel_id=$(this).parents('.mat_zz').attr('rel_w');
	var rel_mat=$(this).parents('.mat_zz').attr('mat_zz');
	var loader=$('[id_loader='+rel_mat+']');
	var max=parseFloat($(this).attr('max'));
	
	
	
	var value=$(this).val();	
	$(this).removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		if(parseFloat(value)>max)
			{
				//выделяем красным и открываем служебную записку
				$(this).addClass('redaas');
			} 
			var pr=Math.round(parseFloat(loader.attr('rel_w'))+((value*(100-parseFloat(loader.attr('rel_w'))))/max));
		    if(pr>100) {pr=100;}		
		    loader.stop(true).animate({width: pr+"%"}, 2000);		
	} else
	{
		//первоночально состояние
		loader.stop(true).animate({width: loader.attr('rel_w')+"%"}, 2000);	
	}
		
	serv_mess_m_app($(this));
	
	//изменение максимальных значений количества материалов
	
	
	
	
}


//контроль ввода количества и стоимости материала при оформлении наряда
function MmyHandlerXX()
{
	var rel_mat=$(this).parents('.mat').attr('rel_mat');	
	var count=$('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').val();
	var old_count=$('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').attr('old_count');
	//alert(old_count);
	if((count!='')&&(count!=0))
	{
		if(old_count!=count)
			{
	  $('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').attr('old_count',count);	
	  UpdateCostFinery(rel_mat);
			}
	}	else
		{
			
				$('.mat[rel_mat='+rel_mat+']').find('.price_finery_mater_').val('').removeClass('redaas');
					if(old_count!=count)
			{
	  $('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').attr('old_count',count);	

			}
			
		}
	
}



//контроль ввода количества и стоимости материала при оформлении наряда
function MmyHandler()
{
	maskk($(this));
	
	maskk_max($(this));

	//alert("!");
	var rel_id=$(this).parents('.mat').attr('rel_w');
	var rel_mat=$(this).parents('.mat').attr('rel_mat');
	
	var max=parseFloat($(this).attr('max'));
	var my=parseFloat($(this).attr('my'));
	var protocol_my=1; // по умолчанию надо проверять сколько у него этого материала
	if($('.yes_signedd_jops').length)
	{
		protocol_my=0;
	}


	var value=$(this).val();	
	$(this).removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		//my не надо проверять для уже проведенных нарядов иначе хана
		//if(((parseFloat(value)!=max)&&(!isNaN(max)))||(parseFloat(value)>my))
		if(((parseFloat(value)!=max)&&(!isNaN(max))))
			{
				//выделяем красным и открываем служебную записку
				$(this).addClass('redaas');
				//alert("!");
			}

		if(protocol_my==1)
		{
			if(parseFloat(value)>my)
			{
				$(this).addClass('redaas');
			}
		}
				
	} 
	
	
	
	/*
	var rel_mat=$(this).parents('.mat').attr('rel_mat');	
	var count=$('.mat[rel_mat='+rel_mat+']').find('.count_finery_mater_').val();
	
	if((count!='')&&(count!=0))
	{
	  UpdateCostFinery(rel_mat);
	}	
	*/
	
	
	
	serv_mess_m($(this));
	summ_finery1(rel_mat);
	
	//изменение максимальных значений количества материалов
	
	
	
	
}


//контроль ввода количества работы при оформлении наряда
function myHandler()
{
	maskk($(this));
	var rel_id=$(this).parents('.work__s').attr('rel_id');
	var id_trr=$(this).parents('.work__s').attr('id_trr');
	var loader=$('[id_loader='+rel_id+']');
	var max=parseFloat($(this).attr('max'));
	var value=parseFloat($(this).val());

	$(this).removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		//alert(value);
		
		if(parseFloat(value)>max)
			{
				//выделяем красным и открываем служебную записку
				$(this).addClass('redaas');
				//alert("!");
			}
		var pr=Math.round(parseFloat(loader.attr('rel_w'))+((value*(100-parseFloat(loader.attr('rel_w'))))/max));
		if(pr>100) {pr=100;}		
		loader.stop(true).animate({width: pr+"%"}, 2000);	
	} else
	{
		//первоночально состояние
		loader.stop(true).animate({width: loader.attr('rel_w')+"%"}, 2000);	
	}
	serv_mess(id_trr);
	summ_finery(id_trr);
	
	//изменение максимальных значений количества материалов
	
	
	
	
}

//контроль ввода суммы за единицу работы при оформлении наряда
function myHandler1()
{
	//alert('var1-'+$(this).val());
	maskk($(this));

	//alert('var2-'+$(this).val());

	var rel_id=$(this).parents('.work__s').attr('rel_id');
	var id_trr=$(this).parents('.work__s').attr('id_trr');
	
	var max=parseFloat($(this).attr('max'));
	var value=$(this).val();
	
	$(this).removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		//alert(value);
		if(parseFloat(value)>max)
			{
				//выделяем красным и открываем служебную записку
				//alert(max);
				$(this).addClass('redaas');
			}
		
	} 
	serv_mess(id_trr);
	summ_finery(id_trr);
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

	clearInterval(timerId);
	$.arcticmodal('close');

	  //открытие формы для входа
	/*
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

  });*/

	$.arcticmodal({
		type: 'ajax',
		url: 'forms/login_new.php?url='+window.location.href,
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



	  
	  
	  
      idleState = true; 	
}

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





//обращение за уведомлением
function NotificationSystem()
{ 
  //
  if($('.users_rule').is('[not]')) 
  {  		
    var data='tk='+$('.users_rule').attr('not');	
    nprogress=1;	  
    AjaxClient('notification','even','GET',data,'AfterNofi',1,0);	
  }
}



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
	  setTimeout ( function () { autoReloadHak(); }, 60000 );
      // Действия на отсутствие пользователя
	  //alert('выход из системы');
	  $(document).unbind('mousemove.time keydown.time scroll.time');
	  //завершение сессии пользователя
	  //$.cookie('user_id', null, {path:'/'});  
	  //$.cookie('da', null, {path:'/'}); 
	  $.cookie("tsl", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
	  //открытие формы для входа

	/*
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
	*/
	$.arcticmodal({
		type: 'ajax',
		url: 'forms/login_new.php?url='+window.location.href,
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
	  
      idleState = true; 
    }







//проферка есть ли по этому дому в корзине заявки на материалы и выводить кнопку оформить заявку
function BasketMaterial()
{
	var id_dom=$('.content_block').attr('dom');
	if($('.add_v_zay').length)
	{
	var cookie = $.cookie(window.b_co+'_'+id_dom);
	} else
	{
	var cookie = $.cookie(window.b_cm+'_'+id_dom);		
	}
	//alert(window.b_co);
	//alert(id_dom);
	
	if($('.add_v_zay').length)
	{
	//добавление в существующую заявку материалов
	if(cookie==null) {  $('.js-count-mat-update-app').slideUp("slow"); $('.js-update-mat-app').hide(); } else
	{
		$('.js-update-mat-app').show();
		var cc = cookie.split('.');
	    var counts=cc.length;
		$('.js-count-mat-update-app').empty().append(counts);

		$('.js-count-mat-update-app').slideDown("slow");

		//$('.naryd_end i').css('transform','scale(2)');
		//$('.naryd_end i').scale(1.5);
		/*
		$('.font-rank-inner11').animate({scale: "1.5"}, 200, function() {  $('.font-rank-inner11').animate({scale: "1"}, 200); });
*/

		 $('#nprogress').show();
		$('#nprogress .bar').animate({width: "100%"}, 200, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });
	}
	} else
	{		
	
	//оформление наряда		
	
	if(cookie==null) { $('.material_end').remove();  $('.material_inv').remove();} else
	{
		
		if(!$("div").is(".material_end")) {
			$('.add_mmm').after('<div class="material_end" data-tooltip="Оформить заявку на материалы"><a href="app/add/' + id_dom + '/">d<i></i></a></div>');
		}
		if(!$("div").is(".material_inv")) {

			$('.add_iii').after('<div class="material_inv" data-tooltip="Оформить накладную"><a href="invoices/add/'+id_dom+'/">H<i></i></a></div>');

		}
		var cc = cookie.split('.');
	    var counts=cc.length;
		$('.material_end i').empty().append(counts);
		$('.material_inv i').empty().append(counts);
		//$('.naryd_end i').css('transform','scale(2)');
		//$('.naryd_end i').scale(1.5);
		$('.material_end i').animate({scale: "1.5"}, 200, function() {  $('.material_end i').animate({scale: "1"}, 200); });

		$('.material_inv i').animate({scale: "1.5"}, 200, function() {  $('.material_inv i').animate({scale: "1"}, 200); });

		 $('#nprogress').show();
		$('#nprogress .bar').animate({width: "100%"}, 200, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });
	}
	}
	
	//помечаем сколько в каком разделе работ в корзине
	/*
	var numOpt=$('.block_i');
	$('.block_i').find('.count_basket_razdel').empty();
	numOpt.each(function (index, value) 
	{ 
			var cc=$(this).find('.checher').length;
			if(cc!=0)
			{
			   $(this).find('.count_basket_razdel').empty().append(cc);	
			}
	});
	*/
}



//проферка есть ли по этому дому в корзине нарядов - наряды и выводить кнопку оформить и количество если что
function BasketFinery()
{
	var id_dom=$('.content_block').attr('dom');
	var cookie = $.cookie(window.b_co+'_'+id_dom);
	//alert(window.b_co);
	//alert(cookie);
	if(($('.add_v_naryad').length)||($('.add_v_zay').length))
	{
		//alert("!");
	//добавление в существующий наряд
		/*
	if(cookie==null) { $('.font-rank11').remove(); $('.js-add_nar').hide(); $('.add_zayy').hide(); $('.js-update-mat-app').hide();     } else
	{
		$('.js-add_nar').show();
		$('.add_zayy').show();
		$('.js-update-mat-app').show();

		var cc = cookie.split('.');
	    var counts=cc.length;
		$('.font-rank-inner11').empty().append(counts);
		//$('.naryd_end i').css('transform','scale(2)');
		//$('.naryd_end i').scale(1.5);
		$('.font-rank-inner11').animate({scale: "1.5"}, 200, function() {  $('.font-rank-inner11').animate({scale: "1"}, 200); });
		 $('#nprogress').show();
		$('#nprogress .bar').animate({width: "100%"}, 200, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });
	}
*/

		if(cookie==null) {  $('.js-count-mat-update-app').slideUp("slow"); $('.js-add_nar').hide(); } else
		{
			$('.js-add_nar').show();
			var cc = cookie.split('.');
			var counts=cc.length;
			$('.js-count-mat-update-app').empty().append(counts);

			$('.js-count-mat-update-app').slideDown("slow");

			//$('.naryd_end i').css('transform','scale(2)');
			//$('.naryd_end i').scale(1.5);
			/*
            $('.font-rank-inner11').animate({scale: "1.5"}, 200, function() {  $('.font-rank-inner11').animate({scale: "1"}, 200); });
    */

			$('#nprogress').show();
			$('#nprogress .bar').animate({width: "100%"}, 200, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });
		}


	} else
	{		
	//оформление наряда		
	
	if(cookie==null) { $('.naryd_end').remove(); } else
	{
		
		if(!$("div").is(".naryd_end"))
		{
			$('.add_nnn').after('<div class="naryd_end" data-tooltip="Оформить наряд"><a href="worder/add/'+id_dom+'/">4<i></i></a></div>');
		}
		var cc = cookie.split('.');
	    var counts=cc.length;
		$('.naryd_end i').empty().append(counts);
		//$('.naryd_end i').css('transform','scale(2)');
		//$('.naryd_end i').scale(1.5);
		$('.naryd_end i').animate({scale: "1.5"}, 200, function() {  $('.naryd_end i').animate({scale: "1"}, 200); });
		 $('#nprogress').show();
		$('#nprogress .bar').animate({width: "100%"}, 200, function() {  $('#nprogress').hide(); $('#nprogress .bar').width('0'); });
	}
	}
	//помечаем сколько в каком разделе работ в корзине
	var numOpt=$('.block_i');
	$('.block_i').find('.count_basket_razdel').empty();
	numOpt.each(function (index, value) 
	{ 
			var cc=$(this).find('.checher').length;
			if(cc!=0)
			{
			   $(this).find('.count_basket_razdel').empty().append(cc);	
			}
	});
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
if(cookie==null) { $.cookie(name, id, {expires: 60,path: '/',domain: window.is_session,secure: false,samesite:'lax'});
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
		
                     })
                     .show();			
		}else
	{
        $("#tooltip").css({ 
                         "top" : eventObject.pageY + 5,
                        "left" : eventObject.pageX + 5
                     })
                     .show();
	}
    }).mouseout(function () { $("#tooltip").remove(); });

}

//закрыть все разделы в себестоимости
var close_all_razdel = function() {
		
		var id_content=$('.content_block').attr('id_content');		
		$('.block_i .i__').parent().parent().removeClass("active");
		$.cookie("l_"+id_content, null, {path:'/'}); 
		$('.block_i .i__').empty().append("+");		  
}

//поиск по себестоимости
//поиск по себестоимости
 var minlen = 3; // минимальная длина слова
 var paddingtop = 30; // отступ сверху при прокрутке
 var scrollspeed = 200; // время прокрутки
 var keyint = 2000; // интервал между нажатиями клавиш
 var term = '';
 var n = 0;
 var search_step=0;
 var time_keyup = 0;
 var time_search = 0;

var  dosearch = function() {
	window.search_step=0;
  term = $('.search_seb').find('input').val();
  $('var.highlight').each(function(){ $(this).after($(this).html()).remove(); });
  var t = '';
  var n=0;
  if(term!='')
	  {
  $('.s_j').each(function(){ 

    $(this).html($(this).html().replace(new RegExp(term, 'ig'), '<var class="highlight">$&</var>')); 

   }); 
	  }
    n = $('var.highlight').length; 
	window.n_search_prime=n;
   $('.result_s').show();
   $('.result_s').find('.se_prev').hide();
   if (n==0)
	   {
    $('.result_s').find('div').empty().append('Найдено: 0');
	$('.result_s').find('.se_next').hide();
	   }
   else
	   {
    $('.result_s').find('div').empty().append('Найдено: <span class="s_ss">'+n+'</span>'); 
	$('.result_s').find('.se_next').show();
	   }
   if (n>1) 
   {
    window.irr = 1;
    $('var.highlight').each(function(irr){ $(this).attr('nss', window.irr); window.irr++;  });
   } 
  
 }
var search_p = function()
{
	dosearch();	
}

var error_anim=function()
{
	//alert($(this).attr('id'));
	setTimeout ( function () { alert($(this).attr('id')); $(this).removeClass('error_formi'); }, 2000 );	
}

var search_prev = function()
{
	window.search_step--;
	if(window.search_step>=0)
	{					
		if($('[nss='+window.search_step+']').parents('.block_i').length)
			{
				if(!$('[nss='+window.search_step+']').parents('.block_i').is(".active"))
					{						
						$('[nss='+window.search_step+']').parents('.block_i').find('.i__').parent().parent().addClass("active");
						var id_content=$('.content_block').attr('id_content');
		                CookieList("l_"+id_content,$('[nss='+window.search_step+']').parents('.block_i').find('.i__').parent().parent().attr('rel'),'add');
		                $('[nss='+window.search_step+']').parents('.block_i').find('.i__').empty().append("-");
					}
				
				
			}
		
		
		jQuery.scrollTo('[nss='+window.search_step+']', 1000, {offset:-200});	
	} 

	if(window.search_step<window.n_search_prime)
		{
			
			$('.result_s').find('.se_next').show();
			
		}
	
	
	if(window.search_step==1)
		{
			$('.result_s').find('.se_prev').hide();
			$('.result_s').find('.se_next').show();
			
		} else
			{
				//$('.result_s').find('.se_prev').hide();
				
			}
		
}

var search_next = function()
{
	window.search_step++;
	if(window.search_step<=window.n_search_prime)
	{					
		if($('[nss='+window.search_step+']').parents('.block_i').length)
			{
				if(!$('[nss='+window.search_step+']').parents('.block_i').is(".active"))
					{
						$('[nss='+window.search_step+']').parents('.block_i').find('.i__').parent().parent().addClass("active");
						var id_content=$('.content_block').attr('id_content');
		                CookieList("l_"+id_content,$('[nss='+window.search_step+']').parents('.block_i').find('.i__').parent().parent().attr('rel'),'add');
		                $('[nss='+window.search_step+']').parents('.block_i').find('.i__').empty().append("-");
						
						
					}
				
				
			}
		
		
		jQuery.scrollTo('[nss='+window.search_step+']', 1000, {offset:-200});	
	} 

	if(window.search_step==window.n_search_prime)
		{
			$('.result_s').find('.se_next').hide();
		}
	
	if(window.search_step!=0)
		{
			$('.result_s').find('.se_prev').show();
			
		} else
		{
				$('.result_s').find('.se_prev').hide();
				
		}
	
}

var search_prime = function()
{

	$('.icon1').hide();
	$('.search_seb').show();
	$('.search_seb').width('400px');
	$('.search_seb').find('input').focus();
	window.show_search=1;
	if($('.search_seb').find('input').val()!='')
	{
			dosearch();			
	}
	
}
//поиск по себестоимости
//поиск по себестоимости


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


//проводим безналичный расчет 
var beznal_upload=function()
{
	var id=$(this).attr('id_bez');
	if($.isNumeric($(this).attr("id_bez")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_bez_dialog.php?id='+$(this).attr("id_bez"),
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
/*
var view_notification = function()
{
	if( $('.noti_block').is(':visible') ) {   $('.noti_block').remove(); $('.view__not').hide(); $('.not_li').find('i').hide();  } else 
	{ 	 
	  $('.menu1').append('<div class="noti_block"><div class="title_noti"><ul class="t_ul"><li>Уведомления</li><li><i class="noti_co" style="display:none;"><span class="noti_coc"></span></i></li></ul></div><div class="scro"></div></div>');
	  //отправляем запрос на получение новых уведомлений
	  $('.noti_block').find('.scro').empty().append('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	  var data ='';

      AjaxClient('notification','view_notification','GET',data,'AfterVVN',1,0);	
	}
}
*/

//редактировать исполнителя
var option_imlementer = function()
{
  var id= $('.content_block').attr('id_content');
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_option_implementer.php?id='+id,
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


//добавить исполнителя
var add_imlementer = function()
{
  //var id= $(this).attr('for');

	/*
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_add_implementer.php?id=1',
    afterLoading: function(data, el) {
        //alert('afterLoading');
    },
    afterLoadingOnShow: function(data, el) {
        //alert('afterLoadingOnShow');
    },
	afterClose: function(data, el) { // после закрытия окна ArcticModal
	clearInterval(timerId);
    }

  });*/
	$.arcticmodal({
		type: 'ajax',
		url: 'forms/form_add_implementer.php?id=1',
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


//редактировать исполнителя
var option_imlementer1 = function()
{
  var id= $(this).attr('for');
  /*
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_option_implementer.php?id='+id,
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
		url: 'forms/form_option_implementer.php?id='+id,
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

//выдать наличные исполнителю аванса
var pay_imlementer_avans = function()
{
  var id= $(this).attr('id_avans');
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_pay_implementer_avans.php?id='+id,
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

//выдать наличные исполнителю
var pay_imlementer = function()
{
  var id= $(this).attr('id_rel');
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_pay_implementer.php?id='+id,
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


//открыть историю по реализованной работе в себестоимости
var hist_mu_prime = function()
{
	
var id= $(this).parents('[rel_id]').attr('rel_id');
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_history_realiz_work.php?id='+id,
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


//открыть настройки по дому
var house_options = function()
{
if ( $('.content_block').is("[dom]") )
{
	if($.isNumeric($('.content_block').attr("dom")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_object_options.php?id='+$('.content_block').attr("dom"),
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
  
return false;

		
}

//показать итоговые суммы в загаловках разделов
var summ_view = function()
{
	
	if( $('.summ_blogi').is(':visible') ) { 
	$('.summ_blogi').hide();
	$('.top_bl').find('h2').removeClass('margin_sum ');	
	$(this).removeAttr('on');
	CookieList("it_",'on','del');	
	} else
	{
	$('.summ_blogi').show();
	$('.top_bl').find('h2').addClass('margin_sum ');
	$(this).attr('on','show');
	CookieList("it_",'on','add');	
	}
	
}


//принять накладную
var take_invoice = function()
{
   $('#lalala_pod_form').submit();	
}


//подписать наряд
var sign_naryad = function()
{


   $('#lalala_pod_form').submit();	



}


//утвердить наряд
var seal_naryad = function()
{
   $('#lalala_seal_form').submit();	
}

//распровести наряд
var disband_naryad = function()
{
   $('#lalala_disband_form').submit();	
}

//снять подпись
var shoot_naryad = function()
{
   $('#lalala_shoot_form').submit();	
}

//нажатие на кнопку по решению служебной заявки
var decision_mess_app = function()
{
	var dec=-1;
	if(!$(this).parents('.edit_123').is('.ready'))
	{
		$('.pod_zay').hide(); $('.add_zay').show();
		$(this).parents('.edit_123').find('i').removeClass('active');
	   	if($(this).is('.yes')) { dec=1; }
		if($(this).is('.no')) { dec=0; }
		$(this).addClass('active');
		//alert(dec);
		$(this).parents('.messa').find('.decision_mes').val(dec);
	}
}

//нажатие на кнопку по решению служебной записки наряды
var decision_mess = function()
{
	var dec=-1;
	if(!$(this).parents('.edit_122').is('.ready'))
	{
		$('.js-pod_nar').hide(); $('.js-add_nar').show();
		$(this).parents('.edit_122').find('i').removeClass('active');
	   	if($(this).is('.yes')) { dec=1; }
		if($(this).is('.no')) { dec=0; }
		$(this).addClass('active');
		//alert(dec);
		$(this).parents('.messa').find('.decision_mes').val(dec);
	}
}


//сохранить заявку на материал
var save_zayava = function()
{
	var error=0;

	$('.messa:visible').find('.text_zayva_message_').removeClass('error_formi');




	$('.messa:visible').find('.text_zayva_message_').each(function(i,elem) {
	
		var text=$(this).val();
		if(text=='')
	    {
			error=1;
			$(this).addClass('error_formi');
		}
    });


	$('.mat_zz').find('.count_app_mater_').removeClass('error_formi');
	$('.mat_zz').find('.calendar_zay').removeClass('error_formi');
	
	$('.messa:visible').each(function(i,elem) {
	    var id_work=$(this).attr('id_mes');
		//проверим что все поля для каждой служебной записки заполнены
		
		
		
		var count=$('.mat_zz[mat_zz='+id_work+']').find('.count_app_mater_').val();
		//var price=$('.mat_zz[rel_id='+id_work+']').find('.price_finery_').val();
		
		$('.mat_zz[mat_zz='+id_work+']').find('.count_app_mater_').removeClass('error_formi');
		//$('.mat_zz[mat_zz='+id_work+']').find('.date_r_base').removeClass('error_formi');
		
		if((count==0)||(count=='')||(!$.isNumeric(count)))
	    {
			$('.mat_zz[mat_zz='+id_work+']').find('.count_app_mater_').addClass('error_formi');
			error=1;
		}

		
		/*
		$('.mat[rel_w='+id_work+']').each(function(i,elem) {
		var count=$(this).find('.count_finery_mater_').val();
		var price=$(this).find('.price_finery_mater_').val();
		$(this).find('.price_finery_mater_').removeClass('error_formi');
		$(this).find('.count_finery_mater_').removeClass('error_formi');	
		if((count==0)||(count=='')||(!$.isNumeric(count)))
	    {
			$(this).find('.count_finery_mater_').addClass('error_formi');
			error=1;
		}
		if((price==0)||(price=='')||(!$.isNumeric(price)))
	    {
			$(this).find('.price_finery_mater_').addClass('error_formi');
			error=1;
		}
		});
		*/
		
    });
	$('.js-add-app-material .gloab').each(function(i,elem) {
		if($(this).val() == '')  { $(this).parents('.input_2018').addClass('required_in_2018');
			$(this).parents('.list_2018').addClass('required_in_2018');
			error++;
			//alert($(this).attr('name'));
		} else {$(this).parents('.input_2018').removeClass('required_in_2018');$(this).parents('.list_2018').removeClass('required_in_2018');}
	});



	if(error!=0)
		{
			alert_message('error','Не все поля заполнены для сохранения');
			//$('.error_text_add').empty().append('Не все поля заполнены для сохранения');
			
			//setTimeout ( function () { $('.error_text_add').empty(); }, 7000 );

			
		} else
		{	
		    $('#lalala_add_form').submit();		
		}
	
	
		
}





//редактировать материал к работе в разделе в себестоимости
var edit_m_button_click = function() {
	
if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_material_2021.php?id='+$(this).attr("for"),
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
  
return false;

	
	
}

//удалить материал к работе в разделе в себестоимости
var del_m_button_click = function() {
	
if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_material.php?id='+$(this).attr("for"),
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
  
return false;

}

//добавить материал к работе в разделе в себестоимости
var add_m_button_click = function() {
	
if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_add_material_2021.php?id='+$(this).attr("for"),
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


//распровести операцию по оплате
var DellPay = function() {
if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_pay.php?id='+$(this).attr("id_rel"),
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
  
return false;
	
}

//распровести операцию по оплате
var DellCash = function() {
if ( $(this).is("[id_rel]") )
{
	if($.isNumeric($(this).attr("id_rel")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_disband_cash.php?id='+$(this).attr("id_rel"),
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
  
return false;
	
}


//удалить работу в разделе в себестоимости
var del_button_click = function() {
if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_work.php?id='+$(this).attr("for"),
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
  
return false;
	
}

//редактировать работу в разделе в себестоимости
var edit_button_click = function() {
	
if ( $(this).is("[for]") )
{
	if($.isNumeric($(this).attr("for")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_edit_work_2021.php?id='+$(this).attr("for"),
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
  
return false;

	
	};

//раскрытие раздела в себестоисти
var block_i_i = function() {	

var id_content=$('.content_block').attr('id_content');
	  
	   if($(this).parent().parent().is(".active")) 
	  {
		  $(this).parent().parent().removeClass("active");
		  CookieList("l_"+id_content,$(this).parent().parent().attr('rel'),'del');
		  $(this).empty().append("+");
	  } else
	  {
		  $(this).parent().parent().addClass("active");
		  CookieList("l_"+id_content,$(this).parent().parent().attr('rel'),'add');
		  $(this).empty().append("-");
	  }	
	  
	
};


//проверка выделенных материалов у работы
var MaterialSelectAll = function() {

		  $('[rel_id]').each(function(i,elem) {
			  
	        var length_all_mat_1=$(this).nextUntil(".loader_tr").length;
			var count_all_mnmnm_1=0;  
			$(this).nextUntil(".loader_tr").each(function(i,elem) {
				  
				 	 if($(this).is(".chechers")) 
	                 { 
	                    count_all_mnmnm_1++;
					 }
              });  
			if(count_all_mnmnm_1==length_all_mat_1)
		    { 
			  $(this).find('.addd_icon_mateo').addClass("activ_matt");
			} else
			{
			  $(this).find('.addd_icon_mateo').removeClass("activ_matt");
			}
          });	

}
	
//функция проверки что все материалы у этой работе в корзине для заявок
var basket_all_material = function(thisss) {
 
	var length_all_mat=thisss.parents('.material').prevAll('[rel_id]:first').nextUntil(".loader_tr").length;
	var count_all_mnmnm=0;
	thisss.parents('.material').prevAll('[rel_id]:first').nextUntil(".loader_tr").each(function(i,elem) {
				  
				 	 if($(this).is(".chechers")) 
	                 { 
	                    count_all_mnmnm++;
					 }
              });
	//alert(length_all_mat);
	if(count_all_mnmnm==length_all_mat)
		{
			thisss.parents('.material').prevAll('[rel_id]:first').find('.addd_icon_mateo').addClass("activ_matt");
		} else
			{
				thisss.parents('.material').prevAll('[rel_id]:first').find('.addd_icon_mateo').removeClass("activ_matt");
			}
	
}

//нажать на кнопку выделить все материалы по работе
var add_material_click = function() {
	  if($(this).is(".activ_matt")) 
	  {
		  //значит выделены все материалы по этой работе
		  //$(this).parents('[rel_id]').nextUntil(".loader_tr").remove();
		  $(this).removeClass("activ_matt");
		  
		  $(this).parents('[rel_id]').nextUntil(".loader_tr").each(function(i,elem) {
			  
	           $(this).find('.nm_nm').trigger("click");
          });
		  
	  } else
		  {
			  //не все материалы выделены. но может какие то и выделены
			  $(this).addClass("activ_matt");
			  
			  
		  	  $(this).parents('[rel_id]').nextUntil(".loader_tr").each(function(i,elem) {
				  
				 	 if(!$(this).is(".chechers")) 
	                 { 
	                    $(this).find('.nm_nm').trigger("click");
					 }
              });
		  $(this).addClass("activ_matt");			  
		  }
	
}


//нажать на материал в разделе - добавить в корзину заявок
var nm_div = function() {
	
	var id_dom=$('.content_block').attr('dom');
	if(!$('.add_v_zay').length)
	{
	  if($(this).parents('[rel_ma]').is(".chechers")) 
	  {
		  //убрали выделение
		  $(this).parent().parent().removeClass("chechers");

		  CookieList(window.b_cm+"_"+id_dom,$(this).parents('[rel_ma]').attr('rel_ma'),'del','sort');	
		 // alert($(this).parents('[rel_id]').attr('rel_id'));
		  BasketMaterial(); 
		  basket_all_material($(this));
		  ToolTip();
	  } else
	  {
		  $(this).parent().parent().addClass("chechers");
		  CookieList(window.b_cm+"_"+id_dom,$(this).parents('[rel_ma]').attr('rel_ma'),'add','sort');
		  BasketMaterial();	
		  basket_all_material($(this));
		  ToolTip();	  
	  }	
	} else
	{
		if($(this).parents('[rel_ma]').is(".chechers")) 
	  {
		  //убрали выделение
		  $(this).parent().parent().removeClass("chechers");
		  CookieList(window.b_co+"_"+id_dom,$(this).parents('[rel_ma]').attr('rel_ma'),'del','sort');	
		 // alert($(this).parents('[rel_id]').attr('rel_id'));
		  BasketMaterial(); 
		  basket_all_material($(this));
		  ToolTip();
	  } else
	  {
		  $(this).parent().parent().addClass("chechers");
		  CookieList(window.b_co+"_"+id_dom,$(this).parents('[rel_ma]').attr('rel_ma'),'add','sort');
		  BasketMaterial();	
		  basket_all_material($(this));
		  ToolTip();	  
	  }		
	}
	
}

//нажатие на стрелку вернуть к выбору себестоимости в общей таблице
var close_prime_dom = function() {
   //CookieList(window.b_co+"_"+id_dom,$(this).parents('[rel_id]').attr('rel_id'),'del');
   var id_dom=$('.content_block').attr('dom'); 
   $.cookie("pr_", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
	//alert("!");
   $('.close_prime_dom_a')[0].click(); ;	
}




//нажать на работу в разделе - добавить в корзину
var st_div = function() {
	
	var id_dom=$('.content_block').attr('dom');
	
	  if($(this).parents('[rel_id]').is(".checher")) 
	  {
		  $(this).parent().parent().removeClass("checher");
		  CookieList(window.b_co+"_"+id_dom,$(this).parents('[rel_id]').attr('rel_id'),'del');	
		 // alert($(this).parents('[rel_id]').attr('rel_id'));
		  BasketFinery();  
		  ToolTip();
	  } else
	  {
		  $(this).parent().parent().addClass("checher");
		  CookieList(window.b_co+"_"+id_dom,$(this).parents('[rel_id]').attr('rel_id'),'add');
		  BasketFinery();	
		  ToolTip();	  
	  }	
	
}

//удалить всю себестоимость по дому
var del_sebe = function() {
	



if ( $('.content_block').is("[dom]") )
{
	if($.isNumeric($('.content_block').attr("dom")))
	{
  $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_dell_sebe.php?id='+$('.content_block').attr("dom"),
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
  
return false;
	
	};


//обновление реакций по нажатию в блоке. открытие, иконки, добавление в корзину, удаление работы, редактирование работы, добавление работы и т.д.
//выполнять при добавление нового блока, работы, материала
var update_block = function() {
	//открытие плюс минус
	$(".block_i .i__").unbind('click');
	$(".block_i .i__").bind('click', block_i_i);
	//иконки блока удалить редактировать добавить работу
	$(".edit_icon_block").unbind('click');
    $(".edit_icon_block").bind('click', edit_button_block);
	$(".del_icon_block").unbind('click');
    $(".del_icon_block").bind('click', del_button_block);
	$(".add_icon_block").unbind('click');
    $(".add_icon_block").bind('click', add_button_rabota);	
	//корзина нарядов выделение работ в блоки
	$('.st_div').unbind( "click");
	$('.st_div').bind( "click", st_div);
	
	//корзина заявок на материал выделение материалов в блоки
	$('.nm_nm').unbind( "click");
	$('.nm_nm').bind( "click", nm_div);
	
	//иконки работ в блоке удалить редактировать
	$(".edit_icon").unbind('click');
	$(".edit_icon").bind('click', edit_button_click);
	
	
	$(".UGRAFE").unbind('click');
	$(".UGRAFE").bind('click', edit_grafik_click);
	
	
	$(".del_icon").unbind('click');
	$(".del_icon").bind('click', del_button_click);	
	$(".addd_icon").unbind('click');
	$(".addd_icon").bind('click', add_m_button_click);	
	
	//addd_icon_mateo
	$(".addd_icon_mateo").unbind('click');
	$(".addd_icon_mateo").bind('click', add_material_click);	
	
	
	//иконки работы с материалами
	$(".edit_icon_m").unbind('click');
	$(".edit_icon_m").bind('click', edit_m_button_click);
	$(".del_icon_m").unbind('click');
	$(".del_icon_m").bind('click', del_m_button_click);		
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
			$('.js-add_nar').show();
			$('.js-pod_nar').hide();
		}
	}
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

var savedefault_zay = function (thiss)
{
	//lert("!");
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
			$('.add_zay').show();
			$('.pod_zay').hide();
		}
	}
}


$(function (){
	animation_teps();
$(window).on('resize',windowSize);	

$('.loader_ada').remove();
$('.loader_ada1').remove();
		
	
BasketFinery(); //проверка корзины нарядов	
BasketMaterial(); //проверка корзины материалов
MaterialSelectAll(); //выделение кнопок выделить все материалы по работе
	
jQuery('.scrollbar-inner').scrollbar(); //скрулл меню при малой высоте
ToolTip();  //подсказки при наведении
sl_message_width();
$('.label_s').bind("change keyup input click", label_show);

//форма добавление тура - выбор паспорт какой
	$('body').on("change keyup input click",'.js-password-butt',password_butt);
	//нажатие на отдельные chtckbox залки в определенной группе
	$('body').on("change keyup input click",'.js-checkbox-group',CheckboxGroup);


	$('body').on("change keyup input click",'.js-type-soft-view1',MemoButType);

$('body').on("change keyup input click",'.tabs_005U',{key: "005U"},tabs_app);

	$('body').on("change keyup input click",'.js-sign-a',SingFo);


	$('body').on("change keyup input click",'.js-reject-app',RejectFo);
	$('body').on("change keyup input click",'.js-forward-app',ForwardFo);

//делаем поля с классом только дробными и целыми числами		
//$('.smeta1').on("change keyup input click",'.count_mask',function(){ $(this).val($(this).val().replace(/[^\d.]*/g, '').replace(/([.])[.]+/g, '$1').replace(/^[^\d]*(\d+([.]\d{0,5})?).*$/g, '$1'));  });
	$('body').on("click",'.burger_ok',SliceMM);
	$('.menu_x').clone().appendTo(".mobile-nav span");
//
$('body').on("keyup",'.loll_soply',search_posta);	
$('body').on("click",'.loll_soply',search_posta1);	
$('body').on("change keyup input click",'.loll_drop li',search_posta_li);
$('body').on("change keyup input click",'.label_exitt',search_posta_li2);
	

$('body').on("change keyup input click",'.loll_plus',plus_postt)	

$('.suppp_tr').on("change keyup input click",'.yoop_click',yoop_click)	

	
$('.save_button2').bind("change keyup input click", send_meee);
	
$('.content').on("click",'.send_mess',SendMessage);	
$('.help_user').on("click",'.send_mess',SendMessage);

//$('.menu_jjs').on("change keyup input click",'.menu_click',menuclick);

$('body').on("change keyup input click",'.menu_click',menuclick);

//$('.menu_click').bind("change keyup input click", menuclick);
	
$('.js-close_prime_dom	').on('click', close_prime_dom);
	
$('.pay_imp').on("click",'.beznal_upload',beznal_upload);		
	

$('.div_dialog').on("click",'.dialog_a',function(e) {  if($(e.target).closest(".del_dialog").length==0)
  {
	var dialog_id=$(this).attr('rel_diagol');
	$(this).attr('href','/message/dialog/'+dialog_id+'/');
	$(this).trigger('Click');

  } });


	
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

      xhr.open("POST", "invoices/upload.php", true);
      //xhr.send(file);
	
	 var formData = new FormData();
     formData.append("thefile", file);
	 formData.append("id",id);
     xhr.send(formData);

    }

	
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

	$('.block_invoice_20188').on("change keyup input click",".del_invoice", dell_invoice);

//	$('.invoice_block').on("change keyup input click",".del_invoice_material", dell_invoice_material);
//	$('.invoice_block').on("change keyup input click",".material_defect", material_defect);
	
//	$('.invoice_block').on("change keyup input click",".del_invoice_akt", material_defect_dell);
	
	
	$('.messa_form_a').on("change",'.invoice_file_photo',UploadInvoicePhotoChange);
	$('.messa_form_a').on("change",'.invoice_file_akt',UploadInvoiceAktChange);	
	
	$('.invoice_block').on("click",".add_akt_defect", UploadInvoiceAkt);	
	$('.invoice_block').on("click",".add_akt_defect1", UploadInvoicePhoto);
	
	$('.invoice_block').on("change keyup input click",".count_defect_in_,.text_zayva_message_,.del_invoice_akt",function(){ $(this).parents('[invoices_messa]').find('.print_invoice_akt').hide(); });

//показать скрыть пароль глазик
	$('body').on("click",'.ais',Eye);

	$('body').on("change keyup input click",".js-save-setting", save_setting);
	
	$('.invoice_block').on("change keyup input click",".count_defect_in_,.count_in_", BrakError);
	
		$('.invoice_block').on("change keyup input click",".count_in_", ErrorMax);
	


	
	
$('.invoice_block').on("change",'#ispol_invoice',UpdateContractorInvoice);
//$('.invoice_block').on("change",'#ispol_type_invoice',nds_invoice);
	


$('.img_invoice_div').on("click",'.del_image_invoice',DellImageInvoice);	

$('.img_invoice_div').on("click",'.invoice_upload',UploadInvoice);
$('.img_invoice_div').on("change",'.sc_sc_loo12',UploadInvoiceChange);


//загрузить фото в настройках
	$('.l_photo').on("change keyup input click",'.invoice_upload',UploadInvoice_old);
	$('.content').on("change",'.sc_sc_loos2',UploadReportsChange_old);

$('body').on("click",'.soply_upload',UploadScanS);
$('body').on("change",'.sc_sc_loo11',UploadScanSChange);
	
$('.bill_table').on("change keyup input click",'.xvg_bill_score',xvg_bill);	

$('.bill_table').on("change keyup input click",'.xvg_no',xvg_no);
$('.bill_table').on("change keyup input click",'.xvg_yes',xvg_yes);
	
$('.stock_table_list').on("change keyup input click",'.xvg_no1',xvg_no1);	
$('.stock_table_list').on("change keyup input click",'.xvg_yes1',xvg_yes1);		

$('.booker_table').on("change keyup input click",'.booker_yes',booker_yes);	
	
$('.pay_imp').on("click",'.naryd_upload',UploadScan);
$('.pay_imp').on("change",'.sc_sc_loo',UploadScanChange);
$('.pay_imp').on("click",'.rasp_pay',DellCash);
$('.pay_imp').on("click",'.del_pay',DellPay);


jQuery(document).on("focus click",'.input_new_2018',InputFocusNew);	
jQuery(document).on("blur",'.input_new_2018',InputBlurNew);
	jQuery(document).on("keyup",'.input_new_2018',KeyUpInput);

	jQuery(document).on("focus click",'.input_new_2021',InputFocusNew2021);
	jQuery(document).on("blur",'.input_new_2021',InputBlurNew2021);



	//jQuery(document).on("focus click",'.input_new_2021',InputFocusNew2021);
	//jQuery(document).on("blur",'.input_new_2021',InputBlurNew2021);
	jQuery(document).on("keyup",'.input_new_2021',KeyUpInput2021);


	//jQuery(document).on("click",'.print_stock_',PrintStock_);
	
$('.suppp_tr').on("click",'.supply_tr_o',ChangeSupply);


$('.notif_imp').on("click",'.del_notif',DellNotif);
	$('.notif_div_2018').on("click",'.del_notif',DellNotif);



$('.mat_zz').on("click",'.del_material_zayva',DellZayvaMaterial);		
$('.mat_zz').on("click",'.del_material_zayva1',DellZayvaMaterial1);	
$('.work__s').on("click",'.del_naryd_work',DellNarydWork);	
$('.work__s').on("click",'.del_naryd_work1',DellNarydWork1);
$('.smeta2').on("click",'.del_naryd',DellNaryd);
$('.smeta2').on("click",'.del_zay_zay',DellZayZay);	


//клик по иконки показать историю нарядов по работе
$('.work__s').on("click",'.history_icon',HistoryN);
	$('.mattx,.js-more-acc-view').on("click",'.history_icon',HistoryN1);

//контроль ввода количества материала при оформлении заявки на материал
$('.mat_zz').on("change keyup input click",'.count_app_mater_',MmyHandlerApp);		
	
//контроль ввода стоимости материала при оформлении наряда
//$('.mat').on("change keyup input click",'.price_finery_mater_',MmyHandler);	
	
	
//контроль ввода количества материала при оформлении наряда
$('.mat').on("change keyup input click",'.count_finery_mater_',MmyHandler);	
$('.mat').on("change keyup input click",'.count_finery_mater_',MmyHandlerXX);		
//контроль ввода количества при оформлении наряда
$('.work__s').on("change keyup input click",'.count_finery_',myHandler);	
//контроль ввода стоимости при оформлении наряда
$('.work__s').on("change keyup input click",'.price_finery_',myHandler1);
//выводить по двойному щелчку по полю его макс возможное значение
$('.work__s').on("dblclick",'.count_finery_,.price_finery_',Mydblclick);	
$('.mat').on("dblclick",'.count_finery_mater_',Mydblclick);	
	
setTimeout ( function () { 
	
	//если что-то меняешь в работе  то удаляем все решения по служ.запискам включая материал
	$('.workx').on("change keyup input click",'.count_finery_,.price_finery_,.text_finery_message_',function(){ if($(this).attr('readonly')==undefined) {  var thiss = $(this);   var id_s=thiss.parents('[work]').attr('work'); $('[work='+id_s+']').find('.edit_12').remove();  $('[work='+id_s+']').find('.edit_122').find('i').removeClass('active'); $('[work='+id_s+']').find('.decision_mes').val("-1");   }  });	

	//если что-то меняешь в материале  то удаляем все решения по служ.записке этого материала
	$('.mattx').on("change keyup input click",'.count_finery_mater_,.price_finery_mater_,.text_finery_message_',function(){ if($(this).attr('readonly')==undefined) {  var thiss = $(this); var work=thiss.parents('[work]').attr('work');   var id_s=thiss.parents('[rel_matx]').attr('rel_matx'); $('[id_mes='+work+'_'+id_s+']').find('.edit_12').remove(); $('[id_mes='+work+'_'+id_s+']').find('.edit_122').find('i').removeClass('active'); $('[id_mes='+work+'_'+id_s+']').find('.decision_mes').val("-1");     }  });	

	
		//если переход в любое редактируемое поле наряда то сбрасывать кнопку подписать и показывать кнопку сохранить
	$('.my_n').on("change keyup input click.naryd",'.count_finery_mater_,.price_finery_mater_,.text_finery_message_,.count_finery_,.price_finery_,.slct_box,#date_table,#date_table1',function(){ $('.js-pod_nar').hide(); $('.js-add_nar').show();  });
	
	
	
	//если что-то меняешь в материале  то удаляем все решения по служ.записке этого материала в заявках на материал
	$('.my_nn').on("change keyup input click",'.count_app_mater_,.calendar_zay,.text_zayva_message_',function(){if(($(this).attr('readonly')==undefined)||(($(this).attr('disabled')==undefined)&&($(this).is('.calendar_zay')))) {  var thiss = $(this); var work=thiss.parents('[mat_zz]').attr('mat_zz'); $('[mat_zz='+work+']').find('.edit_12').remove(); $('[mat_zz='+work+']').find('.edit_123').find('i').removeClass('active'); $('[mat_zz='+work+']').find('.decision_mes').val("-1");     }  });	
	//если переход в любое редактируемое поле служебной записки то сбрасывать кнопку заказать на сохранить
	$('.my_nn').on("change keyup input click",'.count_app_mater_,.calendar_zay,.text_zayva_message_,.js-zame-tours',function(){  if(($(this).attr('readonly')==undefined)||(($(this).attr('disabled')==undefined)&&($(this).is('.calendar_zay')))) {  $('.pod_zay').hide(); $('.add_zay').show(); }   });

	$('.js-acc-view').on("change keyup input click",'.count_xvg_,.price_xvg_,.delivery_xvg_',function(){  if(($(this).attr('readonly')==undefined)||(($(this).attr('disabled')==undefined)&&($(this).is('.calendar_zay')))) {  $('.pod_zay').hide(); $('.add_zay').show(); }   });

	
	$('.zay_2020').on("change keyup input click",'.del_material_zayva1,.zayva_del_naf',function(){ if(($(this).attr('readonly')==undefined)||(($(this).attr('disabled')==undefined)&&($(this).is('.calendar_zay')))) {  $('.pod_zay').hide(); $('.add_zay').show(); } });
	
	
	}, 2000 );
	


//выводить по двойному щелчку по полю его макс возможное значение - заявка на материал	
$('.mat_zz').on("dblclick",'.count_app_mater_',Mydblclick);
	
//выход из системы при бездействии
idleTimer = null;
timerS = null;	
timerH=null;	
idleState = false; // состояние отсутствия
idleWait = 30*60*1000; // время ожидания в мс. (1/1000 секунды) - 30 минут
idTimeStampe=0;	
ExitSystem();
//выход из системы при бездействии
	

//window.is_session='eico.atsun.ru';
	

//уведомления настройки	
idleTimerx = null;
timerSx = null;	
idleStatex = false; // состояние отсутствия
idleWait_start = 30*1000; // время обновления notification - каждые 30 секунд 
idleWait_stop = 5*60*1000; // время простоя после которого скрипт начинает обращаться реже к обновлениям - 5 минут	
idleWait_end = 2*60*1000; // время обновления notification после простоя системы в течении 5 минут - каждые 2 минуты
idleWait_yes=idleWait_start;	
idTimeStampex=0;	
NotifSystem();
$('<audio id="chatAudio"><source src="notify.ogg" type="audio/ogg"><source src="notify.mp3" type="audio/mpeg"><source src="notify.wav" type="audio/wav"></audio>').appendTo('body');	
//уведомления настройки	
	
nprogress=0; //показывать загрузчик линию при ajax запросах	

//1000 м.сек
	setInterval(function(){ $this=inWindow(".Effectbbo");  if(inWindow(".Effectbbo").length!=0) {   setTimeout ( function () {  $this.removeClass('yes_bbs1'); }, 5000 );  }  }, 1000); // 1000 м.сек




update_block();
$('.menu1').on("click",'.count_numb_score',save_soply);

	
	

//$('.mkr_,.smeta2').on("change",'.option_mat',option_mat);	

$('.mkr_').on("change",'.option_mat',option_mat);		
	
$('.button_ada_wall').on("change",'.option_mat1',option_mat1);	
	
//$('.scope_scope').on("change",'.option_score1',option_score1);
$('.statusis').on("change",'.vall_supply', vall_supply);	
//$(".drops").find("li").bind('click', droplis);
	
$('.menu_top,.smeta2').on("click",'.drops li',droplis);	
//анимация линеек



$('.skladd_nei').bind('click', slide_skkk);		
	
	
//выдать наличные исполнителю за работу
$(".pay_baks,.js-pay_baks_top").bind('click', pay_imlementer);

//выдача аванса
$(".pay_avans,.js-pay_avans_top").bind('click', pay_imlementer_avans);
	
//Редактировать данные по исполнителю	
$(".imp_option").bind('click', option_imlementer);	
	
//Изменить исполнителю	
$(".edit_implem").bind('click', option_imlementer1);

//добавить исполнителю	
$(".add__ispoln").bind('click', add_imlementer);	

//удалить диалог
$(".del_dialog").bind('click', del_dialog);	
	
//открыть уведомления
//$(".view__not").bind('click', view_notification);
	
//нажатие на кнопку да или нет по решению служебной записки
$(".edit_122").find('i').bind('click', decision_mess);		

//нажатие на кнопку да или нет по решению служебной записки
$(".edit_123").find('i').bind('click', decision_mess_app);		
	
//нажатие на кнопку сохранить наряд
//$(".add_nar").bind('click', save_naryad);


	

//нажатие на кнопку добавить наименование на склад
//$(".add_invoice1").bind('click', add_invoice1);
	
	
	


//нажатие на кнопку сохранить накладную
//$(".add_invoicess1").bind('click', save_invoicess1);

//нажатие на кнопку сохранить заявку на материал
$(".js-add-app").bind('click', save_zayava);
	
//нажатие на кнопку подписать наряд
$(".js-pod_pro").bind('click', sign_naryad);

//нажатие на кнопку подписать наряд
$(".transfer_invoicess").bind('click', take_invoice);		
	
//нажатие на кнопку согласовать наряд
$(".sogl_pro").bind('click', sign_naryad);	
	
//нажатие на кнопку утвердить наряд
$(".js-ut_nar").bind('click', seal_naryad);

//нажатие на кнопку распровести наряд
$(".js-rasp_nar").bind('click', disband_naryad);
	
//снять подпись
$(".shoot").bind('click', shoot_naryad);	
	
$('#lalala_add_form').on("change keyup input click",'.error_formi', function(){ $this = $(this); setTimeout ( function () {$this.removeClass('error_formi');  }, 2000 ); });	
	
//удалить всю себестоимость по дому
$(".del__seb").bind('click', del_sebe);

//показать себестоимость с суммами
$(".icon17").bind('click', summ_view);	


//поиск по себестоимости	
$('.icon3').bind('click', search_prime);

//закрытие поиска себестоимости при клике вне его	
window.show_search=0;	
$("body").click(function(e) {
	
    if(($(e.target).closest(".search_seb").length==0)&&($(e.target).closest(".icon3").length==0) ){
		//alert(window.show_search);
		//если вне поиска и кнопки поиск то если открыт поиск закрыть
		if(window.show_search==1)
			{
				//alert("!");
				//$('.debug').empty().append($(e.target).attr("class"));
	$('.icon1-xxx').show();
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
	
	if(($(e.target).closest(".noti_block").length==0)&&($(e.target).closest(".view__not").length==0)  ){
		if( $('.noti_block').is(':visible') ) {
	       $('.noti_block').remove();
	       $('.view__not').hide(); $('.not_li').find('i').hide();	
		}
		}

	if(($(e.target).closest(".history_act_mat").length==0)&&($(e.target).closest(".edit_panel11_mat").length==0)  ){
		if( $('.history_act_mat').is(':visible') ) {

			$('.history_act_mat').hide();
			e.stopPropagation();
			//alert("1");
		}
	}


	
});

//обработчики для листания по найденным местам в себестоимости	
$('.result_s').find('.se_next').bind('click', search_next);
$('.result_s').find('.se_prev').bind('click', search_prev);
	
//нажатие на кнопку искать при вводе текста в поиске	
$('.search_seb').find('i').bind('click', search_p);

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

//переход на старину оформления наряды при клике по иконке	
$('.menu1').on("click",'.naryd_end i', function(){ $(this).prev('a')[0].click(); });
	
$('.menu1').on("click",'.material_end i', function(){ $(this).prev('a')[0].click(); });		

$('.text_finery_message_').bind('change keyup input click', function(){  savedefault($(this)); });

$('.text_zayva_message_').bind('change keyup input click', function(){  savedefault_zay($(this)); });	
	
//настройки дома 	
$(".icon2").bind('click', house_options);	
	
//нажать на количество реализации работы в себестоимости
$(".hist_mu").bind('click', hist_mu_prime);	
	

	
	//закрыть все разделы
$(".close_all_r").bind('click', close_all_razdel);

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
		$("#password_formi").addClass('error_formi');

	} else
	{
		$("#password_formi").removeClass('error_formi');
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

	//перейти в себестоимость по объекту по клику меню сверху с выбранным объектом
$('.menu1').on('click','.menu3_prime li',  function(){ $(this).children('a')[0].click(); });
	
//свернуть развернуть левое основное меню
	/*
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
*/
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


	var to_k = $(".form-rate-ok1");
	if (to_k.has(e.target).length === 0){
		//клик вне блока и включающих в него элементов
		//to_k.find(".drops").css("transform", "scaleY(0)");
		to_k.removeClass('show-form-rate1');
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

$('body').on("click",'.slct_box',slctclick_box1);
//$(".slct_box").bind('click', slctclick_box);

//$(".slct_box").bind('click', slctclick_box1);


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

$('body').on("click",'.drop_box li',dropli_box1);
//$(".drop_box").find("li").bind('click', dropli_box);

//$(".drop_box").find("li").bind('click', dropli_box1);
		
	

//меню выбора города-квартала и дома в себестоимости	
//меню выбора города-квартала и дома в себестоимости
//меню выбора города-квартала и дома в себестоимости	

	
	
/*клик на раскрывающее меню квартал*/
	/*
$(document).mouseup(function (e) {
    var container = $(".select");
    if (container.has(e.target).length === 0){
        //клик вне блока и включающих в него элементов
	    //$(".drop").hide();
		$(".drop").css("transform", "scaleY(0)");
		$(".slct").removeClass("active");
    }
});
*/
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
			$(this).parents('.list_2021').removeClass('active1_in_2018x');
		} else
		{
			$(this).addClass("active");
			//$(this).next().show();
			$(this).next().css("transform", "scaleY(1)");

			$(this).parents('.list_2021').addClass('active1_in_2018x');
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
			$(this).parents('.list_2021').removeClass('active1_in_2018x');
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

/*
	  if($(this).is(".active")) 
	  {
		  $(this).removeClass("active");
		  //$(this).next().hide();
		  $(this).next().css("transform", "scaleY(0)");
	  } else
	  {
		  $(this).addClass("active");
		  //$(this).next().show();
		  $(this).next().css("transform", "scaleY(1)");
	  }




var elemss=$(this).attr('list_number');	


$('.slct').each(function(i,elem) 
{
    var att=$(this).attr('data_src');
	//закрыть все кроме себя
	if ($(this).attr('list_number')!=elemss) {  	
			$(this).removeClass("active");
			//$(this).next().hide();
		$(this).next().css("transform", "scaleY(0)");
	} 
});	
	
	
	 
		  
return false;
*/
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
			    $(this).parent().find("li").removeClass("sel_active");
			    $(this).addClass("sel_active");
			  
			
			  
			 // $(this).parent().parent().find(".slct").removeClass("active").html(f);
			   $(this).parent().parent().find(".slct").removeClass("active").empty().append(f);
			   $(this).parent().parent().find(".slct").attr("data_src",e);
				  $(this).parents('.list_2021').addClass('active_in_2018x');
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



	
//$('#save').bind('change', changesave);	

var list_number	= function() {
	var active_new=$(this).find("a").attr("rel");
	if(active_new==2)
		{
			$("#date_table").show(); 
		}
}
	
/*клик на раскрывающее меню сортировка снабжение*/
var changesort2 = function() {  
$.cookie("su_2", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
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
}

};
$('#sort2').bind('change', changesort2);	
	
	
$('[list_number=t2]').next().find('li').bind('click', list_number);		

var changesort1 = function() {  
$.cookie("su_1", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_1",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');


};
$('#sort1').bind('change', changesort1);	


	
var changesort_stock3 = function() {  
$.cookie("su_st_3", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_st_3",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');

};
$('#sort_stock3').bind('change', changesort_stock3);		
	

var changesort_stock1 = function() {  
$.cookie("su_st_1", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_st_1",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');

};
$('#sort_stock1').bind('change', changesort_stock1);	
	
var changesort_stock2__= function() {  
	$.cookie("su_st_2", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
	$(this).prev().val('');

	$('.js--sort').removeClass('greei_input');
	$('.js--sort').find('input').removeAttr('readonly');



	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');
	$(this).hide();	
}
	
	
var changesort_stock2= function() {  
$.cookie("su_st_2", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_st_2",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');
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


};
$('.name_stock_search_input').bind('change keyup input click', changesort_stock2);	
	
	
$('.dell_stock_search').bind('change keyup input click', changesort_stock2__);	





/*
var vall_basket2 = function() {  
	var el_v=$(this).val();
	//alert(el_v);
	if(el_v==1)
	{	
		//сохранить текущий
		save_soply();
	}
	if(el_v==2)
	{
		//закрыть текущий
		var iu=$('.content_block').attr('iu');		
		$.cookie("current_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
		$.cookie("basket_score_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
		$.cookie("basket_supply_"+iu, null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
		
		$('.current_score').find('.number_score').empty();
		$('.current_score').find('.count_numb_score').empty();
		$('.current_score').hide();
		$('.more_supply2').hide();
		
		$('.checher_supply').removeClass('checher_supply');
		$('.score_active').removeClass('score_active');
	}	
	if(el_v==3)
	{
	  //открыть
		var iu=$('.content_block').attr('iu');	
		var cookie_flag_current = $.cookie('current_supply_'+iu);
	//alert(cookie_new);
	if(cookie_flag_current!=null) 
	{	
		id_soply=cookie_flag_current;
	
		
		
		 $.arcticmodal({
    type: 'ajax',
    url: 'forms/form_update_soply.php?id='+id_soply,
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
};	
*/
	
	/*
var vall_basket = function() {  
	var el_v=$(this).val();
	//alert(el_v);
	if(el_v==1)
	{
	    //добавить новый счет
		add_soply();
		
	}
	
	if(el_v==2)
	{
		//Очистить корзину
		erase_basket();
	}
	
	
	//$('[rel_status='+$(this).attr('rel')+']').hide();
	//var data ='url='+window.location.href+'&id='+$(this).attr('rel')+'&val='+el_v;
	//AjaxClient('supply','status_work','GET',data,'Aftervall_supply',$(this).attr('rel'),0);			
};	
*/
//$('.vall_basket').bind('change', vall_basket);
//$('.vall_basket2').bind('change', vall_basket2);

//$('.option_score1').bind('change', option_score1);		

var changesortbill4 = function() {  
$.cookie("bi_4", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("bi_4",$(this).val(),'add');
$('.show_sort_supply').removeClass('active_supply');
$('.show_sort_supply').addClass('active_supply');	

};
$('#sortb4').bind('change', changesortbill4);		

var changesortbill3 = function() {  
$.cookie("bi_3", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("bi_3",$(this).val(),'add');
$('.show_sort_supply').removeClass('active_supply');
$('.show_sort_supply').addClass('active_supply');	

};
$('#sortb3').bind('change', changesortbill3);	
	
var changesort3 = function() {  
$.cookie("su_3", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_3",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');


};
$('#sort3').bind('change', changesort3);	
	
	
var changesort4 = function() {  
$.cookie("su_4", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_4",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');


};
$('#sort4').bind('change', changesort4);	
	
	

var changesort_stock4 = function() {  
$.cookie("su_st_4", null, {path:'/',domain: window.is_session,secure: false,samesite:'lax'});
CookieList("su_st_4",$(this).val(),'add');
	$('.js-reload-top').removeClass('active-r');
	$('.js-reload-top').addClass('active-r');

};
$('#sort_stock4').bind('change', changesort_stock4);	
	

/*клик на раскрывающее меню квартал*/
var changecity = function() {  

 //удаляются старые меню
var data ='url='+window.location.href+'&id='+$(this).val();
$('.menu2_prime').hide();
$('.menu3_prime').hide();
AjaxClient('menu_prime','city','GET',data,'AfterChangeCity','1',0);	

};
$('#city').bind('change', changecity);
	
	

window.changekvartal = function() {  

 //удаляются старые меню
var data ='url='+window.location.href+'&id='+$(this).val();
$('.menu3_prime').hide();
AjaxClient('menu_prime','kvartal','GET',data,'AfterChangeKvartal','1',0);	

};
$('#kvartal').bind('change', changekvartal);

});
 

function AfterUpdateCostFinery(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		$('.mat[rel_mat='+update+']').find('.price_finery_mater_').val(data.cost);
		
		
	var rel_id=$('.mat[rel_mat='+update+']').find('.price_finery_mater_').parents('.mat').attr('rel_w');
	var rel_mat=$('.mat[rel_mat='+update+']').find('.price_finery_mater_').parents('.mat').attr('rel_mat');
	
	var max=parseFloat($('.mat[rel_mat='+update+']').find('.price_finery_mater_').attr('max'));
	var my=parseFloat($('.mat[rel_mat='+update+']').find('.price_finery_mater_').attr('my'));
	//alert(max);
	var value=$('.mat[rel_mat='+update+']').find('.price_finery_mater_').val();	
	$('.mat[rel_mat='+update+']').find('.price_finery_mater_').removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		if(((parseFloat(value)>max)&&(!isNaN(max)))||(parseFloat(value)>my))
			{
				//выделяем красным и открываем служебную записку
				$('.mat[rel_mat='+update+']').find('.price_finery_mater_').addClass('redaas');
			} 				
	} 
		
		
	    serv_mess_m($('.mat[rel_mat='+update+']').find('.price_finery_mater_'));
	    summ_finery1(update);
	}
	if ( data.status=='error' )
    {
		$('.mat[rel_mat='+update+']').find('.price_finery_mater_').val('');
		
		
					var rel_id=$('.mat[rel_mat='+update+']').find('.price_finery_mater_').parents('.mat').attr('rel_w');
	var rel_mat=$('.mat[rel_mat='+update+']').find('.price_finery_mater_').parents('.mat').attr('rel_mat');
	
	var max=parseFloat($('.mat[rel_mat='+update+']').find('.price_finery_mater_').attr('max'));
	var my=parseFloat($('.mat[rel_mat='+update+']').find('.price_finery_mater_').attr('my'));
	
	var value=$('.mat[rel_mat='+update+']').find('.price_finery_mater_').val();	
	$('.mat[rel_mat='+update+']').find('.price_finery_mater_').removeClass('redaas');
	if((value!=0)&&(value!='')&&($.isNumeric(value)))
	{
		if(((parseFloat(value)!=max)&&(!isNaN(max)))||(parseFloat(value)>my))
			{
				//выделяем красным и открываем служебную записку
				$('.mat[rel_mat='+update+']').find('.price_finery_mater_').addClass('redaas');	
			} 
				
	} 		
		
		
		serv_mess_m($('.mat[rel_mat='+update+']').find('.price_finery_mater_'));
	    summ_finery1(update);
	}
}


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



//постфункция обновление актов на отбраковку и фоток брака
function AfterUpdateAkt(data,update)
{
	
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		
		if(update==0)
			{
				$('[invoices_messa='+data.id+']').find('.img_akt ul').empty().append(data.echo);
			} else
				
				{
					$('[invoices_messa='+data.id+']').find('.img_akt1 ul').empty().append(data.echo);
				}
		
		
	}
	
	
}





//постфункция обновление статусов
function Afterupdate_status(data,update)
{
	if ( data.status=='ok' )
    {
		//alert(update);
	    var cc = update.split('.');
	    for ( var t = 0; t < cc.length; t++ ) 
	    { 	
		     $('[supply_id='+cc[t]+']').find('.statusis').empty().append(data.basket[t]);
			$('[supply_id='+cc[t]+']').find('.mkr_').empty();
			
	    }
		
		
		
	}
	
	
	
}


function Aftervall_supply(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		//alert(update);
		$('[rel_status='+update+']').after(data.status_echo).remove();
		
		var si= $('[rel_status='+update+']').parents('[supply_stock]').attr('supply_stock');
		
		var si1=si.split('_');
		UpdateStatusADA(si1[0]);
		
		
		
	}
	if ( data.status=='error' )
    {
		
		
		
	}
}


function AfterChangeCity(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
		$('.menu2_prime').remove();
        $('.menu3_prime').remove();
		$('.menu1_prime').after(data.echo);
		$(".slct").unbind('click.sys');
		$(".slct").bind('click.sys', slctclick);
		$(".drop").find("li").unbind('click');
		$(".drop").find("li").bind('click', dropli);
		$('#kvartal').unbind('change');
		$('#kvartal').bind('change', changekvartal);
		
	} 
	if ( data.status=='error' )
    {		
		$('.menu2_prime').show();
        $('.menu3_prime').show();	
	}
	//alert(data.echo);
}

function AfterNofi(data,update)
{
	nprogress=0;
	if ( data.status=='update' )
    {
		//узнаем что за новые уведомления у пользователя и выводим их
		var dialog=0;
		var date='';
		if($('.message_block').length!=0)
		{
		   dialog = $('.message_block').attr('id_content');
		   date=$('[dmes_e]:last').attr('dmes_e');	
		}
			
		
		
		var data ='tk='+data.token+'&id_dialog='+dialog+'&date='+date;
		AjaxClient('notification','notification','GET',data,'AfterNotification','1',0);
	}
}

//постфункция удаления материала из накладной
function AfterDellMaterialInvoice(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	} 
	if ( data.status=='ok' )
    {
		$('[invoice_material='+update+']').remove();
		$('[invoices_messa='+update+']').next().remove();
		$('[invoices_messa='+update+']').remove();
		
		
		itog_invoice();
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

//постфункция вкладки в обращениях
function AfterTabsInfoApp(data,update)
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

//получение новых уведомлений
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
		$('.noti_block').on("click",'.del_notif',DellNotif);	
	}
}

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
			$('.view__not').show();
			$('#chatAudio')[0].play();
			
			//если есть колокольчик то выводим на пару секунд уведомление из-за которого все обновилось
			if($('.view__not').length)
			{
				if( $('.noti_block').is(':visible') ) {	
					//обновить 
					$('.noti_block').find('.scro').empty().append('<div class="loader_inter"><div></div><div></div><div></div><div></div></div>');
	                var data ='';
                    AjaxClient('notification','view_notification','GET',data,'AfterVVN',1,0);	
				} else
				{
					//открыть на пару секунд	
					$('.menu1').append('<div class="noti_block"><div class="title_noti"><ul class="t_ul"><li>Новое уведомление</li><li><i class="noti_co" style="display:none;"><span class="noti_coc"></span></i></li></ul></div><div class="scro">'+data.echo+'</div></div>');
					setTimeout ( function () { $( '.noti_block' ).remove (); }, 5000 );
				}
					
			}
			
			
		}
		//сообщения
		if(data.echo_m==0)
		{
			//скрываем уведомления и количество ставим 0	
			$('.mess_li').find('i').empty();
			$('.mess_li').hide();
			//$('.view__not').hide(); //колокольчик
		} else
		{
			$('.mess_li').find('i').empty().append(data.echo_m);
			$('.mess_li').find('i').show();
			//$('.view__not').show(); //колокольчик
			$('#chatAudio')[0].play();					
			
			if($('.message_block').length!=0)
		    {
				
				if($('.sego_mess').length==0)
		        {
			       $('.padding_mess').append('<div class="dialog_clear"></div><div class="message_date"><div><span class="sego_mess">сегодня</span></div></div>');	
		        }
				
		        $('.padding_mess').append('<div class="dialog_clear"></div>'+data.echo_dialog);
				
				
				scroll_to_bottom(2000);
			}
			
			
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

function AfterUCASH(data,update)
{
	$('[cl_pay='+update+']').empty().append(data.echo);
	$('[or_pay='+update+']').empty().append('<div class="font-rank rasp_pay" data-tooltip="Распровести" id_rel="'+update+'"><span class="font-rank-inner">x</span></div>');
			$('.pay_summ2').remove();
		$('.pay_summ3').remove();
		$('.pay_summ4').remove();
		$('.j_cash').after(data.echo2);
	ToolTip();


	NumberBlockFile();


}




//постфункция обновление статуса после к оплате счет
function AfterWalletSTx(data,update)
{
	//alert(update);
	$('.billl[rel_id='+update+']').find('.loader_inter').remove();
	
	if ( data.status=='reg' )
    {
		$('.b-loading').hide();
		WindowLogin();
	}
	
	
	if ( data.status=='ok' )
    {
		$('.billl[rel_id='+update+']').find('.status_wallet_ada').empty().append(data.echo);
	    $('.billl[rel_id='+update+']').find('.button_ada_wall').empty().append(data.button);
	}
}

function AfterChangeKvartal(data,update)
{
	if ( data.status=='reg' )
    {
		WindowLogin();
	}
	
	if ( data.status=='ok' )
    {
        $('.menu3_prime').remove();
		$('.menu2_prime').after(data.echo);
		$(".slct").unbind('click.sys');
		$(".slct").bind('click.sys', slctclick);
		$(".drop").find("li").unbind('click');
		$(".drop").find("li").bind('click', dropli);
		
		
	} 
	if ( data.status=='error' )
    {		
        $('.menu3_prime').show();	
	}
	//alert(data.echo);
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



!function(e){"use strict";function t(e,t){if(this.createTextRange){var a=this.createTextRange();a.collapse(!0),a.moveStart("character",e),a.moveEnd("character",t-e),a.select()}else this.setSelectionRange&&(this.focus(),this.setSelectionRange(e,t))}function a(e){var t=this.value.length;if(e="start"==e.toLowerCase()?"Start":"End",document.selection){var a,i,n,l=document.selection.createRange();return a=l.duplicate(),a.expand("textedit"),a.setEndPoint("EndToEnd",l),i=a.text.length-l.text.length,n=i+l.text.length,"Start"==e?i:n}return"undefined"!=typeof this["selection"+e]&&(t=this["selection"+e]),t}var i={codes:{46:127,188:44,109:45,190:46,191:47,192:96,220:92,222:39,221:93,219:91,173:45,187:61,186:59,189:45,110:46},shifts:{96:"~",49:"!",50:"@",51:"#",52:"$",53:"%",54:"^",55:"&",56:"*",57:"(",48:")",45:"_",61:"+",91:"{",93:"}",92:"|",59:":",39:'"',44:"<",46:">",47:"?"}};e.fn.number=function(n,l,s,r){r="undefined"==typeof r?",":r,s="undefined"==typeof s?".":s,l="undefined"==typeof l?0:l;var u="\\u"+("0000"+s.charCodeAt(0).toString(16)).slice(-4),h=new RegExp("[^"+u+"0-9]","g"),o=new RegExp(u,"g");return n===!0?this.is("input:text")?this.on({"keydown.format":function(n){var u=e(this),h=u.data("numFormat"),o=n.keyCode?n.keyCode:n.which,c="",v=a.apply(this,["start"]),d=a.apply(this,["end"]),p="",f=!1;if(i.codes.hasOwnProperty(o)&&(o=i.codes[o]),!n.shiftKey&&o>=65&&90>=o?o+=32:!n.shiftKey&&o>=69&&105>=o?o-=48:n.shiftKey&&i.shifts.hasOwnProperty(o)&&(c=i.shifts[o]),""==c&&(c=String.fromCharCode(o)),8!=o&&45!=o&&127!=o&&c!=s&&!c.match(/[0-9]/)){var g=n.keyCode?n.keyCode:n.which;if(46==g||8==g||127==g||9==g||27==g||13==g||(65==g||82==g||80==g||83==g||70==g||72==g||66==g||74==g||84==g||90==g||61==g||173==g||48==g)&&(n.ctrlKey||n.metaKey)===!0||(86==g||67==g||88==g)&&(n.ctrlKey||n.metaKey)===!0||g>=35&&39>=g||g>=112&&123>=g)return;return n.preventDefault(),!1}if(0==v&&d==this.value.length?8==o?(v=d=1,this.value="",h.init=l>0?-1:0,h.c=l>0?-(l+1):0,t.apply(this,[0,0])):c==s?(v=d=1,this.value="0"+s+new Array(l+1).join("0"),h.init=l>0?1:0,h.c=l>0?-(l+1):0):45==o?(v=d=2,this.value="-0"+s+new Array(l+1).join("0"),h.init=l>0?1:0,h.c=l>0?-(l+1):0,t.apply(this,[2,2])):(h.init=l>0?-1:0,h.c=l>0?-l:0):h.c=d-this.value.length,h.isPartialSelection=v==d?!1:!0,l>0&&c==s&&v==this.value.length-l-1)h.c++,h.init=Math.max(0,h.init),n.preventDefault(),f=this.value.length+h.c;else if(45!=o||0==v&&0!=this.value.indexOf("-"))if(c==s)h.init=Math.max(0,h.init),n.preventDefault();else if(l>0&&127==o&&v==this.value.length-l-1)n.preventDefault();else if(l>0&&8==o&&v==this.value.length-l)n.preventDefault(),h.c--,f=this.value.length+h.c;else if(l>0&&127==o&&v>this.value.length-l-1){if(""===this.value)return;"0"!=this.value.slice(v,v+1)&&(p=this.value.slice(0,v)+"0"+this.value.slice(v+1),u.val(p)),n.preventDefault(),f=this.value.length+h.c}else if(l>0&&8==o&&v>this.value.length-l){if(""===this.value)return;"0"!=this.value.slice(v-1,v)&&(p=this.value.slice(0,v-1)+"0"+this.value.slice(v),u.val(p)),n.preventDefault(),h.c--,f=this.value.length+h.c}else 127==o&&this.value.slice(v,v+1)==r?n.preventDefault():8==o&&this.value.slice(v-1,v)==r?(n.preventDefault(),h.c--,f=this.value.length+h.c):l>0&&v==d&&this.value.length>l+1&&v>this.value.length-l-1&&isFinite(+c)&&!n.metaKey&&!n.ctrlKey&&!n.altKey&&1===c.length&&(p=d===this.value.length?this.value.slice(0,v-1):this.value.slice(0,v)+this.value.slice(v+1),this.value=p,f=v);else n.preventDefault();f!==!1&&t.apply(this,[f,f]),u.data("numFormat",h)},"keyup.format":function(i){var n,s=e(this),r=s.data("numFormat"),u=i.keyCode?i.keyCode:i.which,h=a.apply(this,["start"]),o=a.apply(this,["end"]);0!==h||0!==o||189!==u&&109!==u||(s.val("-"+s.val()),h=1,r.c=1-this.value.length,r.init=1,s.data("numFormat",r),n=this.value.length+r.c,t.apply(this,[n,n])),""===this.value||(48>u||u>57)&&(96>u||u>105)&&8!==u&&46!==u&&110!==u||(s.val(s.val()),l>0&&(r.init<1?(h=this.value.length-l-(r.init<0?1:0),r.c=h-this.value.length,r.init=1,s.data("numFormat",r)):h>this.value.length-l&&8!=u&&(r.c++,s.data("numFormat",r))),46!=u||r.isPartialSelection||(r.c++,s.data("numFormat",r)),n=this.value.length+r.c,t.apply(this,[n,n]))},"paste.format":function(t){var a=e(this),i=t.originalEvent,n=null;return window.clipboardData&&window.clipboardData.getData?n=window.clipboardData.getData("Text"):i.clipboardData&&i.clipboardData.getData&&(n=i.clipboardData.getData("text/plain")),a.val(n),t.preventDefault(),!1}}).each(function(){var t=e(this).data("numFormat",{c:-(l+1),decimals:l,thousands_sep:r,dec_point:s,regex_dec_num:h,regex_dec:o,init:this.value.indexOf(".")?!0:!1});""!==this.value&&t.val(t.val())}):this.each(function(){var t=e(this),a=+t.text().replace(h,"").replace(o,".");t.number(isFinite(a)?+a:0,l,s,r)}):this.text(e.number.apply(window,arguments))};var n=null,l=null;e.isPlainObject(e.valHooks.text)?(e.isFunction(e.valHooks.text.get)&&(n=e.valHooks.text.get),e.isFunction(e.valHooks.text.set)&&(l=e.valHooks.text.set)):e.valHooks.text={},e.valHooks.text.get=function(t){var a,i=e(t),l=i.data("numFormat");return l?""===t.value?"":(a=+t.value.replace(l.regex_dec_num,"").replace(l.regex_dec,"."),(0===t.value.indexOf("-")?"-":"")+(isFinite(a)?a:0)):e.isFunction(n)?n(t):void 0},e.valHooks.text.set=function(t,a){var i=e(t),n=i.data("numFormat");if(n){var s=e.number(a,n.decimals,n.dec_point,n.thousands_sep);return e.isFunction(l)?l(t,s):t.value=s}return e.isFunction(l)?l(t,a):void 0},e.number=function(e,t,a,i){i="undefined"==typeof i?"1000"!==new Number(1e3).toLocaleString()?new Number(1e3).toLocaleString().charAt(1):"":i,a="undefined"==typeof a?new Number(.1).toLocaleString().charAt(1):a,t=isFinite(+t)?Math.abs(t):0;var n="\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4),l="\\u"+("0000"+i.charCodeAt(0).toString(16)).slice(-4);e=(e+"").replace(".",a).replace(new RegExp(l,"g"),"").replace(new RegExp(n,"g"),".").replace(new RegExp("[^0-9+-Ee.]","g"),"");var s=isFinite(+e)?+e:0,r="",u=function(e,t){return""+ +(Math.round((""+e).indexOf("e")>0?e:e+"e+"+t)+"e-"+t)};return r=(t?u(s,t):""+Math.round(s)).split("."),r[0].length>3&&(r[0]=r[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,i)),(r[1]||"").length<t&&(r[1]=r[1]||"",r[1]+=new Array(t-r[1].length+1).join("0")),r.join(a)}}(jQuery);
//# sourceMappingURL=jquery.number.min.js.map