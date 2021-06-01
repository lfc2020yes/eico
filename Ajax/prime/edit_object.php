<?php
//редактировать данные по объекту в себестоимости, название, квадратных метров


$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$number=htmlspecialchars($_GET['number']);
$text=htmlspecialchars($_GET['text']);
$name=htmlspecialchars($_GET['name']);
$token=htmlspecialchars($_GET['tk']);


if(token_access_new($token,'edit_house',$id,"s_form"))
{

 if(((isset($_GET['id']))and(is_numeric($_GET['id'])))and((isset($_GET['name']))and($_GET['name']!='')))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	    if(($role->permission('Объект','U'))or($sign_admin==1))
	    {
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id from i_object as a where id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


mysql_time_query($link,'update i_object set object_name="'.htmlspecialchars(trim($name)).'",object_area="'.htmlspecialchars(trim($number)).'",about="'.htmlspecialchars(trim($text)).'" where id = "'.htmlspecialchars(trim($id)).'"');
					
		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	 }
  }

 //}
//}
}
}

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>