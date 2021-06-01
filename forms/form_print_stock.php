<?php
//форма сформировать отчет для склада

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
if ((count($_GET) != 1)) 
{
	goto end_code;	
}	

if ((!$role->permission('Склад','A'))and($sign_admin!=1))
{
    goto end_code;	
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'print_stock_report8',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   
	?>   
			<div id="Modal-one" class="box-modal table-modal eddd1 add_form_via print_stocks">
			<form id="lalala_form22" action="stock/print/" style=" padding:0; margin:0;" method="post"   enctype="multipart/form-data">
			
			<div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span class="new_qqe">Сформировать документ для печати</span></h1>';
echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';	
	
				echo'<div class="soply_step_1">';
				
						echo'<div class="table bill_wallet_option option_xvg2 active_bill">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Данные по объекту</div>
				<input type="hidden" name="date_bill_" class="input_option_xvg date_bill_" value="1">
			</div>';	
			echo'<div class="xvg_add_date option_slice_xxg active_xxg bg_xxg">';
	
				
			   echo'<div class="input-width m10_right">';
		
		
	$result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box" style="float:none; margin-top: 0px; z-index:123;"><a class="slct_box_form ee_group" data_src="0"><span class="ccol">Город</span></a><ul class="drop_box_form">';
		    echo'<li class="sel_active"><a href="javascript:void(0);"  rel="0">Любой</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  if((array_search($row_t["id"],$hie_town) !== false)or($sign_admin==1)) 
               {	 
		
				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>'; 
			   
			   }
			  
			 }
		   echo'</ul><input name="stock_town_" id="stock_town_" value="0" type="hidden"></div>'; 
	   }

		echo'</div>';				
	echo'<div class="input-width m10_right stock_kv_x"></div>';
	echo'<div class="input-width m10_right stock_ob_x"></div>';				
				
				
?>
	
	
	<?
		
				
				
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
				<div class="table-cell option2">Дополнительные параметры</div>
				<input type="hidden" name="mat_bill_" class="input_option_xvg mat_bill_" value="1">
			</div>';	
		
				
					echo'<div class="xvg_add_date option_slice_xxg active_xxg bg_xxg">';
	
				
			   echo'<div class="input-width m10_right">';
		
		
	$result_t=mysql_time_query($link,'Select a.* from z_stock_group as a order by a.name');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box" style="float:none;  margin-top: 0px; z-index:120;"><a class="slct_box_form ee_group" data_src="0"><span class="ccol">Группа</span></a><ul class="drop_box_form">';
		   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="0">Любая</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			  
			 }
		   echo'</ul><input name="stock_group_" id="stock_group_" value="0" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';	
				
				
				
				
			   echo'<div class="input-width m10_right">';
		
		
	$result_t=mysql_time_query($link,'Select a.* from r_user as a where not(a.login="root") order by a.name_user');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box" style="float:none;"><a class="slct_box_form ee_group" data_src="0"><span class="ccol">Пользователь</span></a><ul class="drop_box_form">';
		   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="0">Любой</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);


			    if((array_search($row_t["id"],$hie_user) !== false)or($sign_admin==1)) 
               {	 

				 echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name_user"].'</a></li>'; 
			   
			 }				 
				 
				 
				 
				 // echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			  
			 }
		   echo'</ul><input name="stock_user_" id="stock_user_" value="0" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';					
				
				
		echo'</div>';			

	
?>
			
			
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_print_stock" class="save_button"><i>Сформировать</i></div>
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
