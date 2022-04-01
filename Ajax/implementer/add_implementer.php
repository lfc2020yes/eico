<?php
//редактировать данные по исполнителю


$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_POST['id']);
$tel=htmlspecialchars($_POST['name_tel']);
$fio=htmlspecialchars($_POST['name_kto']);
$fio1=htmlspecialchars($_POST['name_kogo']);
$name=htmlspecialchars($_POST['name_imp']);
$names=htmlspecialchars($_POST['name_org']);
$token=htmlspecialchars($_POST['tk']);

if(!token_access_new($token,'add_implementer',$id,"rema",2880))
{

    $debug=h4a(100,$echo_r,$debug);
    goto end_code;

}
/*
if(token_access_new($token,'add_implementer',$id,"s_form"))
{
*/
 if(((isset($_POST['id']))and(is_numeric($_POST['id'])))and((isset($_POST['name_imp']))and($_POST['name_imp']!='')))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	if (($role->permission('Исполнители','A'))or($sign_admin==1))
	    {
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';

/*
mysql_time_query($link,'update i_implementer set name_team="'.htmlspecialchars(trim($name)).'",fio="'.htmlspecialchars(trim($fio)).';'.htmlspecialchars(trim($fio1)).'",tel="'.htmlspecialchars(trim($tel)).'" where id = "'.htmlspecialchars(trim($id)).'"');
*/

mysql_time_query($link,'INSERT INTO i_implementer (id_user,implementer,name_team,fio,tel) VALUES ("'.$id_user.'","'.htmlspecialchars(trim($name)).'","'.htmlspecialchars(trim($names)).'","'.htmlspecialchars(trim($fio)).';'.htmlspecialchars(trim($fio1)).'","'.htmlspecialchars(trim($tel)).'")');
				
		 	  
	   
	 }
  }  else
	  {
		  $status_ee='reg';
	  }

 //}
//}
}
end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>