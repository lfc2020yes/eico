<?php
//удаление уведомления

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$tk='';

//$token=htmlspecialchars($_GET['tk']);
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован
if(isset($_SESSION["user_id"]))
	  { 
if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{


		 //узнаем что обновилось
	     
		 $result_t=mysql_time_query($link,'Select a.id from r_notification as a where a.id="'.htmlspecialchars(trim($_GET["id"])).'" and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			  $status_ee='ok';
			  mysql_time_query($link,'delete FROM r_notification where id="'.htmlspecialchars(trim($_GET["id"])).'"');			 
		 }
	  
	  
	  
}

 


		  } else
	  {
		  $status_ee='reg';
	  }


$aRes = array("status"   => $status_ee);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>