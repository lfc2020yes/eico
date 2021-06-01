<?php
//отправка счета на согласование

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
 if ((!$role->permission('Счета','A'))and($sign_admin!=1))
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
$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
//**************************************************
//**************************************************


$status_ee='ok';


mysql_time_query($link,'update z_acc set status="2" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');

$result_score=mysql_time_query($link,'Select a.*,b.status from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
				/*		 
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>			 
				*/	
			   //score_pay score_app score_active
			$os_status = array("9", "11");			 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
	
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   if(array_search($row_score["status"],$os_status)!==false)
			   {
				   mysql_time_query($link,'update z_doc_material set status="12" where id = "'.$row_score["id_doc_material"].'"');
				   
				   
	   
				   
	    $result_noti=mysql_time_query($link,'Select a.*,c.material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and b.id="'.$row_score["id_doc_material"].'"');

				 
        $num_results_noti = $result_noti->num_rows;
	    if($num_results_score!=0)
	    {		   			  			   
			   $row_noti = mysqli_fetch_assoc($result_noti);
			
		}
				 
		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="12" and a.id_system=13');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
   
				   
				   
				   
				 //уведомление создателю заявки об изменение статуса по одному из материалов его заявки

                 $user_send_new= array();		
				 array_push($user_send_new,$row_noti["id_user"]);
					
				 $text_not='В вашей <a href="app/'.$row_noti['id'].'/">заявке на материал №'.$row_noti['number'].'</a>, позиция <strong>'.$row_noti['material'].'</strong> изменила свой статус - <strong>'.$row_status["name_status"].'</strong>.';
				     
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);				   
				   
				   
				   
			   }
			   
		   }
		}
$date_base__=explode("-",$row_t["date"]);

$status_echoss=$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0];
//отправляем уведомление
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	

				$user_send= array();	
				$user_send_new= array();		

				  
                //$FUSER=new find_user($link,$row_list['id_object'],'U','Группировка');
                $user_send_new=array_merge($hie->boss['3'],$hie->boss['4']);		
				$text_not='Поступил <strong>новый счет №'.$row_t['number'].' на согласование</strong>, от '.$status_echoss.' на сумму <strong>'.$row_t['summa'].' рублей.</strong>';	
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		  






end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>