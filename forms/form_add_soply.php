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
			<div id="Modal-one" class="box-modal table-modal eddd1 add_form_via">
			<form id="lalala_form" style=" padding:0; margin:0;" method="get" enctype="multipart/form-data">
			
			<div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span class="new_qqe">Добавление нового счета</span></h1>';
echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';	
	
				echo'<div class="soply_step_1">';
				
						echo'<div class="table bill_wallet_option option_xvg2 active_bill">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Данные по счету</div>
				<input type="hidden" name="date_bill_" class="input_option_xvg date_bill_" value="1">
			</div>';	
			echo'<div class="xvg_add_date option_slice_xxg active_xxg bg_xxg" style="background-color:#72b7f8;">';
				?>
	
	
	<?
	  $result_t2=mysql_time_query($link,'SELECT A.name,A.id FROM z_contractor as A ORDER BY A.name ');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<select class="demo-4" name="posta_posta">';	  
	  if(($row_t["id_stock"]==0)or($row_t["id_stock"]==''))
	  {
		  echo'<option selected value="0">Поставщик</option>';
	  } else
	  {
		  echo'<option value="0">Поставщик</option>';
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

<div style="margin-bottom: 10px;">

	<div class="contractor_add "><label class="label_contractor">Добавление нового поставщика</label><label class="label_exitt"></label>
	<div class="input_2018"><label>Название</label><input name="name_contractor" id="name_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>

	<div class="input_2018"><label>Адрес</label><input name="address_contractor" id="address_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>	
	
		<div class="input_2018"><label>ИНН</label><input name="inn_contractor" id="inn_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	
	</div>
	
			
	<div class="input_2018"><label>Номер счета</label><input name="number_soply1" id="number_soply1" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	
	<div class="input_2018"><label>Дата счета</label><input name="date_soply" id="date_soply" class="input_new_2018  required date2018_mask" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>		

	<div class="input_2018"><label>Срок поставки в днях</label><input name="date_soply1" id="date_soply1" class="input_new_2018 count_mask_cel" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>	
	</div>
<?
		/*
//прикрепить счет				
				
echo'<div id_upload="'.$row__2["id"].'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'.$row__2["id"].'" id_sc="'.$row__2["id"].'" name="upload'.$row__2["id"].'"><input class="sc_sc_loo" type="file" name="myfile'.$row__2["id"].'"></form><div class="loaderr_scan scap_load_'.$row__2["id"].'"><div class="scap_load__" style="width: 0%;"></div></div>';	*/			
	?>								
	
	
<?
	//echo'<div class="img_ssoply3"><span>Материалы из заявок содержащиеся в счете:</span></div>';
	echo'</div>';
					echo'<div class="table bill_wallet_option option_xvg2 active_bill">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Материалы из заявок содержащиеся в счете</div>
				<input type="hidden" name="mat_bill_" class="input_option_xvg mat_bill_" value="1">
			</div>';	
		
				
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
				
  //$result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc');	
$result_t2=mysql_time_query($link,'Select  b.id_stock,b.id from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc');				
  
  //echo'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc';
				
				
  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<div class="xvg_add_material option_slice_xxg active_xxg">';	  
	  $ddf=1;
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {

		$row__2= mysqli_fetch_assoc($result_t2);
		  $rr=$ksss+1;
	/*
		$result_url_m=mysql_time_query($link,'select A.material,A.units from i_material as A where A.id="'.htmlspecialchars(trim($row__2["id_i_material"])).'"');
        $num_results_custom_url_m = $result_url_m->num_rows;
        if($num_results_custom_url_m!=0)
        {
			$row_material = mysqli_fetch_assoc($result_url_m);
	
		}
		*/

		  	$result_work_zz=mysql_time_query($link,'
			SELECT a.count_units AS ss,
c.price AS mm,
c.units
FROM 
z_doc_material AS a,
i_material AS c
WHERE 
a.id_i_material=c.id AND
a.id="'.$row__2["id"].'"');
		  
		    $num_results_work_zz = $result_work_zz->num_rows;
	        if($num_results_work_zz!=0)
	        {
		        $id_work=0;			
		   			  			   
			    $row_work_zz = mysqli_fetch_assoc($result_work_zz);
				   //echo('<div>'.$row_work_zz['count_units'].' '.$row_material['units'].'</div>');
					
		/*			
		$result_url=mysql_time_query($link,'select A.* from z_stock as A where A.id="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
			   //echo('select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);


		}
		*/	
		$xmd='';
		$result_t3=mysql_time_query($link,'SELECT a.id
FROM 
z_doc_material AS a
WHERE 
a.id="'.$row__2["id"].'"');				
  		$num_results_t3 = $result_t3->num_rows; 
        if($num_results_t3!=0)
        {	
			for ($op=0; $op<$num_results_t3; $op++)
            {
		       $row__3= mysqli_fetch_assoc($result_t3);
		       if($op==0) {$xmd=$row__3["id"];} else {$xmd=$xmd.'.'.$row__3["id"];}
	        }
		}
				
				
				
					  if($row__2["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"'); 
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					}
					 }
					
					
					 echo'<div class="xvg_material" yi_sopp_="'.$row__2["id"].'">
					 <input type="hidden" value="'.$row__2["id"].'" name="material['.$rr.'][stock]">	
					 <input type="hidden" value="'.$xmd.'" class="xvg_material_doc" name="material['.$rr.'][xmd]">	
			  <div class="table w_mat">
			      <div class="table-cell name_wall wall1">'.$row1ss__341["name"].'<div class="font-rank del_basket_joo" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div></div>
				  <div class="table-cell name_wall wall2">'.$row_work_zz['units'].'</div>
				  <div class="table-cell name_wall wall3"><div class="width-setter xvg_pp"><label>MAX('.$row_work_zz['ss'].')</label><input count="'.$row__2["id"].'" style="margin-top:0px;" data-tooltip="Количество в счете"  name="material['.$rr.'][count]" max="'.$row_work_zz['ss'].'" placeholder="MAX - '.$row_work_zz['ss'].'" class="input_f_1 input_100 white_inp label_s count_mask count_xvg_ jj_number" autocomplete="off" type="text" value=""></div></div>
				  
				  
			      <div class="table-cell count_wall wall4"><div class="width-setter xvg_pp"><label>MAX('.$row_work_zz['mm'].')</label><input price="'.$row__2["id"].'" style="margin-top:0px;" data-tooltip="Цена в счете за единицу с ндс"  name="material['.$rr.'][price]" max="'.$row_work_zz['mm'].'" placeholder="MAX - '.$row_work_zz['mm'].'" class="input_f_1 input_100 white_inp label_s count_mask price_xvg_ jj_number" autocomplete="off" type="text" value=""></div></div>
				  <div class="table-cell name_wall wall6 all_price_count_xvg "><span class="pay_summ_bill1"></span></div>
				  
			  </div>
			</div>';
					
					/*
					<div class="width-setter"><label>MAX('.$ostatok.')</label><input style="margin-top:0px;" all="'.$row1ss["count_units"].'" name="mat_zz['.$i.'][count]" max="'.$ostatok.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s count_app_mater_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["count"],"").'"></div>
					*/
					/*
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
				*/	
		        
		    }		  
	  }	  	  
	  
	  
	  
	  echo'<div class="table w_mat all_xvg">
			      <div class="table-cell name_wall wall1">Итого по счету</div>
				  <div class="table-cell name_wall wall2"></div>
				  <div class="table-cell name_wall wall3"></div>
				  
				  
			      <div class="table-cell count_wall wall4"></div>
				  <div class="table-cell name_wall wall6 all_summa_xvg"><span class="pay_summ_bill1"></span></div>
				  
			  </div>
	  ';
	  
	  
	  
	  
	  
	  
	  echo'</div>';
  }
	
				echo'<div class="table bill_wallet_option option_xvg2 ">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Ваш комментарий к счету</div>
				<input type="hidden" name="com_bill_" class="input_option_xvg com_bill_" value="0">
			</div>';			
				
	//echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
				?>
				<div class="option_slice_xxg  bg_xxg">
<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:0px;">
			<div class="otziv_add">
<?
           echo'<textarea cols="20" rows="1" id="otziv_area_ada" name="text_comment" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>
        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area_ada\').autoResize({extraSpace : 30});
$(\'#otziv_area_ada\').trigger(\'keyup\');

ToolTip();
});

	</script>';
           				

				
	?>
	</div>	
	
														
	</div>		
<?				

		
					echo'<div class="table bill_wallet_option option_xvg2 active_bill img_ssoply">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Файлы связанные с договором</div>
				<input type="hidden" name="file_bill_" class="input_option_xvg filr_bill_" value="0">
			</div>';
				echo'<div class="img_ssoply"><ul></ul></div>';
?>	
				
		
		
		
			
			
			
			
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

<script type="text/javascript">
$(function(){

$(".date2018_mask").mask("99.99.9999", {placeholder: "дд.мм.гггг" });														
itogprice_xvg();																			
});
</script>	
