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
$token=htmlspecialchars($_POST['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

/*
$day_nedeli=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_user=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_today=date("Y-m-d");
*/

if(!token_access_new($token,'sign_acc_order',$id,"rema",120)) {
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


$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_POST['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0) {
    $debug=h4a(108,$echo_r,$debug);
    goto end_code;
}else
{
    $row_t = mysqli_fetch_assoc($result_t);
}

if(($row_t["status"]!=1)and($row_t["status"]!=8))
{
    $debug=h4a(145,$echo_r,$debug);
    goto end_code;
}
if(($row_t["id_user"]!=$id_user))
{
    $debug=h4a(175,$echo_r,$debug);
    goto end_code;
}
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет



//добавить новых поставщиков если надо

include_once $url_system.'ilib/lib_interstroi.php';
include_once $url_system.'ilib/lib_edo.php';


$edo = new EDO($link,$id_user,false);

$restart=false;
if(($row_t["id_edo_run"]!='')and($row_t["id_edo_run"]!=0))
{
    //значит ему возвращали уже и это просто пересоглашение
    $restart=true;
}
//echo($next_edo);


if ($edo->next($id, 1,0,$restart)===false) {
//echo("!");

    $status_ee='ok';
    //id_executor
    mysql_time_query($link,'update z_acc set status="2" where id = "'.htmlspecialchars(trim($_POST['id'])).'"');


    $result_uu = mysql_time_query($link, 'select status from z_acc where id="' . ht($_POST['id']) . '"');
    $num_results_uu = $result_uu->num_rows;

    if ($num_results_uu != 0) {
        $row_uu = mysqli_fetch_assoc($result_uu);

        $color_status=1;
        if(( $row_uu["status"]==2)) {$color_status=2;}
//к оплате
        if ( $row_uu["status"] == 3) {
            $color_status = 3;
        }
//оплачено
        if ( $row_uu["status"] == 4) {
            $color_status = 5;
        }
//отказано
        if (( $row_uu["status"] == 8)or( $row_uu["status"] == 5)) {
            $color_status = 4;
        }


        $result_status = mysql_time_query($link, 'SELECT a.* FROM r_status AS a WHERE a.numer_status="' . $row_uu["status"] . '" and a.id_system=16');
//echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
        if ($result_status->num_rows != 0) {
            $row_status = mysqli_fetch_assoc($result_status);


            $echo = '<div class="js-state-acc-link"><div id_status="' . $row_uu["status"] . '" class="status_admin js-status-preorders s_pr_' . $color_status . ' ' . $js_mod . '">' . $row_status["name_status"] . '</div></div>';

        }
    }




//echo(gettype($edo->arr_task));

    $admin_note=0;
    $admin_users='';
    foreach ($edo->arr_task as $key => $value)
    {
        //оправляем всем уведомления кому нужно рассмотреть этот документ далее


        $user_send_new= array();
        //уведомление
        array_push($user_send_new, $value["id_executor"]);

        $name_c='';
        $result_uu = mysql_time_query($link, 'select * from z_contractor where id="' . ht($row_t['id_contractor']) . '"');
        $num_results_uu = $result_uu->num_rows;

        if ($num_results_uu != 0) {
            $row_uud = mysqli_fetch_assoc($result_uu);
            $name_c='Контрагент - '.$row_uud["name"];
        }

        $text_not='Вам поступила задача <a class="link-history" href="acc/'.$row_t['id'].'/">Счет №'.$row_t['number'].' от '.date_ex(0,$row_t['date']).'</a>. '.$name_c.' '.$value["description"];

        //$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';
        //отправка уведомления
        $user_send_new= array_unique($user_send_new);
        notification_send($text_not,$user_send_new,$id_user,$link);

        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        $admin_note=1;
        $kto1=name_sql_x($value["id_executor"]);
        if($admin_users=='')
        {
            $admin_users=$kto1;
        } else
        {
            $admin_users.=', '.$kto1;
        }
        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        //пишем уведомление админу что новая заявка создана и отправлена на согласование

    }


    if($admin_note!=0)
    {
        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        $user_admin= array();
        array_push($user_admin, 11);

        $kto=name_sql_x($id_user);
        $title='Cчет №'.$row_t['number'].' отправлен на согласование';

        $message=$kto.' отправил - <a class="link-history" href="acc/' . $row_t['id'] . '/">Счет №'.$row_t['number'].' от '.date_ex(0,$row_t['date']).'</a> на согласование. Счет поступил к - '.$admin_users;
        notification_send_admin($title,$message,$user_admin,$id_user,$link);

        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        //пишем уведомление админу что новая заявка создана и отправлена на согласование

    }



    // echo '<pre>arr_task:'.print_r($edo->arr_task,true) .'</pre>';

    if ($edo->error == 1) {
        // в array $edo->arr_task задания на согласование
    } else {

    }
} else {
    // процесс согласования со всеми заданиями выполнен
    // echo '<pre>'.$edo->error_name[$edo->error].' - процесс согласования со всеми заданиями выполнен </pre>';
}





end_code:


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo,"block"=>$task_cloud_block,"name"=>$names);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>