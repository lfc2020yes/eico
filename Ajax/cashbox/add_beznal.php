<?php
//выдача денег исполнителю в кассе

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


if(token_access_new($token,'add_beznal',$id,'s_form'))
{
   if (($role->permission('Касса','A'))or($sign_admin==1))
   {	
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 		 
		 if (($role->permission('Касса','R'))or($sign_admin==1))
	     { 
		     //проверяем может ли видеть этот наряд

			 
		   $result_t=mysql_time_query($link,'Select a.*,b.summa_debt from c_cash as a,i_implementer as b where a.id_implementer=b.id and a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if(($row_t["sign_rco"]==0))
		     { 
				 
			
			//проверяем. Если это не аванс то может ли столько провести человек. возможно долг уже меньше 
			//если аванс проводить в любом случае
				
			if((($row_t["prepayment"]==0)and($row_t["summa_rco"]<=$row_t["summa_debt"]))or($row_t["prepayment"]==1))
			{
			

			
         $status_ee='ok';
			
			 //загрузился
  mysql_time_query($link,'update c_cash set sign_rco="'.$id_user.'",status=1,file_name="",cashless="1" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');	
				
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


$aRes = array("debug"=>$debug,"status"   => $status_ee);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>