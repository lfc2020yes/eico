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
if ((count($_GET) != 1)or(!isset($_GET['id']))or($_GET['id']=='')) 
{
	goto end_code;	
}	

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    goto end_code;	
}


$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t==0)
	       {	
			 goto end_code;
		   }else
		   {
			 $row_t = mysqli_fetch_assoc($result_t);
			   
		   }



//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'update_soply',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   
$read='';	   
if($row_t["status"]!=1)
		{
	$read='readonly="true"';
} 


?>
			<div id="Modal-one" class="box-modal table-modal eddd1 add_form_via">
			
			<div class="box-modal-pading "><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span class="new_qqe">Счет №'.$row_t["number"].'</span>';
				
			if($row_t["status"]!=1)
			{
			$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_t["status"].'" and a.id_system=16');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
echo'<div class="status_materialz bill_st_plus status_z">'.$row_status["name_status"].'</div>';

}
			}
				
			echo'</h1>';

	
	//echo'<div class="soply_step_1">';
			if(($row_t["status"]!=1)and($row_t["comment_status"]!=''))
			{
				echo'<div class="table bill_wallet_option option_xvg2 active_bill">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Комментарий к статусу</div>
				<input type="hidden" name="date_bill_1d" class="input_option_xvg date_bill_" value="1">
			</div>';	
			echo'<div class=" option_slice_xxg active_xxg bg_xxg">';

				echo'<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:0px;">
			<div class="otziv_add">';

           echo'<textarea cols="20" rows="1" '.$read.' id="otziv_area_ada1" name="text_comment1" class="di text_area_otziv">'.$row_t["comment_status"].'</textarea>';
		   ?>
        </div></div>
			<?	
			echo'</div>';	
			}
				
				
				
				
						echo'<div class="table bill_wallet_option option_xvg2 active_bill">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Данные по счету</div>
				<input type="hidden" name="date_bill_" class="input_option_xvg date_bill_" value="1">
			</div>';	
			echo'<div class="xvg_add_date option_slice_xxg active_xxg bg_xxg" style="background-color:#72b7f8;">';

				
					
					if($row_t["status"]==1)
					{
				
	  $result_t2=mysql_time_query($link,'SELECT A.name,A.id FROM z_contractor as A ORDER BY A.name ');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<select '.$read.' class="demo-4" name="posta_posta">';	  
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
		if($row__2["id"]==$row_t["id_contractor"]) 
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
	
<?	
echo'<input type="hidden" value="0" '.$read.' class="new_contractor_" name="new_contractor_">';
?>				

<div style="margin-bottom: 10px;">

	<div class="contractor_add "><label class="label_contractor">Добавление нового поставщика</label><label class="label_exitt"></label>
	<div class="input_2018"><label>Название</label><input name="name_contractor" id="name_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>

	<div class="input_2018"><label>Адрес</label><input name="address_contractor" id="address_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>	
	
		<div class="input_2018"><label>ИНН</label><input name="inn_contractor" id="inn_contractor" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	
	</div></div>
	
	<?		
					} else
					{
		 $result_t22=mysql_time_query($link,'SELECT A.name,A.id FROM z_contractor as A where A.id="'.$row_t["id_contractor"].'" ');				

  $num_results_t22 = $result_t22->num_rows; 
  if($num_results_t22!=0)
  {				
		$row__22= mysqli_fetch_assoc($result_t22);
	  
  }
						
		echo'<div class="input_2018"><label>Поставщик</label><input '.$read.' name="name_soply" value="'.$row__22["name"].'" class="input_new_2018 required demo-4" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>	';				
						
					}
				
		$date_graf2  = explode("-",$row_t["date"]);
		$ddd='';
		
				
						
		if(strtotime($row_t["date_delivery"]) != 0)
		{	
		    $date_graf3  = explode("-",$row_t["date_delivery"]);
			$ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
		}
	
	echo'<div class="input_2018"><label>Номер счета</label><input '.$read.' name="number_soply1" value="'.$row_t["number"].'" id="number_soply1" class="input_new_2018 required" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>
	
	<div class="input_2018"><label>Дата счета</label><input '.$read.' name="date_soply" id="date_soply" value="'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'" class="input_new_2018  required date2018_mask" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>		

	<div class="input_2018"><label>Срок поставки в днях</label><input '.$read.' name="date_soply1" value="'.$row_t["delivery_day"].'" id="date_soply1" class="input_new_2018 count_mask_cel" autocomplete="off" type="text"><div class="div_new_2018"><hr class="one"><hr class="two"></div></div>';	
		?>
	
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
		
				
				
	//echo($sql);			
				
  //$result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc');	
$result_t2=mysql_time_query($link,'Select b.id_stock,b.id,d.count_material,d.price_material from z_doc_material as b,i_material as c, z_doc_material_acc as d where d.id_doc_material=b.id and d.id_acc="'.htmlspecialchars(trim($_GET['id'])).'" and c.id=b.id_i_material');				
  
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
			      <div class="table-cell name_wall wall1">'.$row1ss__341["name"];
				
						if($row_t["status"]==1)
		{
				echo'<div class="font-rank del_basket_joo" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
		}
			echo'</div>
				  <div class="table-cell name_wall wall2">'.$row_work_zz['units'].'</div>
				  <div class="table-cell name_wall wall3"><div class="width-setter xvg_pp"><label>MAX('.$row_work_zz['ss'].')</label><input '.$read.' count="'.$row__2["id"].'" style="margin-top:0px;" data-tooltip="Количество в счете"  name="material['.$rr.'][count]" max="'.$row_work_zz['ss'].'" placeholder="MAX - '.$row_work_zz['ss'].'" value="'.$row__2["count_material"].'" class="input_f_1 input_100 white_inp label_s count_mask count_xvg_ jj_number" autocomplete="off" type="text" ></div></div>
				  
				  
			      <div class="table-cell count_wall wall4"><div class="width-setter xvg_pp"><label>MAX('.$row_work_zz['mm'].')</label><input '.$read.' price="'.$row__2["id"].'" style="margin-top:0px;" data-tooltip="Цена в счете за единицу"  name="material['.$rr.'][price]" max="'.$row_work_zz['mm'].'" placeholder="MAX - '.$row_work_zz['mm'].'" class="input_f_1 input_100 white_inp label_s count_mask price_xvg_ jj_number" autocomplete="off" type="text" value="'.$row__2["price_material"].'"></div></div>
				  <div class="table-cell name_wall wall6 all_price_count_xvg "><span class="pay_summ_bill1"></span></div>
				  
			  </div>
			</div>';
					
		        
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


  if(($row_t["status"]==4)or($row_t["status"]==3)or($row_t["status"]==20))
  {
	  echo'<div class="table bill_wallet_option option_xvg2 active_bill">';
	  echo'<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Получено по счету</div>
				<input type="hidden" name="aa_bill_" class="input_option_xvg com_bill_" value="1">
			</div>';
	  
$result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock from z_doc_material as b, z_doc_material_acc as d where d.id_doc_material=b.id and d.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');				
  
  //echo'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc';
				
				
  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<div class="xvg_add_material option_slice_xxg active_xxg" style="margin-bottom: 0px;">';	  
	  $ddf=1;
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {

		$row__2= mysqli_fetch_assoc($result_t2);

					
		
		$PROC=0;
				
		$result_url=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where b.id_stock="'.$row__2["id_stock"].'" and b.id=a.id_doc_material and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
			   //echo('select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);
		}
		
	
		$result_t3=mysql_time_query($link,'SELECT a.*
FROM 
z_stock AS a
WHERE 
a.id="'.$row__2["id_stock"].'"');				
  		$num_results_t3 = $result_t3->num_rows; 
        if($num_results_t3!=0)
        {	
		       $row__3= mysqli_fetch_assoc($result_t3);
		}
	
				
	    $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ, sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'" and a.id_stock="'.$row__2["id_stock"].'"');
		  //echo 'select sum(a.count_units) as summ from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'" and a.id_stock="'.$row__2["id_stock"].'"';
         $pri=0;       
		$num_results_proc = $result_proc->num_rows;
        if($num_results_proc!=0)
        {
			$row_proc = mysqli_fetch_assoc($result_proc);
			if($row_proc["summ"]!='')
			{
			   $pri=$row_proc["summ"]-$row_proc["summ1"];	
			}
		} 
				
			if($row_list1["ss"]!=0)
			{
		       $PROC=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row_list1["ss"]);
			}
				
				
				
		  
					
					 echo'<div class="xvg_material supply_ll">
					 
					 <div class="loaderr_supply"><div class="teps_supply" rel_w="'.$PROC.'" style="width: 0%;"><div class="peg_div_supply"><div></div></div></div></div>
					 
			  <div class="table w_mat" style="position: relative;">
			      <div class="table-cell name_wall walls1">'.$row__3["name"];
				
			echo'</div>
				  <div class="table-cell name_wall walls2">'.$pri.' из '.$row_list1["ss"].' '.$row__3['units'].'</div>
				 			  
				   <div class="table-cell count_wall walls6"><div class="procss">'.$PROC.'%</div></div>
			  </div>
			</div>';
		
		  
		  

		        
		    	  
	  }	  	  
	  
	  
	  
	 
	  
	  
	  
	  
	  
	  echo'</div>';
  }	  
	  
	  if($row_t["status"]==20)
	  {
		  			   //подсвечиваем красным за 1 день до доставки
			   $date_delivery1=date_step($row_t["date"],($row_t["delivery_day"]-1));	
			   //echo($date_delivery1);
			   
			   $style_book='';
			   if(dateDiff_1(date("y-m-d").' '.date("H:i:s"),$date_delivery1.' 00:00:00')>=0)
			   {
				   $style_book='reddecision1';
			   }   
				   
			   $date_delivery=date_step($row_t["date"],$row_t["delivery_day"]);				   
		       $date_graf2  = explode("-",$date_delivery);			  
	  } else
	  {
		  			   //подсвечиваем красным за 1 день до доставки
			   $date_delivery1=date_step($row_t["date_paid"],($row_t["delivery_day"]-1));	
			   //echo($date_delivery1);
			   
			   $style_book='';
			   if(dateDiff_1(date("y-m-d").' '.date("H:i:s"),$date_delivery1.' 00:00:00')>=0)
			   {
				   $style_book='reddecision1';
			   }   
				   
			   $date_delivery=date_step($row_t["date_paid"],$row_t["delivery_day"]);				   
		       $date_graf2  = explode("-",$date_delivery);	
		  
	  }
		  
		  
		   echo'<div class="table yy_tt">
			    <div class="table-cell name_wall walls1">Срок поставки до</div>';
		  echo'<div class="table-cell name_wall walls2"><span style="float:right; padding-bottom: 2px;" class="date_proc '.$style_book.'">до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span></div>';
		  
		  
		    echo'</div>';
		  	  
	  
	  
	  
	  
  }
		

	if($row_t["comment"]!='')
	{
		echo'<div class="table bill_wallet_option option_xvg2 active_bill">';
	} else
	{
				echo'<div class="table bill_wallet_option option_xvg2 ">';
				}
				
				echo'<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Ваш комментарий к счету</div>
				<input type="hidden" name="com_bill_" class="input_option_xvg com_bill_" value="0">
			</div>';			
				
	//echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
	if($row_t["comment"]!='')
	{	
				echo'<div class="option_slice_xxg  bg_xxg active_xxg">';
	} else
	{
		echo'<div class="option_slice_xxg  bg_xxg">';
	}
				
echo'<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:0px;">
			<div class="otziv_add">';

           echo'<textarea cols="20" rows="1" '.$read.' id="otziv_area_ada" name="text_comment" class="di text_area_otziv">'.$row_t["comment"].'</textarea>';
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
<?				

				
$result_score=mysql_time_query($link,'Select a.* from z_acc_attach as a where a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
	


$num_results_score = $result_score->num_rows;
if($num_results_score!=0)
{
	echo'<div class="table bill_wallet_option option_xvg2 active_bill img_ssoply" style="display:block;">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Файлы связанные с договором</div>
				<input type="hidden" name="file_bill_" class="input_option_xvg filr_bill_" value="0">
			</div>';
	echo'<div class="option_slice_xxg  bg_xxg active_xxg">';
				echo'<div class="img_ssoply"  style="display:block;"><ul>';
	
	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
	    $row_score = mysqli_fetch_assoc($result_score);	
		echo'<li sop="'.$row_score["id"].'">';
		if($row_t["status"]==1)
		{
		echo'<i for="'.$row_score["id"].'" data-tooltip="Удалить изображение" class="del_icon_blockbb"></i>';
		}
		
		if(($row_score["type"]=='jpg')or($row_score["type"]=='jpeg'))
		{
		
		echo'<a target="_blank" href="supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div style=" background-image: url(supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].')"></div></a></li>';
		} else
		{
			
			echo'<a target="_blank" href="supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div class="doc_pdf">'.$row_score["type"].'</div></a></li>';		
			
		}
	}
	
	echo'</ul></div>';		
} else
{
					echo'<div class="table bill_wallet_option option_xvg2 active_bill img_ssoply"  style="display:block;">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Файлы связанные с договором</div>
				<input type="hidden" name="file_bill_" class="input_option_xvg filr_bill_" value="0">
			</div>';
	
	echo'<div class="option_slice_xxg  bg_xxg active_xxg">';
				echo'<div class="img_ssoply"><ul></ul></div>';			
}
	if($row_t["status"]==1)
		{ 
			
			echo'<div id_upload="'.htmlspecialchars(trim($_GET['id'])).'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'.htmlspecialchars(trim($_GET['id'])).'" id_sc="'.htmlspecialchars(trim($_GET['id'])).'" name="upload'.htmlspecialchars(trim($_GET['id'])).'"><input class="sc_sc_loo11" type="file" name="myfile'.htmlspecialchars(trim($_GET['id'])).'"></form><div class="loaderr_scan scap_load_'.htmlspecialchars(trim($_GET['id'])).'" style="width:100%"><div class="scap_load__" style="width: 0%;"></div></div>';
			
		}				
			echo'</div>';			
				
				
				
				
	/*

  echo'<div class="img_ssoply1"><span>Материалы из заявок содержащиеся в счете:</span></div>';			
	//echo($sql);			
				
  $result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc_material as b,i_material as c, z_doc_material_acc as d where d.id_doc_material=b.id and d.id_acc="'.htmlspecialchars(trim($_GET['id'])).'" and c.id=b.id_i_material');				

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

		  	$result_work_zz=mysql_time_query($link,'Select d.count_material,a.*,b.id as idd,b.id_user,b.id_object,d.id as did from z_doc_material as a,z_doc as b,i_material as c,z_doc_material_acc as d where d.id_acc="'.htmlspecialchars(trim($_GET['id'])).'" and d.id_doc_material=a.id and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'" ');
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
					
					echo'</td><td class="bold_soply"><label>Необходимо</label><div style="margin-top:19px;">'.$row_work_zz['count_units'].' '.$row_material['units'].'</div></td><td class="bold_soply"><label>Количество в счете</label><input '.$read.' id_jj="'.$row_work_zz['did'].'" name="number_ryyy" id="number_ryy" class="input_f_1 input_100 white_inp count_mask jj_number " autocomplete="off" type="text" value="'.$row_work_zz['count_material'].'"></td>';	
					echo'<td><label>Объект</label>'.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</td><td>';
					if($row_t["status"]==1)
		            {
					   echo'<div class="font-rank del_basket_joo1" id_rel="'.$row_work_zz['did'].'"><span class="font-rank-inner">x</span></div>';
					}
					echo'</td></tr>';	
					
		        }
		    }		  
	  }	  	  
	  echo'</tbody></table>';
  }
	
				
				
				*/
	/*			
$result_score=mysql_time_query($link,'Select a.* from z_acc_attach as a where a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
	


$num_results_score = $result_score->num_rows;
if($num_results_score!=0)
{
	echo'<div style="height:30px;"></div><div class="img_ssoply" style="display:block;"><span>Файлы связанные с договором:</span><ul>';
	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
	    $row_score = mysqli_fetch_assoc($result_score);	
		echo'<li sop="'.$row_score["id"].'">';
		if($row_t["status"]==1)
		{
		echo'<i for="'.$row_score["id"].'" data-tooltip="Удалить изображение" class="del_icon_blockbb"></i>';
		}
		echo'<a target="_blank" href="supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.jpg" rel="'.$row_score["id"].'"><div style=" background-image: url(supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.jpg)"></div></a></li>'; 
	}
	echo'</ul></div>';		
} else
{
	echo'<div class="img_ssoply"><span>Файлы связанные с договором:</span><ul></ul></div>';
}
	
	if($row_t["status"]==1)
		{ 
			
			echo'<div id_upload="'.htmlspecialchars(trim($_GET['id'])).'" data-tooltip="загрузить счет" class="soply_upload">Перетащите счет, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'.htmlspecialchars(trim($_GET['id'])).'" id_sc="'.htmlspecialchars(trim($_GET['id'])).'" name="upload'.htmlspecialchars(trim($_GET['id'])).'"><input class="sc_sc_loo11" type="file" name="myfile'.htmlspecialchars(trim($_GET['id'])).'"></form><div class="loaderr_scan scap_load_'.htmlspecialchars(trim($_GET['id'])).'" style="width:100%"><div class="scap_load__" style="width: 0%;"></div></div>';
			
		}
				
			
	echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
				?>
<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:10px;">
			<div class="otziv_add">
<?
           echo'<textarea cols="20" rows="1" id="otziv_area_ada" name="text" class="di text_area_otziv">'.$row_t["comment"].'</textarea>';
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
$(".input_new_2018").trigger('focus');	
																			
});
</script>															
		
<?				
//$date_base__=explode("-",$row_t["date"]);

//$status_echo=$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0];		
		
//echo'<div class="comme">Вы точно хотите удалить счет <b>№"'.$row_t["number"].'"</b> от <b>'.$status_echo.'</b> на сумму <b>'.$row_t["summa"].'</b> руб.?</div>';

				

?>	
		
		
			*/
?>
			
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">       
 <?
	if($row_t["status"]==1)
		{ 
echo'<div id="yes_soply12" class="save_button"><i>Сохранить</i></div>
<div id="no_rd" class="no_button"><i>Отменить</i></div>';  
	
		}
	 ?>
 </div>           
<input type=hidden name="ref" value="00">
            
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
animation_teps_supply();
$(".date2018_mask").mask("99.99.9999", {placeholder: "дд.мм.гггг" });														
itogprice_xvg();			
	$(".input_new_2018").trigger('focus');	
	$('.jj_number').change(); 
});
</script>	

