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

//$query=htmlspecialchars($_GET['query']);
$query=mb_convert_case(htmlspecialchars($_GET['query']), MB_CASE_LOWER, "UTF-8");

$active=htmlspecialchars($_GET['active']);
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
 if ((!$role->permission('Снабжение','U'))and($sign_admin!=1))
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
if ((!isset($_GET["query"]))or(trim($_GET["query"])=='')) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
//**************************************************
/*
if(($row_t["id_user"]!=$id_user)and($sign_admin!=1))
{ 
	    $debug=h4a(7,$echo_r,$debug);
		goto end_code;	
}
*/
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';


$result_score=mysql_time_query($link,
							  
'select * from( 
(  
SELECT A.name,A.id FROM z_contractor A WHERE LOWER(A.name) LIKE "'.$query.'%"
ORDER BY A.name 

)
UNION
(

SELECT A.name,A.id FROM z_contractor A WHERE LOWER(A.name) LIKE "%'.$query.'%" 
AND A.name NOT IN 
(SELECT A.name FROM z_contractor A WHERE A.name LIKE "'.$query.'%")
ORDER BY A.name

)							  
							  
) Z order by Z.name limit 0,20');
	



/*		 
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>			 
				*/	
			   //score_pay score_app score_active
				 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
	$status_ee='yes';
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   if($row_score["id"]==$active)
			   {
				   $echo.='<li class="sel_active"><a href="javascript:void(0);" rel="'.$row_score["id"].'">'.search_text_strong(0,$query,$row_score["name"]).'</a></li>';
			   } else
			   {
				  $echo.='<li><a href="javascript:void(0);" rel="'.$row_score["id"].'">'.search_text_strong(0,$query,$row_score["name"]).'</a></li>'; 
			   }
		   }
		}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>