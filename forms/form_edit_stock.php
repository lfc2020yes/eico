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

if ((!$role->permission('Склад','U'))and($sign_admin!=1))
{
    goto end_code;	
}

//есть ли такой счет вообще
	   $result_t=mysql_time_query($link,'Select a.* from z_stock as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t==0)
	   {
		   goto end_code;	 
	   } else
	   {
		   $row_t = mysqli_fetch_assoc($result_t);

	   }


//смотрим чтобы не было связей с этим наименованием
$svyz=0;						 
//количество взаимосвязей в себестоимости
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM i_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');            	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$svyz++;
	}					 
}	
						 
//количество взаимосвязей в заявках
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM z_doc_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');            	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$svyz++;
	}					 
}						 
//количество взаимосвязей в заявках
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM z_invoice_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');             	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$svyz++;
	}					 
}				


if($svyz!=0)
{
	goto end_code;
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'edit_stock_',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   


	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1 _2zcyZS"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Изменить наименование</span></h1>';

		

	?>
		
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			
  echo'<div class="add_sklad_pl22">
<input type="hidden" value="0" class="new_sklad_name" name="new_sklad_name_">
<input name="count_work" id="count_work" placeholder="название" class="input_f_1 input_100 white_inp white_list_name" value="'.$row_t["name"].'" autocomplete="off" type="text" style="border-width: 1px 1px 1px 1px;"><div class="add_sk_sk_sk"></div>';
				
				
echo'<div><div class="input-width m10_right"  style="position:relative;"><div class="width-setter" style="position:relative;"><input name="ed_new_stock" id="units_inv" placeholder="Ед. Изм." value="'.$row_t["units"].'" class="input_f_1 input_100 white_inp dop_table_x ed_new_stock" autocomplete="off" type="text"><i class="icon_cal1 option_inv"></i></div>
		   
<div class="dop_table" style="z-index:120;"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div>
		   
 </div></div>';		



   echo'<div class="input-width m10_right">';
		
	
				
	   $su_4=0;
		$su4_name='';
	  	if ((is_numeric($row_t["id_stock_group"]))and($row_t["id_stock_group"]!=0)and($row_t["id_stock_group"]!=''))
		{
			$su_4=$row_t["id_stock_group"];
			
		    $result_url1=mysql_time_query($link,'select A.name from z_stock_group as A where A.id="'.htmlspecialchars(trim($row_t["id_stock_group"])).'"');
            $num_results_custom_url1 = $result_url1->num_rows;
            if($num_results_custom_url1!=0)
            {
			    $row_list11 = mysqli_fetch_assoc($result_url1);
				$su4_name=$row_list11["name"];
		    }				
			
		}			
				
	$result_t=mysql_time_query($link,'Select a.* from z_stock_group as a order by a.name');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box" style="float:none;"><a class="slct_box_form ee_group" data_src="'.$su_4.'">'.$su4_name.'</a><ul class="drop_box_form">';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

			   if($su_4==$row_t["id"])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			   }
			  
			 }
		   echo'</ul><input name="group_new_stock" id="group_new_stock" value="'.$su_4.'" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';					
				
				
				
				
echo'</div>';
			?>       

			<br>
 <div class="over">     
  <div class="sk_error"></div>         
<div id="yes_add_stock1" class="save_button"><i>Ок</i></div>
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

