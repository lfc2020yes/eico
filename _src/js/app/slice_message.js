//добавление всплывающих подсказок к действиям
//style - ok error war
//alert_message('error','Не все поля заполнены');
function alert_message(style,text)
{
	
	var maxValue = 1;
$(".alert_wrapper .div-box").find('.alert-message').each(function() { 
      value = $(this).attr("alert-id");
  if(value > maxValue) {
    maxValue = value;
  }
});

	
	$('.alert_wrapper .div-box').prepend(function () { $(this).find('.alert-message ').addClass('show-alert'); },'<div alert-id="'+(maxValue+1)+'" class="  alert-message '+style+'-a"><div class="alert-icon"></div><div class="alert-content">'+text+'</div><div class="alert-close js-alert-close"></div></div>');

	setTimeout ( function () {  $('.alert-message[alert-id='+(maxValue+1)+']').addClass('show-alert'); }, 500 );	
	
	//$('.alert_wrapper .div-box').find('.alert-message').first().addClass('show-alert');
	
	setTimeout ( function () {  $('.alert-message[alert-id='+(maxValue+1)+']').addClass('hide-alert'); 
							 

				setTimeout ( function () {  $('.alert-message[alert-id='+(maxValue+1)+']').remove(); 
							 
							 
							 
							 
							 }, 500 );
							 
							 }, 5000 );
}