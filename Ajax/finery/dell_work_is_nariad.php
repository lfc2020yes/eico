<?php
//удалить работу из наряда

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$n=htmlspecialchars($_GET['n']);
$token=htmlspecialchars($_GET['tk']);
$dom=0;
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


if(token_access_new($token,'dell_naryd_work11',$id,"s_form"))
{



if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))and(isset($_GET["n"]))and((is_numeric($_GET["n"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Наряды','R'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'Select a.id,a.id_user,a.id_object from n_nariad as a where a.id="'.htmlspecialchars(trim($_GET['n'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if(array_search($row_t["id_user"],$hie_user)!==false)
		     { 
			
	      //не подписан ли		 
		  if((sign_naryd_level($link,$id_user,$sign_level,$_GET["n"],$sign_admin)))
	      {
	        	$result_t2=mysql_time_query($link,'Select count(a.id) as cc from n_work as a where a.id_nariad="'.htmlspecialchars(trim($_GET['n'])).'"');
               $row_t2 = mysqli_fetch_assoc($result_t2); 
	           if($row_t2["cc"]!=1)
	           {
				    $dom=$row_t["id_object"];
         $status_ee='ok';
         mysql_time_query($link,'delete FROM n_work where id="'.htmlspecialchars(trim($id)).'" and id_nariad="'.htmlspecialchars(trim($n)).'"');
			   }
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


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo,"dom" =>  $dom);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>