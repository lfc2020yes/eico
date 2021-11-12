<?php
//редактировать раздел в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$echo_r=1;
$debug='';
$count_all_all=0;
$names='';

$id=htmlspecialchars($_POST['id']);
$summa_waves=htmlspecialchars($_POST['summa_waves']);
$token=htmlspecialchars($_POST['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

/*
$day_nedeli=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_user=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_today=date("Y-m-d");
*/


if(!token_access_new($token,'waves_soply',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}

if(((!isset($_POST['id']))or(!is_numeric($_POST['id'])))) {
    $debug=h4a(104,$echo_r,$debug);
    goto end_code;
}

if(((!isset($_POST['summa_waves']))or(!is_numeric($_POST['summa_waves'])))) {
    $debug=h4a(1043,$echo_r,$debug);
    goto end_code;
}

$result_t=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id="'.htmlspecialchars(trim($_POST['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0) {
    $debug=h4a(108,$echo_r,$debug);
    goto end_code;
}else
{
    $row_t = mysqli_fetch_assoc($result_t);
}


$result_uu45 = mysql_time_query($link, 'SELECT DISTINCT 
b.id_stock

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
b.id="'.ht($_POST['id']).'"
AND c.id=b.id_i_material
AND a.id=b.id_doc
AND a.id_edo_run = edo.id_run
AND edo.id_status = 0
AND edo.id_executor IN ('.ht($id_user).')

AND b.status NOT IN ("1","8","10","3","5","4") 	 ');
$num_results_uu45 = $result_uu45->num_rows;

if ($num_results_uu45 == 0) {
    goto end_code;
}


if($summa_waves>$row_t["count_units"])
{
    goto end_code;
}
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


//добавить новых поставщиков если надо


mysql_time_query($link,'update z_doc_material set count_units="'.ht($_POST["summa_waves"]).'" where id = "'.htmlspecialchars(trim($id)).'"');



end_code:


$aRes = array("debug"=>$debug,"status"   => $status_ee,"summa" =>  $_POST["summa_waves"],"id"=>$id);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>