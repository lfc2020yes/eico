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

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';


//**************************************************
if ( count($_GET) != 2 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if ((!$role->permission('Склад','A'))and($sign_admin!=1))
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
if ((!isset($_GET["id"]))or($_GET["id"]=='')) 
{
   $debug=h4a(41,$echo_r,$debug);
   goto end_code;	
}


if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(43,$echo_r,$debug);
   goto end_code;	
}


				if((array_search($_GET["id"],$hie_town) !== false)or($sign_admin==1)) 
               {
				   
			   } else
			   {
				      $debug=h4a(4311,$echo_r,$debug);
                      goto end_code;	
			   }



//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';


$result_town=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town="'.htmlspecialchars(trim($_GET['id'])).'" order by a.id');
	
                 $num_results_custom_town = $result_town->num_rows;
                 if($num_results_custom_town!=0)
                 {
							   $echo.='<div class="select_box eddd_box" style="float:none; z-index:122;"><a class="slct_box_form ee_group" data_src="0"><span class="ccol">Квартал</span></a><ul class="drop_box_form">';
		    $echo.='<li class="sel_active"><a href="javascript:void(0);"  rel="0">Любой</a></li>'; 
					for ($i=0; $i<$num_results_custom_town; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_town);
				 
			   if((array_search($row_t["id"],$hie_kvartal) !== false)or($sign_admin==1)) 
               { 

				  $echo.='<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>'; 
			   
			   }
			 } 
		       $echo.='</ul><input name="stock_kvartal_" id="stock_kvartal_" value="0" type="hidden"></div>';   	
					 
		         } else
				 {
					 
$status_ee='no';
				 }

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>