<?php
//форма редактирование раздела в себестоимости дома
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы
		//соль для данного действия
		$token=token_access_compile($_GET['id'],'dell_soply',$secret);

        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   
	   $result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление счета</span></h1>';

		
$date_base__=explode("-",$row_t["date"]);

$status_echo=$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0];		
		
echo'<div class="comme">Вы точно хотите удалить счет <b>№"'.$row_t["number"].'"</b> от <b>'.$status_echo.'</b> на сумму <b>'.$row_t["summa"].'</b> руб.?</div>';
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_soply" class="save_button"><i>Удалить</i></div>
<div id="no_rd" class="no_button"><i>Отменить</i></div>            
 </div>           
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

