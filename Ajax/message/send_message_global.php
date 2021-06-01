<?php
//отправка сообщения пользователю

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$text=htmlspecialchars($_GET['text']);






  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id from r_user as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  
		  
$status_ee='ok';

//добавляем новое сообщение 		
		   $date_r=date("y.m.d").' '.date("H:i:s");
mysql_time_query($link,'INSERT INTO r_message (id,id_user,message,status,id_sign,datesend) VALUES ("","'.htmlspecialchars(trim($id)).'","'.htmlspecialchars(trim($text)).'","1","'.htmlspecialchars(trim($id_user)).'","'.$date_r.'")');
$ID_D=mysqli_insert_id($link);								  

		   
//добавляем в диалоги 
dialog($id,$id_user,$link);  

		   
//изменяем код уведомлений чтобы пользователь увидел об этом сообщении
$noti_key=new_key($link,10);
mysql_time_query($link,'update r_user set noti_key="'.$noti_key.'" where id = "'.htmlspecialchars(trim($id)).'"'); 
		   
							  
$fl='dialog_right';

$echo.='<a class="table dialog_message '.$fl.'" dmes_e="'.$date_r.'"  id_message="'.$ID_D.'"><div class="row">';

$rtt='<div class="ull"></div>';
	
	
	//свои сообщения
$echo.='<div class="cell b"><div class="messi ">'.$rtt.htmlspecialchars_decode($text).'<span class="clock_message">'.date('G').':'.date('i').'</span></div></div>';	
	

$echo.='<div class="cell a"><div  sm="'.$id_user.'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$id_user,'_100x100.jpg">').'</div></div>';

$echo.='</div></a>';


//$echo.='Раздел '.$number.'. '.$text; 



	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 //}
//}



$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo"   => $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>