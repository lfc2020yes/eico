<?php
//форма добавления нового раздела в себестоимость

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
	
	    //составление секретного ключа формы
		//составление секретного ключа формы	
		$token=token_access_compile($_GET['id'],'add_block',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   

		//проверим может ли он добавлять разделы в себестоимость
		if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	    {
		
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Добавление раздела</span></h1>';

        $result_town=mysql_time_query($link,'select C.object_name,B.town,A.kvartal from i_kvartal as A,i_town as B,i_object as C where  A.id_town=B.id and C.id="'.htmlspecialchars(trim($_GET['id'])).'" and C.id_kvartal=A.id');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		    echo'<div class="comme">Себестоимость - '.$row_town["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</div>';
		}
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';


		   echo'<div class="input-width"><div class="width-setter"><input name="number_r" id="number_r" placeholder="Номер раздела" class="input_f_1 input_100 white_inp count_mask_cel" autocomplete="off" type="text"></div></div>';
$rann=0;
	$result_town2=mysql_time_query($link,'select max(A.razdel1) as mm from i_razdel1 as A where  A.id_object="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town2 = $result_town2->num_rows;
        if($num_results_custom_town2!=0)
        {
			$row_town2 = mysqli_fetch_assoc($result_town2);	
			
			$rann=$row_town2["mm"];
		
		
		if($row_town2["mm"]!='')
		{
		   echo'<div class="comme" style="margin-top:10px">Максимальный номер сейчас - '.$rann.'</div>';
		}
		}
		//номер раздела по умолчанию макс+1
		//если ввел и такой уже есть подсвечивать красным поле   
				?>
	
				
				
				
<div class="div_textarea_otziv">
			<div class="otziv_add">
<?
           echo'<textarea placeholder="Название" cols="40" rows="1" id="otziv_area" name="text" class="di text_area_otziv"></textarea>';
		   ?>
        </div></div>
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
<div id="yes_ra" class="save_button"><i>добавить</i></div></div>
            
            
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

