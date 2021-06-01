<?php
//редактировать исполнителя

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
	if (($role->permission('Исполнители','A'))or($sign_admin==1))
    {
	    //составление секретного ключа формы
		//составление секретного ключа формы
		$token=token_access_compile($_GET['id'],'add_implementer',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
$status=1;
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Добавить Исполнителя</span></h1>';
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';

?>
<div class="div_textarea_otziv name_obb">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Название Исполнителя в системе" rows="1" id="otziv_area_ppp" name="text" class="di text_area_otziv tt_obb"></textarea>';
		   ?>
        </div></div>
		   
		   		   		   
<div class="div_textarea_otziv name_obb">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Название Организации" rows="1" id="otziv_area11" name="text" class="di text_area_otziv tt_obb"></textarea>';
		   ?>
        </div></div>
       
<div class="div_textarea_otziv">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Руководитель организации. Именительный падеж - КТО?" rows="1" id="otziv_area" name="text" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>  

<div class="div_textarea_otziv">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Руководитель организации. Дательный падеж - КОМУ?" rows="1" id="otziv_area_p" name="text" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>                  
        
        
<div class="div_textarea_otziv">
			<div class="otziv_add">
<?
           echo'<textarea cols="40" placeholder="Телефон" rows="1" id="otziv_area12" name="text" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>                  
        
        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area\').autoResize({extraSpace : 50});
$(\'#otziv_area_ppp\').focus();
});

	</script>';
         
            		   

			?>
	


			<br>
 <div class="over">            
<div id="yes_opt_imp_add" class="save_button"><i>добавить</i></div></div>
            
            
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
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

?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

