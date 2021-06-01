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
if ((count($_GET) != 1)or(!isset($_GET["id"]))or(!is_numeric($_GET["id"]))) 
{
	goto end_code;	
}	

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    goto end_code;	
}

$result_t=mysql_time_query($link,'Select a.id,a.id_stock,b.material from z_doc_material as a,i_material as b where a.id_i_material=b.id and a.id="'.htmlspecialchars(trim($_GET["id"])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t==0)
	       {	
			     goto end_code;	
		   } else
		   {
			     $row_t = mysqli_fetch_assoc($result_t);
		   }


//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'edit_sklad',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   
	   
?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h3  class="h111 head_h pay_uf" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'">Связь со складом<div></div></h1>';

				
			//echo'<div class="comme">Заказанный материал</div>';

				
echo'<div class="img_ssoply11"><span >Название заказанного материала:</span></div>';			
echo'<div style="border-top: 1px solid rgba(0,0,0,0.1); height: 10px;
margin-top: 10px;"></div>';
echo'<a class="a_soply_a">'.$row_t["material"].'</a>';	

echo'<div class="img_ssoply11" style="margin-bottom:15px;"><span>Название материала на складе:</span></div>';	
			
												
?>			

			

			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			
  $result_t2=mysql_time_query($link,'Select a.name,a.id from z_stock as a order by a.name desc');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<select class="demo-3">';	  
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

$('.demo-3').selectMania({
    themes: ['orange'], 
    placeholder: 'Нет связи со складом',
	removable: true,
			search: true
});

</script>           

			
<?
				
echo'<div class="add_sklad_pl">
<input type="hidden" value="0" class="new_sklad_name" name="new_sklad_name_">
<input name="count_work" id="count_work" placeholder="Новое название" class="input_f_1 input_100 white_inp white_list_name" value="'.$row_t["material"].'" autocomplete="off" type="text" style="border-width: 1px 1px 1px 1px;"><div class="add_sk_sk_sk"></div>';
				
				
echo'<div><div class="input-width m10_right"  style="position:relative;"><div class="width-setter" style="position:relative;"><input name="ed_new_stock" id="units_inv" placeholder="Ед. Изм." value="" class="input_f_1 input_100 white_inp dop_table_x ed_new_stock" autocomplete="off" type="text"><i class="icon_cal1 option_inv"></i></div>
		   
<div class="dop_table" style="z-index:120;"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div>
		   
 </div></div>';		



   echo'<div class="input-width m10_right">';
		
		
	$result_t=mysql_time_query($link,'Select a.* from z_stock_group as a order by a.name');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box" style="float:none;"><a class="slct_box_form ee_group" data_src="0"><span class="ccol">Группа</span></a><ul class="drop_box_form">';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			  
			 }
		   echo'</ul><input name="group_new_stock" id="group_new_stock" value="0" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';					
				
				
				
				
echo'</div>';
?>				
			
			
 <div class="over">      
 
  <div class="sk_error"></div>    
                
<div id="yes_update_sk_sk" class="save_button"><i>Сохранить</i></div>
<div id="no_rd" class="no_button end_list_white"><i>Отменить</i></div>            
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

