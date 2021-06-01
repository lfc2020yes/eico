<?php

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/config.php';

function ht($varr)
{
    return(htmlspecialchars(trim($varr)));
}

//убрать первый 0 для часов
//02 - 2
//12 - 12
function date_minus_null_x($time)
{
    if($time[0]==0)
    {
        return   $time[1];
    } else
    {
        return   $time;
    }
}

//получение даты с шагом от какой то даты
//только в формате Y-m-d
//date_step_sql_more('2020-07-01','+1m')
function date_step_sql_more_x($date,$step)
{
    $char='-';
    $maski1 = explode('-', $date);
    $maski= array('Y','m','d');

    $m=0; $d=0; $y=0;
    $minus_plus=$step[0];
    $na=substr($step, 1);
    $na=substr($na, 0, -1);



    if($step[(strlen($step)-1)]=='Y')
    {
        $y=(int)($minus_plus.$na);
    }
    if($step[(strlen($step)-1)]=='m')
    {
        $m=(int)($minus_plus.$na);
    }
    if($step[(strlen($step)-1)]=='d')
    {
        $d=(int)($minus_plus.$na);
    }
    $date_step='';
    for ($ksss=0; $ksss<count($maski); $ksss++)
    {
        if($ksss==0)
        {
            $date_step=date($maski[$ksss], mktime(date("G"), date("i"), date("s"), ((int)date_minus_null_x($maski1[1])+$m),((int)date_minus_null_x($maski1[2])+$d), ((int)date_minus_null_x($maski1[0])+$y)));
        } else
        {
            $date_step=$date_step.$char.date($maski[$ksss], mktime(date("G"), date("i"), date("s"), ((int)date_minus_null_x($maski1[1])+$m),((int)date_minus_null_x($maski1[2])+$d), ((int)date_minus_null_x($maski1[0])+$y)));
        }
    }

    return  $date_step;
}

//разница минут между двумя отческами времени
function raz_min($dt1, $dt2, $timeZone = 'GMT') {
    $tZone = new DateTimeZone($timeZone);
    $dt1 = new DateTime($dt1, $tZone);
    $dt2 = new DateTime($dt2, $tZone);
    $ts1 = $dt1->format('H:i:s');
    $ts2 = $dt2->format('H:i:s');
    $diff = strtotime($ts1)-strtotime($ts2);
    $diff/= 60;
    return floor($diff);
}

function time_unix($dt1,$timeZone = 'GMT')
{
  //преобразование времени в метку времени Unix для сравнения
    $tZone = new DateTimeZone($timeZone);
    $dt1 = new DateTime($dt1, $tZone);
    $ts1 = $dt1->format('H:i:s');
    return $ts1;
}

//перевод даты из формата 15.07.2020 в формат 2020-07-15 (sql)  -> ex=1
//перевод даты из формата 2020-07-15 (sql) в формат 15.07.2020  -> ex=0

function date_ex($ex,$date)
{
    if(($date!='')and($date!='00.00.0000')and($date!='0000-00-00'))
    {
        if($ex==1) {
            $date_ex = explode(".", htmlspecialchars(trim($date)));
            $date_start = $date_ex[2] . '-' . $date_ex[1] . '-' . $date_ex[0];
        } else
        {
            $date_ex = explode("-", htmlspecialchars(trim($date)));
            $date_start = $date_ex[2] . '.' . $date_ex[1] . '.' . $date_ex[0];
        }
    }
    return  $date_start;
}

//прибавить к времени время
function plus_minutes($time,$minutes)
{
    $oldTime = strtotime($time);
    $newTime = date("H:i:s", strtotime('+'.$minutes.' minutes', $oldTime));
    return $newTime;
}

/*
$data_start - дата начала задачи когда поступила
$minutes - сколько минут дается на выполнения задачи
*/

//-> крайний срок выполнения в дате
//srok_vip('21.05.2021 17:11:00', 60)
function srok_vip($data_start,$minutes)
{
    global $link;
    $date_exp = explode(" ", $data_start);
    $minutes_work = 0;  //сколько времени потратил на выполнения
    $new_day = 0;  //искать дату выполнения в следующих днях

$return_date=date_ex(1, $date_exp[0]);
$return_time='';

    $result_uuy = mysql_time_query($link, 'select A.* from ccm_working_calendar as A where A.time_end>"' . ht($date_exp[1]) . '" and A.data="' . date_ex(1, $date_exp[0]) . '" 
    and A.isworkday=1');
    $num_results_uuy = $result_uuy->num_rows;
    if ($num_results_uuy != 0) {
        $row_8 = mysqli_fetch_assoc($result_uuy);
        //значит сегодня еще есть времЯ для выполнения данного задания
        //вопрос успеет ли
        if ($row_8["dinner"] == 1) {
            //есть обед
            if ((time_unix($date_exp[1]) > time_unix($row_8["time_start"])) and (time_unix($date_exp[1]) < time_unix($row_8["time_end"]))) {
                //поступила в рабочее время

                if (time_unix($date_exp[1]) >= time_unix($row_8["time_end_dinner"])) {
                    //поступила после обеда
                    if (raz_min($row_8["time_end"], $date_exp[1]) >= $minutes) {
                        //успеет сделать до конца рабочего времени
                        $return_time=plus_minutes($date_exp[1], $minutes);
                    } else {
                        //не успевает сделать сегодня записываем сколько времени на сегодня потратил
                        $new_day = 1;
                        $minutes_work = raz_min($row_8["time_end"], $date_exp[1]);
                    }
                } else {
                    if ((time_unix($date_exp[1]) >= time_unix($row_8["time_start_dinner"])) and (time_unix($date_exp[1]) < time_unix($row_8["time_end_dinner"]))) {
//поступила во время обеда
                        //отталкиваемся от начала работы после обеда
                        if (raz_min($row_8["time_end"], $row_8["time_end_dinner"]) >= $minutes) {
                            //успеет сделать до конца рабочего времени
                            $return_time=plus_minutes($row_8["time_end_dinner"], $minutes);
                        } else {
                            //не успевает сделать сегодня записываем сколько времени на сегодня потратил
                            $new_day = 1;
                            $minutes_work = raz_min($row_8["time_end"], $row_8["time_end_dinner"]);
                        }
                    } else {
                        //поступила до обеда
                        //успеет ли вообще сделать за сегодня с учетом обеда
                        $minute_work_day = raz_min($row_8["time_end"], $row_8["time_start"]);
                        $minute_dinner_day = raz_min($row_8["time_end_dinner"], $row_8["time_start_dinner"]);
                        $minute_work_all_day = $minute_work_day - $minute_dinner_day;
                        if ($minute_work_all_day >= $minutes) {
                            //успевает сделать сегодня после обеда
                            $do_obeda_work = raz_min($row_8["time_start_dinner"], $row_8["time_start"]);
                            $ost_posle_obeda = $minutes - $do_obeda_work;

                            $return_time=plus_minutes($row_8["time_end_dinner"], $ost_posle_obeda);

                        } else {
                            //сегодня не успевает сделать
                            $new_day = 1;
                            $minutes_work = $minute_work_all_day;
                        }

                    }
                }

            } else {
                //поступила не в рабочее время
                //вопрос до или после него
                if ((time_unix($date_exp[1]) > time_unix($row_8["time_end"]))) {
                    //после окончания рабочего дня
                    $new_day = 1;
                    $minutes_work = 0; //потратил на работу 0 минут пока
                } else {

                    if (raz_min($row_8["time_end_dinner"], $row_8["time_start"]) <= $minutes) {
                        //успевает сделать до обеда
                        $return_time=plus_minutes($row_8["time_start"], $minutes);
                    } else {
                        //не успевает сделать до обеда
                        //успеет ли вообще сделать за сегодня с учетом обеда
                        $minute_work_day = raz_min($row_8["time_end"], $row_8["time_start"]);
                        $minute_dinner_day = raz_min($row_8["time_end_dinner"], $row_8["time_start_dinner"]);
                        $minute_work_all_day = $minute_work_day - $minute_dinner_day;
                        if ($minute_work_all_day >= $minutes) {
                            //успевает сделать сегодня после обеда
                            $do_obeda_work = raz_min($row_8["time_start_dinner"], $row_8["time_start"]);
                            $ost_posle_obeda = $minutes - $do_obeda_work;
                            $return_time=plus_minutes($row_8["time_end_dinner"], $ost_posle_obeda);
                        } else {
                            //сегодня не успевает сделать
                            $new_day = 1;
                            $minutes_work = $minute_work_all_day;
                        }
                    }
                }
            }
        } else {
            //нет обеда
            if ((time_unix($date_exp[1]) > time_unix($row_8["time_start"])) and (time_unix($date_exp[1]) < time_unix($row_8["time_end"]))) {
                //поступила в рабочее время
                if (raz_min($row_8["time_end"], $date_exp[1]) >= $minutes) {
                    //успеет сделать до конца рабочего времени
                    $return_time=plus_minutes($date_exp[1], $minutes);
                } else {
                    //не успевает сделать сегодня записываем сколько времени на сегодня потратил
                    $new_day = 1;
                    $minutes_work = raz_min($row_8["time_end"], $date_exp[1]);
                }
            } else {
                //поступила не в рабочее время
                //вопрос до или после него
                if ((time_unix($date_exp[1]) > time_unix($row_8["time_end"]))) {
                    //после окончания рабочего дня
                    $new_day = 1;
                    $minutes_work = 0; //потратил на работу 0 минут пока
                } else {
                    //до начала рабочего дня поступила
                    //вопрос успеет ли за сегодня
                    if (raz_min($row_8["time_end"], $row_8["time_start"]) >= $minutes) {
                        //успеет сделать до конца рабочего времени
                        $return_time=plus_minutes($row_8["time_start"], $minutes);
                    } else {
                        //не успевает сделать сегодня записываем сколько времени на сегодня потратил
                        $new_day = 1;
                        $minutes_work = raz_min($row_8["time_end"], $date_exp[1]);
                    }
                }
            }
        }
    } else
    {
        $new_day=1;
    }
    if($new_day==1)
    {
        //ищем конец задачи на следующий день
        $date_exp[0]=date_ex(1,$date_exp[0]);
        do {
            $ost_minute_task=$minutes-$minutes_work;  //сколько у него осталось времени для выполнения этой задачи
            //определяем следующий день
            $date_exp[0]=date_step_sql_more_x($date_exp[0],'+1d');
            $return_date=$date_exp[0];
            $result_uuy = mysql_time_query($link, 'select A.* from ccm_working_calendar as A where A.data="'.ht($date_exp[0]).'"');
            $num_results_uuy = $result_uuy->num_rows;
            //echo('select A.* from ccm_working_calendar as A where A.data="'.ht($date_exp[0]).'"');
            if ($num_results_uuy != 0) {

                $row_8 = mysqli_fetch_assoc($result_uuy);
                if($row_8["isworkday"]==1)
                {
                //в этот день работает и посмотрим может ли он закончить свою задачу в это рабочее время этого дня
                if ($row_8["dinner"] == 1) {
                    //с обедом день
                    $minute_work_day = raz_min($row_8["time_end"], $row_8["time_start"]);
                    $minute_dinner_day = raz_min($row_8["time_end_dinner"], $row_8["time_start_dinner"]);
                    $minute_work_all_day = $minute_work_day - $minute_dinner_day;
                    if ($minute_work_all_day >= $ost_minute_task) {
                        //успевает сделать в этот день
                        $do_obeda_work = raz_min($row_8["time_start_dinner"], $row_8["time_start"]);

                        if ($do_obeda_work >= $ost_minute_task) {
                            //закончит до обеда
                            $return_time = plus_minutes($row_8["time_start"], $ost_minute_task);
                            $new_day = 0;
                        } else {
                            //закончит после обеда
                            $ost_posle_obeda = $ost_minute_task - $do_obeda_work;
                            $return_time = plus_minutes($row_8["time_end_dinner"], $ost_posle_obeda);
                            $new_day = 0;
                        }
                    } else {
                        //сегодня не успевает сделать
                        $minutes_work = $minutes_work + $minute_work_all_day;
                    }
                } else {
                    //без обеда день
                    if (raz_min($row_8["time_end"], $row_8["time_start"]) >= $ost_minute_task) {
                        //успеет сделать до конца рабочего времени
                        $return_time = plus_minutes($row_8["time_start"], $ost_minute_task);
                        $new_day = 0;
                    } else {
                        //не успевает сделать сегодня записываем сколько времени на сегодня потратил
                        $minutes_work = $minutes_work + raz_min($row_8["time_end"], $row_8["time_start"]);

                    }
                }
            }
            } else {  return false; }
        } while($new_day==1);
    }
return ($return_date.' '.$return_time);
}

echo(srok_vip('21.05.2021 14:11:00', 520));

?>