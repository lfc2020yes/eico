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
 if ((!$role->permission('Накладные','A'))and($sign_admin!=1))
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
if ((!isset($_GET["id"]))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
$result_t=mysql_time_query($link,'Select a.*,b.status,b.id_user,a.subtotal,b.summa from z_invoice_material as a,z_invoice as b where a.id_invoice=b.id and a.id="'.$id.'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if((($row_t["status"]!=1)))
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

mysql_time_query($link,'delete FROM z_invoice_material where id="'.htmlspecialchars(trim($_GET['id'])).'"');


$new_summa=$row_t["summa"]-$row_t["subtotal"];

mysql_time_query($link,'update z_invoice set summa="'.$new_summa.'" where id = "'.htmlspecialchars($row_t['id_invoice']).'"');


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>