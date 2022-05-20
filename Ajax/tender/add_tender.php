<?php
//добавление нового счета

/*
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".post_p").val();
	} else
	{
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val();	
*/

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
$token=htmlspecialchars($_GET['tk']);

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=1; //выводить или нет ошибку 0 -нет
$debug='';
if(!token_access_new($token,'add_tenders',$id,"rema",2880))
{
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}

//**************************************************
/*
if (( count($_GET) != 10 )&&( count($_GET) != 12 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
*/
//**************************************************
 if ((!$role->permission('Тендеры','A'))and($sign_admin!=1))
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
//**************************************************
if((htmlspecialchars(trim($_GET['name']))=='')or(htmlspecialchars(trim($_GET['link']))==''))
{
  $debug=h4a(35,$echo_r,$debug);
  goto end_code;	
}
//**************************************************



$result_t=mysql_time_query($link,'Select a.* from z_tender_place as a where a.id="'.htmlspecialchars(trim($_GET['place'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}

//$dates=ht($_GET["date1"]);
//**************************************************
//**************************************************
//проверка что количество не больше нужного


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

	//echo($_GET['name_c']);
//добавить новых поставщиков если надо


//$DATER2 = explode('.', trim(htmlspecialchars($_GET['date2'])));
		
	/*
mysql_time_query($link,'INSERT INTO z_acc (number,date,date_create,id_contractor,summa,date_delivery,delivery_day,id_user,status,comment) VALUES ("'.htmlspecialchars(trim($_GET['number'])).'","'.$DATER1[2].'-'.$DATER1[1].'-'.$DATER1[0].'","'.date("y-m-d").' '.date("H:i:s").'","'.$ID_P.'","'.$summaa.'","","'.htmlspecialchars(trim($_GET['date2'])).'","'.$id_user.'","1","'.htmlspecialchars(trim($_GET['com'])).'")');
*/

mysql_time_query($link,'INSERT INTO z_tender (
name,
id_object,
date,
id_z_tender_place,
summa,
id_user,
status,
comment,
link) VALUES (
"'.htmlspecialchars(trim($_GET['name'])).'",
"'.htmlspecialchars(trim($_GET['object'])).'"
,"'.date("y-m-d").' '.date("H:i:s").'",

"'.htmlspecialchars(trim($_GET['place'])).'",
"'.htmlspecialchars(trim(trimc($_GET['summa']))).'","'.$id_user.'","1","'.htmlspecialchars(trim($_GET['com'])).'","'.htmlspecialchars(trim($_GET['link'])).'")');

	$ID_D=mysqli_insert_id($link);






end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"ty" => $ID_D,"basket"=>$basket,"summa"=>$summaa,"dates"=>$dates);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>