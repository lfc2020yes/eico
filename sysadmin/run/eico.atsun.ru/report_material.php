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


    ?>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>

        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Отчет по материалам</div></caption>

            <tr><td style="padding-right: 10px">дата начала (YYYY-mm-dd):<td>
                    <input class="text"  name="date1" size="10" value="<?=$date1?>" />

            <tr><td style="padding-right: 10px">дата конца (YYYY-mm-dd):<td>
                    <input class="text"  name="date2" size="10" value="<?=$date2?>" />


                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>

        <?
        $sql = "
SELECT

O.`id`, O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`
,R1.*
,R2.*

, M.`id` AS id_material, M.`id_razdel2`, M.`material`
, M.`count_units` AS count_units_material
, M.`units` AS units_material
, M.`price` AS price_material
, M.`subtotal` AS subtotal_material
, M.`count_realiz` AS count_realiz_material
, M.`summa_realiz` AS summa_realiz_material


-- ,SUM(R1.summa_r1), SUM(R1.`summa_m1_realiz`), SUM(R1.`summa_m1`), SUM(R1.`summa_r1_realiz`)
FROM

`i_object` AS O,
`i_razdel1` AS R1,
`i_razdel2` AS R2,
`i_material` AS M
WHERE

R1.`id_object` =50           -- по объекту
AND R1.razdel1 in (4,5)      -- по разделам
AND R2.razdel2 in (1,5)      -- по статьям

AND O.`id` = R1.`id_object`
AND R1.`id` = R2.`id_razdel1`
AND R2.`id` = M.`id_razdel2`
-- GROUP BY

-- O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`
        ";
        echo "<table border='1' style='border-collapse: collapse;'>";
        $rep = new Report_smeta($mysqli);
        if ($result = $mysqli->query($sql)) {
            while ($row0 = $result->fetch_assoc()) {

                $rep->r0($row0 );
                $rep->r1($row0 );
                $rep->r2($row0 );
                $rep->material($row0 );
                $rep->doc($row0 );
            }
            $result->close();
        }
        ?>
        </table>
    </form>
    </html>
    <?php
}

class Report_smeta {
    var $id_object;
    var $razdel1;
    var $razdel2;
    var $mysqli;
    public function Report_smeta ($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function r0(&$row) {
        if (! ($this->id_object == $row[id_object])) {
            $this->id_object = $row[id_object];
            echo "<tr><td colspan='6'><b> объект: ".$row[object_name]
                ." </b>работы: ".round($row[total_r0],2)." - ".round($row[total_r0_realiz],2)
                ." материалы: ".round($row[total_m0],2)." - ".round($row[total_m0_realiz],2)
                ;
        }

    }
    public function r1(&$row) {
        if (! ($this->razdel1 == $row[razdel1])) {
            $this->razdel1 = $row[razdel1];
            echo "<tr><td width='20px'><td colspan='5'> раздел ".$this->razdel1.": ".$row[name1]
                ." работы: ".round($row[summa_r1],2)." - ".round($row[summa_r1_realiz],2)
                ." материалы: ".round($row[summa_m1],2)." - ".round($row[summa_m1_realiz],2)
                ;
        }

    }
    public function r2(&$row) {
        if (! ($this->razdel2 == $row[razdel2])) {
            $this->razdel2 = $row[razdel2];
            echo "<tr><td><td  width='20px'><td colspan='4'> cтатья: ".$this->razdel2." ".$row[name_working]
                ." ".round($row[count_units],2).$row[units]." сумма работ: ".round($row[subtotal],2)
                ." - ".round($row[count_r2_realiz],2).$row[units]." сумма работ: ".round($row[summa_r2_realiz],2)

                ." материалы: ".round($row[summa_material],2)." - ".round($row[summa_mat_realiz],2)
                ;
        }

    }
    public function material(&$row) {
            echo "<tr><td><td><td  width='20px'><td colspan='3'>".$row[material]
                ." ".round($row[count_units_material],2).$row[units_material]
                ." [".round($row[price_material],2) ."] "
                ." сумма: ".round($row[subtotal_material],2)
                ." - ".round($row[count_realiz_material],2).$row[units_material]." сумма: ".round($row[summa_realiz_material],2)
                ;

    }
    public function doc(&$row) {
        $sql = "
SELECT 
  M.`id`,
  M.`id_doc`,
  M.`id_i_material`,
  M.`id_stock`,
  M.`id_object`,
  M.`count_units`,
  M.`count_units_act`,
  M.`date_delivery`,
  M.`id_group_material`,
  M.`status`,
  M.`memorandum`,
  M.`id_sign_mem`,
  M.`signedd_mem`,
  S.`name` AS name_stock,
  S.`units` AS units_stock,
  S.`id_stock_group`,
  D.`number`,D.`date`,D.`name`,D.`id_user`,
  U.`name_user`
FROM
  `z_doc_material` M
  LEFT JOIN `z_stock` AS S ON (S.id=M.`id_stock`),
 `z_doc` D,
 `r_user` U
WHERE
  M.`id_i_material`=".$row[id_material]."
  AND M.`id_doc` = D.`id`  
  AND D.`id_user` = U.`id`
        ";
        if ($result = $this->mysqli->query($sql)) {
            while ($rowZ = $result->fetch_assoc()) {

                echo "<tr><td><td><td><td  width='20px'><td colspan='2' style='background-color: #C9DAE1'>" . $rowZ[count_units].$row[units_material]
                    ." до даты: ".$rowZ[date_delivery]
                    . " по заявке №" . $rowZ[number]
                    . " от " . $rowZ[date] ." ".$rowZ[name]
                    . " [ ".$rowZ[name_user]." ]";
                $this->acc($rowZ);
            }
        }
    }

    public function acc(&$row)
    {
        $sql = "
SELECT 
* 
FROM 
`z_doc_material_acc` M, `z_acc` A, `z_contractor` C 
WHERE
M.`id_doc_material` = " . $row[id] . "
AND M.`id_acc` = A.`id`
AND A.`id_contractor` = C.`id`       
        ";
        if ($result = $this->mysqli->query($sql)) {
            while ($row1 = $result->fetch_assoc()) {

                echo "<tr><td><td><td><td><td  width='20px'><td colspan='1' style='background-color: #8CD4F5'>" . $row1[count_material].$row[units_material]
                    . " " . round($row1[price_material], 2)
                    . " [" . round($row1[count_material] *  $row1[price_material],2) . "] "
                    . " по счету №" . $row1[number]
                    . " от " . $row1[date] ." на сумму: ".round($row1[summa], 2)
                    . " [ ".$row1[name]." инн.".$row1[inn]." ]";
            }
        }
    }

}
?>


