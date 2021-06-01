<?php
//форма удаление диалога с пользователем

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 0)and(!isset($_GET["id"]))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы
		$token=token_access_compile($_GET['id'],'calendar_dialog',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
		   
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'"><span>Выберите дату</span></h1>';
		
?>
	
	<input readonly="true"  name="datess" value="" id="date_table" class="input_f_1 input_100 calendar_t white_inp" placeholder="Дата документа"  autocomplete="off" type="text">
		
<div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div>		
<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">
var disabledDays = [];
 $(document).ready(function(){
	 alert("!");
            $("#date_table").datepicker({ 
altField:'#date_hidden_table',
onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
altFormat:'dd.mm.yy',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,
minDate: "0", maxDate: "+1Y",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 65,
                left: 0
            });
        }, 10);
	
    $('.bookingBox').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} });
	 		
 });
	 
	 
function resizeDatepicker() {
    setTimeout(function() { $('.bookingBox_gr1 > .ui-datepicker').width('100%'); }, 10);
}	 

function jopacalendar(queryDate,queryDate1,date_all) 
	{
	
if(date_all!='')
	{
var dateParts = queryDate.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]); 
var dateParts1 = queryDate1.match(/(\d+)/g), realDate1 = new Date(dateParts1[0], dateParts1[1] -1, dateParts1[2]); 	 	 
	}
	}	 
 </script>		
		
			<br>
 <div class="over">           
<div id="yes_cal_supply" class="save_button"><i>Выбрать</i></div>
<div id="no_cal_supply" class="no_button"><i>Отмена</i></div>            
 </div>           
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?
	   
	  
	
	}
}
if($status==0)
{
	//что то не так. Почему то бронировать нельзя
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();	
}
/*

						 $datetime1 = date_create('Y-m-d');
                         $datetime2 = date_create('2017-01-17');
						 
                         $interval = date_create(date('Y-m-d'))->diff( $datetime2	);				 
                         $date_plus=$interval->days;
						 */
						 //echo(dateDiff_(date('Y-m-d'),'2017-01-17'));
						 


?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

