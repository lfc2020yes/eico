<?php
//изменение статуса в снабжение в заказе - в работе

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$val=htmlspecialchars($_GET['val']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';
//**************************************************
if ( count($_GET) != 3 ) 
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
$result_t=mysql_time_query($link,'Select a.*,b.id_object,b.id as id_docc,b.id_user,b.number,c.material from i_material as c, z_doc_material as a,z_doc as b where c.id=a.id_i_material and a.id_doc=b.id and a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
	//проверяем может ли видеть этот наряд
	if(($row_t["status"]!=20)and($row_t["status"]!=11)and($row_t["status"]!=9))
	{ 
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	}
}
//**************************************************
//**************************************************
if ((!isset($_GET["val"]))or((!is_numeric($_GET["val"])))or(($_GET["val"]!=20)and($_GET["val"]!=11)and($_GET["val"]!=9)))
{
	$debug=h4a(7,$echo_r,$debug);
	goto end_code;
}
//**************************************************

//**************************************************


$status_ee='ok';
			
//загрузился
mysql_time_query($link,'update z_doc_material set status="'.$val.'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');	

$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$val.'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');







/*
if($_GET["val"]==10)
{
//смотрим если это все исполнено в заявки то ее ставим тоже исполненной

$result_score2=mysql_time_query($link,'
			   SELECT
			   b.id,
			   b.status
			   
			    
			   
			   FROM 
			   z_doc_material as b 
			   
			   WHERE 
			  
			   b.id_doc="'.$row_t["id_doc"].'"
			   
			   
			   ');

						 
        $num_results_score2= $result_score2->num_rows; 
	    if($num_results_score2!=0)
	    {
			$count_13=0;
       	   for ($ss2=0; $ss2<$num_results_score2; $ss2++)
		   {			   			  			   
			   $row_score2 = mysqli_fetch_assoc($result_score2); 
			   if($row_score2["status"]==10) { $count_13++;}
		   }
			if($count_13==$num_results_score2)
			{
				mysql_time_query($link,'update z_doc set status="10" where id = "'.$row_score["id_doc"].'"');
			}
			
		}
}
*/	

if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
	$status_echo='<div rel_status="'.$id.'" class="st_bb menu_click status_materialz status_z'.$val.'">'.$row_status["name_status"].'</div>';
	
	            //уведомление создателю заявки об изменение статуса по одному из материалов его заявки

                 $user_send_new= array();		
				 array_push($user_send_new, $row_t["id_user"]);
					
				 $text_not='В вашей <a href="app/'.$row_t['id_docc'].'/">заявке на материал №'.$row_t['number'].'</a>, позиция <strong>'.$row_t['material'].'</strong> изменила свой статус - <strong>'.$row_status["name_status"].'</strong>.';	
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
	
	
	
	
	
}


	


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>