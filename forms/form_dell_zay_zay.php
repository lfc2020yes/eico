<?php
//форма удаления  наряда который уже оформлен

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;
//$dom=0;


//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) ==1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
    //
	
	
	if((isset($_SESSION["user_id"]))and(is_numeric($id_user)))
	{
		//есть ли у него доступ в наряды вообще
		if (($role->permission('Заявки','A'))or($sign_admin==1))
	    {
		
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		$token=token_access_compile($_GET['id'],'dell_zay__',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   //существует ли такой наряд
	   $result_t=mysql_time_query($link,'Select a.id,a.status,a.number,a.id_user from z_doc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   
		   //проверяем может ли видеть этот наряд
		   $os = array("3", "1", "8", "5", "4");
if (((in_array($row_t["status"], $os))and($row_t["id_user"]==$id_user))or(($sign_admin==1)and(in_array($row_t["status"], $os))))
{ 
			    
		   
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление Заявки на Материал</span></h1>';

		
		
		
echo'<div class="comme">Вы точно хотите удалить <b>заявку на материал №'.$row_t["number"].'</b>?</div>';
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_naryd_work1140" class="save_button"><i>Удалить</i></div>
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

