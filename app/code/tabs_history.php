<?
//

$query_string.='<div class="input-block-2020">';


include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);

$arr_document = $edo->history(ht($_GET["id"]), 0);
//$query_string.='<pre>arr_document:' . print_r($arr_document, true) . '</pre>';
$status_state=0;
foreach ($arr_document as $key => $value) {
    if ((is_array($value["state"])) and (!empty($value["state"]))) {

        foreach ($value["state"] as $keys => $val) {
            $status_state=1;
$name_kto='';
            $result_uu = mysql_time_query($link, 'select name_user from r_user where id="' . ht($val["id_executor"]) . '"');
            $num_results_uu = $result_uu->num_rows;

            if ($num_results_uu != 0) {
                $row_uu = mysqli_fetch_assoc($result_uu);
                $name_kto=$row_uu["name_user"];
            }



            $query_string.='<div class="state-history gray-yy-'.$val["id_status"].'">
               <div class="st-state"><span data-tooltip="'.$val["name_status"].'" class="state-class more-icon-'.$val["id_status"].'"></span></div>
               <div class="st-task"><span class="label-task-gg ">Задача
</span>'.$val["name"];

            //если есть какое то решение отказ замечание передача на кого то
           //→

            if($val["comment_executor"]!='') {
                $query_string .= '<div class="remark-state"><span>'.$val["comment_executor"].'</span></div>';
            }

            $query_string.='</div>
               <div class="st-kto"><span class="label-task-gg ">Исполнитель
</span><span class="send_mess" sm="'.$val["id_executor"].'">'.$name_kto.'</span></div>
               <div class="st-srok"><span class="label-task-gg ">Срок исполнения
</span>';

            $class_ddf1='';
            if($val["id_status"]==0)
            {
                if(dateDiff_2021($val["date_ready"],date('Y-m-d H:i:s'))<0)
                {
                    $class_ddf1='reddecision1';
                }
            }


            if(date_ex_time(0,$val["date_ready"])!='')
            {
                $query_string.='<span class="'.$class_ddf1.'">'.date_ex_time(0,$val["date_ready"]).'</span>';
            } else
            {
                $query_string.='—';
            }



            $query_string.='</div>
               <div class="st-date"><span class="label-task-gg ">Дата исполнения
</span>';

            $date_ex=date_ex_time(0,$val["date_execute"]);

            $class_ddf='';
            if((dateDiff_2021($val["date_execute"],$val["date_ready"])<0)and($val["id_status"]!=0))
            {
                $class_ddf='reddecision1';
            }


            if($date_ex!='')
            {
                $query_string.='<span class="'.$class_ddf.'">'.$date_ex.'</span>';
            }else
            {
                $query_string.='<span class="'.$class_ddf.'">—</span>';
            }



            $query_string.='</div>
            </div>';

        }
    }
}
if($status_state==0)
{
    $query_string.='<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Истории пока нет.</span></span></div>';
}


$query_string.='</div>';
