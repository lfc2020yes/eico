<?php
//получение в меню сверху в разделе себестоимость квартала и домов после выбора города
//если в этом городе один квартал то выводить сразу и дома


function reset_url($url) {
    $value = str_replace ( "http://", "", $url );
    $value = str_replace ( "https://", "", $value );
    $value = str_replace ( "www.", "", $value );
    $value = explode ( "/", $value );
    $value = reset ( $value );
    return $value;
}

$_SERVER['HTTP_REFERER'] = reset_url ( $_SERVER['HTTP_REFERER'] );
$_SERVER['HTTP_HOST'] = reset_url ( $_SERVER['HTTP_HOST'] );
 
if ($_SERVER['HTTP_HOST'] != $_SERVER['HTTP_REFERER']) {

    // @header ( 'Location: ' . $config['http_home_url'] );
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
    die ();
}
     
     
 
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    /* значит ajax-запрос */
     
    /* обрабатываем */
     
} else {

	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
}

//Проверяем вдруг это взлом. смотрим есть ли такой тип, относятся ли эти условия поиска к этому типу, существует ли сортировка
//если есть n_st смотрим число ли это, append тоже проверяем



define( '_SECRETJ', 7 );
header("Content-type: application/json");
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
//подключение к базе
include_once $url_system.'module/config.php';
//подключение написанных функций для сайта
include_once $url_system.'module/function.php';
include_once $url_system.'login/function_users.php'; 
initiate($link);
$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


/*
$day_nedeli=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_user=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_today=date("Y-m-d");
*/
if(isset($_SESSION['s_t']))
{

//расшифровка токена
//расшифровка токена
			
$token1=explode(".", $token);
//соль для данного действия
$sale='dell_prime';
			
$id_p=$token1[0];
$secr=$_SESSION['s_t'];

$rrr=md5($secr.$id_p.$secr[0].$sale);
if(($rrr==$token1[1])and($id_p==$id))
{
	$token1[2]=decode_x($token1[2],$secr);		
	$strt= substr($token1[2], 1,(strlen($token1[2])-2));
	$posl_chifra_idx=$id_p%10;
	$st_time11 = substr($strt, 0, (strlen($strt)-$posl_chifra_idx));
    $st_time22= substr($strt, (strlen($strt)-$posl_chifra_idx));
			
    $timeform=$st_time22.$st_time11;
	$time_sei=time();
	$razn=60*30; //30 минут
	if((($time_sei-$timeform)<=$razn)and($timeform<$time_sei))
	{





  if((isset($_GET['id']))and(is_numeric($_GET['id'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


//mysql_time_query($link,'delete FROM i_razdel1 where id_object="'.htmlspecialchars(trim($id)).'"');
	/*				

$result_t=mysql_time_query($link,'Select a.razdel1,a.name1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);

		   $echo.='Раздел '.$row_t["razdel1"].'. '.$row_t["name1"]; 
	   }
*/

		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 }
}
}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>