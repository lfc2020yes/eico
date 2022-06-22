<?php
//обновить в поиске в счетах выбор объекта

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$echo_r=1;
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Счета','R'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


			 
$status_ee='ok';

$arr=explode(',',$id);
$su_mass1=implode("','", $arr);



$os4 = array();
$os_id4 = array();

$result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal in(\''.$su_mass1.'\') order by a.id');



$num_results_t = $result_t->num_rows;
if($num_results_t!=0) {
    for ($i = 0; $i < $num_results_t; $i++) {
        $row_t = mysqli_fetch_assoc($result_t);
        if ((array_search($row_t["id"], $hie_object) !== false) or ($sign_admin == 1)) {

            array_push($os4, $row_t['object_name']);
            array_push($os_id4, $row_t['id']);

        }
    }
}



$su_4 = array();
if (isset($_COOKIE["acc_p" . $id_user])) {
    $su_4 = explode(",", $_COOKIE["acc_p" . $id_user]);
} else {
    $su_4 = $os_id4;
}


$select_val_name = '';
for ($i = 0; $i < count($su_4); $i++) {
    if ($select_val_name == '') {
        $select_val_name = $os4[array_search($su_4[$i], $os_id4)];
    } else {
        $select_val_name .= ', ' . $os4[array_search($su_4[$i], $os_id4)];
    }
}

$echo.='<div class="left_drop menu1_prime book_menu_sel js--sort gop_io js-zindex js-object-c' . $class_js_search . '" ><label>Объект</label><div class="select eddd"><a class="slct" list_number="t7" data_src="' . implode(",", $su_4) . '">' . $select_val_name . '</a><ul class="drop-radio js-no-nul-select">';
$zindex--;

for ($i = 0; $i < count($os4); $i++) {
    if ((in_array($os_id4[$i], $su_4)) or ($_COOKIE["acc_p" . $id_user] == '')) {
        $echo.='<li>
				   <div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
				   
				   <a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
    } else {
        $echo.='<li> <div class="choice-radio"><div class="center_vert1"><i></i></div></div><a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
    }

}
$echo.='</ul><input type="hidden" ' . $class_js_readonly . ' name="sort3pr" id="acc_p" value="' . implode(",", $su_4) . '"></div></div>';







end_code:



$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>