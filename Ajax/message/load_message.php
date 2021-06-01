<?php
//удалить диалог с пользователем

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$n=htmlspecialchars($_GET['n_st']);
$s=htmlspecialchars($_GET['s']);
//$token=htmlspecialchars($_GET['tk']);
$count_write=10;
$eshe=0;

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован







  if((isset($_GET['id']))and(is_numeric($_GET['id']))and(isset($_GET['n_st']))and(is_numeric($_GET['n_st'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 

		
		  $poo=$s-($count_write);
		  if($poo<0) {$count_write=$poo+$count_write; $poo=0; }
		  

	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';

	$result_t2=mysql_time_query($link,'
SELECT * FROM ( 
(SELECT ff.*,ff.id_sign as idd FROM r_message AS ff WHERE  (ff.id_user = "'.htmlspecialchars(trim($id_user)).'") and ff.id_sign="'.htmlspecialchars(trim($_GET["id"])).'" ORDER BY ff.datesend)
UNION
(SELECT ff.*,ff.id_sign as idd FROM r_message AS ff WHERE (ff.id_sign = "'.htmlspecialchars(trim($id_user)).'") and ff.id_user="'.htmlspecialchars(trim($_GET["id"])).'" ORDER BY ff.datesend)

) Z ORDER BY datesend limit '.$poo.','.$count_write);
  
	  
	  
	  
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
$echo.='<div class="dialog_clear"></div>';				   
$echo.='<div class="message_date"><div><span>'.$date_prev.'</span></div></div>';	
}
$echo.='<div class="dialog_clear"></div>';	
$fl='dialog_left';
if($value["idd"]==$id_user)
{
	//свои сообщения
	$fl='dialog_right';
}
$echo.='<a class="table dialog_message '.$fl.'" dmes_e="'.$value["date"].'" id_message="'.$value["id"].'"><div class="row">';
if($value["idd"]==$id_user)
{
	$rtt='';
		if(($value["idd"]!=$messi[$key+1]["idd"]))
	{
		$rtt='<div class="ull"></div>';
	}
	
	
	//свои сообщения
$echo.='<div class="cell b"><div class="messi  '.$cll.'">'.$rtt.htmlspecialchars_decode($value["text"]).'<span class="clock_message">'.$value["time"].'</span></div></div>';	
	
	if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$user_prev=$value["idd"];
		$echo.='<div class="cell a"><div  sm="'.$value["idd"].'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$value["idd"],'_100x100.jpg">').'</div></div>';
	} else
	{
	$echo.='<div class="cell a"></div>';
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
		$echo.='<div class="cell a"><div  sm="'.$value["idd"].'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$value["idd"],'_100x100.jpg">').'</div></div>';
	} else
	{
$echo.='<div class="cell a"></div>';
	}
$echo.='<div class="cell b"><div class="messi  '.$cll.'">'.$rtt.htmlspecialchars_decode($value["text"]).'<span class="clock_message">'.$value["time"].'</span></div></div>';
}



					$echo.='</div></a>';	 
					 }
					  
		  
					  
		  
					  
 }			  
		  
	   
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 //}
//}



$aRes = array("debug"=>$debug,"eshe"=>$eshe, "status"   => $status_ee,"echo" =>  $echo,"n_st"=> ($n+1),"poo"=>$poo );
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>