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

$id=htmlspecialchars($_GET['id']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 2 ) 
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
if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
$result_t=mysql_time_query($link,'Select a.*,(select count(g.id) from z_doc_material_acc as g where g.id_acc=a.id ) as countss from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';

$date_base__=explode("-",$row_t["date"]);

$status_echo='№'.$row_t["number"].' от '.$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0];
$dom=$row_t["countss"];

$result_t1=mysql_time_query($link,'Select a.id_doc_material from z_doc_material_acc as a where a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t1 = $result_t1->num_rows;
if($num_results_t1!=0)
{	
			for ($ss=0; $ss<$num_results_t1; $ss++)
		   {	
			   $row_t1 = mysqli_fetch_assoc($result_t1);
			   if($ss!=0)
			   {
				   $basket.='.'.$row_t1["id_doc_material"];
			   } else
			   {
				   $basket=$row_t1["id_doc_material"];
			   }
				   
		   }
	
}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>