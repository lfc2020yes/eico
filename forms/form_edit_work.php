<?php
//форма редактирование работы в себестоимости

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
		$token=token_access_compile($_GET['id'],'edit_work',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   
	   $result_tdd=mysql_time_query($link,'Select a.id from i_razdel2 as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_tdd = $result_tdd->num_rows;
	   if($num_results_tdd!=0)
	   {
		   //$row_tdd = mysqli_fetch_assoc($result_tdd);
		   
		if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	    {
		   
	
		
		   $status=1;
	   
	   
	   ?>
			
<?
//узнаем есть ли материалы у этой работы			
 	$result_txx=mysql_time_query($link,'Select a.* from i_material as a where a.id_razdel2="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_txx = $result_txx->num_rows;
	   if($num_results_txx!=0)
	   {
		  $row_txx = mysqli_fetch_assoc($result_txx); 
		   echo'<div id="Modal-one" class="box-modal table-modal eddd1 _form_2_">';
	   }  else
	   {
		   echo'<div id="Modal-one" class="box-modal table-modal eddd1">';
		   
	   }

 	$result_txxs=mysql_time_query($link,'Select count(a.id) as cc from i_material as a where a.id_razdel2="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_txxs = $result_txxs->num_rows;
	   if($num_results_txxs!=0)
	   {
		  $row_txxs = mysqli_fetch_assoc($result_txxs); 
		   
	   }
		
		
		
		echo'<form id="lalala_form" style=" padding:0; margin:0;" method="get" enctype="multipart/form-data">';
		   if($num_results_txx!=0)
	   {
		   echo'<div class="box-modal-pading _left_ajax_form">';
	   } else{ echo'<div class="box-modal-pading">';}
?>
			
			<div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Редактирование работы</span></h1>';
echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';		
		
        $result_town=mysql_time_query($link,'select A.* from i_razdel2 as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);
			
			
			
		$result_town2=mysql_time_query($link,'select A.name1 from i_razdel1 as A where A.id="'.$row_town["id_razdel1"].'"');
        $num_results_custom_town2 = $result_town2->num_rows;
        if($num_results_custom_town2!=0)
        {
			$row_town2 = mysqli_fetch_assoc($result_town2);
			
		    echo'<div class="comme">'.$row_town2["name1"].'</div>';
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
           echo'<textarea placeholder="Название работы" cols="40" rows="1" id="otziv_area" name="name_work" class="di text_area_otziv">'.$row_town["name_working"].'</textarea>';
		   ?>
        </div></div>
<?		
		
		   echo'<div class="_50_na_50_1"><div class="_50_x">';
		   echo'<div class="input-width m10_right">';

	   $result_tx=mysql_time_query($link,'Select a.id,a.implementer from i_implementer as a where a.id="'.$row_town["id_implementer"].'"');
       $num_results_tx = $result_tx->num_rows;
	   if($num_results_tx!=0)
	   {
		  $row_tx = mysqli_fetch_assoc($result_tx); 
	   }
			
		
	$result_t=mysql_time_query($link,'Select a.id,a.implementer from i_implementer as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   if(($row_town["id_implementer"]==0)or($row_town["id_implementer"]==''))
		   {
		   echo'<div class="select_box eddd_box"><a class="slct_box_form" data_src="0"><span class="ccol">Исполнитель</span></a><ul class="drop_box_form">';
		   } else
		  {	   
		   echo'<div class="select_box eddd_box"><a class="slct_box_form" data_src="'.$row_town["id_implementer"].'"><span class="ccol">'.$row_tx["implementer"].'</span></a><ul class="drop_box_form">';		  
		  }
		   
		   echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);
			   if($row_t["id"]==$row_town["id_implementer"])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["implementer"].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["implementer"].'</a></li>'; 
			   }
			  
			 }
		   echo'</ul><input name="ispol_work" value="'.$row_town["id_implementer"].'" id="ispol" value="0" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';
		echo'</div>
		<div class="_50_x">';
		   echo'<div class="input-width m10_left" style="position:relative;"><div class="width-setter" style="position:relative;"><input name="ed_work" id="number_r" placeholder="Ед. Изм." value="'.$row_town["units"].'" class="input_f_1 input_100 white_inp dop_table_x" autocomplete="off" type="text"><i class="icon_cal1"></i></div>
		   
		   <div class="dop_table"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div>
		   
		   </div>';		
		echo'</div></div>';

		
				   echo'<div class="_50_na_50"><div class="_50_x">';
		   echo'<div class="input-width m10_right"><div class="width-setter"><input name="count_work" id="count_work" placeholder="Количество" class="input_f_1 input_100 white_inp count_mask" value="'.$row_town["count_units"].'" autocomplete="off" type="text"></div></div>';
		echo'</div>
		<div class="_50_x">';
		   echo'<div class="input-width m10_left"><div class="width-setter"><input name="price_work" id="price_work" placeholder="Стоимость" class="input_f_1 input_100 white_inp count_mask" value="'.$row_town["price"].'" autocomplete="off" type="text"></div></div>';		
		echo'</div></div>';
	
		
						   echo'<div class="input-width animate fg_summ"><div class="width-setter"><input name="summa_work" readonly="true" id="summa_work" placeholder="Итоговая сумма" class="input_f_1 input_100 white_inp" autocomplete="off" type="text"></div></div>';

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
<div id="yes_wwa" class="save_button"><i>Сохранить</i></div>
<?
   	   if($num_results_txx!=0)
	   {
		   echo'<div id="ma_rd" style="display:none;" class="ma_button"><i>Добавить материал</i></div>';  
	   } else
	   {
		  echo'<div id="ma_rd" class="ma_button"><i>Добавить материал</i></div>'; 
	   }
?>                                   
</div>
 <?           
echo'<input type=hidden id="freez" name="freez" value="'.htmlspecialchars(trim($_GET['freez'])).'">';  
echo'<input type=hidden id="count_material" name="count_material" value="'.$row_txxs["cc"].'">';			
	?>

           
            </span></div>
            

            
         <?
			   	   if($num_results_txx!=0)
	   {
		   echo'<div class="_right_ajax_form">';
	   } else
	   {
            echo'<div class="_right_ajax_form" style="display: none;">';
	   }
			
			
	//выводим материалы с этой работой
		        if($num_results_txx!=0)
	            {
				  	
				  for ($y=0; $y<$num_results_txx; $y++)
                  {  
			         if($y!=0) { $row_txx = mysqli_fetch_assoc($result_txx); }
					  $rr=$y+1;
					 
					 echo'<div class="matr_add__ material__'.$rr.'"><input type=hidden value="'.$row_txx["id"].'" name="material['.$rr.'][idd]"><div class="box-modal-pading"><div class="comme comme11"><span>Материал №'.$rr.'</span></div><span class="hop_lalala" ><div class="div_textarea_otziv div_text_glo_'.$rr.'"><div class="otziv_add"><textarea placeholder="Название материала" cols="40" rows="2" id="otziv_area_'.$rr.'" name="material['.$rr.'][name]" class="di text_area_otziv text_material">'.$row_txx["material"].'</textarea></div></div><div class="_33_na_33"><div class="_33_x"><div><div class="input-width m10_right" style="position:relative;"><div class="width-setter" style="position:relative;"><input name="material['.$rr.'][ed]" id="number_rm1_'.$rr.'" placeholder="Ед. Изм." value="'.$row_txx["units"].'" class="input_f_1 input_100 white_inp dop_table_x" autocomplete="off" type="text"><i class="icon_cal1"></i></div><div class="dop_table"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div></div></div></div><div class="_33_x"><div class="input-width m10_right m10_left"><div class="width-setter"><input value="'.$row_txx["count_units"].'" name="material['.$rr.'][count]" id="count_material_'.$rr.'" placeholder="Количество" class="input_f_1 input_100 white_inp count_mask_'.$rr.'" autocomplete="off" type="text"></div></div></div><div class="_33_x"><div class="input-width m10_left"><div class="width-setter"><input name="material['.$rr.'][price]" id="price_material_'.$rr.'" value="'.$row_txx["price"].'" placeholder="Стоимость" class="input_f_1 input_100 white_inp count_mask_'.$rr.'" autocomplete="off" type="text"></div></div></div></div><div class="input-width animate fgg fg_summ_'.$rr.'"><div class="width-setter"><input name="material['.$rr.'][sum]" readonly id="summa_material_'.$rr.'" placeholder="Итоговая сумма" class="input_f_1 input_100 white_inp" autocomplete="off" type="text"></div></div><br>';
					  
					 if(($y+1)<$num_results_txx)
					 {
					   echo'<div class="over over11 over11_'.$rr.'" style="height:1px">';
					 } else
					 {
					    //последний материал
						echo'<div class="over over11 over11_'.$rr.'"><i data-tooltip="добавить еще материал" class="i___">+</i>'; 
					 }
					 echo'</div></span></div></div>'; 
					 $ec.='<script type="text/javascript">$(document).ready(function(){
						 update_block_x('.$rr.');
					 });
					 </script>'; 
				  }
					
				}
			
            ?>	
            	
            	
            	
            	
            	
            	
            </div>
            </form>
                        <span class="replace_mm" style="display: none;">
            <div class="matr_add__ material__IDMID"><div class="box-modal-pading"><div class="comme comme11"><span>Материал №IDMID</span><div for="IDMID" data-tooltip="Удалить материал" class="del_icon_material"></div></div><span class="hop_lalala" ><div class="div_textarea_otziv div_text_glo_IDMID"><div class="otziv_add"><textarea placeholder="Название материала" cols="40" rows="2" id="otziv_area_IDMID" name="material[IDMID][name]" class="di text_area_otziv text_material"></textarea></div></div><div class="_33_na_33"><div class="_33_x"><div><div class="input-width m10_right" style="position:relative;"><div class="width-setter" style="position:relative;"><input name="material[IDMID][ed]" id="number_rm1_IDMID" placeholder="Ед. Изм." class="input_f_1 input_100 white_inp dop_table_x" autocomplete="off" type="text"><i class="icon_cal1"></i></div><div class="dop_table"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div></div></div></div><div class="_33_x"><div class="input-width m10_right m10_left"><div class="width-setter"><input name="material[IDMID][count]" id="count_material_IDMID" placeholder="Количество" class="input_f_1 input_100 white_inp count_mask_IDMID" autocomplete="off" type="text"></div></div></div><div class="_33_x"><div class="input-width m10_left"><div class="width-setter"><input name="material[IDMID][price]" id="price_material_IDMID" placeholder="Стоимость" class="input_f_1 input_100 white_inp count_mask_IDMID" autocomplete="off" type="text"></div></div></div></div><div class="input-width animate fgg fg_summ_IDMID"><div class="width-setter"><input name="material[IDMID][sum]" readonly id="summa_material_IDMID" placeholder="Итоговая сумма" class="input_f_1 input_100 white_inp" autocomplete="off" type="text"></div></div><br><div class="over over11 over11_IDMID"><i data-tooltip="добавить еще материал" class="i___">+</i></div></span></div></div>
            </span>
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
<?
echo($ec);
?>

