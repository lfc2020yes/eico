<?php
//загрузка скана по выдачи средств исполнителям

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
$dom=0;
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


if ((isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Касса','R'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'select A.*,B.name_user from c_cash as A,r_user as B where A.id_cash=B.id and A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд

             $status_ee='ok';
			   
			   
			$echo.='';   
			
if((($row_t["sign_rco"]!=0)and($row_t["id_cash"]!=$row_t["sign_rco"]))or($row_t["sign_rco"]==0))
{
$echo.='<div style="margin-left: 0px;" data-tooltip="Выписал - '.$row_t["name_user"].'" class="user_soz">'.avatar_img('<img src="img/users/',$row_t["id_cash"],'_100x100.jpg">').'</div>';
}
if($row_t["sign_rco"]!=0)
{
			   $result_txs=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.$row_t["sign_rco"].'"');
	            if($result_txs->num_rows!=0)
	            {   
					
		          $rowxs = mysqli_fetch_assoc($result_txs);	
	if($row_t["id_cash"]==$row_t["sign_rco"])
	{
					
$echo.='<div style="margin-left: 0px;" data-tooltip="Провел - '.$rowxs["name_user"].'" class="user_soz n_yes">'.avatar_img('<img src="img/users/',$row_t["sign_rco"],'_100x100.jpg">').'</div>';
	} else {$echo.='<div  data-tooltip="Провел - '.$rowxs["name_user"].'" class="user_soz n_yes">'.avatar_img('<img src="img/users/',$row_t["sign_rco"],'_100x100.jpg">').'</div>';}
				}
if($row_t["cashless"]==0)
{
$echo.='<div data-tooltip="проведен" class="user_soz naryd_yes"></div>
<div class="status_nana">проведен - <a target="_blank" class="scan_pay"  href="implementer/scan/'.$row_t["file_name"].'">скан</a></div>';
} else
{
$echo.='<div data-tooltip="проведен по безналичному расчету" class="user_soz naryd_yes"></div>
<div class="status_nana">проведен по безналу</div>';
}
} else
{
	
$echo.='<div id_upload="'.$row_t["id"].'" data-tooltip="загрузить кассовый ордер" class="user_soz naryd_upload"></div>';	
$echo.='<form  class="form_up" id="upload_sc_'.$row_t["id"].'" id_sc="'.$row_t["id"].'" name="upload'.$row_t["id"].'"><input class="sc_sc_loo" type="file" name="myfile'.$row_t["id"].'"></form><div class="loaderr_scan scap_load_'.$row_t["id"].'"><div class="scap_load__" style="width: 0%;"></div></div><div id_bez="'.$row_t["id"].'" data-tooltip="безналичный расчет" class="user_soz beznal_upload"></div>';	
}
			

	$echo2='';		


			   		   $result_t1=mysql_time_query($link,'select A.* from i_implementer as A where A.id="'.htmlspecialchars(trim($row_t['id_implementer'])).'"');
			$row_t1 = mysqli_fetch_assoc($result_t1);
			   
			   
  if($row_t1["summa_made"]>0)
  {
		 $echo2.='<div class="pay_summ4">'.rtrim(rtrim(number_format($row_t1["summa_made"], 2, '.', ' '),'0'),'.').'</div>';	
  }
    if($row_t1["summa_paid"]>0)
  {		
	  $echo2.='<div class="pay_summ3">'.rtrim(rtrim(number_format($row_t1["summa_paid"], 2, '.', ' '),'0'),'.').'</div>';
  }
     if($row_t1["summa_debt"]>0)
  { 
     $echo2.='<div class="pay_summ2">'.rtrim(rtrim(number_format($row_t1["summa_debt"], 2, '.', ' '),'0'),'.').'</div>';
  }					 
				 
			 
		 }
	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 




$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo,"echo2" =>  $echo2);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>