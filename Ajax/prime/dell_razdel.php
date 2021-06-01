<?php
//удалить раздел в себестоимости

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



if(token_access_new($token,'dell_block',$id,"s_form"))
{



  if((isset($_GET['id']))and(is_numeric($_GET['id'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  
		 if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	     { 
		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
			$result_tx=mysql_time_query($link,'Select a.id_object,a.razdel1,a.name1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_tx = $result_tx->num_rows;
	   if($num_results_tx!=0)
	   {  
		  $row_tx = mysqli_fetch_assoc($result_tx); 
	  
			 
			 
$status_ee='ok';

mysql_time_query($link,'delete FROM i_razdel1 where id="'.htmlspecialchars(trim($id)).'"');
//возможно удалить и работы связанные с ним
	
		   
		    //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   
		  if($sign_admin!=1)
		   {   
		 
		
		       $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_tx["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
     
			 $row_list= mysqli_fetch_assoc($result_url);	   
		}
			   
		$result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
			   
			   
			   
				$user_send= array();	
				$user_send_new= array();		

				  
                //$FUSER=new find_user($link,$row_list['id_object'],'U','Группировка');
                $user_send_new=array_merge($hie->boss['4']);		
				$text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> был удален раздел - <strong>№'.$row_tx["razdel1"].'</strong>.';	
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);		   
		   } 
		   
			   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления	   
		   
		
		   
		   
	   }
		 }
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