<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/task_time.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_interstroi.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $date1 =  (isset($_POST["date1"]))?$_POST["date1"]:date("Y-m-d");
    $date2 =  (isset($_POST["date2"]))?$_POST["date2"]:date("Y-m-d", strtotime($date1 . '+ 1 month'));

    $id_kvartal =  (isset($_POST["id_kvartal"]))?$_POST["id_kvartal"]:13;
    $id_object =  (isset($_POST["id_object"]))?$_POST["id_object"]:50;
    $id_razdel1 =  (isset($_POST["id_razdel1"]))?$_POST["id_razdel1"]:'4,5';
    $id_razdel2 =  (isset($_POST["id_razdel2"]))?$_POST["id_razdel2"]:'1,5';

    $acc_ =  (isset($_POST["acc_"]))?1:0;
    $acc_ch = ($acc_>0)?'checked':'';
    $docs =  (isset($_POST["docs"]))?1:0;
    $docs_ch = ($docs>0)?'checked':'';
    $nariad =  (isset($_POST["nariad"]))?1:0;
    $nariad_ch = ($nariad>0)?'checked':'';
    $stock =  (isset($_POST["stock"]))?1:0;
    $stock_ch = ($stock>0)?'checked':'';

    if ($ROW_role!=0) {
        $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
        $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
    }
    else { $styleH=''; $styleF=''; }

    $ret = 0;
    $mysqli = new_connect($ret);
    echo "<p/> result_connect mysqli=" . $mysqli->connect_errno;


    ?>
    <style>
        table.report, table.report th, table.report td {
            border-collapse: collapse;
            clear: both;
            border: 1px solid black;
        }
        table.report th {
            text-align: center;
        }
        table.report td {
            text-align: right;
            white-space: nowrap;
        }
        table.report:hover {
            color: black;
        }
        #left  {
            text-align: left;
        }
        #center  {
            text-align: center;
        }
        #fix {
            width: 2%;
            min-width: 2%;
        }
    </style>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>
        <table><tr><td>
        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Отчет по работам и материалам в разделе себестоимости (сметы)</div></caption>

            <tr><td style="padding-right: 10px">дата начала: (YYYY-mm-dd):<td>
                    <input class="text"  name="date1" size="10" value="<?=$date1?>" />
                <td style="padding-right: 10px">дата конца: (YYYY-mm-dd):<td>
                    <input class="text"  name="date2" size="10" value="<?=$date2?>" />
            <tr><td style="padding-right: 10px">квартал (YYYY-mm-dd):<td>
                    <input class="text"  name="id_kvartal" size="10" value="<?=$id_kvartal?>" />
            <tr><td style="padding-right: 10px">объект (50):<td>
                    <input class="text"  name="id_object" size="10" value="<?=$id_object?>" />
                <td id="center">
                    <label><input class="checkbox" type="checkbox"  name="nariad"  value="<?=$nariad?>" <?=$nariad_ch?> /> - наряды</label>
                <td>
                    <label><input class="checkbox" type="checkbox"  name="stock"  value="<?=$stock?>" <?=$stock_ch?> /> - материалы наряда</label>
            <tr><td style="padding-right: 10px">раздел (4,5):<td>
                    <input class="text"  name="id_razdel1" size="10" value="<?=$id_razdel1?>" />
                <td><td>
                    <label><input class="checkbox" type="checkbox"  name="docs"  value="<?=$docs?>" <?=$docs_ch?> /> - заявки</label>

            <tr><td style="padding-right: 10px">статья (1,5):<td>
                    <input class="text"  name="id_razdel2" size="10" value="<?=$id_razdel2?>" />
                <td><td>
                    <label><input class="checkbox" type="checkbox"  name="acc_" value="<?=$acc_?>" <?=$acc_ch?> /> - счета</label>
                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>

        <?
        $razdel1 = (trim($id_razdel1) == '') ? '' : "AND R1.razdel1 in ($id_razdel1)";
        $razdel2 = (trim($id_razdel2) == '') ? '' : "AND R2.razdel2 in ($id_razdel2)";
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

R1.`id_object` = $id_object           -- по объекту
$razdel1     -- по разделам
$razdel2      -- по статьям

AND O.`id` = R1.`id_object`
AND R1.`id` = R2.`id_razdel1`
AND R2.`id` = M.`id_razdel2`
-- GROUP BY

-- O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`
        ";
        //echo"<pre>".print_r($sql,true)."</pre>"; die();
        ?>
            <tr><td> <tr><td>
        <table class="report">
        <?php
        $rep = new Report_smeta($mysqli,$acc_);
        if ($result = $mysqli->query($sql)) {
            $rep->head();
            $id_work = 0;
            while ($row0 = $result->fetch_assoc()) {

                $rep->r0($row0 );
                $rep->r1($row0 );
                $rep->r2($row0 );

                if ($nariad==1 && $id_work != $row0[id] ) {
                    $id_work = $row0[id];
                    $close_nariad = $rep->nariad($row0, $stock) ;
                }
                $rep->material($row0 );

                if ($docs==1) {
                    $rep->doc($row0);
                }
            }
            $result->close();
        }
        ?>
        </table>
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
    var $accs;
    public function Report_smeta ($mysqli,$acc_=1) {
        $this->mysqli = $mysqli;
        $this->accs = $acc_;
    }
    public function head() {
        ?>
        <tr><th colspan='6' rowspan="3">Наименование</th>
            <th colspan='6'>план</th>
            <th colspan='6'>реализация</th>
            <th colspan='6'>осталось</th>
        <tr><th colspan='3'>работа<th colspan='3'>материалы
            <th colspan='3'>работа<th colspan='3'>материалы
            <th colspan='3'>работа<th colspan='3'>материалы
        <tr><th>кол-во</th><th>цена</th><th>сумма</th>
            <th>кол-во</th><th>цена</th><th>сумма</th>
            <th>кол-во</th><th>цена</th><th>сумма</th>
            <th>кол-во</th><th>цена</th><th>сумма</th>
            <th>кол-во</th><th>цена</th><th>сумма</th>
            <th>кол-во</th><th>цена</th><th>сумма</th>
<?php
    }

    public function r0(&$row) {
        if (! ($this->id_object == $row[id_object])) {
            $this->id_object = $row[id_object];
            ?>
            <tr><th colspan='6' id="left"><b> объект: <?=$row[object_name]?>
                <td><td><td><?=$row[total_r0]?>
                <td><td><td><?=$row[total_m0]?>
                <td><td><td><?=$row[total_r0_realiz]?>
                <td><td><td><?=$row[total_m0_realiz]?>

                <td><td><td><?=$row[total_r0]-$row[total_r0_realiz]?>
                <td><td><td><?=$row[total_m0]-$row[total_m0_realiz]?>
            <?php
        }

    }
    public function r1(&$row) {
        if (! ($this->razdel1 == $row[razdel1])) {
            $this->razdel1 = $row[razdel1];
            $this->razdel2 = 0;
            ?>
            <tr><td id="fix">&nbsp;&nbsp;&nbsp;
                <td colspan='5' id="left"> раздел <?=$this->razdel1?>: <?=$row[name1]?>
                <td><td><td><?=$row[summa_r1]?>
                <td><td><td><?=$row[summa_m1]?>
                <td><td><td><?=$row[summa_r1_realiz]?>
                <td><td><td><?=$row[summa_m1_realiz]?>

                <td><td><td><?=$row[summa_r1]-$row[summa_r1_realiz]?>
                <td><td><td><?=$row[summa_m1]-$row[summa_m1_realiz]?>
            <?php
        }

    }
    public function r2(&$row) {
        if (! ($this->razdel2 == $row[razdel2])) {
            $this->razdel2 = $row[razdel2];
            ?>
            <tr><td><td  id="fix">&nbsp;&nbsp;&nbsp;
                <td colspan='4' id="left"> cтатья: <?=$this->razdel2?> <?=$row[name_working]?>, <?=$row[units]?>
                <td><?=$row[count_units]?>
                <td><td><?=$row[subtotal]?>
                <td><td><td><?=$row[summa_material]?>

                <td><?=$row[count_r2_realiz]?>
                <td><td><?=$row[summa_r2_realiz]?>
                <td><td><td><?=$row[summa_mat_realiz]?>

                <td><?=$row[count_units] - $row[count_r2_realiz]?>
                <td><td><?=$row[subtotal] - $row[summa_r2_realiz]?>
                <td><td><td><?=$row[summa_material] - $row[summa_mat_realiz]?>
            <?php
        }

    }

    public function material(&$row) {
        ?>
                <tr><td><td><td id="fix">&nbsp;&nbsp;&nbsp;
                <td colspan='3' id="left"><?=$row[material]?>, <?=$row[units_material]?>
                <td colspan='3'>
                <td><?=$row[count_units_material]?>
                <td><?=$row[price_material]?>
                <td><?=$row[subtotal_material]?>
    <td colspan='3'>
    <td><?=$row[count_realiz_material]?>
    <td>
    <td><?=$row[summa_realiz_material]?>

    <td colspan='3'>
    <td><?=$row[count_units_material] - $row[count_realiz_material]?>
    <td>
    <td><?=$row[subtotal_material] - $row[summa_realiz_material]?>
        <?php
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
        ?>
        <tr><td colspan="3">
        <td id="fix">&nbsp;&nbsp;&nbsp;
        <td colspan='2' style='background-color: #C9DAE1' id="left">
заявка № <?=$rowZ[number]?> от <?=$rowZ[date]?> <?=$rowZ[name]?> [ <?=$rowZ[name_user]?> ]
<?=$row[units_material]?>
        <td colspan="3">
        <td><?=$rowZ[count_units]?>
        <td><?=$rowZ[date_delivery]?>
        <?php
                if ($this->accs==1)
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
                ?>
                <tr><td><td><td><td><td id="fix">&nbsp;&nbsp;&nbsp;
                    <th id='left' colspan='1' style='background-color: #8CD4F5'>счет №<?=$row1[number]?>
        от <?=$row1[date]?> на сумму: <?=$row1[summa]?>
        [ <?=$row1[name]?> инн <?=$row1[inn]?> ], <?=$row[units_material]?>
       <td colspan="3">
        <td><?=$row1[count_material]?>
        <td><?=$row1[price_material]?>
        <td><?=number_format($row1[count_material] *  $row1[price_material], 2,'.', '')?>

                <?php
            }
        }
    }


    public function nariad(&$row,$stock=false) {
  //     echo"<pre>".print_r($row,true)."</pre>";
      $ret = false;
      $n_data = new Nariad_DATA($this->mysqli);
      if(($ret = $n_data->from_razdel2($row[id]))===true) {
          //------------Есть наряд
        //echo"<pre>".print_r($n_data->si->Show(),true)."</pre>";
        //echo"<pre>".print_r($n_data->arr_data,true)."</pre>"; die();
        foreach ($n_data->arr_data as $item_n) {
              if ($item_n[id_signed1] > 0 and $item_n[signedd_nariad]==1) // Утвержденный наряд
              {
              ?>
             <tr><td><td><td><td id="fix">&nbsp;&nbsp;&nbsp;
                <th colspan="2" style='background-color: #00b05a' id="left">наряд №<?=$item_n[numer_doc]?> от <?=$item_n[date_doc]?> [<?=$item_n[implementer]?> с <?=$item_n[date_begin]?> по <?=$item_n[date_end]?>]
                <td colspan="6" id="center">
                <td><?=$item_n[count_units]?>
                <td><?=$item_n[price]?>
                <td><?=$item_n[subtotal]?>
                <td><td><td><td><td><td><td><td><td>
        <?php

              }
              if (isset($item_n[material])) {
                  foreach ($item_n[material] as $itemm) {
        //echo"<pre>".print_r($itemm[stock],true)."</pre>";
        ?>
<tr><td><td><td><td><td id="fix">&nbsp;&nbsp;&nbsp;
    <td colspan="1" style='background-color: #9df39f ' ><?=$itemm[material]?> от <?=$item_n[date_doc]?> [ <?=$itemm[units]?> ]
    <td colspan="6" id="center"><td><td><td>
    <td><?=$itemm[count_units]?>
    <td><?=$itemm[price]?>
    <td><?=$itemm[subtotal]?>
    <td><td><td><td><td><td>
        <?php
                if($stock and isset($itemm[stock])) {
                    foreach ($itemm[stock] as $items) {
                        ?>
<tr><td><td><td><td><td id="fix">&nbsp;&nbsp;&nbsp;
    <td colspan="1" style='background-color: #ffffcc ' ><?=$items[name]?> [ <?=$items[units]?> ]
    <td colspan="6" id="center"><td><td><td>
    <td><?=$items[count_units]?>
    <td><?=$items[price]?>
    <td>
    <td><td><td><td><td><td>
                        <?php
                    }
                }
              }
            }
        }
      }
      // $nariad_data->si->Show();
      return $ret;


    }

}
?>


