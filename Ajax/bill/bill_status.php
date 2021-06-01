<?php
//обновление статуса по счету и кнопок действия

/*
		 var data ='url='+window.location.href+'&id='+id;		
*/

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$echo1='';

$vid=0;
$debug='';
$count_all_all=0;
$basket='';

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if (( count($_GET) != 2 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Счета','S'))and($sign_admin!=1))
{
  $debug=h4a(2,$echo_r,$debug);
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
if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
//**************************************************


$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
} else
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}
//**************************************************


$status_ee='ok';

//кнопки
if($row_t["status"]==2)
	{
	$echo.='<div  data-tooltip="Не оплачивать" rel_bill="'.$row_t["id"].'" class="user_mat xvg_no"></div>';		
	$echo.='<div  data-tooltip="К оплате" rel_bill="'.$row_t["id"].'" class="user_mat xvg_yes"></div>';	
	}
	if(($row_t["status"]==3)or($row_t["status"]==20))
	{	
	   $echo.='<div style="float:right; width:20px;">';
		$echo.='<div class="more_supply1 menu_click"></div>';	
		
		
	   $echo.='<div class="menu_supply menu_su1"><ul style="right: 10px; top: 0px;" class="drops no_active" data_src="0"><li><a href="javascript:void(0);" rel="1">Изменить</a></li><li><a href="javascript:void(0);" rel="2">Отменить оплату</a></li></ul><input rel="x" name="vall_bill" class="option_mat1" value="0" type="hidden"></div>';
		
	   $echo.='</div>';	
	}

//статус
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_t["status"].'" and a.id_system=16');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
$echo1.='<div rel_status="'.$row_t["id"].'" class="st_bb menu_click status_materialz status_z'.$row_t["status"].' ">'.$row_status["name_status"];

if(($row_t["path_summa"]!='')and($row_t["path_summa"]!=0))
{
	$echo1.='<br>Частично - '.rtrim(rtrim(number_format($row_t["path_summa"], 2, '.', ' '),'0'),'.');
}
if(($row_t["date_buy"]!='')and($row_t["date_buy"]!=0))
{
			$date_graf3  = explode("-",$row_t["date_buy"]);
			$ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
	$echo1.='<br>Оплата после - '.$ddd;
}	
	
$echo1.='</div>';			
}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo"   => $echo1,"button"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>