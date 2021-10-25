<?php
//история нарядов по определенной работе

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$echo_r=1;
$debug='';
$count_all_all=0;
$table='';

$id=htmlspecialchars($_GET['id']);


if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

/*
if ((!$role->permission('Себестоимость','U'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}
*/

if(($role->permission('График','U'))or($sign_admin==1))
{
$debug=h4a(103,$echo_r,$debug);
goto end_code;
}


$result_t1=mysql_time_query($link,'select A.*,B.id_object from i_razdel2 as A,i_razdel1 as B where B.id=A.id_razdel1 and A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t1 = $result_t1->num_rows;
if($num_results_t1==0)
{
    $debug=h4a(501,$echo_r,$debug);
    goto end_code;
} else
{
    $row1 = mysqli_fetch_assoc($result_t1);
}

if(($sign_admin!=1)and(array_search($row1['id_object'],$hie_object)===false))
{
    //echo($sign_admin);
    $debug=h4a(591,$echo_r,$debug);
    goto end_code;
    //echo('!');
}



//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';

mysql_time_query($link,'update i_razdel2 set 
                      date0="'.ht($_GET['start']).'",
                      date1="'.ht($_GET['end']).'"
                      
                      where id = "'.htmlspecialchars(trim($id)).'"');





end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>