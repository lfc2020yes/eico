<?php
//получение материалов из счета при выборе текущего счета

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$basket='';

$id=htmlspecialchars($_COOKIE["current_supply_".$id_user]);



$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 1 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Снабжение','U'))and($sign_admin!=1))
{
  $debug=h4a(2,$echo_r,$debug);
  goto end_code;	
}
//**************************************************
 if(!isset($_SESSION["user_id"]))
{ 
  $status_ee='reg';	
  $debug=h4a(3,$echo_r,$debug);
  goto end_code;
}
//**************************************************
if ((!isset($_COOKIE["current_supply_".$id_user]))or((!is_numeric($id)))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_COOKIE["current_supply_".$id_user])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
	//проверяем может ли видеть этот наряд
	if($row_t["status"]!=1)
	{ 
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	}
} else
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}
//**************************************************
if(($row_t["id_user"]!=$id_user)and($sign_admin!=1))
{ 
	    $debug=h4a(7,$echo_r,$debug);
		goto end_code;	
}
//**************************************************
if ((!isset($_COOKIE["basket_score_".$id_user]))or($_COOKIE["basket_score_".$id_user]==''))
{
	    $debug=h4a(9,$echo_r,$debug);
		goto end_code;	
}
//**************************************************
//**************************************************


$status_ee='ok';
//mysql_time_query($link,'delete FROM z_doc_material_acc where id_acc="'.htmlspecialchars(trim($id)).'"');


$dom=$row_t["number"];
$update=explode(".",$_COOKIE["basket_score_".$id_user]);



  $sql_del='Select a.id,a.id_doc_material from z_doc_material_acc as a where a.id_acc="'.htmlspecialchars(trim($id)).'"';

$result_del=mysql_time_query($link,$sql_del);	  
$num_results_del = $result_del->num_rows;
if($num_results_del!=0)
{
   for ($pp=0; $pp<$num_results_del; $pp++)
   {
       $row_del= mysqli_fetch_assoc($result_del);
	   if(array_search($row_del["id_doc_material"],$update)==false)
	   {
		   mysql_time_query($link,'delete FROM z_doc_material_acc where id_acc="'.htmlspecialchars(trim($row_del["id"])).'"');
	   }
	   
   }
}


	
for ($ss=0; $ss<count($update); $ss++)
{			   			  			   
			   
			   if(is_numeric($update[$ss]))
			   {
				     $sql_del='Select a.id from z_doc_material_acc as a where a.id_acc="'.htmlspecialchars(trim($id)).'" and a.id_doc_material="'.htmlspecialchars(trim($update[$ss])).'"';

$result_del=mysql_time_query($link,$sql_del);	  
$num_results_del = $result_del->num_rows;
if($num_results_del==0)
{
				   
				   mysql_time_query($link,'INSERT INTO z_doc_material_acc (id_doc_material,id_acc) VALUES ("'.htmlspecialchars(trim($update[$ss])).'","'.htmlspecialchars(trim($id)).'")');
}
			   }
			   
}
		

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"number" => $dom,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>