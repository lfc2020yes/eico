<?php
//форма редактирование раздела в себестоимости дома

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		$token=token_access_compile($_GET['id'],'edit_grafic',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   
	   $result_t=mysql_time_query($link,'Select a.name_working,a.date0,a.date1,razdel2,id_razdel1 from i_razdel2 as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   
		   
		 //проверим может ли он добавлять разделы в себестоимость
		if (($role->permission('График','U'))or($sign_admin==1))
	    {
		   
		   
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Редактирование графика работ</span></h1>';

        $result_town=mysql_time_query($link,'Select a.razdel1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($row_t['id_razdel1'])).'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_t1 = mysqli_fetch_assoc($result_town);	
		
		
		
echo'<div class="comme">'.$row_t1["razdel1"].'.'.$row_t["razdel2"].' '.$row_t["name_working"].')</div>';
		}
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
		   

			echo'<div class="input-width">';
		echo'<div class="_50_x">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-right: 0px;">';
				if($row_t["date0"]!='')
			{
				$date_graf1  = explode("-",$row_t["date0"]);
				$timestamp_graf1=mktime(0,0,0,date_minus_null($date_graf1[1]),date_minus_null($date_graf1[2]),date_minus_null($date_graf1[0])).'000';
			} else
			{
				$timestamp_graf1=0;
			}	    
			//echo(mktime(0,0,0,date_minus_null($date_graf1[1]),date_minus_null($date_graf1[2]),date_minus_null($date_graf1[0])));
		    echo'<input id="date_hidden_table_gr1" name="date_naryad" value="'.$timestamp_graf1.'" type="hidden">';

			
			
			echo'<input readonly="true" name="datess" value="'.MaskDate_D_M_Y_ss($row_t["date0"]).'" id="date_table_gr1" class="input_f_1 input_100 calendar_t white_inp" placeholder="Дата начала работ"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
		
		echo'<div class="pad10" style="padding: 0;"><span class="bookingBox_gr1"></span></div>';
			
			
		echo'</div>';	
	
			
			echo'<div class="input-width">';
		echo'<div class="_50_x">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-right: 0px;">';
		    				if($row_t["date1"]!='')
			{
				$date_graf2  = explode("-",$row_t["date1"]);
				$timestamp_graf2=mktime(0,0,0,date_minus_null($date_graf2[1]),date_minus_null($date_graf2[2]),date_minus_null($date_graf2[0])).'000';
			} else
			{
				$timestamp_graf2=0;
			}
		    echo'<input id="date_hidden_table_gr2" name="date_naryad1" value="'.$timestamp_graf2.'" type="hidden">';
			
			echo'<input readonly="true" name="datess1" value="'.MaskDate_D_M_Y_ss($row_t["date1"]).'" id="date_table_gr2" class="input_f_1 input_100 calendar_t white_inp" placeholder="Дата окончания работ"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
		
		echo'<div class="pad10" style="padding: 0;"><span class="bookingBox_gr2"></span></div>';
			
			
		echo'</div>';				
			
			
	
			
			?>
		<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">var disabledDays = [];
 $(document).ready(function(){           
            $("#date_table_gr1").datepicker({ 
altField:'#date_hidden_table_gr1',
onClose : function(dateText, inst){
	    date_graf();
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
altFormat:'@',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "dd.mm.yy", 
firstDay: 1,
minDate: "-2Y", maxDate: "+2Y",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 0,
                left: 0
            });
        }, 10);
	
    $('.bookingBox_gr1').empty().append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} });


            $("#date_table_gr2").datepicker({ 
altField:'#date_hidden_table_gr2',
onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
		date_graf();
    },
altFormat:'@',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "dd.mm.yy", 
firstDay: 1,
minDate: "-2Y", maxDate: "+2Y",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 0,
                left: 0
            });
        }, 10);
	
    $('.bookingBox_gr2').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
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
            

			<br>
 <div class="over">            
<div id="yes_reff" class="save_button"><i>сохранить</i></div></div>
            
            
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?
	  }
	 }
	}
}
if($status==0)
{
	//что то не так. Почему то бронировать нельзя
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();	
}						 


?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

