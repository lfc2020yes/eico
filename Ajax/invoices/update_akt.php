<?php
//получение материалов из счета при выборе текущего счета

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$basket='';

$id=htmlspecialchars($_GET['id']);
$type=htmlspecialchars($_GET['type']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 3 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Накладные','A'))and($sign_admin!=1))
{
  $debug=h4a(2,$echo_r,$debug);
  goto end_code;	
}

if(($type!=0)and($type!=1))
{
  $debug=h4a(23,$echo_r,$debug);
  goto end_code;	
}

//**************************************************
 if(!isset($_SESSION["user_id"]))
{ 
  $status_ee='reg';	
  $debug=h4a(3,$echo_r,$debug);
  goto end_code;
}
//**************************************************
if ((!isset($_GET["id"]))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
$result_t=mysql_time_query($link,'Select a.* from z_invoice_material as a where a.id="'.$id.'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
			   
		   } else
		   {
			      $debug=h4a(6,$echo_r,$debug);
   goto end_code;	
		   }


//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';
$basket=array();



$result_score=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.id_invoice_material="'.$id.'" and a.type_invoice="'.$type.'"');
	
$url_scan='scan_akt';
if($type==1)
{
$url_scan='scan_material';	
}


$num_results_score = $result_score->num_rows;
if($num_results_score!=0)
{
	
	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
	   $row_score = mysqli_fetch_assoc($result_score);
		$allowedExts = array("pdf", "doc", "docx","jpg","jpeg"); 
		if(($row_score["type"]=='jpg')or($row_score["type"]=='jpeg'))
		{
		
		$echo.='<li sops="'.$row_score["id"].'"><a target="_blank" href="invoices/'.$url_scan.'/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div style=" background-image: url(invoices/'.$url_scan.'/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].')"></div></a></li>';
		} else
		{
			
			$echo.='<li sops="'.$row_score["id"].'"><a target="_blank" href="invoices/'.$url_scan.'/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div class="doc_pdf1">'.$row_score["type"].'</div></a></li>';		
			
		}
	}
			
}




end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"id" => $id,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>