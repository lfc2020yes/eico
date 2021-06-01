<?php
//форма редактирования материала по работе в себестоимости

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
		$token=token_access_compile($_GET['id'],'edit_material',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	  
	   $result_tdd=mysql_time_query($link,'Select a.id from i_material as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_tdd = $result_tdd->num_rows;
	   if($num_results_tdd!=0)
	   {
		   //$row_t = mysqli_fetch_assoc($result_t);
		
		   if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	       {
		
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1">
			<form id="lalala_form" style=" padding:0; margin:0;" method="get" enctype="multipart/form-data">

			
			<div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Редактирование материала</span></h1>';
echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';		
		
        $result_town=mysql_time_query($link,'select A.* from i_material as A where  A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
			
			
        $result_town2=mysql_time_query($link,'select A.name_working from i_razdel2 as A where  A.id="'.$row_town["id_razdel2"].'"');
        $num_results_custom_town2 = $result_town2->num_rows;
        if($num_results_custom_town2!=0)
        {
			$row_town2 = mysqli_fetch_assoc($result_town2);
			echo'<div class="comme">'.$row_town2["name_working"].'</div>';
		}
			
			
		    
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';

	?>					
<div class="div_textarea_otziv div_text_glo">
			<div class="otziv_add">
<?
           echo'<textarea placeholder="Название материала" cols="40" rows="1" id="otziv_area" name="name_work" class="di text_area_otziv">'.$row_town["material"].'</textarea>';
		   ?>
        </div></div>
<?		

					echo'<div class="_33_na_33"><div class="_33_x"><div>';
	
			echo'<div class="input-width m10_right"  style="position:relative;"><div class="width-setter" style="position:relative;"><input name="ed_work" id="number_r" placeholder="Ед. Изм." value="'.$row_town["units"].'" class="input_f_1 input_100 white_inp dop_table_x" autocomplete="off" type="text"><i class="icon_cal1"></i></div>
		   
		   <div class="dop_table"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div>
		   
		   </div>';	
		
		
		echo'</div></div>
		<div class="_33_x">';
		   echo'<div class="input-width m10_right m10_left"><div class="width-setter"><input name="count_work" value="'.$row_town["count_units"].'" id="count_work_mm" placeholder="Количество" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text"></div></div>';
		echo'</div>
		<div class="_33_x">';
		   echo'<div class="input-width m10_left"><div class="width-setter"><input name="price_work"  value="'.$row_town["price"].'" id="price_work_mm" placeholder="Стоимость" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text"></div></div>';		
		echo'</div></div>';	
			
			
			
			
	
		
						   echo'<div class="input-width animate fg_summ"><div class="width-setter"><input name="summa_work" readonly="true" id="summa_work_mm" placeholder="Итоговая сумма" value="'.rtrim(rtrim(number_format(($row_town["count_units"]*$row_town["price"]), 2, '.', ''),'0'),'.').'" class="input_f_1 input_100 white_inp" autocomplete="off" type="text"></div></div>';

				?>
	
				
				

        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area\').autoResize({extraSpace : 50});
$(\'#otziv_area\').focus().trigger(\'keyup\');
});

	</script>';
           ?> 
            

			<br>
 <div class="over">            
<div id="yes_me" class="save_button"><i>Сохранить</i></div>               
</div>
 <?               
	?>           
            </span></div>
            

            
            

            </form>

            </div>		
<?
	  }
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

