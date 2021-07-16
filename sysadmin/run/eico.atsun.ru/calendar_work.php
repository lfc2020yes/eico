<?php
include_once '../ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/task_time.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $date1 =  (isset($_POST["date1"]))?$_POST["date1"]:date("Y-m-d");
    $date2 =  (isset($_POST["date2"]))?$_POST["date2"]:date("Y-m-d", strtotime($date1 . '+ 1 month'));

    if ($ROW_role!=0) {
        $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
        $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
    }
    else { $styleH=''; $styleF=''; }

    $ret = 0;
    $mysqli = new_connect($ret);
    echo "<p/> result_connect mysqli=" . $mysqli->connect_errno;

    if ($_POST["edo"]>0) {


        if (!$mysqli->connect_errno) {
            echo "<p>step one";
//-----------------------------------------------------------------------------
            // $date1 -> $date2
            $date_tek = $date1;
            do {

                $day = date("w", mktime(0, 0, 0,
                    date("m", strtotime($date_tek)),
                    date("d", strtotime($date_tek)),
                    date("Y", strtotime($date_tek))));
                echo "<pre> $date1 -> $date_tek day=$day</pre>";
                iDelUpd($mysqli,"delete from `ccm_working_calendar` where `data` = '$date_tek' ",false);
                $sql = "
INSERT INTO `ccm_working_calendar` 
(
  
  `data`,
  `isworkday`,
  `time_start`,
  `time_end`,
  `dinner`,
  `time_start_dinner`,
  `time_end_dinner`
)(
SELECT
  
  '$date_tek',
  `isworday`,
  `time_start`,
  `time_end`,
  `dinner`,
  `time_start_dinner`,
  `time_end_dinner`
FROM `ccm_working_hours_mask` WHERE `day` = $day
)
                            ";
                //echo "<pre> $sql</pre>";
                if (($new_id = iInsert_1R($mysqli, $sql, $show = false)) == 0) {
                    break;
                }
                $date_tek = date("Y-m-d", strtotime($date_tek . '+ 1 days'));

            } while ($date_tek < $date2);
            //$timeReady = \CCM\TimeReady\srok_vip(date('Y.m.d H:i:s', time()),$row[timing]*60,$this->mysqli);


        }
        $mysqli->close();
    }
//==========================================================
  /*  $day_tek = date("w", mktime(0, 0, 0,
        date("m", strtotime($date_tek)),
        date("d", strtotime($date_tek)),
        date("Y", strtotime($date_tek))));*/
    $day_tek = date('d.m.Y H:i:s', time());
    $timeReady = \CCM\TimeReady\srok_vip($day_tek,5*60,$mysqli);
    echo "<pre>тест:: $day_tek - > $timeReady</pre>";

    ?>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>

        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Производственный календарь</div></caption>

            <tr><td style="padding-right: 10px">дата начала (YYYY-mm-dd):<td>
                    <input class="text"  name="date1" size="10" value="<?=$date1?>" />

            <tr><td style="padding-right: 10px">дата конца (YYYY-mm-dd):<td>
                    <input class="text"  name="date2" size="10" value="<?=$date2?>" />


                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>
    </form>
    </html>
    <?php
}
?>


