<?php
//распроводка выдачи с удалением старого скана и изменения статуса операции

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);
$dom=0;
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


if(token_access_new($token,'dellete_pay',$id,'s_form'))
{

		  if (($role->permission('Касса','A'))or($sign_admin==1))
{	

if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Касса','R'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'Select a.* from c_cash as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'" and a.sign_rco=0 and a.status=0');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
			
         $status_ee='ok';
			
			   
			   
			 //изменить rco
			 mysql_time_query($link,'delete FROM c_cash where id="'.htmlspecialchars(trim($_GET['id'])).'"');

		   
			 
		 }
	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

}

}


$aRes = array("debug"=>$debug,"status"   => $status_ee);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>