<?php
//форма редактирование объекта в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

//создание секретного ключа для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;


//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{		
		if(($role->permission('Объект','U'))or($sign_admin==1))
	    {
	    //составление секретного ключа формы
		//составление секретного ключа формы
		$token=token_access_compile($_GET['id'],'edit_house',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   //echo("!");
	   $result_t=mysql_time_query($link,'Select a.* from i_object as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Настройки объекта</span></h1>';
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';

?>		   
<div class="div_textarea_otziv name_obb">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Название объекта" rows="1" id="otziv_area11" name="text" class="di text_area_otziv tt_obb">'.$row_t["object_name"].'</textarea>';
		   ?>
        </div></div>
<div class="div_textarea_otziv">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Описание объекта" rows="1" id="otziv_area" name="text" class="di text_area_otziv">'.$row_t["about"].'</textarea>';
		   ?>
        </div></div>        
        
        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area\').autoResize({extraSpace : 50});
$(\'#otziv_area11\').focus();
});

	</script>';
         
            		   
		   if($row_t["object_area"]!=0)
		   {
		    echo'<div class="input-width"><div class="width-setter"><input name="number_r" id="number_r" placeholder="Площадь объекта (м2)" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text" value="'.$row_t["object_area"].'"></div></div>';
		   } else
		   {
		    echo'<div class="input-width"><div class="width-setter"><input name="number_r" id="number_r" placeholder="Площадь объекта (м2)" class="input_f_1 input_100 white_inp count_mask_cel" autocomplete="off" type="text"></div></div>';
			   
		   }
			?>
	


			<br>
 <div class="over">            
<div id="yes_he" class="save_button"><i>сохранить</i></div></div>
            
            
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?
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

?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

