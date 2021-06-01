<?php
//удаление материала по работе в себестоимости

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

if(token_access_new($token,'dell_material',$id,"s_form"))
{

  if((isset($_GET['id']))and(is_numeric($_GET['id'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		   if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	       {
$status_ee='ok';
		$result_t1=mysql_time_query($link,'Select a.name1,a.id,a.id_object,a.razdel1,b.name_working,c.* from i_razdel1 as a,i_razdel2 as b,i_material as c where c.id_razdel2=b.id and b.id_razdel1=a.id and c.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		   $row1 = mysqli_fetch_assoc($result_t1);

mysql_time_query($link,'delete FROM i_material where id="'.htmlspecialchars(trim($id)).'"');
			   
 //уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
		  
		if($sign_admin!=1)
		{   
		 
		
		       $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row1['id_object'])).'"');
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
				$text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> в разделе - <strong>'.$row1["name1"].'</strong>, в работе - <strong>'.htmlspecialchars(trim($row1["name_working"])).'</strong>, был удален материал - <strong>'.htmlspecialchars(trim($row1['material'])).'</strong>, с количеством -  <strong>'.htmlspecialchars(trim($row1['count_units'])).' '.htmlspecialchars(trim($row1['units'])).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($row1['price'])).' руб.</strong>';		
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
}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>