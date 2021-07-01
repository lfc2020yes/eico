<?php
//получить данные по вкладке обращения
$name_form='003U';
$key_form='bt_task_info';

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
$disco=0;
$id=htmlspecialchars($_GET['id']);
$id_tabs=htmlspecialchars($_GET['id_tabs']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************

//**************************************************
if ((!$role->permission('Заявки','R'))and($sign_admin!=1))
{
    $debug=h4a(12,$echo_r,$debug);
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


if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{
    goto end_code;
}

$id_user=id_key_crypt_encrypt($_SESSION["user_id"]);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 3))
{
    goto end_code;
}




$result_t=mysql_time_query($link,'Select A.* from z_doc as A where A.id="'.ht($id).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{
    $debug=h4a(5,$echo_r,$debug);
    goto end_code;
} else
{
    $row_8 = mysqli_fetch_assoc($result_t);
    //$mas_responsible=explode(",",$row_8["id_user_responsible"]);
}




//может ли он смотреть эту задачу
//он ее поставил
//он в исполнителях
//он является командует тем кто есть в создателях или исполнителях



//**************************************************
//**************************************************
//**************************************************
//**************************************************
/*
0 - о задаче
1 - Журнал событий
*/

$status_ee='ok';

$token_inlude="taabbssd32.dfDD";


// информация
if($id_tabs==1)
{
    include $url_system.'app/code/tabs_info.php';
}

// процесс/задача
if($id_tabs==2)
{
    include $url_system.'app/code/tabs_task.php';
}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"query" => $query_string,"echo"=>$echo);
/*require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);
*/
echo json_encode($aRes);
?>