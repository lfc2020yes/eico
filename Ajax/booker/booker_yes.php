<?php
//счет не оплачивать

/*
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".post_p").val();
	} else
	{
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val();	
*/

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
$token=htmlspecialchars($_GET['tk']);
$hie = new hierarchy($link,$id_user);

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

if(!token_access_new($token,'yes_bookers',$id,"s_form"))
{
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}

//**************************************************
if (( count($_GET) != 4 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Бухгалтерия','U'))and($sign_admin!=1))
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
//**************************************************


$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
	//проверяем может ли видеть этот наряд
	if($row_t["status"]!=3)
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


$status_ee='ok';

	
mysql_time_query($link,'update z_acc set status="4",date_paid="'.htmlspecialchars(trim($_GET['date'])).'",id_user_paid="'.$id_user.'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');



		//уведомление создателю счету, снабженцу об изменение статуса счета на не оплачивать

		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="4" and a.id_system=16');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}


                 $user_send_new= array();	

                 array_push($user_send_new,$row_t["id_user"]);
                 $user_send_new=array_merge($user_send_new,$hie->boss['4']);


				 $text_not='<strong>Счет №'.$row_t['number'].'</strong> изменил свой статус - <strong>'.$row_status["name_status"].'</strong>.';
				 //отправка уведомления
			     $user_send_new= array_unique($user_send_new);	
			     notification_send($text_not,$user_send_new,$id_user,$link);				   
				      


$result_score=mysql_time_query($link,'Select b.id,b.status,a.count_material from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.path_buy=1 and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
				/*		 
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>			 
				*/	
			   //score_pay score_app score_active
				 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
	
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   
			   if($row_score["status"]!=14)
			   {
		
		mysql_time_query($link,'update z_doc_material set status="14" where id = "'.$row_score["id"].'"');
				   
		$result_noti=mysql_time_query($link,'Select a.*,c.material,c.units from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and b.id="'.$row_score["id"].'"');

				 
        $num_results_noti = $result_noti->num_rows;
	    if($num_results_score!=0)
	    {		   			  			   
			   $row_noti = mysqli_fetch_assoc($result_noti);
			
		}
				 
		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="14" and a.id_system=13');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
		//уведомление создателю заявки об изменение статуса по одному из материалов его заявки

        $user_send_new= array();		
		array_push($user_send_new,$row_noti["id_user"]);
		
		//$date_graf2  = explode("-",$row_t["date_delivery"]);
		$date_delivery=date_step(htmlspecialchars(trim($_GET['date'])),$row_t["delivery_day"]);		   
		$date_graf2  = explode("-",$date_delivery);		   
				   
				   
		$text_not='В вашей <a href="app/'.$row_noti['id'].'/">заявке на материал №'.$row_noti['number'].'</a>, позиция <strong>'.$row_noti['material'].'</strong> изменила свой статус - <strong>'.$row_status["name_status"].'</strong>. Дата доставки <strong>до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</strong>. Количество ~ <strong>'.$row_score["count_material"].' '.$row_noti["units"].'</strong>';
				     
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);				   
				   
			   } else
			   {
				   //часть ему уже доставляется. это по новому счету еще
				   
		$result_noti=mysql_time_query($link,'Select a.*,c.material,c.units from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and b.id="'.$row_score["id"].'"');

				 
        $num_results_noti = $result_noti->num_rows;
	    if($num_results_score!=0)
	    {		   			  			   
			   $row_noti = mysqli_fetch_assoc($result_noti);
			
		}
				 
		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="14" and a.id_system=13');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
		//уведомление создателю заявки об изменение статуса по одному из материалов его заявки

        $user_send_new= array();		
		array_push($user_send_new,$row_noti["id_user"]);
		
		//$date_graf2  = explode("-",$row_t["date_delivery"]);
		$date_delivery=date_step(htmlspecialchars(trim($_GET['date'])),$row_t["delivery_day"]);		   
		$date_graf2  = explode("-",$date_delivery);		   
				   
				   
		$text_not='В вашей <a href="app/'.$row_noti['id'].'/">заявке на материал №'.$row_noti['number'].'</a>, по позиции <strong>'.$row_noti['material'].'</strong> поступила новая информация - <strong>оплачена еще часть материала</strong>. Дата доставки <strong>до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</strong>. Количество ~ <strong>'.$row_score["count_material"].' '.$row_noti["units"].'</strong>';
				     
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);					   
				   
				   
			   }
				   
				   
				   
			   }
			   
			   
		   }
		

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"ty" => $ID_D,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>