<?php
//удалить диалог с пользователем

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован



if(token_access_new($token,'dell_dialog',$id,"s_form"))
{



  if((isset($_GET['id']))and(is_numeric($_GET['id'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  

	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';

mysql_time_query($link,'delete FROM r_dialog where id_user="'.htmlspecialchars(trim($id_user)).'" and dialog_user="'.htmlspecialchars(trim($id)).'"');

//пометить все непрочитанные сообщения с этим пользователем как прочитанные			 
mysql_time_query($link,'update r_message set status="0" where id_user = "'.htmlspecialchars(trim($id_user)).'"');  		 
		 
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 //}
//}
}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>