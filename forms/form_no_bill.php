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

if ((!$role->permission('Счет','S'))and($sign_admin!=1))
{
    goto end_code;	
}

//есть ли такой счет вообще
	   $result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t==0)
	   {
		   goto end_code;	 
	   } else
	   {
		   $row_t = mysqli_fetch_assoc($result_t);

	   }

if($row_t['status']!=2)
{
	goto end_code;
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'no_bill',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   


	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Не оплачивать счет</span></h1>';

		
	$date_graf2  = explode("-",$row_t["date"]);
					  // echo'<span class="stock_name_mat">от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span>';		
		
echo'<div class="comme">Вы точно хотите поставить статус <b>не оплачивать</b> к <b>"Cчет №'.$row_t["number"].'"</b> от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'?</div>';
		
	
		
		echo'<div class="table bill_wallet_option option_xvg2 ">
				
				<div class="table-cell option1"><div class="st_div_bill"><i></i></div></div>
				<div class="table-cell option2">Комментарий к статусу</div>
				<input type="hidden" name="com_bill_" class="input_option_xvg com_bill_" value="0">
			</div>';			
				
	//echo'<br><div class="img_ssoply1"><span>Комментарий к счету:</span></div>';	
				?>
				<div class="option_slice_xxg  bg_xxg">
<div class="div_textarea_otziv" style="border-width: 1px 1px 1px 1px !important; margin-top:0px;">
			<div class="otziv_add">
<?
           echo'<textarea cols="20" rows="1" id="otziv_area_ada" name="text_comment" class="di text_area_otziv no_comment_bill"></textarea>';
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
		
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_bill_no" class="save_button"><i>Ок</i></div>
<div id="no_rd" class="no_button"><i>Закрыть</i></div>            
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

