<?php
//получение новых уведомлений

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$tk='';

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован
if(isset($_SESSION["user_id"]))
	  { 


		 //узнаем что обновилось
	     
		 $result_t=mysql_time_query($link,'Select count(a.id) as cc from r_notification as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
		     $echo1=$row_t["cc"];
			  $status_ee='ok';
			 
			 
			 	  $result_t2=mysql_time_query($link,'select A.* from r_notification as A where A.status=1 and  A.id_user="'.htmlspecialchars(trim($id_user)).'" order by A.datetime desc');
	  $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
			           $echo.='<div class="block" rel_noti="'.$row__2["id"].'"><div class="bb"></div>
	<div class="users">'.avatar_img('<img src="img/users/',$row__2["sign_user"],'_100x100.jpg">').'</div>
	<div class="text">'.htmlspecialchars_decode($row__2["notification"]).'<br><span class="noti_dates">'.time_stamp($row__2["datetime"]).'</span></div>
	<div class="ui"><div class="font-rank del_notif" data-tooltip="Удалить" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div></div>
	</div>';
					 }
				  }
			 	  
			      mysql_time_query($link,'update r_notification set status="0" where id_user = "'.htmlspecialchars(trim($id_user)).'"'); 
			 
		 }
	  
	  
	  


 


		  } else
	  {
		  $status_ee='reg';
	  }


$aRes = array("status"   => $status_ee,"echo" =>  $echo, "not" =>  $echo1);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>