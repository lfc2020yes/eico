<?
//вывод обращений в разделе все обращения
$task_cloud_block='';
$new_sayx='';
$no_click_vis = '';
if((isset($new_sa))and($new_sa==1))
{
	$new_sayx='new-say';
} 
	/*
	10 -100
	n  - x
	*/
	$const_day=10; //считаем что 10 дней это 100 процентов просрочка
	$PROC=0;
	//$zad=dateDiff_1(date("y-m-d").' '.date("H:i:s"),$row_list["ring_datetime"]);
	/*
$pros=0;
	if(($zad>0)and($row_list["status"]==0))
			   {
		$PROC=round($zad*100/$const_day);
		if($PROC>100)
		{
			$PROC=100;
		}
		$pros=1;
	}
*/
	
	/*
	  $rrdx=explode(' ',$row_list["ring_datetime"]);
	  $rrd1x=explode(':',$rrdx[1]);
	*/
	
	$comment_b='';
	$svyz='—';
$time_z='—';
	
	
	
	
	
	
if(isset($new_pre))
{
	
$task_cloud_block.='<div class="preorders_block_global new-worder-block-2021 '.$new_sayx.'" id_pre="'.$value["id"].'"><span class="js-update-block-preorders">';
}

$task_cloud_block.='<div class="trips-b-number"><div style="width: 100%;">'.$value["id"];

//выводим кнопку печать наряд если он проведен
/*
if((($value["status"]==20)or($value["status"]==21))and(($role->permission('Печать наряда','R'))or($sign_admin==1)))
{
*/
/*
$task_cloud_block.='<a target="_blank" href="worder/print/'.$value["id"].'/" data-tooltip="Печатать наряд" class="my-print-new-2021"></a>';
*/
//}

//if((($value["status"]==20)or($value["status"]==21))and(($role->permission('Печать наряда','R'))or($sign_admin==1))) {
    $task_cloud_block .= '<div class="menu_jjs basket-items more-active-s" style=""><div class="more_print menu_click"></div><div class="menu_supply menu_su1"><ul class="drops no_active active_menu_s drops_print" data_src="0">

<li class="no-more-number js-menu-jjs-print"><a target="_blank" href="worder/print/' . $value["id"] . '/">Форма наряда</a></li>
<li class="no-more-number js-menu-jjs-print"><a target="_blank" href="worder/print/' . $value["id"] . '/list/" >Лист согласования</a></li>
<li class="no-more-number js-menu-jjs-print"><a target="_blank" href="worder/print/' . $value["id"] . '/m29/">Форма м29</a></li>

</ul></div></div>';
//}













$task_cloud_block.='</div>';



//$task_cloud_block.='<div class="yes-note zame_kk js-zame-tours" data-tooltip = "Написать заметку о туре" ></div >';

$task_cloud_block.='</div>
	<div class="trips-b-info"><span class="label-task-gg ">Название 
</span>';

if($small_block==1) {
    $task_cloud_block .= '<a style="display:block;" href="worder/'.$value["id"].'/"><span class="spans ggh-e name-blue"><span>Наряд №' . $value["numer_doc"] . ' ('.date_ex(0,$value["date_doc"]).')</span></span></a>';
} else {
    $task_cloud_block .= '<div><span class="spans ggh-e name-blue">Наряд №' . $value["numer_doc"] . ' ('.date_ex(0,$value["date_doc"]).')</span></div>';
}
/*
    //выводим последний комментарий если тур просматривает хозяин тура или хозяин этого комментария
    $result_uui = mysql_time_query($link, 'select comment from preorders_status_history_new where id_preorder="' . ht($row_list["id"]) . '" and action_history="1" and id_user="'.$id_user.'" order by datetimes desc limit 1');
    $num_results_uui = $result_uui->num_rows;

    if ($num_results_uui != 0) {
        $row_uui = mysqli_fetch_assoc($result_uui);
        $task_cloud_block.='<div class="commun">'.$row_uui["comment"].'</div>';
    }
*/
//статус обращения
$js_mod='';
//статус обращения

    $color_status=1;
    if(($value["status"]==9)or($value["status"]==3)or($value["status"]==4)) {$color_status=2;}
    if($value["status"]==5) {$color_status=3;}
    if($value["status"]==8) {$color_status=4;}
if($value["status"]==21) {$color_status=5;}
//выводим статус заявки
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$value["status"].'" and a.id_system=22');
//echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0) {
    $row_status = mysqli_fetch_assoc($result_status);
}


    $task_cloud_block.='<div id_status="'.$value["status"].'" class="status_admin js-status-preorders s_pr_'.$color_status.' '.$js_mod.'">'.$row_status["name_status"].'</div>';





$result_uu=mysql_time_query($link,'select name_user from r_user where id="'.ht($value['id_user']).'"');
$num_results_uu = $result_uu->num_rows;

if($num_results_uu!=0)
{
    $row_uu = mysqli_fetch_assoc($result_uu);
    $task_cloud_block.='<div class="pass_wh_trips" style="margin-top: 10px;"><label>Создатель</label><div class="obi">'.$row_uu['name_user'].'</div></div>';
}

if(!empty($value["date_begin"]))
{
    $date_per=date_ex(0,$value["date_begin"]).' - '.date_ex(0,$value["date_end"]);
} else
{
    $date_per='Неизвестно';
}

$task_cloud_block.='<div class="pass_wh_trips" style="margin-top: 10px;"><label>Период работ</label><div class="obi">'.$date_per.'</div></div>';



$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($value["id_object"])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url!=0)
{
    $row_list1 = mysqli_fetch_assoc($result_url);
}

$result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
$num_results_custom_town = $result_town->num_rows;
if($num_results_custom_town!=0)
{
    $row_town = mysqli_fetch_assoc($result_town);
}

$task_cloud_block.='</div><div class="trips-b-user"><span class="label-task-gg ">Исполнитель/Объект
</span>';


$result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$value["id_implementer"].'"');
$num_results_t22 = $result_t22->num_rows;
if($num_results_t22!=0)
{
    $row_t22 = mysqli_fetch_assoc($result_t22);
    // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';

    if (($role->permission('Исполнители','R'))or($sign_admin==1))
    {
        $task_cloud_block.='<a class="new-small-text-worder-link" href="implementer/'.$row__2["id_implementer"].'/">'.$row_t22["implementer"].'</a>';
    } else
    {
        $task_cloud_block.='<span class="new-small-text-worder">'.$row_t22["implementer"].'</span>';
    }


}

$task_cloud_block.='<div class="pass_wh_trips" style="margin-top: 10px;"><span class="kuda-trips">'.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</span></div>';


if(!empty($value["date_create"]))
{
    $rrd=explode(' ',$value["date_create"]);
    $rrd0=explode('-',$rrd[0]);
    $rrd1=explode(':',$rrd[1]);
    $task_cloud_block.='<div class="titi" style="padding-top: 10px;">'.$rrd0[2].'.'.$rrd0[1].'.'.$rrd0[0].' '.$rrd1[0].':'.$rrd1[1].'</div>';
} else
{
    $task_cloud_block.='<div class="titi" style="padding-top: 10px;">Неизвестно</div>';
}


$task_cloud_block.='</div><div class="trips-b-user"><span class="label-task-gg ">Итого работа/материал
</span>';

$kuda_trips='—';
/*
$result_uu = mysql_time_query($link, 'select name from trips_country where id="' . ht($row_list["id_country"]) . '"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $row_uu = mysqli_fetch_assoc($result_uu);
    $kuda_trips=$row_uu["name"];
}
*/

$task_cloud_block.='<span class="s_j pay_summ" style="margin-left: -3px;">'.rtrim(rtrim(number_format($value["summa_work"], 2, '.', ' '),'0'),'.').'<span class="small_ruboi">'.rtrim(rtrim(number_format($value["summa_material"], 2, '.', ' '),'0'),'.').'</span></span>';





$task_cloud_block.='</div><div class="trips-b-comment">';

if($small_block!=1) {

    $task_cloud_block.='<span class="label-task-gg ">Последнее событие/Сканы с подписью технадзора
    </span><div><span class="spans ggh-e">'.$row_list["text"].'</span></div>';

    if (($value["id_user"] != $id_user) or ($value["status"] != 1)) {
//если заявка уже отправлена на согласования файлы просто выводятся списком. никто их исправлять не может
        $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="13" and A.visible=1 and A.id_object="' . ht($value["id"]) . '"');

        $num_results_uu = $result_6->num_rows;

        if ($num_results_uu != 0) {
            while ($row_6 = mysqli_fetch_assoc($result_6)) {

                $task_cloud_block .= '<div class="li-image download-file"><span class="name-img"><a class="bold_file" target="_blank" href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span><span class="size-img">' . $row_6["type"] . ', ' . get_filesize($url_system.'upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '') . '</span></div>';

            }
        }


    }
}
/*
if($small_block==1) {
    if ((!empty($value["name_s"]))and((isset($_GET["tabs"]))and($_GET["tabs"]!=2))) {
        $task_cloud_block .= '<div><a href="worder/' . $value["id"] . '/" class="yes-tender">' . $value["name_s"] . '</a></div>';
    }
}
*/
if($small_block==1) {
    if ((!empty($value["name_s"]))and((isset($_GET["tabs"]))and($_GET["tabs"]==1))) {
        $task_cloud_block .= '<div><a href="worder/' . $value["id"] . '/" class="yes-tender">' . $value["name_s"] . '</a></div>';
    }
    if ((!empty($value["name_s"]))and((isset($_GET["tabs"]))and($_GET["tabs"]==2))) {
        $task_cloud_block .= '<div class="pass_wh_trips" ><label>Задача</label><div class="obi">' . $value["name_s"] . '</div></div>';
    }
}

//определим последнее действие по обращению

$arr_document_end = $edo->my_documents(2, ht($value["id"]), '>=-10', false);
//echo '<pre>arr_document:'.print_r($arr_document_end, true) . '</pre>';

$id_end_step='';
foreach ($arr_document_end as $key1 => $value1)
{
    if((is_array($value1["state"]))and(!empty($value1["state"]))) {

        foreach ($value1["state"] as $keys1 => $val1) {
//echo($val["id_run_item"]);

            //выбираем последний выполненное действие
            if ($val1["id_status"] != 0) {
                $id_end_step=$keys1;
              //  echo($val1["id_status"]);
                $end_step_id_user=$val1["id_executor"];
                $end_step_name=$val1["name_user"];
                $end_step_task=$val1["name_status"];

            }
        }}
}
//echo $id_end_step;
if($id_end_step!=='')
{
    $kem='<span class="send_mess" sm="'.$end_step_id_user.'">'.$end_step_name.'</span>';
    $task_cloud_block .= '<div class="strong_wh_2020 st-202020">↓ Последнее событие</div>';

    //$task_cloud_block .= '<div class="oto-z-pr">'.$kem.' ('.time_stamp($row_85["datetimes"]).')</div><div class="oto-z-pr1">'.$end_step_task.'</div>';
    $task_cloud_block .= '<div class="oto-z-pr">'.$kem.' </div><div class="oto-z-pr1">'.$end_step_task.'</div>';
}





/*
$result_85 = mysql_time_query($link,'SELECT A.id,A.action_history,A.id_user, A.datetimes,A.edit,A.comment  FROM preorders_status_history_new AS A WHERE A.id_preorder="'.ht($row_list["id"]).'" and not(A.action_history=4) order by A.id desc,A.datetimes desc limit 1');



$num_85 = $result_85->num_rows;
if($num_85>0) {

    $row_85 = mysqli_fetch_assoc($result_85);
    $kem='';
    $result_work_zz1=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.$row_list5["id_user"].'"');
    $kem='неизвестно';
    $num_results_work_zz1 = $result_work_zz1->num_rows;
    if($num_results_work_zz1!=0)
    {
        $row_work_zz1 = mysqli_fetch_assoc($result_work_zz1);
        $kem=$row_work_zz1["name_user"];
    }
    $task_cloud_block .= '<div class="strong_wh_2020 st-202020">↓ Последнее событие</div>';
    $task_cloud_block .= '<div class="oto-z-pr">'.$kem.' ('.time_stamp($row_85["datetimes"]).')</div><div class="oto-z-pr1">'.$row_85["comment"].'</div>';

}
*/
$task_cloud_block.='</div>';
/*
	$task_cloud_block.='</div><div class="trips-b-user"><span class="label-task-gg ">Комментарий/последнее событие
</span>



</div>';
*/


//$task_cloud_block.='</div>';

if(isset($new_pre)) {

    $task_cloud_block .= '</span>';
}


if($value["status"]!=1)
{


if(((isset($visible_gray))and($visible_gray==1))or($value["id_user"]==$id_user)or((isset($_GET["tabs"]))and($_GET["tabs"]==2))) {
    $tabs_menu_x = array("Процесс/Задача","История");
    $tabs_menu_x_js = array("");
    $tabs_menu_x_id = array("2","3");
} else {

    $tabs_menu_x = array("Задание", "Процесс/Задача","История");
    $tabs_menu_x_js = array("", "");
    $tabs_menu_x_id = array("1", "2","3");
}

$class_menu_pr='';
if ((isset($_GET['menu_id']))and(array_search($_GET['menu_id'], $tabs_menu_x_id) !== false)) {
    $class_menu_pr='active-trips-menu';
}
$task_cloud_block.='<div class="mm_w-preorders form005U '.$class_menu_pr.'">
	   <ul class="tabs_hedi js-tabs-menu">';




    for ($i=0; $i<count($tabs_menu_x); $i++) {
        $pay_string='';

        if ((isset($_GET['menu_id']))and($_GET['menu_id'] == $tabs_menu_x_id[$i])) {
            $task_cloud_block .= '<li class="tabs_009U active ' . $tabs_menu_x_js[$i] . '" id="' . $tabs_menu_x_id[$i] . '">' . $tabs_menu_x[$i] .$pay_string. '</li>';
        } else {
            $task_cloud_block .= '<li class="tabs_009U ' . $tabs_menu_x_js[$i] . '" id="' . $tabs_menu_x_id[$i] . '">' . $tabs_menu_x[$i] .$pay_string. ' </li>';
        }

    }
/*
if (($role->permission('Заявки','U'))or($sign_admin==1)) {

    if(($value["id_user"]==$id_user)or($sign_admin==1)) {
if(($value["status"]!=5)and($value["status"]!=6)) {
    $task_cloud_block .= '<li class="tabs_005U edit-li-tr" id="0"><a class="js-buy-edit-preorders edit-trips-all" data-tooltip="Изменить" ></a></li>';
}

    }
   }
*/

/*
if (($role->permission('Обращения','D'))or($sign_admin==1)) {

    if(($row_list["id_user"]==$id_user)or($sign_admin==1)) {

        $min=dateDiff_min(date('Y-m-d H:i:s'), $row_list['date_create']);

        if(($min<60)and(($row_list['id_user']==$id_user)or($sign_admin==1))) {

            $task_cloud_block .= '<li class="tabs_005U annul-li-tr" id="0"><a  class="edit-preorders-all1 js-buy-del-pre" data-tooltip="Удалить" ></a></li>';

        }
    }


}
*/




	  $task_cloud_block.='</ul>
   </div>';

$task_cloud_block.='<div class="px_bg_trips">
</div>';
}
if(isset($new_pre)) {

    $task_cloud_block .= '</div>';
}

$block_preorders=$task_cloud_block;

if((isset($_GET["menu_id"]))and($_GET["menu_id"]!=0)) {
    //открыта какая то вкладка в туре и необходимо обновление информации по этой вкладке
    $id_tabs=$_GET["menu_id"];
    $token_inlude='taabbssd32.dfDD';
    $task_cloud_block='';
// информация
    if($id_tabs==1)
    {
       // include $url_system.'preorders/code/tabs_task.php';
    }
// документы
    if($id_tabs==2)
    {
        //include $url_system.'preorders/code/tabs_file.php';
    }
// журнал операций
    if(($id_tabs==3))
    {
       // include $url_system.'preorders/code/tabs_operation.php';
    }

    $echo_more=$query_string;
}


?>