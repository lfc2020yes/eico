<?php
//форма удаления работы из наряда который уже оформлен

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;
//$dom=0;


//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) ==2)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))and(isset($_GET["n"]))and((is_numeric($_GET["n"])))) 
{
    //
	
	
	if((isset($_SESSION["user_id"]))and(is_numeric($id_user)))
	{
		//есть ли у него доступ в наряды вообще
		if (($role->permission('Наряды','R'))or($sign_admin==1))
	    {
	
		//не подписан ли он выше кем то
		  if((sign_naryd_level($link,$id_user,$sign_level,$_GET["n"],$sign_admin)))
	      {
		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		$token=token_access_compile($_GET['id'],'dell_naryd_work11',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   //существует ли такой наряд
	   $result_t=mysql_time_query($link,'Select a.id,a.id_user from n_nariad as a where a.id="'.htmlspecialchars(trim($_GET['n'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   
		   //проверяем может ли видеть этот наряд
		   if(array_search($row_t["id_user"],$hie_user)!==false)
		   {
			   
		   //относится ли выбранная работа к данному наряду - есть ли она в наряде
		   $result_t1=mysql_time_query($link,'Select a.name_work from n_work as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'" and a.id_nariad="'.htmlspecialchars(trim($_GET['n'])).'"');
           $num_results_t1 = $result_t1->num_rows;
	       if($num_results_t1!=0)
	       {
			   $row_t1 = mysqli_fetch_assoc($result_t1);
			   //не является ли она единственной работой
			   $result_t2=mysql_time_query($link,'Select count(a.id) as cc from n_work as a where a.id_nariad="'.htmlspecialchars(trim($_GET['n'])).'"');
               $row_t2 = mysqli_fetch_assoc($result_t2); 
	           if($row_t2["cc"]!=1)
	           {
				  
			   
		   
		   
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 dom="'.htmlspecialchars(trim($_GET['n'])).'" class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление работы из наряда</span></h1>';

		
		
		
echo'<div class="comme">Вы точно хотите удалить работу <b>"'.$row_t1["name_work"].'"</b> из наряда №'.$_GET['n'].'?</div>';
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_naryd_work11" class="save_button"><i>Удалить</i></div>
<div id="no_rd" class="no_button"><i>Отменить</i></div>            
 </div>           
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?
		   } else
		   {
			//единсвенная работа	 
				   
			   
		   
		   
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 dom="'.htmlspecialchars(trim($_GET['n'])).'" class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление работы из наряда</span></h1>';

		
		
		 
echo'<div class="comme">Вы не можете удалить работу <b>"'.$row_t1["name_work"].'"</b> из наряда №'.$_GET['n'].', так как это единсвенная работа в данном наряде!</div>';
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
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

