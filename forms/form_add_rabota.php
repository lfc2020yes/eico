<?php
//форма добавления работы в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 2)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы	
		$token=token_access_compile($_GET['id'],'add_work_mat',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   /*
	   $result_t=mysql_time_query($link,'Select a.name1,a.id,a.id_object from i_razdel1 as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   */
		
		//проверим может ли он добавлять разделы в себестоимость
		if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	    {
		
		
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1">
			<form id="lalala_form" style=" padding:0; margin:0;" method="get" enctype="multipart/form-data">

			
			<div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Добавление работы</span></h1>';
echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';		
		
        $result_town=mysql_time_query($link,'select A.name1 from i_razdel1 as A where  A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		    echo'<div class="comme">'.$row_town["name1"].'</div>';
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
           echo'<textarea placeholder="Название работы" cols="40" rows="1" id="otziv_area" name="name_work" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>
<?		
		
		   echo'<div class="_50_na_50_1"><div class="_50_x">';
		   echo'<div class="input-width m10_right">';
		
		
	$result_t=mysql_time_query($link,'Select a.id,a.implementer from i_implementer as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box"><a class="slct_box_form" data_src="0"><span class="ccol">Исполнитель</span></a><ul class="drop_box_form">';
		   echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["implementer"].'</a></li>'; 
			  
			 }
		   echo'</ul><input name="ispol_work" id="ispol" value="0" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';
		echo'</div>
		<div class="_50_x">';
		   echo'<div class="input-width m10_left" style="position:relative;"><div class="width-setter" style="position:relative;"><input name="ed_work" id="number_r" placeholder="Ед. Изм." class="input_f_1 input_100 white_inp dop_table_x" autocomplete="off" type="text"><i class="icon_cal1"></i></div>
		   
		   <div class="dop_table"><span><i>шт</i></span><span><i>м3</i></span><span><i>м2</i></span><span><i>т</i></span><span><i>пог.м</i></span><span><i>маш/час</i></span><span><i>компл</i></span></div>
		   
		   </div>';		
		echo'</div></div>';

		
				   echo'<div class="_50_na_50"><div class="_50_x">';
		   echo'<div class="input-width m10_right"><div class="width-setter"><input name="count_work" id="count_work" placeholder="Количество" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text"></div></div>';
		echo'</div>
		<div class="_50_x">';
		   echo'<div class="input-width m10_left"><div class="width-setter"><input name="price_work" id="price_work" placeholder="Стоимость" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text"></div></div>';		
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
<div id="yes_wa" class="save_button"><i>Сохранить</i></div>
           
<div id="ma_rd" class="ma_button"><i>Добавить материал</i></div>      
</div>
 <?           
echo'<input type=hidden id="freez" name="freez" value="'.htmlspecialchars(trim($_GET['freez'])).'">';     
	?>
<input type=hidden id="count_material" name="count_material" value="0">
           
            </span></div>
            

            
            
            <div class="_right_ajax_form" style="display: none;">
            	
            	
            	
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

