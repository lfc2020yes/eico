<?php
//редактировать данные по объекту в себестоимости, название, квадратных метров


$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
//$number=htmlspecialchars($_GET['number']);
//$text=htmlspecialchars($_GET['text']);
//$name=htmlspecialchars($_GET['name']);
$token=htmlspecialchars($_GET['tk']);

//echo("0");
if(token_access_new($token,'edit_grafic',$id,"s_form"))
{
//echo("1");
 if(((isset($_GET['id']))and(is_numeric($_GET['id'])))and((isset($_GET['data1']))and($_GET['data1']!=''))and((isset($_GET['data2']))and($_GET['data2']!='')))
  {
	  //echo("2");
	  $date_graf1  = explode(".",htmlspecialchars($_GET['data1']));
	 $timestamp_graf1=mktime(0,0,0,date_minus_null($date_graf1[1]),date_minus_null($date_graf1[0]),date_minus_null($date_graf1[2]));
	  
	  $date_graf2  = explode(".",htmlspecialchars($_GET['data2']));
	 $timestamp_graf2=mktime(0,0,0,date_minus_null($date_graf2[1]),date_minus_null($date_graf2[0]),date_minus_null($date_graf2[2]));	  
	  
	  if($timestamp_graf2>=$timestamp_graf1)
	  {
		  //echo("3");
	  if(isset($_SESSION["user_id"]))
	  { 
	    if (($role->permission('График','U'))or($sign_admin==1))
	    {
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id from i_razdel2 as a where id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


mysql_time_query($link,'update i_razdel2 set date0="'.htmlspecialchars(trim($date_graf1[2])).'-'.htmlspecialchars(trim($date_graf1[1])).'-'.htmlspecialchars(trim($date_graf1[0])).'",date1="'.htmlspecialchars(trim($date_graf2[2])).'-'.htmlspecialchars(trim($date_graf2[1])).'-'.htmlspecialchars(trim($date_graf2[0])).'" where id = "'.htmlspecialchars(trim($id)).'"');

$echo='<span class="UD0">'.htmlspecialchars($_GET['data1']).'</span><span> - </span><span class="UD1">'.htmlspecialchars($_GET['data2']).'</span>';		   
		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	 }
  }

 //}
}
}
}

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>