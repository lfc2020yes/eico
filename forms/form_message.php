<?php
//форма написания сообщения пользователю

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;
//$dom=0;
$id=htmlspecialchars($_GET['id']);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) ==1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
    //
	

  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		/*
		  if (($role->permission('Касса','R'))or($sign_admin==1))  
		{
		*/
	
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		$token=token_access_compile($_GET['id'],'new_message_users',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   //существует ли такой наряд
	   $result_t1=mysql_time_query($link,'Select a.id,a.name_user  from r_user as a where a.id="'.htmlspecialchars(trim($id)).'"');
			
		//echo('Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  	
			
			
		   $row_t1 = mysqli_fetch_assoc($result_t1);
		   $status=1;
		   
		   ?>
			<div id="Modal-one" class="box-modal table-modal mess_f"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close mess_exit" >T</div>
			
			<span class="clock_table clock_table1"></span>
<?
			echo'<h3 class=" mess_h2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'">Сообщение</h3>';
		   
$filename = $url_system.'img/users/'.htmlspecialchars(trim($_GET['id'])).'_100x100.jpg'; 
						  if (file_exists($filename)) {
						   echo'<img data-tooltip="'.$row_t1["name_user"].'" class="user_messs" src="img/users/'.htmlspecialchars(trim($_GET['id'])).'_100x100.jpg">';
						  } else
						  {
							echo'<img data-tooltip="'.$row_t1["name_user"].'" class="user_messs" src="img/users/0_100x100.jpg">'; 
						  }
		   
		    //echo'<img data-tooltip="'.$row_t1["name_user"].'" class="user_messs" src="img/users/'.$_GET['id'].'_100x100.jpg">';
?>	
			
			<span class="hop_lalala mess_text_u" >
            <?
			//echo($_GET["url"]);
			//echo'<div class="imp_p"><span>Исполнитель:</span> <a href="implementer/'.$row_t1["id"].'/">'.$row_t1["implementer"].'</a></div>';

?>		   
  
        
        <?
        	  echo'<script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_area\').autoResize({extraSpace : 50});
$(\'#otziv_area\').focus().trigger(\'keyup\');
ToolTip();

});

	</script>';
		   
		   
		   
		   
		  
         
		    //echo'<div class="input-width"><div class="width-setter mess_s"><input name="number_rr" id="number_rrss" placeholder="Ваше сообщение" class="input_mess input_100_x white_inp_x" autocomplete="off" type="text"></div></div>';
		
		   echo'<div class="div_textarea_otziv otziv_mess"><div class="otziv_add"><textarea placeholder="Ваше сообщение" cols="40" rows="1" id="otziv_area" name="text" class="di text_area_otziv input_mess"></textarea></div></div>';
		   
		   
			?>
	


			<br>
 <div class="over">            
<div id="yes_send" class="save_button1"><i>.</i></div>
<div id="no_rd" class="no_button1"><i>x</i></div>            
           
            
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?	   
		   
		   
	   

		   } 
	   
		//}
	
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

