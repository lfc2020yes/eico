<?php
//форма добавления нового счета 

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;


if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{	
	goto end_code;
}

$id_user=id_key_crypt_encrypt($_SESSION["user_id"]);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 1)or(!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
	goto end_code;	
}	

if ((!$role->permission('Бухгалтерия','U'))and($sign_admin!=1))
{
    goto end_code;	
}

//есть ли такой счет вообще
	   $result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t==0)
	   {
		   goto end_code;	 
	   } else
	   {
		   $row_t = mysqli_fetch_assoc($result_t);

	   }

if($row_t['status']!=3)
{
	goto end_code;
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'yes_bookers',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   


	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Подтвердить оплату</span></h1>';

		
	$date_graf2  = explode("-",$row_t["date"]);
					  // echo'<span class="stock_name_mat">от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span>';		
	$summa='';
			if(($row_t["path_summa"]!='')and($row_t["path_summa"]!=0))
{
	 $summa=rtrim(rtrim(number_format($row_t["path_summa"], 2, '.', ' '),'0'),'.');
	
} else
{
	 $summa=rtrim(rtrim(number_format($row_t["summa"], 2, '.', ' '),'0'),'.');
}
		
				
echo'<div class="comme">Вы точно хотите подтвердить оплату в размере '.$summa.' рублей по <b>"Cчету №'.$row_t["number"].'"</b> от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'?</div>';
		
	?>
				
<div class="" style="margin-top:10px;">
			<div class="wallet_material">
			  <div class="table w_mat">
			      <div class="table-cell one_wall"></div>
			      <div class="table-cell name_wall wall1">Дата оплаты</div>
			      <div class="table-cell">
			      	
			      	<?
					  $date_graf2  = explode("-",date('Y-m-d'));
					  
					  
			      		   echo'<div class="input-width m10_right" style="position:relative;margin-right: 10px; margin-bottom: 10px; margin-top: -10px;">';
		    echo'<input id="date_hidden_table_gr1" name="date_naryad" value="'.date('Y-m-d').'" type="hidden">';

			
			
			echo'<input readonly="true" name="datess" value="'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'" id="date_table_gr1" class="input_f_1 input_100 calendar_t white_inp" placeholder=""  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div>';
				
					?>
			      	
			      	
			      </div>
			  </div>
			</div>	
			
			<div class="pad10" style="padding: 0;"><span class="bookingBox_gr1"></span></div>
			
			</div>				
		<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">var disabledDays = [];
 $(document).ready(function(){           
            $("#date_table_gr1").datepicker({ 
altField:'#date_hidden_table_gr1',
onClose : function(dateText, inst){
	  
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
altFormat:'yy-mm-dd',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "dd.mm.yy", 
firstDay: 1,
minDate: "-1M", maxDate: "+2Y",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 0,
                left: 0
            });
		//$('.bookingBox_gr1').append($('#ui-datepicker-div'));
		
		//$('#ui-datepicker-div').appendTo($('.bookingBox_gr1'));
		//$('.ui-datepicker').hide();
		//$('#ui-datepicker-div').show();
        }, 10);
	
    $('.bookingBox_gr1').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
    //$('#ui-datepicker-div').hide();
} });


	 
<?
?>		 
//$('#date_table1').datepicker('setDate', ['+1d', '+30d']);
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
            				
		
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_booker_yes" class="save_button"><i>Ок</i></div>
<div id="no_rd" class="no_button"><i>Отмена</i></div>            
 </div>           
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?




end_code:		   
		   
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

