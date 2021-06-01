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
if ((count($_GET) != 0))
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
$token=token_access_compile($_GET['id'],'add_stock_',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   


	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1 _2zcyZS"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Добавить наименование</span></h1>';

		
	$date_graf2  = explode("-",$row_t["date"]);
					  // echo'<span class="stock_name_mat">от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span>';		
		
//echo'<div class="comme">Вы точно хотите удалить наименование - <b>"'.$row_t["name"].'"</b>?</div>';
		
	?>
		
			
			<span class="hop_lalala" >
            <?
echo'<div class="add_sklad_pl22">
<input type="hidden" value="0" class="new_sklad_name" name="new_sklad_name_">
<input name="count_work" id="count_work" placeholder="название" class="input_f_1 input_100 white_inp white_list_name" value="" autocomplete="off" type="text" style="border-width: 1px 1px 1px 1px;"><div class="add_sk_sk_sk"></div>';
				
				
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
            

			<br>
 <div class="over">  
 <div class="sk_error"></div>          
<div id="yes_add_stock" class="save_button"><i>Ок</i></div>
<div id="no_rd" class="no_button no_add_sss"><i>Закрыть</i></div>            
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

