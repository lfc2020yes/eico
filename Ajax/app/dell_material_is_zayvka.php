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


if(token_access_new($token,'dell_material_zayavka',$id,"s_form"))
{



if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))and(isset($_GET["n"]))and((is_numeric($_GET["n"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Заявки','A'))or($sign_admin==1))
	     { 
			 

       $result_t=mysql_time_query($link,'Select a.id,a.status,a.id_user from z_doc as a,z_doc_material as b where a.id=b.id_doc and b.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
	
		             if((($row_t['status']==1)and($row_t['id_user']==$id_user))or(($sign_admin==1)and($row_t['status']==1)))
	                 {
		 // echo("!");
	if((isset($_SESSION["user_id"]))and(is_numeric($id_user)))
	{		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		$token=token_access_compile($_GET['id'],'dell_material_zayavka',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   


         $status_ee='ok';
         mysql_time_query($link,'delete FROM z_doc_material where id="'.htmlspecialchars(trim($id)).'"');
			   
		 
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