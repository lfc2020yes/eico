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
if ((count($_GET) != 0)or(!isset($_COOKIE['basket_supply_'.htmlspecialchars(trim($id_user))]))or(($_COOKIE['basket_supply_'.htmlspecialchars(trim($id_user))]==''))) 
{
	goto end_code;	
}	

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    goto end_code;	
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'add_soply',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   
	   
?>
			<div id="Modal-one" class="box-modal table-modal eddd1">
			<form id="lalala_form" style=" padding:0; margin:0;" method="get" enctype="multipart/form-data">
			
			<div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span class="new_qqe">Добавление нового счета</span></h1>';
?>
	
				
	<div class="" style="width:100%;">
	
	<?
	  $result_t2=mysql_time_query($link,'SELECT A.name,A.id FROM z_contractor as A ORDER BY A.name ');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<select class="demo-4">';	  
	  if(($row_t["id_stock"]==0)or($row_t["id_stock"]==''))
	  {
		  echo'<option selected value="0">Нет связи со складом</option>';
	  } else
	  {
		  echo'<option value="0">Нет связи со складом</option>';
	  }
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {

		$row__2= mysqli_fetch_assoc($result_t2);
		  $select='';
		if($row__2["id"]==$row_t["id_stock"]) 
		{
			$select='selected';
		}
		 echo'<option '.$select.' value="'.$row__2["id"].'">'.$row__2["name"].'</option>'; 
		  
	  }
	  echo'</select>';
  }
				
				
				
			?>
 

	
<script>

$('.demo-4').selectMania({
    themes: ['orange1'], 
    placeholder: '',
	removable: true,
			search: true
});

</script>    
	
	
<input type="hidden" value="0" class="new_contractor_" name="new_contractor_">	
<div class="contractor__">
	<div class="input_2018 loll_div"><div class="loll_dell"></div>
	<i data-tooltip="добавить нового поставщика" class="loll_plus">+</i>
<div class="b-loading-message"></div>
	<div class="b-loading"><div class="b-loading__circle-wrapper"><div class="b-loading__circle b-loading__circle_delayed"></div><div class="b-loading__circle"></div></div></div>
	
	<label>Поставщик</label><input name="number_soply" id="number_soply" class="input_new_2018 required loll_soply" autocomplete="off" type="text">
	<input type="hidden" value="" class="post_p" name="post_p">
	<ul class="loll_drop">
	</ul>
	
	<div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	</div>
	<div class="contractor_add"><label class="label_contractor">Добавление нового поставщика</label><label class="label_exitt"></label>
	<div class="input_2018"><label>Название</label><input name="name_contractor" id="name_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>

	<div class="input_2018"><label>Адрес</label><input name="address_contractor" id="address_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>	
	
		<div class="input_2018"><label>ИНН</label><input name="inn_contractor" id="inn_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	
	</div>
	
			
	<div class="input_2018"><label>Номер счета</label><input name="number_soply1" id="number_soply1" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>

	<div class="input_2018"><label>Сумма в счете</label><input name="summa_soply" id="summa_soply" class="input_new_2018 count_mask required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	
	<div class="input_2018"><label>Дата счета</label><input name="date_soply" id="date_soply" class="input_new_2018  required date2018_mask" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>		

	<div class="input_2018"><label>Дата доставки</label><input name="date_soply1" id="date_soply1" class="input_new_2018 date2018_mask" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>	
<?
		/*
//прикрепить счет				
				
echo'<div id_upload="'.$row__2["id"].'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'.$row__2["id"].'" id_sc="'.$row__2["id"].'" name="upload'.$row__2["id"].'"><input class="sc_sc_loo" type="file" name="myfile'.$row__2["id"].'"></form><div class="loaderr_scan scap_load_'.$row__2["id"].'"><div class="scap_load__" style="width: 0%;"></div></div>';	*/			
	?>								
	
	
<?
	echo'<div class="img_ssoply1"><span>Материалы из заявок содержащиеся в счете:</span></div>';			
				
		$sql='';		
	if (( isset($_COOKIE["basket_supply_".$id_user]))and($_COOKIE["basket_supply_".$id_user]!=''))
	{	
		$D = explode('.', $_COOKIE["basket_supply_".$id_user]);
		for ($ir=0; $ir<count($D); $ir++)
		{
			if($ir==0)
			{
				$sql.='"'.$D[$ir].'"';
			} else
			{
				$sql.=', "'.$D[$ir].'"';
			}
		}
	}
				
	//echo($sql);			
				
  $result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<table cellspacing="0"  cellpadding="0" border="0" class="table_soply"><thead><tr class="title_smeta"><th class="t_1"></th><th class="t_1"></th><th class="t_1"></th></tr></thead><tbody>';	  
	  $ddf=1;
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {

		$row__2= mysqli_fetch_assoc($result_t2);
	
		$result_url_m=mysql_time_query($link,'select A.material,A.units from i_material as A where A.id="'.htmlspecialchars(trim($row__2["id_i_material"])).'"');
        $num_results_custom_url_m = $result_url_m->num_rows;
        if($num_results_custom_url_m!=0)
        {
			$row_material = mysqli_fetch_assoc($result_url_m);
	
		}	
		  /*
		  echo'<tr><td colspan="3" class="blue_soply"><div class="nmss supl">'.$row_material["material"].'</div>';
		  
		if($row__2["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"'); 
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					  echo'<span data-tooltip="название товара на складе" class="stock_name_mat">'.$row1ss__341["name"].'</span>';
					} else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}
					 } else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}		  
		  
		  echo'</td></tr>';
		  */
		  	$result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id IN ('.$sql.') and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'" ');
		    $num_results_work_zz = $result_work_zz->num_rows;
	        if($num_results_work_zz!=0)
	        {
		        $id_work=0;			
		        for ($i=0; $i<$num_results_work_zz; $i++)
		        {			   			  			   
			       $row_work_zz = mysqli_fetch_assoc($result_work_zz);
				   //echo('<div>'.$row_work_zz['count_units'].' '.$row_material['units'].'</div>');
					
					
					$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
			   //echo('select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);

			        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
		}
					
					echo'<tr yi_sopp_="'.$row_work_zz['id'].'"><td>';
					
					
					
					echo'<span class="number_basket_soply">№'.$ddf.'</span>';
					$ddf++;
					//echo $row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
						
					echo'</td><td>';
					
					echo'<div class="nmss supl">'.$row_material["material"].'</div>';
		  
		if($row__2["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"'); 
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					  echo'<span data-tooltip="название товара на складе" class="stock_name_mat">'.$row1ss__341["name"].'</span>';
					} else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}
					 } else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}	
					//error_formi
					
					echo'</td><td class="bold_soply"><label>Необходимо</label><div style="margin-top:19px;">'.$row_work_zz['count_units'].' '.$row_material['units'].'</div></td><td class="bold_soply"><label>Количество в счете</label><input id_jj="'.$row_work_zz['id'].'" name="number_ryyy" id="number_ryy" class="input_f_1 input_100 white_inp count_mask jj_number " autocomplete="off" type="text"></td>';	
					echo'<td><label>Объект</label>'.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</td><td><div class="font-rank del_basket_joo" id_rel="'.$row_work_zz['id'].'"><span class="font-rank-inner">x</span></div></td></tr>';	
					
		        }
		    }		  
	  }	  	  
	  echo'</tbody></table>';
  }
	
				
				
	echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
				?>
<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:10px;">
			<div class="otziv_add">
<?
           echo'<textarea cols="20" rows="1" id="otziv_area_ada" name="text" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>
        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area_ada\').autoResize({extraSpace : 30});
$(\'#otziv_area_ada\').trigger(\'keyup\');
});

	</script>';
           				

				
	?>
	</div>	
	
<script type="text/javascript">
$(function(){

$(".date2018_mask").mask("99.99.9999", {placeholder: "дд.мм.гггг" });														
																			
});
</script>															
		
<?				
//$date_base__=explode("-",$row_t["date"]);

//$status_echo=$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0];		
		
//echo'<div class="comme">Вы точно хотите удалить счет <b>№"'.$row_t["number"].'"</b> от <b>'.$status_echo.'</b> на сумму <b>'.$row_t["summa"].'</b> руб.?</div>';
		
?>	
		
		
		
			<div class="img_ssoply"><span>Файлы связанные с договором:</span><ul></ul></div>
			
			
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_soply11" class="save_button"><i>Добавить</i></div>
<div id="no_rd" class="no_button"><i>Отменить</i></div>            
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

