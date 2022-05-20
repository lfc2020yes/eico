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
$number=htmlspecialchars($_POST['number_r']);
$text=htmlspecialchars($_POST['text']);
$token=htmlspecialchars($_POST['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

/*
$day_nedeli=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_user=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_today=date("Y-m-d");
*/


if(!token_access_new($token,'edit_docs_more_x',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Договора','U'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}

if(((!isset($_POST['id']))or(!is_numeric($_POST['id'])))) {
    $debug=h4a(104,$echo_r,$debug);
    goto end_code;
}


$result_t=mysql_time_query($link,'Select a.* from z_dogovor as a where a.id="'.htmlspecialchars(trim($_POST['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0) {
    $debug=h4a(108,$echo_r,$debug);
    goto end_code;
}else
{
    $row_t = mysqli_fetch_assoc($result_t);
}

if(($row_t["status"]!=1)and($row_t["status"]!=4))
{
    $debug=h4a(145,$echo_r,$debug);
    goto end_code;
}
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


//добавить новых поставщиков если надо
if($_POST["new_contractor_"]==1)
{
   // mysql_time_query($link,'INSERT INTO z_contractor (name,adress,inn) VALUES ("'.htmlspecialchars(trim($_POST['name_contractor'])).'","'.htmlspecialchars(trim($_POST['address_contractor'])).'","'.htmlspecialchars(trim($_POST['inn_contractor'])).'")');

    mysql_time_query($link,'INSERT INTO z_contractor (name,name_small,adress,inn,ogrn,status,dir) VALUES ("'.htmlspecialchars(trim($_POST['name_c'])).'","'.htmlspecialchars(trim($_POST['name_small_c'])).'","'.htmlspecialchars(trim($_POST['address_c'])).'","'.htmlspecialchars(trim($_POST['inn_c'])).'","'.htmlspecialchars(trim($_POST['ogrn_c'])).'","'.htmlspecialchars(trim($_POST['status_c'])).'","'.htmlspecialchars(trim($_POST['dir_c'])).'")');



    $ID_P=mysqli_insert_id($link);
} else
{
    $ID_P=htmlspecialchars(trim($_POST['id_kto']));
}


mysql_time_query($link,'update z_dogovor set number="'.ht($_POST["number_soply1"]).'",date="'.ht(date_ex(1,$_POST["date_soply"])).'",id_object="'.ht(trim(trimc($_POST["forward_id"]))).'",summa="'.ht(trim(trimc($_POST["summa_soply"]))).'",comment="'.ht($_POST["text_comment"]).'",id_contractor="'.$ID_P.'" where id = "'.htmlspecialchars(trim($id)).'"');

$names='Договор №'.ht($_POST["number_soply1"]).' от '.ht($_POST["date_soply"]);

if (!is_object($edo)) {
    include_once $url_system.'ilib/lib_interstroi.php';
    include_once $url_system.'ilib/lib_edo.php';
    $edo = new EDO($link, $id_user, false);
}

$arr_document = $edo->my_documents(3, ht($id), '>=-10', true);

$new_pre = 1;
$task_cloud_block='';

if($_POST["list"]==1) {
    $small_block = 1;
}
//echo '<pre>arr_document:'.print_r($arr_document,true) .'</pre>';

foreach ($arr_document as $key => $value) {
    include $url_system . 'docs/code/block_app.php';
    //echo($task_cloud_block);
}





end_code:


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo,"block"=>$task_cloud_block,"name"=>$names);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>