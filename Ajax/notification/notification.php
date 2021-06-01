<?php
//узнаем что нового и сколько обновилось у пользователя. уведомления

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo_m=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$tk='';

$token=htmlspecialchars($_GET['tk']);
$id_dialog=htmlspecialchars($_GET['id_dialog']);
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован
if(isset($_SESSION["user_id"]))
{ 
if(token_access_not($link,$token,'update_notification',$id_user,5))
{

		 //узнаем что обновилось
	     
		 $result_t=mysql_time_query($link,'Select count(a.id) as cc from r_notification as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
		     $echo1=$row_t["cc"];
			  $status_ee='ok';
			 
			 
		 $result_t=mysql_time_query($link,'Select a.noti_key from r_user as a where a.id="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $tk=$row_t["noti_key"];
		 }
		
		 //узнаем последнее уведомление
		 $result_t=mysql_time_query($link,'select A.* from r_notification as A where A.status=1 and  A.id_user="'.htmlspecialchars(trim($id_user)).'" order by A.datetime desc limit 1');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row__2= mysqli_fetch_assoc($result_t);		 
			 $echo='<div class="block" rel_noti="'.$row__2["id"].'"><div class="bb"></div>
	<div class="users">'.avatar_img('<img src="img/users/',$row__2["sign_user"],'_100x100.jpg">').'</div>
	<div class="text">'.htmlspecialchars_decode($row__2["notification"]).'<br><span class="noti_dates">'.time_stamp($row__2["datetime"]).'</span></div>
	<div class="ui"><div class="font-rank del_notif" data-tooltip="Удалить" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div></div>
	</div>';
		 }
			 
		 }
	
	     
	     //узнаем может новые сообщения
	     $result_t=mysql_time_query($link,'Select count(a.id) as cc from r_message as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
		     $echo_m=$row_t["cc"];
			  $status_ee='ok';
			 
		 $result_t=mysql_time_query($link,'Select a.noti_key from r_user as a where a.id="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $tk=$row_t["noti_key"];
		 }
			 	 
		 	 
			 
		 }
	  if((isset($_GET['id_dialog']))and(is_numeric($_GET['id_dialog']))and($_GET['id_dialog']!=0))
      {
		
		  //обновляем данные по сообщению в панеле
		  //делаем все сообщения от этого пользователя в панеле просмотренными
		  $whr='';
		  	  if((isset($_GET['date']))and($_GET['date']!=''))
      {
		  $whr='where datesend>"'.htmlspecialchars(trim($_GET["date"])).'"';
	  }
		
		  	  mysql_time_query($link,'update r_message set status="0" where id_user="'.htmlspecialchars(trim($id_user)).'" and id_sign="'.htmlspecialchars(trim($_GET['id_dialog'])).'"');
		  
		  
		  	$result_t2=mysql_time_query($link,'
SELECT * FROM ( 
(SELECT ff.*,ff.id_sign as idd FROM r_message AS ff WHERE  (ff.id_user = "'.htmlspecialchars(trim($id_user)).'") and ff.id_sign="'.htmlspecialchars(trim($_GET["id_dialog"])).'" ORDER BY ff.datesend)
UNION
(SELECT ff.*,ff.id_sign as idd FROM r_message AS ff WHERE (ff.id_sign = "'.htmlspecialchars(trim($id_user)).'") and ff.id_user="'.htmlspecialchars(trim($_GET["id_dialog"])).'" ORDER BY ff.datesend)

) Z '.$whr.' ORDER BY datesend');
  
	  
	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
					  $messi=array();
                      if($poo!=0)
					  {
						  $eshe=1;
					  }
		   for ($ksss=0; $ksss<$num_results_t2; $ksss++)
           {     
              $row__2= mysqli_fetch_assoc($result_t2);
			  $messi[$ksss]["id"]=$row__2["id"]; 
			  $messi[$ksss]["status"]=$row__2["status"];  
			  $messi[$ksss]["idd"]=$row__2["idd"];
			   $messi[$ksss]["date"]=$row__2["datesend"];
			  $messi[$ksss]["datesend"]=time_stamp_mess($row__2["datesend"]); 
			  $messi[$ksss]["text"]=$row__2["message"];
			   $messi[$ksss]["time"]=time_stamp_time($row__2["datesend"]); 
		   }
					  $date_end=$row__2["datesend"];
				  
					  
//echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_cash" class="smeta2 notif_imp"><tbody>';
					  $date_prev='';
					  $user_prev='';
					 // print_r($messi);
//$echo.'<div class="history_message">еще</div>';					  
foreach ($messi as $key => $value)
{     
                
           //echo($messi[1]["idd"]);          
$cll='';
  
if($value['status'] != 0) 
{
  $cll='bluesss';
}
			   $date_flag=0;
if($date_prev!=$value["datesend"])
{
$date_flag=1;	
$date_prev=$value["datesend"];	
//$echo_dialog.='<div class="dialog_clear"></div>';	

//$echo_dialog.='<div class="message_date"><div><span>'.$date_prev.'</span></div></div>';	
}
$echo_dialog.='<div class="dialog_clear"></div>';		
//$echo_dialog.='<div class="dialog_clear"></div>';	
$fl='dialog_left';
if($value["idd"]==$id_user)
{
	//свои сообщения
	$fl='dialog_right';
}
$echo_dialog.='<a class="table dialog_message '.$fl.'" dmes_e="'.$value["date"].'" id_message="'.$value["id"].'"><div class="row">';
if($value["idd"]==$id_user)
{
	$rtt='';
		if(($value["idd"]!=$messi[$key+1]["idd"]))
	{
		$rtt='<div class="ull"></div>';
	}
	
	
	//свои сообщения
$echo_dialog.='<div class="cell b"><div class="messi  '.$cll.'">'.$rtt.htmlspecialchars_decode($value["text"]).'<span class="clock_message">'.$value["time"].'</span></div></div>';	
	
	if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$user_prev=$value["idd"];
		$echo_dialog.='<div class="cell a"><div  sm="'.$value["idd"].'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$value["idd"],'_100x100.jpg">').'</div></div>';
	} else
	{
	$echo_dialog.='<div class="cell a"></div>';
	}
} else	
{
	
	$rtt='';
		if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$rtt='<div class="ull"></div>';
	}	
	
	if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$user_prev=$value["idd"];
		$echo_dialog.='<div class="cell a"><div  sm="'.$value["idd"].'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$value["idd"],'_100x100.jpg">').'</div></div>';
	} else
	{
$echo_dialog.='<div class="cell a"></div>';
	}
$echo_dialog.='<div class="cell b"><div class="messi  '.$cll.'">'.$rtt.htmlspecialchars_decode($value["text"]).'<span class="clock_message">'.$value["time"].'</span></div></div>';
}



					$echo_dialog.='</div></a>';	 
					 }
					  
		  
					  
		  
					  
 }	
		  
	  }
	
	  
	  
}

 


		  } else
	  {
		  $status_ee='reg';
	  }


$aRes = array("status"   => $status_ee,"tk" =>  $tk, "not" =>  $echo1,"echo"=>$echo,"echo_m"=>$echo_m,"echo_dialog" => $echo_dialog);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>