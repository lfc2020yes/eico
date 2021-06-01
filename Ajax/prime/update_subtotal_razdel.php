<?php
//обновление итоговом по определенному разделу в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;
$table='';

$id=htmlspecialchars($_GET['id']);
//$number=htmlspecialchars($_GET['number']);
//$text=htmlspecialchars($_GET['text']);
//$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


/*
$day_nedeli=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_user=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_today=date("Y-m-d");
*/



	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=10;	
		   $stack_td = array();			
		   
	       
	       if($sign_admin!=1)
		   {   
			 //столбцы  выполнено на сумму - остаток по смете  
	         if ($role->is_column('i_razdel2','summa_r2_realiz',true,false)==false) 
		     { 
			  $count_rows=$count_rows-2;
			  array_push($stack_td, "summa_r2_realiz"); 
		     } 
             //строка итого по работе, по материалам, по разделу
		     if ($role->is_column('i_razdel1','summa_r1',true,false)==false) 
		     { 
			    array_push($stack_td, "summa_r1"); 
		     } 	  
             //строка итого по объекту
		     if ($role->is_column('i_object','total_r0',true,false)==false) 
		     { 
			    array_push($stack_td, "total_r0"); 
		     } 
	         //строка итого за метр кв
		     if ($role->is_column('i_object','object_area',true,false)==false) 
		     { 
			    array_push($stack_td, "object_area"); 
		     } 		
		   }





if(isset($_SESSION["s_form"]))
{

//расшифровка токена
//расшифровка токена
	/*		
$token1=explode(".", $token);
//соль для данного действия
$sale='add_work_mat';
			
$id_p=$token1[0];
$secr=$_SESSION['s_t'];

$rrr=md5($secr.$id_p.$secr[0].$sale);
if(($rrr==$token1[1])and($id_p==$id))
{
	$token1[2]=decode_x($token1[2],$secr);		
	$strt= substr($token1[2], 1,(strlen($token1[2])-2));
	$posl_chifra_idx=$id_p%10;
	$st_time11 = substr($strt, 0, (strlen($strt)-$posl_chifra_idx));
    $st_time22= substr($strt, (strlen($strt)-$posl_chifra_idx));
			
    $timeform=$st_time22.$st_time11;
	$time_sei=time();
	$razn=60*30; //30 минут
	if((($time_sei-$timeform)<=$razn)and($timeform<$time_sei))
	{

*/



  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.name1,a.summa_r1,a.summa_m1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  //такой раздел есть можно проверять переданные переменные
		   $row_t = mysqli_fetch_assoc($result_t1);
		 
		  if(array_search('summa_r1',$stack_td) === false) 
	      { 
           $echo.='<div class="itog">Итого работа<i><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_r1"], 2, '.', ' '),'0'),'.').'</span></i></div>';
			$echo.='<div class="itog">Итого материал<i><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_m1"], 2, '.', ' '),'0'),'.').'</span></i></div>';
			$echo.='<div class="itog">Итого по разделу: "'.$row_t["name1"].'"<i><span class="s_j">в т.ч. НДС 18% - '.rtrim(rtrim(number_format((($row_t["summa_m1"]+$row_t["summa_r1"])/1.18*0.18), 2, '.', ' '),'0'),'.').' / '.rtrim(rtrim(number_format(($row_t["summa_m1"]+$row_t["summa_r1"]), 2, '.', ' '),'0'),'.').'</span></i></div>';
		   
		   $echo1.='<div class="ss1" data-tooltip="итого работа"><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_r1"], 2, '.', ' '),'0'),'.').'</span></div>
				<div class="ss2" data-tooltip="итого материал"><span class="s_j">'.rtrim(rtrim(number_format($row_t["summa_m1"], 2, '.', ' '),'0'),'.').'</span></div>
				<div class="ss3" data-tooltip="итого сумма + ндс"><span class="s_j">'.rtrim(rtrim(number_format(($row_t["summa_m1"]+$row_t["summa_r1"]), 2, '.', ' '),'0'),'.').' (НДС 18% - '.rtrim(rtrim(number_format((($row_t["summa_m1"]+$row_t["summa_r1"])/1.18*0.18), 2, '.', ' '),'0'),'.').')</span></div>';
		  }
		   
		   
		   $status_ee='ok';
		   
	   }

		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo,"echo1" =>  $echo1);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>