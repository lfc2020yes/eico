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

if ((!$role->permission('Счет','S'))and($sign_admin!=1))
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

if(($row_t['status']!=3)and($row_t['status']!=20))
{
	goto end_code;
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'yes_bill_edit',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   


	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1 "><div class="box-modal-pading "><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
				$date_graf2  = explode("-",$row_t["date"]);
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Изменить "Подготовить к оплате"</span></h1>';

	

	echo'<div class="" style="width:100%;">';
		
				
				$date_graf2  = explode("-",$row_t["date"]);
			echo'<div class="table bill_wallet">
		<div class="table-cell cell_small">
				
							<div class="text_wallet1 padd"><span class="bill_str1">→</span>max значение</div>
			<span class="pay_summ_bill1">'.$row_t["summa"].'</span>
				
				</div>
		<div class="table-cell cell_big">
				
				<div class="text_wallet padd">сумма к оплате</div>
				<span class="pay_summ_bill">';
				
				if(($row_t["path_summa"]!='')and($row_t["path_summa"]!=0))
				{
				echo'<input  name="wall_summ" id="wall_summ" max="'.$row_t["summa"].'" value="'.$row_t["path_summa"].'" placeholder="" class="count_mask summ_input_ww" autocomplete="off" type="text"></span>';
				} else
				{
				echo'<input readonly="true" name="wall_summ" id="wall_summ" max="'.$row_t["summa"].'" value="'.$row_t["summa"].'" placeholder="" class="count_mask summ_input_ww" autocomplete="off" type="text"></span>';					
				}
				
				
				
				echo'<div class="text_wallet padd">по счету №'.$row_t["number"].' от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</div>
				</div>
				
			</div>';
			
				if(($row_t["path_summa"]!='')and($row_t["path_summa"]!=0))
				{
			echo'<div class="table bill_wallet_option option_y1 active_bill">';
				} else
				{
			echo'<div class="table bill_wallet_option option_y1">';					
				}
				?>
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Частичная оплата</div>
				
			</div>	
			<?	
				if(($row_t["path_summa"]!='')and($row_t["path_summa"]!=0))
				{
			echo'<div class="cha_1 active_option" style="display: block;">';
				} else
				{
				echo'<div class="cha_1">';		
				}
			
					$result_work_zz=mysql_time_query($link,'
	
	SELECT 
	a.*,b.id as idd,
	b.count_units,
	b.id_object,
	b.id_stock,
	c.id_user as users,
	c.date_create
	
	FROM 
	z_doc_material_acc as a,
	z_doc_material as b,
	z_doc as c
	WHERE
	b.id_doc=c.id and 
	a.id_acc="'.$row_t["id"].'" and
	a.id_doc_material=b.id
	
	;');

						 
		//echo 'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_;				 
						 
						 
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {

	
	
		  $id_work=0;
			
		   for ($i=0; $i<$num_results_work_zz; $i++)
		   {			   			  			   
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);
			   			 $result_t1__341=mysql_time_query($link,'Select a.name,a.units  from z_stock as a where a.id="'.$row_work_zz["id_stock"].'"'); 
			    $num_results_t1__341 = $result_t1__341->num_rows;
	            if($num_results_t1__341!=0)
	            {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					
				$date_graf2  = explode(" ",$row_work_zz["date_create"]);	 		
		$date_graf3  = explode("-",$date_graf2[0]);
			$ddd1=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];  
			   		   	
				if($row_work_zz["path_buy"]==1)	
				{
			  echo'<div class="wallet_material active_wall " wall_id="'.$row_work_zz["id"].'" >
			  <div class="table w_mat">
			      <div class="table-cell one_wall"><div class="st_div_wall  wallet_checkbox"><i></i></div><input class="rt_wall yop_'.$row_work_zz["id"].'" name="material_r'.$row_work_zz["id"].'" value="1" type="hidden"></div>';
				} else
				{
				  echo'<div class="wallet_material  " wall_id="'.$row_work_zz["id"].'">
			  <div class="table w_mat">
			      <div class="table-cell one_wall"><div class="st_div_wall  wallet_checkbox"><i></i></div><input class="rt_wall yop_'.$row_work_zz["id"].'" name="material_r'.$row_work_zz["id"].'" value="0" type="hidden"></div>';				
				}
					
			      echo'<div class="table-cell name_wall wall1">'.$row1ss__341["name"].'</div>
			      <div class="table-cell count_wall wall2"><span>'.$row_work_zz["count_material"].' '.$row1ss__341["units"].'</span></div>
			      <div class="table-cell count_wall dop_wall"><label>Заявка</label> от '.$ddd1.'</div>
			  </div>
			</div>';
						  
					
				}
			   
			   
			   
		   }
			
		}
				
			?>
			
			
	
			</div>	
			
			
			
			<?
							if($row_t["status"]==20)	
				{
		echo'<div class="table bill_wallet_option option_xvg2 active_bill" style="margin-top: 0px;">';
				} else
				{
		echo'<div class="table bill_wallet_option option_xvg2" style="margin-top: 0px;">';					
				}
				echo'<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Оплачивать по факту получения</div>';
										if($row_t["status"]==20)	
				{	
				echo'<input type="hidden" name="popol_bill_" class="input_option_xvg popol_bill_" value="1">';
				} else
				{
				echo'<input type="hidden" name="popol_bill_" class="input_option_xvg popol_bill_" value="0">';	
				}

			echo'</div>';			
				
										if($row_t["status"]==20)	
				{	
echo'<div class="option_slice_xxg  bg_xxg" style="display:block;">';
				} else
				{
echo'<div class="option_slice_xxg  bg_xxg">';					
				}
	//echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
				?>
		
<span style="font-family: GEInspiraBold;
padding-left: 10px;
text-transform: uppercase;
font-size: 14px;
color: rgba(0,0,0,0.7)">Оплачивать товар только по факту получения.</span>
        <?
        
           				

				
	?>
	</div>																																									
			
			
			
			
			
			
			
				<?
							if(($row_t["date_buy"]!='')and($row_t["date_buy"]!='0000-00-00'))
				{

			echo'<div class="table bill_wallet_option option_to option_two option_y2 active_bill">';
				} else
				{
				echo'<div class="table bill_wallet_option option_to option_two option_y2">';	
				}
				?>
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Оплатить после даты</div>
				
			</div>					
	<?		
							if(($row_t["date_buy"]!='')and($row_t["date_buy"]!='0000-00-00'))
				{
			echo'<div class="date_cha active_option" style="display: block;">';
				} else
				{
					echo'<div class="date_cha">';
				}
				?>
			<div class="wallet_material">
			  <div class="table w_mat">
			      <div class="table-cell one_wall"></div>
			      <div class="table-cell name_wall wall1">Выберите необходимую дату</div>
			      <div class="table-cell">
			      	
			      	<?
					  							if(($row_t["date_buy"]!='')and($row_t["date_buy"]!='0000-00-00'))
				{
						$date_graf2  = explode("-",$row_t["date_buy"]);
			      		   echo'<div class="input-width m10_right" style="position:relative;margin-right: 10px; margin-bottom: 10px; margin-top: -10px;">';
		    echo'<input id="date_hidden_table_gr1" name="date_naryad" value="'.$row_t["date_buy"].'" type="hidden">';		
			echo'<input readonly="true" name="datess" value="'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'" id="date_table_gr1" class="input_f_1 input_100 calendar_t white_inp" placeholder=""  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div>';
				} else
				{
			      		   echo'<div class="input-width m10_right" style="position:relative;margin-right: 10px; margin-bottom: 10px; margin-top: -10px;">';
		    echo'<input id="date_hidden_table_gr1" name="date_naryad" value="" type="hidden">';		
			echo'<input readonly="true" name="datess" value="" id="date_table_gr1" class="input_f_1 input_100 calendar_t white_inp" placeholder=""  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div>';					
				}
					?>
			      	
			      	
			      </div>
			  </div>
			</div>	
			
			<div class="pad10" style="padding: 0;"><span class="bookingBox_gr1"></span></div>
			
			</div>		
							
				<?
				

			
			
		echo'';					
?>	
		
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
minDate: "0", maxDate: "+2Y",
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
            	
		
		</div>
		
<?
				if($row_t["comment_status"]!='')
				{
		echo'<div class="table bill_wallet_option option_xvg2 active_bill" style="border-bottom: 1px solid rgba(0,0,0,0.1); border-top: 0px solid rgba(0,0,0,0.1);
margin-top: 0px;">';
				} else
				{
			echo'<div class="table bill_wallet_option option_xvg2 " style="border-bottom: 1px solid rgba(0,0,0,0.1); border-top: 0px solid rgba(0,0,0,0.1);
margin-top: 0px;">';				
				}
				
				echo'<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Комментарий по оплате</div>
				<input type="hidden" name="com_bill_" class="input_option_xvg com_bill_" value="0">
			</div>';			
				
	//echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
								if($row_t["comment_status"]!='')
				{
				echo'<div class="option_slice_xxg  bg_xxg" style="display: block;">';
				} else
				{
				echo'<div class="option_slice_xxg  bg_xxg">';	
				}
?>
<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:0px;">
			<div class="otziv_add">
<?
												if($row_t["comment_status"]!='')
				{
           echo'<textarea cols="20" rows="1" id="otziv_area_adaxx" name="text_comment" class="di text_area_otziv no_comment_bill">'.$row_t["comment_status"].'</textarea>';
				} else
				{
           echo'<textarea cols="20" rows="1" id="otziv_area_adaxx" name="text_comment" class="di text_area_otziv no_comment_bill"></textarea>';					
				}
		   ?>
        </div></div>
        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area_adaxx\').autoResize({extraSpace : 30});
$(\'#otziv_area_adaxx\').trigger(\'keyup\');

ToolTip();
});

	</script>';
           				

				
	?>
	</div>			
						
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_bill_non1" class="save_button"><i>Ок</i></div>
<div id="no_rd" class="no_button"><i>Закрыть</i></div>            
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

