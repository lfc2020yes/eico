

$(function (){
	//войти
	$('.box-modal').on("change keyup input click",".js-log",LoginYes);	
	//восстановить
	$('.box-modal').on("change keyup input click",".js-recover-password",RecoverLogin);
	
	//нашатие enter при входе в поле логин или пароль
    $('.box-modal').on("keypress",'.js-form-open .gloab',EnterLogin);	
	
	//подсчет ндс при вводе стоимости в заявке
	$('.box-modal').on("change keyup input click",".js-cost-offers-c",CostOffers);
	
	//отправить заявку после всех заполнений
	$('.box-modal').on("change keyup input click",".js-offers-send-end",SendOffersEnd);
	
	
});

//отправить заявку после всех заполнений
//  |
// \/
function SendOffersEnd()
{
	
	if(!$(this).is('.no-rules'))
		{
	
	var err = 0;
	$('.offers-form-k .gloab').each(function(i,elem) {
	if($(this).val() == '')  {$(this).parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $(this).parents('.input_2018').addClass('required_in_2018'); err++; } else {$(this).parents('.input_2018').removeClass('required_in_2018');}		
});
		
	

	
	
	if(err==0)
		{
			
			$('.offers-form-k .js-offers-send-end').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 15px; top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
			
			
			
		AjaxClient('tender','offers','POST',0,'AfterSendOffersEnd',0,'offers-form-k');	
			
		} else
			{
				ErrorBut('.offers-form-k .js-offers-send-end','Ошибка заполнения!');
			}
		}
}


function AfterSendOffersEnd(data,update)
{
	if (data.status=='ok')
    {
	    $('.offers-form-k').after('<span class="help-message"><strong>Ваша заявка на участие в закупке принята!</strong><br> После проверки заявки нашими специалистами, Вы сможетe принимать участие в аукционе по данной закупке.</span><div class="yes" style="margin-left: 0px;margin-top: 30px;">q</div>');
		
		$('.offers-form-k').remove();
		$('.js-new-offers').slideUp("slow");
		
		
	} else
	{
	 	  $('.offers-form-k .js-offers-send-end').show();
		  $('.offers-form-k .b_loading_small').remove();			
		  ErrorBut('.offers-form-k .js-offers-send-end','Ошибка!');	
	}
}

//подсчет ндс при вводе стоимости в заявке
//  |
// \/
function CostOffers()
{
	var cost=parseFloat($(this).val().replace(/\s/g, ''));
	//debug(cost,0);
	if(!isNaN(cost))
		{
	if ($(this).is('.js-nds')) {
	  //цена вводилась с ндс
		var s_nds=cost.toFixed(2);
		var nd = (cost / 1.20 * 0.20).toFixed(2);
		var no_nds = (cost - nd).toFixed(2);

	}
	if ($(this).is('.js-nonds')) {
	  //цена вводилась без ндс
		var no_nds = cost.toFixed(2);
		var s_nds=(no_nds*1.2).toFixed(2);
		var nd = (s_nds-no_nds).toFixed(2);

	}
			
	$('.js-no-nds').empty().append($.number(no_nds, 2, '.', ' '));	
	$('.js-s-nds').empty().append($.number(s_nds, 2, '.', ' '));
	$('.js-nds').empty().append($.number(nd, 2, '.', ' '));	
	$('.tender-offers-itog').slideDown("slow");
			
		} else
			{
				//$('.js-no-nds, .js-s-nds, .js-nds').empty('0');
				
				$('.tender-offers-itog').slideUp("slow",function() { $(this).find('.js-no-nds, .js-s-nds, .js-nds').empty().append('0');  });
			}
}


//нажать enter при входе
//  |
// \/
function EnterLogin(e)
{
	if(e.which == 13) {
       LoginYes();
    }
}

//напомнить пароль в форме найти
//  |
// \/
function RecoverLogin()
{
	var err = 0;
	$('.js-form-open .gloab1').each(function(i,elem) {
	if($(this).val() == '')  {$(this).parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $(this).parents('.input_2018').addClass('required_in_2018'); err++; } else {$(this).parents('.input_2018').removeClass('required_in_2018');}		
});
		
	

	
	
	if(err==0)
		{
			$('.js-form-open .js-recover-password').hide();
			$('.js-form-open .js-log').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
			
			
			
		AjaxClient('open','recover','POST',0,'AfterRecoverLogin',0,'login-form-k');	
			
		} else
			{
				$('.js-form-open .message-form').hide();
			}
}
function AfterRecoverLogin(data,update)
{
	$('.js-form-open .message-form').empty();
	if ( data.status=='reload' )
    {
		autoReload();
	}
	
	
	if( data.status=='ok' )
		{
			var mail_name=$('.js-form-open .js-in1').val();
			$('.js-form-open').empty().append('<span class="help-message">Проверьте свою электронную почту. Мы отправили письмо на электронный адрес <strong>'+mail_name+'.</strong> Перейдите по ссылке в письме для сброса пароля.<br><br>Если письма нет во входящих, то попробуйте найти его в других папках (например, «Спам», «Социальные сети» или другие).</span><div class="yes">q</div>'); 
		}
	
	if ( data.status=='login_error' )
    {
		var hoop=$('.js-form-open .js-in1').parents('.input_2018');
		$('.js-form-open .js-log').show();
		$('.js-form-open .b_loading_small').remove();
		hoop.addClass('required_in_2018');
		hoop.find('.error-message').empty().append('поле заполнено неверно');	
		$('.js-form-open .js-recover-password').show();
	}
	
	//личный кабинет заблокирован
	if ( data.status=='enabled' )
    {
		$('.js-form-open .message-form').empty().append('«Ошибка! Ваш личный кабинет заблокирован»').show();
		$('.js-form-open .b_loading_small').remove();		
		$('.js-form-open .js-log').show();	
		$('.js-form-open .js-recover-password').show();
	}	
	
	if ( data.status=='no_active_email' )
    {
		$('.js-form-open .message-form').empty().append('<div>«Ошибка! Ваша электронная почта не подтверждена»<br>Невозможно напомнить пароль</div>').show();
		$('.js-form-open .b_loading_small').remove();		
		$('.js-form-open .js-log').show();		
	}	
	
}



//логин пароль/нажатие кнопки войти
//  |
// \/
function LoginYes()
{
	
	if($('.js-form-open .js-log').is('.clock'))
		{
			
		} else
			{
	
	var err = 0;

	$('.js-form-open .gloab').each(function(i,elem) {
	if($(this).val() == '')  {$(this).parents('.input_2018').find('.error-message').empty().append('поле не заполнено');	 $(this).parents('.input_2018').addClass('required_in_2018'); err++; } else {$(this).parents('.input_2018').removeClass('required_in_2018');}		
});
		
	

	
	
	if(err==0)
		{
			$('.js-form-open .js-log').hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>');
			
			$('.js-form-open .message-form').hide();
			
		AjaxClient('open','open','POST',0,'AfterLoginYes',0,'login-form-k');	
			
		} else
			{   
				ErrorBut('.js-form-open .js-log','Ошибка заполнения!');
				
				
			}
				
			}
}


function AfterLoginYes(data,update)
{
	if (( data.status=='reload' )||( data.status=='ok' ))
    {
		autoReload();
	}
	
	//личный кабинет заблокирован
	if ( data.status=='enabled' )
    {
		$('.js-form-open .message-form').empty().append('«Ошибка! Ваш личный кабинет заблокирован»').show();
		$('.js-form-open .b_loading_small').remove();		
		$('.js-form-open .js-log').show();		
	}	

	if ( data.status=='no_active_email' )
    {
		$('.js-form-open .message-form').empty().append('<div>«Ошибка! Ваша электронная почта не подтверждена»</div><div class="activate_mail_link js-active-link"><span>отправить письмо для активации</span></div>').show();
		$('.js-form-open .b_loading_small').remove();		
		$('.js-form-open .js-log').show();		
	}	
	
	
	//превышено количество попыток
	if ( data.status=='time_limit' )
    {
		
		$('.js-form-open .message-form').empty().append('«Слишком много неуспешных попыток авторизации. Необходимо подождать '+data.echo+'»').show();
		$('.js-form-open .b_loading_small').remove();		
		$('.js-form-open .js-log').addClass('clock').show();
		initializeTimerLogin(data.echo1);
	}
	
	
	
	//ошибка логин
	if ( data.status=='login_error' )
	{
		var hoop=$('.js-form-open .js-in1').parents('.input_2018');
		$('.js-form-open .js-log').show();
		$('.js-form-open .b_loading_small').remove();
		hoop.addClass('required_in_2018');
		hoop.find('.error-message').empty().append('поле заполнено неверно');
	}
	//ошибка пароль	
	if ( data.status=='password_error' )
    {
		var hoop=$('.js-form-open .js-in2').parents('.input_2018');
		$('.js-form-open .js-log').show();
		$('.js-form-open .b_loading_small').remove();
		hoop.addClass('required_in_2018');
		hoop.find('.error-message').empty().append('поле заполнено неверно');		
	}
	//ошибка логин и пароль
	if ( data.status=='password_login' )
    {
		var hoop=$('.js-form-open .gloab').parents('.input_2018');
				$('.js-form-open .js-log').show();
		$('.js-form-open .b_loading_small').remove();
		hoop.addClass('required_in_2018');
		hoop.find('.error-message').empty().append('неверный e-mail или пароль');
		
	}
}

