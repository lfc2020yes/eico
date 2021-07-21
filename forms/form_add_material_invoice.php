<?php
//форма добавления нового счета 

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
/*
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;
*/
$status=0;


if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{	
	goto end_code;
}

$id_user=id_key_crypt_encrypt($_SESSION["user_id"]);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 2)or(!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
	goto end_code;	
}	

if ((count($_GET) != 2)or(!isset($_GET["col"]))or((!is_numeric($_GET["col"])))) 
{
	goto end_code;	
}	


$result_t=mysql_time_query($link,'Select a.id from z_contractor as a where a.id="'.htmlspecialchars(trim($_GET['col'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	
}


if ((!$role->permission('Накладные','A'))and($sign_admin!=1))
{
    goto end_code;	
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'add_material_invoice',$secret);
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
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'" col="'.htmlspecialchars(trim($_GET['col'])).'"><span class="new_qqe">Добавление материала в накладную</span></h1>';
echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';				
echo'<input type="hidden" value="'.$token.'" name="tk">';	
echo'<input type="hidden" value="0" class="new_sklad_i" name="new_sklad_i">';	
				echo'<div class="invoice_step_1">';
				
			echo'<div class="xvg_add_date option_slice_xxg active_xxg bg_xxg invoice_bills" >';
				?>
	
	
	<?
	  $result_t2=mysql_time_query($link,'SELECT A.name,A.id FROM z_stock as A ORDER BY A.name ');				

  $num_results_t2 = $result_t2->num_rows; 
  if($num_results_t2!=0)
  {
	  
echo'<select class="demo-5" name="posta_posta">';	  

		  echo'<option selected value="0">Позиция на складе</option>';
	
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {
		$row__2= mysqli_fetch_assoc($result_t2);
		  $select='';
		  $count_acc=0;
		  
		  
		  //не выводим вдруг она уже есть в накладной проверяем
		  $result_t23=mysql_time_query($link,'SELECT A.id FROM z_invoice_material as A where A.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_stock="'.$row__2["id"].'" ');
		    $num_results_t23 = $result_t23->num_rows; 
  if($num_results_t23==0)
  {
		  
		  
		  
		   //к оплате - оплачено - оплачивать после получения
		   $result_t3=mysql_time_query($link,'SELECT DISTINCT a.id FROM z_acc as a,z_doc_material_acc as b,z_doc_material as c where a.status IN ("3", "4","20") and a.id=b.id_acc and b.id_doc_material=c.id and c.id_stock="'.$row__2["id"].'" and a.id_contractor="'.htmlspecialchars(trim($_GET['col'])).'"');		
		  //если по счету все приняли не видеть этого счета
		   $num_results_tu = $result_t3->num_rows;
           if($num_results_tu!=0)
           {
			   
		     for ($iu=0; $iu<$num_results_tu; $iu++)
            {  	
			   $PROC=0;	
               $row_tu = mysqli_fetch_assoc($result_t3);
			   $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_tu["id"].'" and a.id_stock="'.$row__2["id"].'"');
                
	           $num_results_proc = $result_proc->num_rows;
               if($num_results_proc!=0)
               {
		          $row_proc = mysqli_fetch_assoc($result_proc);
				   
				   
				  $result_proc1=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.$row_tu["id"].'" and b.id_stock="'.$row__2["id"].'"');	
				   $num_results_proc1 = $result_proc1->num_rows;
				  if($num_results_proc1!=0)
                  { 				   
				    $row_proc1 = mysqli_fetch_assoc($result_proc1); 
				  }
				   
				  if($row_proc1["ss"]!=0)
				  {
		              $PROC=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row_proc1["ss"]); 
					  
				  }
				   
	           } 
	  	       if($PROC<100)
			   {
				   $count_acc++;
			   }
			   
		    }
		  
	       }	  
  
		  
		  
 $bill='';
		  $class='';

	  if($count_acc!=0)
	  {
		  $skl='счет,счета,счетов';
		   $bill=' ['.$count_acc.' '.PadejNumber($count_acc,$skl).']';
		  $class='class="select-mania-yes"';
	  }
  
		  
		 echo'<option '.$select.' '.$class.' value="'.$row__2["id"].'">'.$row__2["name"].' '.$bill.'</option>'; 
  }
	  }
	  echo'</select>';
  }
				
				
				
			?>
 

	
<script>

$('.demo-5').selectMania({
    themes: ['orange2'], 
    placeholder: '',
	removable: true,
			search: true
});

</script>    
	

<?
				
echo'<div class="add_sklad_pl1">

<input name="name_new_stock" id="count_work" placeholder="Новое название" class="input_f_1 input_100 white_inp name_new_stock" value="" autocomplete="off" type="text" style="border-width: 1px 1px 1px 1px; margin-top:0px;"><div class="add_sk_sk_sk1" style="top:12px;"></div>';
				
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
	
	

				echo'<div class="error_text_add no_bill_material" style="float:none; display:none; margin-top:10px; color:rgba(0,0,0,0.8);">Связанных счетов с выбранным материалом не найдено</div>';
				echo'<div class="search_bill"></div>';
				
	//echo'<div class="img_ssoply3"><span>Материалы из заявок содержащиеся в счете:</span></div>';
	echo'</div>';
					
		
				
				

	//echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
?>
	
														
	</div>		
	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_material_invoice" class="save_button"><i>Добавить</i></div>
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
																			
});
</script>	
