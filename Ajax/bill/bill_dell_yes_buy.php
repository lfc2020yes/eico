<?php
//на оплату счет

/*
		   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&date='+$("#date_hidden_table_gr1").val()+'&summa='+$(".summ_input_ww").val()+'&add='+add;	
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

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

if(!token_access_new($token,'dell_yes_bill',$id,"s_form"))
{
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}

//**************************************************
if (( count($_GET) != 3 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Счета','S'))and($sign_admin!=1))
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
	if(($row_t["status"]!=3)and($row_t["status"]!=20))
	{ 
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	}
} else
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}


//если статус 20 то отменить нельзя если уже есть какие то накладные по счету
			$PROC=0;	
			   $result_proc=mysql_time_query($link,'select count(a.id) as cc from z_invoice_material as a where a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');
                
	           $num_results_proc = $result_proc->num_rows;
               if($num_results_proc!=0)
               {
		          $row_proc = mysqli_fetch_assoc($result_proc);
				   
				   if($row_proc["cc"]!=0)
				   {
					  $debug=h4a(622,$echo_r,$debug);
		              goto end_code;
				   }
				   
			   }



$status_ee='ok';


mysql_time_query($link,'update z_acc set status="2",path_summa="",date_buy="",comment_status="" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');




mysql_time_query($link,'update z_doc_material_acc set path_buy="0" where id_acc = "'.htmlspecialchars(trim($_GET['id'])).'"');	


	if($row_t["status"]!=20)
	{   
        $result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="2" and a.id_system=16');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
        $user_send_new= array();		
		array_push($user_send_new,$row_t["id_user"]);
					
		$text_not='<strong>Счет №'.$row_t['number'].'</strong> со статусом к оплате <strong>отменен</strong>. Теперь статус счета - <strong>'.$row_status["name_status"].'</strong>.';
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);	
	} else
	{
        $result_status11=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="20" and a.id_system=16');	
		if($result_status11->num_rows!=0)
        {  
           $row_status11 = mysqli_fetch_assoc($result_status11);
		}		
		
		
        $result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="2" and a.id_system=16');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
        $user_send_new= array();		
		array_push($user_send_new,$row_t["id_user"]);
					
		$text_not='<strong>Счет №'.$row_t['number'].'</strong> со статусом '.$row_status11["name_status"].' <strong>отменен</strong>. Теперь статус счета - <strong>'.$row_status["name_status"].'</strong>.';
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);			
	}
 
	if($row_t["status"]!=20)
	{        
        //уведомление в бухгалтерию о поступлении нового счета на оплату
        $FUSER=new find_user($link,'*','U','','buh');
		$user_send_new=$FUSER->id_user;

		$text_not='<strong>Счет №'.$row_t['number'].'</strong> со статусом к оплате - <strong>отменен</strong>.';
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);	
	}

//проходим по всем материалам в заявке которые содержутся в счете и если у этой заявки материала статус был к оплате и нет других связанных счетов с этим материалом заявкой со статусом равным  3,4,20 тогда изменяем статус на 12 в работе а статус этой заявки на 9 заказано
$result_score=mysql_time_query($link,'Select b.id,b.id_doc,b.status from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');

				 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   if($row_score["status"]==13)
			   {
				    $result_score1=mysql_time_query($link,'
			   SELECT
			   a.status
			   
			    
			   
			   FROM 
			   z_acc as a,
			   z_doc_material_acc as b 
			   
			   WHERE 
			   not(a.id ="'.htmlspecialchars(trim($_GET['id'])).'") and
			   a.status IN ("3","4","20") and
			   b.id_acc=a.id and
			   b.path_buy=1 and
			   b.id_doc_material="'.$row_score["id"].'"			 		   
			   ');

						 
        $num_results_score1 = $result_score1->num_rows;
			 
	    if($num_results_score1==0)
	    {
		   mysql_time_query($link,'update z_doc_material set status="12" where id = "'.htmlspecialchars(trim($row_score["id"])).'"');	       
           mysql_time_query($link,'update z_doc set status="9" where id = "'.htmlspecialchars(trim($row_score["id_doc"])).'"');	  
			
			
		   
				 $result_noti=mysql_time_query($link,'Select a.*,c.material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and b.id="'.$row_score["id"].'"');

				 
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
		}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"ty" => $ID_D,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>