<?php
//удалить наряда

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
$dom=0;
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


if(token_access_new($token,'dell_naryd_x',$id,"s_form"))
{



if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Наряды','R'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'Select a.id,a.id_user,a.id_object from n_nariad as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if(array_search($row_t["id_user"],$hie_user)!==false)
		     { 
			
	      //не подписан ли		 
		  if((sign_naryd_level($link,$id_user,$sign_level,$_GET["id"],$sign_admin)))
	      {

			
         $status_ee='ok';
        
			  
	  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				  $user_send= array();	
					$user_send_new= array();	
				
				  
				  
	
					   
	
	//сообщаем создателю наряда если удаляем не создатель					  
	if($id_user!=$row_list["id_user"])
	{
      array_push($user_send_new, $row_list["id_user"]);
		
						  
						  
				 $user_send_new= array_unique($user_send_new);		
				 //print_r($user_send_new);	
	 					  

				  $text_not='<strong>'.$name_user.'</strong> удалил <strong>Наряд №'.htmlspecialchars(trim($_GET['id'])).'</strong>';
				 
				  
				  //echo($text_not);
				  		  
					
				  notification_send($text_not,$user_send_new,$id_user,$link);	
	}
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		  
			  
			  
			  
			  
	   mysql_time_query($link,'delete FROM n_nariad where id="'.htmlspecialchars(trim($id)).'"');
			  
	     
			  
			  
			  
			  
		 }
			 }
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